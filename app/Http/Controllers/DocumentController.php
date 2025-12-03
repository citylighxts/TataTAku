<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\History;
use App\Jobs\ProcessDocumentCorrection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException; // Tambahkan ini

class DocumentController extends Controller
{
    public function uploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        // 1. SECURITY: Validasi diperketat dengan ClamAV
        // Pastikan package 'sunspikes/clamav-validator' sudah terinstall
        $request->validate([
            'document_name' => 'required|string|max:255', // Batasi panjang string
            'file' => 'required|mimes:pdf|max:10240|clamav', // Tambahkan 'clamav' di sini
        ], [
            'file.clamav' => 'File terdeteksi mengandung virus atau malware dan telah ditolak.', // Custom message
            'file.mimes' => 'Hanya file PDF yang diperbolehkan.',
            'file.max' => 'Ukuran file maksimal 10MB.'
        ]);

        try {
            $file = $request->file('file');
            $document_name = $request->input('document_name');

            // 2. SECURITY: Sanitasi Nama File Ekstra Aman
            // Menggunakan UUID atau Random String di depan untuk mencegah tebakan file
            $safeName = preg_replace('/[^A-Za-z0-9_-]/', '', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = time() . '_' . Str::random(8) . '_' . $safeName . '.pdf';
            
            $usedDisk = config('filesystems.default') ?: 'public';
            
            // Simpan file (File ini sudah dijamin bersih oleh validator di atas)
            $path = $file->storeAs('documents', $filename, $usedDisk);

            \Log::info('Upload: stored clean file', [
                'file_path' => $path,
                'disk' => $usedDisk,
                'user_id' => Auth::id(),
            ]);

            $document = Document::create([
                'user_id' => Auth::id(),
                'file_name' => $document_name,
                'file_location' => $path,
                'disk' => $usedDisk,
                'upload_status' => 'Processing',
            ]);

            \Log::info('DEBUG UPLOAD: Path Absolut', ['resolved_path' => \Storage::disk($usedDisk)->path($path)]);

            History::create([
                'user_id' => Auth::id(),
                'document_id' => $document->id,
                'activity_type' => 'upload',
                'details' => 'Dokumen diunggah oleh user',
            ]);

            ProcessDocumentCorrection::dispatch($document);

            return redirect()->route('correction.status', $document->id)
                             ->with('success', 'Dokumen berhasil diunggah (Aman dari Virus) dan sedang diproses...');

        } catch (ValidationException $e) {
            // Tangkap error validasi virus secara spesifik jika perlu logging tambahan
            throw $e; 
        } catch (\Throwable $e) {
            \Log::error('Upload failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            // Hapus file jika sempat terupload sebagian (cleanup)
            if (isset($path) && Storage::disk($usedDisk)->exists($path)) {
                Storage::disk($usedDisk)->delete($path);
            }

            return back()->with('error', 'Terjadi kesalahan sistem saat mengunggah dokumen.');
        }
    }

    public function checkStatus($id)
    {
        try {
            \Log::info("🔵 Polling received for Document ID {$id}"); 

            $document = Document::find($id);
            if (! $document) {
                return response()->json([
                    'status' => 'Deleted',
                    'done' => false, 
                    'details' => 'Dokumen telah dihapus oleh pengguna.',
                    'progress' => [],
                    'redirect_url' => null
                ]);
            }

            if ($document->user_id !== Auth::id()) {
                return response()->json(['status' => 'Unauthorized'], 403);
            }

            $document->refresh();
            $status = trim($document->upload_status ?? '');
            
            $isDoneAndReady = ($status === 'Ready');

            \Log::info("🟢 Document ID {$id} status: '{$status}'. DoneAndReady: {$isDoneAndReady}");
        
            
            return response()->json([
                'status' => $document->upload_status,
                'done' => $isDoneAndReady, 
                'details' => $document->details,
                'progress' => array_slice($document->progress_log ?? [], -20),
                'redirect_url' => $isDoneAndReady ? route('correction.show', $document->id) : null
            ]);

        } catch (\Throwable $e) {
            \Log::error("❌ checkStatus ERROR: " . $e->getMessage(), [
                'document_id' => $id
            ]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function showStatus($id)
    {
        $document = Document::findOrFail($id); 
        
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        return view('correction_status', compact('document'));
    }

    public function showCorrection($id)
    {
        $document = Document::with('chapters')->findOrFail($id);
        $document->refresh();

        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $statusLower = strtolower(trim($document->upload_status ?? ''));
        
        if ($statusLower !== 'ready') {
            \Log::warning("⚠️ Clash Detected: User tried accessing correction page for ID {$id} but status is '{$document->upload_status}'");
            return view('correction_status', compact('document'));
        }

        return view('correction', compact('document'));
    }

    public function download($id)
    {
        $document = Document::with('chapters')->findOrFail($id);
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke koreksi ini.');
        }

        if ($document->chapters->isEmpty()) {
            return back()->with('error', 'Dokumen ini belum dipecah menjadi bab.');
        }

        $separator = "\n\n" . str_repeat('=', 60) . "\n\n";
        $full_original_text = "";
        $full_corrected_text = "";

        foreach ($document->chapters as $chapter) {
            $full_original_text .= $chapter->chapter_title . $separator . $chapter->original_text . $separator;
            
            if ($chapter->status === 'Completed' && !empty($chapter->corrected_text)) {
                $full_corrected_text .= $chapter->chapter_title . $separator . $chapter->corrected_text . $separator;
            } else {
                $full_corrected_text .= $chapter->chapter_title . $separator . $chapter->original_text . $separator;
            }
        }

        $html = view('pdf.correction', [
            'title'          => $document->file_name,
            'corrected_text' => trim($full_corrected_text),
            'original_text'  => trim($full_original_text),
        ])->render();

        $pdf = Pdf::loadHTML($html)->setPaper('a4');

        $filename = 'koreksi-'.Str::slug($document->file_name).'-'.now()->format('Ymd-His').'.pdf';

        return $pdf->download($filename);
    }


    public function viewOriginal($id)
    {
        $document = Document::findOrFail($id);
        $hasValidSignature = request()->hasValidSignature();
        $isOwner = Auth::check() && $document->user_id === Auth::id();
        
        if (! $hasValidSignature && ! $isOwner) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        $path = $document->file_location;
        if (empty($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $diskName = $document->disk ?: config('filesystems.default') ?: 'public';
        $disk = \Storage::disk($diskName);
        
        try {
            if (method_exists($disk, 'path')) {
                $localPath = $disk->path($path);
                if (file_exists($localPath)) {
                    return response()->file($localPath, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline']);
                }
            }
            if (method_exists($disk, 'temporaryUrl')) {
                return redirect()->away($disk->temporaryUrl($path, now()->addMinutes(15)));
            }
            return response()->stream(function () use ($disk, $path) {
                fpassthru($disk->readStream($path));
            }, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline']);
        } catch (\Exception $e) {
            \Log::error('Error serving original file', ['document_id' => $document->id, 'error' => $e->getMessage()]);
            abort(500, 'Terjadi kesalahan saat mengakses file.');
        }
    }

    public function debugUploadTestcase(Request $request)
    {
        try {
            $testcaseFileName = '5025211016-Undergraduate_Thesis_compressed.pdf';
            $sourcePath = public_path('files/' . $testcaseFileName);

            if (!File::exists($sourcePath)) {
                \Log::error('Debug Upload: File testcase tidak ditemukan', ['path' => $sourcePath]);
                return back()->with('error', 'File testcase tidak ditemukan di ' . $sourcePath);
            }

            $document_name = "Debug Testcase - " . $testcaseFileName;
            $newFilenameBase = time() . '_' . Str::slug(pathinfo($document_name, PATHINFO_FILENAME), '_');
            $newFilename = $newFilenameBase . '.pdf';

            $usedDisk = config('filesystems.default') ?: 'public';
            $destinationPath = 'documents/' . $newFilename; 

            $fileContents = File::get($sourcePath);
            Storage::disk($usedDisk)->put($destinationPath, $fileContents);
            
            $storagePath = Storage::disk($usedDisk)->path($destinationPath);
            \Log::info('Debug Upload: File testcase disalin', [
                'source' => $sourcePath,
                'destination' => $storagePath,
                'disk' => $usedDisk,
            ]);

            $document = Document::create([
                'user_id' => Auth::id(),
                'file_name' => $document_name,
                'file_location' => $destinationPath, 
                'disk' => $usedDisk,
                'upload_status' => 'Processing', 
            ]);

            History::create([
                'user_id' => Auth::id(),
                'document_id' => $document->id,
                'activity_type' => 'upload_debug',
                'details' => 'Dokumen testcase di-trigger oleh user',
            ]);

            ProcessDocumentCorrection::dispatch($document);

            return redirect()->route('correction.status', $document->id) 
                             ->with('success', 'Dokumen testcase berhasil di-trigger dan sedang diproses...');

        } catch (\Throwable $e) {
            \Log::error('Debug Upload failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat memproses file testcase.');
        }
    }
}