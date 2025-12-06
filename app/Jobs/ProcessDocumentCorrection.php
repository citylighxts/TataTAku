<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\DocumentChapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http as HttpFacade;
use Illuminate\Support\Facades\DB;

class ProcessDocumentCorrection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $document;
    protected $documentId;
    public $timeout = 900;

    public function __construct(Document $document)
    {
        $this->document = $document->withoutRelations();
        $this->documentId = $document->id;
    }

    public function handle()
    {
        $document = Document::find($this->documentId);
        if (! $document) {
            Log::warning("Document ID {$this->documentId} no longer exists; aborting job.");
            return;
        }

        $document->update([
            'original_text' => null,
            'corrected_text' => null,
        ]);

        $this->pushProgress($document, 'Memulai pemrosesan dokumen...', 'Processing');

        $file_path = null;

        try {
            $diskName = $document->disk ?: 'public';

            $relativePath = $document->file_location;

            if (!Storage::disk($diskName)->exists($relativePath)) {
                throw new \Exception("File fisik tidak ditemukan di storage (Disk: $diskName, Path: $relativePath)");
            }

            $file_path = Storage::disk($diskName)->path($relativePath);

            Log::info("Worker accessing file directly at: {$file_path}", ['document_id' => $document->id]);

        } catch (\Throwable $e) {
            Log::error('File access failed: ' . $e->getMessage(), ['document_id' => $document->id]);
            $document->update(['upload_status' => 'Failed', 'details' => 'File tidak ditemukan di disk server.']);
            return;
        }

        try {
            try {
                $h = @fopen($file_path, 'rb');
                $first = @fread($h, 5);
                @fclose($h);
                if (strpos($first, '%PDF') === false) { 
                     throw new \Exception('Invalid PDF data: Missing %PDF header.');
                }
            } catch (\Throwable $e) {
                Log::warning('PDF header check failed: ' . $e->getMessage(), ['document_id' => $document->id]);
            }

            $parser = new Parser();
            $this->pushProgress($document, 'Membaca dan mempartisi dokumen (per halaman)...');

            $pdf = $parser->parseFile($file_path);
            $pages = $pdf->getPages();
            Log::info("Total pages found: " . count($pages), ['document_id' => $this->documentId]);

            $structureValidation = $this->validateDocumentStructure($pages);
            
            if (!$structureValidation['valid']) {
                Log::warning("Document structure validation failed for ID {$this->documentId}: {$structureValidation['message']}");
                $document->update([
                    'upload_status' => 'Invalid_Format',
                    'details' => $structureValidation['message']
                ]);
                $this->pushProgress($document, 'Validasi gagal: ' . $structureValidation['message'], 'Invalid_Format');
                return;
            }

            $chapters_data = $this->splitByBab($pages); 
            
            if (empty($chapters_data)) {
                 Log::warning("No valid chapters found for Document ID {$this->documentId}. Marking as 'No_Chapters'.");
                 $document->update([
                     'upload_status' => 'No_Chapters', 
                     'details' => 'Dokumen ini tidak dapat dipecah. Pastikan file yang diunggah adalah Tugas Akhir (TA).'
                 ]);
                 return;
            }

            $totalChapters = count($chapters_data);
            Log::info("Document {$this->documentId} split into {$totalChapters} chapters. Saving to DB...");

            DocumentChapter::where('document_id', $this->documentId)->delete();

            DB::transaction(function () use ($chapters_data, $document, $totalChapters) {
                $createdChapters = 0;
                foreach ($chapters_data as $index => $chapter) {
                    if (empty($chapter['isi'])) continue;
                    
                    DocumentChapter::create([
                        'document_id' => $this->documentId,
                        'chapter_title' => $chapter['judul'],
                        'chapter_order' => $index + 1,
                        'original_text' => $chapter['isi'],
                        'status' => 'Pending',
                    ]);
                    $this->pushProgress($document, "Menyimpan {$chapter['judul']}...");
                    $createdChapters++;
                }

                if ($createdChapters === 0) {
                    throw new \Exception('Gagal menyimpan bab yang valid setelah pemrosesan.');
                }

                $document->upload_status = 'Ready'; 
                $document->details = "Dokumen berhasil dipecah menjadi {$createdChapters} bab dan siap untuk dikoreksi.";
                $this->pushProgress($document, 'Dokumen siap.', 'Ready');
                $document->save();
            });

            Log::info("Document ID {$this->documentId} split successfully (page-by-page).");

        } catch (\Exception $e) {
            Log::error("Document Splitting Failed for ID {$this->documentId}: " . $e->getMessage());
            $document->update(['upload_status' => 'Failed', 'details' => 'Pemecahan gagal: ' . substr($e->getMessage(), 0, 250)]);
        }
    }

    private function pushProgress(Document $document, string $message, string $status = null)
    {
        try {
            $log = $document->progress_log ?? [];
            if (!is_array($log)) $log = [];
            $entry = ['ts' => now()->toDateTimeString(), 'message' => $message];
            $log[] = $entry;
            if (count($log) > 50) $log = array_slice($log, -50);

            $update = ['progress_log' => $log, 'details' => $message];
            if (!is_null($status)) {
                $update['upload_status'] = $status;
            }
            $document->update($update);
        } catch (\Throwable $e) {
            Log::warning("pushProgress failed for Document ID {$document->id}: " . $e->getMessage());
        }
    }

    private function cleanPageText(string $text): string
    {
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        $text = preg_replace('/[^\pL\pN\pP\pS\pZ\s]/u', '', $text);
        $text = preg_replace('/(\w)-\n(\w)/', '$1$2', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text); 
        return trim($text);
    }

    private function splitByBab(array $pages): array
    {
        try {
            $toc = $this->extractTOC($pages);
            $chapters = [];

            $fullText = '';
            $tocEndFound = false;

            foreach ($pages as $pageNum => $page) {
                $text = $this->cleanPageText($page->getText());

                if (!$tocEndFound && preg_match('/DAFTAR\s+ISI/i', $text)) {
                    Log::info("Mulai halaman daftar isi di halaman {$pageNum}");
                    continue;
                }

                if ($toc && !$tocEndFound) {
                    if (preg_match('/\bBAB\s+(I|1)\b/i', $text)) {
                        $tocEndFound = true;
                        Log::info("Akhir daftar isi ditemukan di halaman {$pageNum}");
                    } else {
                        continue; 
                    }
                }

                if ($tocEndFound || !$toc) {
                    $fullText .= "\n\n" . $text;
                }
            }

            $fullText = str_replace(["ВАВ", "І", "Ш"], ["BAB", "I", "II"], $fullText);

            if ($toc && count($toc) > 0) {
                Log::info("Menggunakan TOC sebagai peta bab...");
                foreach ($toc as $i => $entry) {
                    $currentTitle = $entry['judul'];
                    $currentNumber = $entry['bab'];
                    $next = $toc[$i + 1] ?? null;

                    $startPattern = '/(?:BAB|ВАВ)\s+' . preg_quote($currentNumber, '/') . '\s+' . preg_quote($currentTitle, '/') . '/i';
                    $endPattern = $next
                        ? '/(?:BAB|ВАВ)\s+' . preg_quote($next['bab'], '/') . '\s+' . preg_quote($next['judul'], '/') . '/i'
                        : null;

                    $startPos = null;
                    $endPos = null;

                    if (preg_match($startPattern, $fullText, $m, PREG_OFFSET_CAPTURE)) {
                        $startPos = $m[0][1];
                    }

                    if ($endPattern && preg_match($endPattern, $fullText, $m2, PREG_OFFSET_CAPTURE)) {
                        $endPos = $m2[0][1];
                    }

                    if ($startPos !== null) {
                        if (!$endPos) {
                            $regex_end_last = '/\b(DAFTAR\s+PUSTAKA|REFERENSI|PUSTAKA|LAMPIRAN|GLOSARIUM|BIODATA\s+PENULIS|(?:[\(\[\*]?\s*)?HALAMAN\s+INI\s+SENGAJA\s+DIKOSONGKAN(?:\s*[\)\]\*])?|HALAMAN\s+KOSONG)\b/i';

                            if (preg_match($regex_end_last, $fullText, $mEnd, PREG_OFFSET_CAPTURE, $startPos)) {
                                $endPos = $mEnd[0][1]; 
                            }
                        }

                        $chapterText = substr($fullText, $startPos, $endPos ? $endPos - $startPos : null);
                        $chapterText = trim(preg_replace($startPattern, '', $chapterText, 1));
                        $chapterText = preg_replace('/\n{1,5}\d{1,4}\s*$/m', '', $chapterText); 
                        $chapterText = preg_replace('/\(\s*\)$/m', '', $chapterText);           
                        $chapterText = preg_replace('/^\s*\d{1,4}\s*$/m', '', $chapterText);    
                        $chapterText = preg_replace('/^\s*[\(\[]\s*$/m', '', $chapterText);    
                        $chapters[] = [
                            'judul' => "BAB {$currentNumber} {$currentTitle}",
                            'isi' => trim($chapterText)
                        ];
                    }
                }
            } else {
                Log::info("TOC tidak ditemukan. Fallback ke deteksi regex BAB manual...");
                $chapters = $this->splitByRegex($pages);
            }

            return $chapters;

        } catch (\Exception $e) {
            Log::error("splitByBab failed: " . $e->getMessage());
            return [];
        }
    }

    private function extractTOC(array $pages): ?array
    {
        try {
            $regex_toc_header = '/DAFTAR\s+ISI/i';
            $regex_toc_entry = '/\b(?:BAB|ВАВ)\s+([IVXLC\d]+)\s+([A-Z][A-Z\s\-&]+)/m';
            $regex_stop = '/^(DAFTAR PUSTAKA|LAMPIRAN)/i';

            $tocText = '';
            $foundTOC = false;

            foreach ($pages as $pageNum => $page) {
                $pageText = $this->cleanPageText($page->getText());
                if (!$foundTOC && preg_match($regex_toc_header, $pageText)) {
                    $foundTOC = true;
                    $tocText .= "\n" . $pageText;
                    continue;
                }
                if ($foundTOC) {
                    if (preg_match($regex_stop, $pageText)) break;
                    $tocText .= "\n" . $pageText;
                }
            }

            if (empty($tocText)) return null;

            preg_match_all($regex_toc_entry, $tocText, $matches, PREG_SET_ORDER);
            $tocEntries = [];

            foreach ($matches as $match) {
                $tocEntries[] = [
                    'bab' => trim($match[1]),
                    'judul' => trim(preg_replace('/\s+/', ' ', $match[2])),
                ];
            }

            $tocEntries = collect($tocEntries)
                ->unique(function ($e) {
                    return strtoupper(preg_replace('/\s+/', ' ', $e['judul']));
                })
                ->values()
                ->all();

            return $tocEntries;

        } catch (\Exception $e) {
            Log::error("extractTOC failed: " . $e->getMessage());
            return null;
        }
    }

    private function extractSubBab(string $chapterText): array
    {
        $subbabList = [];

        $regex_subbab = '/(?<=\n|\r|^)(\d+\.\d+|[IVX]+\.\d+)\s+([A-Z][A-Za-z\s\-]+)/';

        preg_match_all($regex_subbab, $chapterText, $matches, PREG_OFFSET_CAPTURE);

        for ($i = 0; $i < count($matches[0]); $i++) {
            $startPos = $matches[0][$i][1];
            $judul = trim($matches[2][$i][0]);
            $endPos = isset($matches[0][$i + 1][1]) ? $matches[0][$i + 1][1] : null;

            $isi = substr($chapterText, $startPos, $endPos ? $endPos - $startPos : null);
            $isi = trim(preg_replace('/^' . preg_quote($matches[0][$i][0], '/') . '/', '', $isi, 1));

            $subbabList[] = [
                'judul' => $judul,
                'isi' => trim($isi)
            ];
        }

        return $subbabList;
    }

    private function validateDocumentStructure(array $pages): array
    {
        $totalPages = count($pages);
        
        if ($totalPages < 20) {
            return [
                'valid' => false,
                'message' => 'Dokumen memiliki kurang dari 20 halaman. Ini tidak sesuai dengan format Tugas Akhir.'
            ];
        }
        
        $foundChapters = 0;
        $allText = '';
        
        foreach ($pages as $page) {
            $text = strtoupper($this->cleanPageText($page->getText()));
            $allText .= ' ' . $text;
            
            if (preg_match('/\b(?:BAB|ВАВ)\s+[IVX1-9]/i', $text)) {
                $foundChapters++;
            }
        }
        
        if ($foundChapters < 3) {
            return [
                'valid' => false,
                'message' => 'Dokumen tidak memiliki struktur BAB yang memadai. TA harus memiliki minimal 3 BAB.'
            ];
        }
        
        if (stripos($allText, 'DAFTAR ISI') === false) {
            return [
                'valid' => false,
                'message' => 'Dokumen tidak memiliki Daftar Isi. Pastikan file yang diunggah adalah Tugas Akhir yang lengkap.'
            ];
        }
        
        return ['valid' => true, 'message' => 'Valid'];
    }
    }