@extends('layouts.app')

@section('content')
<div class="min-h-screen transition-colors duration-500" id="mainContainer">
    
    {{-- Animated Gradient Background --}}
    <div class="fixed inset-0 transition-colors duration-500" id="gradientBg"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 opacity-5 transition-opacity duration-500" id="gridPattern"></div>
    

    {{-- Navbar --}}
    <header class="relative z-50 backdrop-blur-xl border-b shadow-lg transition-colors duration-500" id="navbar">
        <div class="w-full py-10"> 
            <div class="flex justify-between items-center relative">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer absolute left-0 top-1/2 -translate-y-1/2 pl-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo"
                            class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>
                
                {{-- TataTAku --}}
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <span class="text-2xl font-bold gradient-text-navbar animate-gradient-text bg-[length:200%_auto]">
                        TataTAku
                    </span>
                </div>

                {{-- Ikon User & Actions --}}
                <div class="flex items-center gap-4 absolute right-0 top-1/2 -translate-y-1/2 pr-4">
                    {{-- Theme Toggle --}}
                    <button onclick="toggleTheme()" class="w-10 h-10 rounded-full border-2 transition-all duration-300 flex items-center justify-center group relative overflow-hidden" id="themeToggle">
                        <svg class="w-5 h-5 transition-all duration-300" id="themeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- Profil --}}
                    <a class="relative flex items-center group cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] flex items-center justify-center shadow-lg shadow-[#85BBEB]/30 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 border text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl theme-tooltip">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                            <div class="absolute -top-1 right-3 w-2 h-2 border-l border-t transform rotate-45 theme-tooltip-arrow"></div>
                        </div>
                    </a>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="relative group">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full border flex items-center justify-center transition-all duration-300 group theme-btn-logout">
                            <svg class="w-6 h-6 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                        </button>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 border text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl theme-tooltip">
                            Keluar
                            <div class="absolute -top-1 right-3 w-2 h-2 border-l border-t transform rotate-45 theme-tooltip-arrow"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="relative">
        {{-- Breadcrumb --}}
        <div class="absolute left-0 w-screen z-10">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 hover:text-[#85BBEB] transition-colors duration-300 group fade-in-up px-4 pt-2 theme-breadcrumb">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>
        </div>

        {{-- Main Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            
            {{-- Page Title --}}
            <div class="text-center mb-8 sm:mb-12 fade-in-up" style="animation-delay: 0.1s;">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 theme-title">
                    Hasil Pemeriksaan
                </h1>
                <p class="text-base sm:text-lg theme-subtitle">
                    File: <span class="font-semibold text-[#85BBEB]">{{ $document->file_name }}</span>
                </p>
            </div>

            {{-- Container untuk logika AlpineJS --}}
            <div class="space-y-6 fade-in-up" style="animation-delay: 0.2s;" x-data="chapterCorrector()">

                @forelse ($document->chapters as $chapter)
                    {{-- Setiap Bab adalah komponen AlpineJS --}}
                    <div class="relative"
                         x-data="chapterItem(
                             {{ $chapter->id }},
                             '{{ $chapter->status }}',
                             '{{ $chapter->details }}',
                             {{ $chapter->corrected_text ? 'true' : 'false' }},
                             '{{ route('chapter.correct', $chapter) }}',
                             '{{ route('chapter.status', $chapter) }}'
                         )">
                        
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
                        
                        <div class="relative backdrop-blur-xl rounded-3xl shadow-2xl border overflow-hidden transition-colors duration-500 theme-chapter-card">
                            
                            {{-- Header Bab (Tombol Accordion) --}}
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 sm:p-6 cursor-pointer" @click="isOpen = !isOpen">
                                <h2 class="text-xl sm:text-2xl font-bold theme-card-title">
                                    {{ $chapter->chapter_order }}. {{ $chapter->chapter_title }}
                                </h2>
                                <div class="flex flex-wrap items-center gap-3 sm:gap-4 w-full sm:w-auto">
                                    {{-- Indikator Status --}}
                                    <span class="px-3 sm:px-4 py-1 rounded-full text-xs sm:text-sm font-semibold"
                                          :class="{
                                              'bg-yellow-300/20 text-[#D69E2E]': status === 'Pending',
                                              'bg-blue-300/20 text-blue-300': status === 'Queued' || status === 'Processing',
                                              'bg-green-400/20 text-green-400': status === 'Completed',
                                              'bg-red-400/20 text-red-400': status === 'Failed'
                                          }"
                                          x-text="statusText()"></span>
                                    
                                    {{-- Tombol Koreksi / Indikator Loading --}}
                                    <template x-if="status === 'Pending' || status === 'Failed'">
                                        <button @click.stop="startCorrection()" class="px-4 sm:px-6 py-2 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] text-[#0A0A2E] rounded-full font-bold text-sm sm:text-base hover:opacity-90 transition-all duration-200 shadow-xl whitespace-nowrap">
                                            Koreksi Bab Ini
                                        </button>
                                    </template>
                                    <template x-if="status === 'Queued' || status === 'Processing'">
                                        <div class="w-6 h-6 border-4 border-[#85BBEB] border-t-transparent rounded-full animate-spin"></div>
                                    </template>
                                    <template x-if="status === 'Completed'">
                                        <div class="w-6 h-6 text-green-400">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </template>

                                    {{-- Chevron --}}
                                    <div class="w-6 h-6 text-[#85BBEB] transition-transform" :class="{'rotate-180': isOpen}">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Pesan Error (jika gagal) --}}
                            <template x-if="status === 'Failed' && details">
                                <div class="px-4 sm:px-6 pb-4 -mt-2 text-red-400 text-sm" x-text="'Error: ' + details"></div>
                            </template>

                            {{-- Konten Accordion (Teks Asli vs Koreksi) --}}
                            <div x-show="isOpen" x-transition class="border-t p-4 sm:p-6 lg:p-8 theme-chapter-content">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                                    {{-- Teks Asli --}}
                                    <div>
                                        <h5 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4 flex items-center gap-2 theme-card-title">
                                            <svg class="w-5 h-5 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Teks Asli
                                        </h5>
                                        <div class="prose max-w-none leading-relaxed text-sm sm:text-base p-4 rounded-xl max-h-[400px] sm:max-h-[600px] overflow-y-auto custom-scrollbar theme-text-box">
                                            <p class="whitespace-pre-wrap break-words theme-text-content">{{ $chapter->original_text }}</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Teks Koreksi --}}
                                    <div>
                                        <h5 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4 flex items-center gap-2 theme-card-title">
                                            <svg class="w-5 h-5 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Rekomendasi Koreksi
                                        </h5>
                                        <div class="p-4 rounded-xl min-h-[200px] max-h-[400px] sm:max-h-[600px] overflow-y-auto custom-scrollbar theme-text-box">
                                            
                                            {{-- Tampilkan berdasarkan status --}}
                                            <template x-if="status === 'Pending' || status === 'Failed'">
                                                <div class="flex items-center justify-center h-full min-h-[200px]">
                                                    <span class="text-[#85BBEB]/50 italic text-center text-sm">Klik "Koreksi Bab Ini" untuk memulai.</span>
                                                </div>
                                            </template>
                                            
                                            <template x-if="status === 'Queued' || status === 'Processing'">
                                                <div class="flex flex-col items-center justify-center h-full min-h-[200px]">
                                                    <div class="w-8 h-8 border-4 border-[#85BBEB] border-t-transparent rounded-full animate-spin mb-4"></div>
                                                    <span class="text-[#85BBEB]/80 italic text-sm text-center" x-text="details || 'Memproses...'"></span>
                                                </div>
                                            </template>
                                            
                                            <template x-if="status === 'Completed'">
                                                <div>
                                                    {{-- Jika tidak ada koreksi --}}
                                                    <template x-if="!correctionsList || correctionsList.length === 0">
                                                        <div class="flex flex-col items-center justify-center py-8 text-center">
                                                            <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4">
                                                                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                </svg>
                                                            </div>
                                                            <p class="text-green-300 font-semibold text-base mb-2">Tidak Ada Kesalahan Ditemukan</p>
                                                            <p class="text-green-400/70 text-sm">Teks sudah sesuai dengan kaidah Bahasa Indonesia.</p>
                                                        </div>
                                                    </template>

                                                    {{-- Jika ada koreksi --}}
                                                    <template x-if="correctionsList && correctionsList.length > 0">
                                                        <div class="space-y-4">
                                                            {{-- Info Header --}}
                                                            <div class="border rounded-lg p-3 mb-4 theme-info-box">
                                                                <p class="text-[#85BBEB] font-semibold text-sm flex items-center gap-2">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    <span x-text="'Total: ' + correctionsList.length + ' koreksi ditemukan'"></span>
                                                                </p>
                                                            </div>

                                                            {{-- List Koreksi --}}
                                                            <template x-for="(item, index) in correctionsList" :key="index">
                                                                <div class="border-l-4 border-yellow-400 rounded-r-lg p-4 transition-colors theme-correction-item">
                                                                    {{-- Header Item --}}
                                                                    <div class="flex items-start justify-between mb-3">
                                                                        <span class="corrected-index font-bold text-base" x-text="'#' + (index + 1)"></span>
                                                                    </div>
                                                                    
                                                                    {{-- Teks Asli --}}
                                                                    <div class="mb-3">
                                                                        <div class="flex items-center gap-2 mb-1.5">
                                                                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                            </svg>
                                                                            <p class="text-red-400/90 text-xs font-semibold uppercase tracking-wide">Teks Asli:</p>
                                                                        </div>
                                                                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3">
                                                                            <p class="text-sm leading-relaxed theme-correction-text" x-text="item.original"></p>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    {{-- Arrow Divider --}}
                                                                    <div class="flex justify-center my-2">
                                                                        <svg class="w-6 h-6 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                                        </svg>
                                                                    </div>
                                                                    
                                                                    {{-- Perbaikan --}}
                                                                    <div>
                                                                        <div class="flex items-center gap-2 mb-1.5">
                                                                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                            </svg>
                                                                            <p class="text-green-400/90 text-xs font-semibold uppercase tracking-wide">Perbaikan:</p>
                                                                        </div>
                                                                        <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-3">
                                                                            <p class=" text-sm leading-relaxed corrected-text" x-text="item.corrected"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/10 to-transparent rounded-2xl blur-xl"></div>
                        <div class="relative text-center text-lg sm:text-xl backdrop-blur-sm p-8 sm:p-12 rounded-2xl border transition-colors duration-500 theme-empty-state">
                            Dokumen ini tidak memiliki bab.
                        </div>
                    </div>
                @endforelse

            </div> {{-- End container AlpineJS --}}

            {{-- Tombol Aksi Bawah --}}
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mt-8 sm:mt-12 fade-in-up" style="animation-delay: 0.3s;">
                <a href="{{ route('history') }}" class="flex-1 px-6 sm:px-8 py-3 sm:py-4 backdrop-blur-md border-2 rounded-xl transition-all duration-300 font-semibold text-center relative overflow-hidden group theme-btn-outline">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Riwayat
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </a>

                <button onclick="downloadDocument()" class="flex-1 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-xl hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-semibold relative overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh PDF
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </div>
        </div>
    </main>
</div>

<style>
/* ==================== DARK MODE (DEFAULT) ==================== */

#gradientBg {
    background-image: linear-gradient(to bottom right, #0A0A2E, #1a1a40, #0A0A2E);
}

#gridPattern {
    background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px);
    background-size: 50px 50px;
}

#navbar {
    background-color: rgba(10, 10, 46, 0.7);
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 10px 15px -3px rgba(133, 187, 235, 0.05);
}

.theme-tooltip {
    background-color: #1a1a40;
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-tooltip-arrow {
    background-color: #1a1a40;
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-btn-logout {
    background-color: rgba(133, 187, 235, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-btn-logout:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.5);
}

.theme-breadcrumb {
    color: #85BBEB;
}

.theme-breadcrumb:hover {
    color: #FEF9F0;
}

.theme-title {
    color: #FFFFFF;
}

.theme-subtitle {
    color: #C0C0C0;
}

.theme-chapter-card {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-chapter-content {
    border-color: rgba(133, 187, 235, 0.2);
}

.theme-card-title {
    color: #FFFFFF;
}

.theme-text-box {
    background-color: rgba(10, 10, 46, 0.5);
}

.theme-text-content {
    color: #C0C0C0;
}

.theme-info-box {
    background-color: rgba(133, 187, 235, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-correction-item {
    background: linear-gradient(to right, rgba(234, 179, 8, 0.1), transparent);
}

.theme-correction-item:hover {
    background: linear-gradient(to right, rgba(234, 179, 8, 0.15), transparent);
}

.theme-correction-text {
    color: #FEF9F0;
}

.theme-empty-state {
    background-color: rgba(10, 10, 46, 0.5);
    border-color: rgba(133, 187, 235, 0.2);
    color: #C0C0C0;
}

.theme-btn-outline {
    background-color: rgba(254, 249, 240, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-btn-outline:hover {
    background-color: rgba(254, 249, 240, 0.2);
    border-color: rgba(133, 187, 235, 0.5);
}

#themeToggle {
    border-color: rgba(133, 187, 235, 0.4);
    color: #85BBEB;
    background-color: rgba(133, 187, 235, 0.1);
}

#themeToggle:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.6);
}

.corrected-text {
    color: white;
}

.corrected-index {
    color: white;
}

/* Dynamic gradient text colors - DARK MODE */
.gradient-text-navbar {
    background: linear-gradient(to right, #FFFFFF, #85BBEB, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ==================== LIGHT MODE ==================== */

body.light-mode #gradientBg {
    background-image: linear-gradient(to bottom right, #FAFBFC, #F0F4F8, #E8EEF5);
}

body.light-mode #gridPattern {
    background-image: linear-gradient(#4A5568 1px, transparent 1px), linear-gradient(90deg, #4A5568 1px, transparent 1px);
    opacity: 0.05;
}

body.light-mode #navbar {
    background-color: rgba(255, 255, 255, 0.85);
    border-color: rgba(133, 187, 235, 0.15);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

body.light-mode .theme-tooltip {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.2);
    color: #2D3748;
}

body.light-mode .theme-tooltip-arrow {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-btn-logout {
    background-color: rgba(133, 187, 235, 0.08);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-btn-logout:hover {
    background-color: rgba(133, 187, 235, 0.15);
    border-color: rgba(133, 187, 235, 0.3);
}

body.light-mode .theme-breadcrumb {
    color: #85BBEB;
}

body.light-mode .theme-breadcrumb:hover {
    color: #2D3748;
}

body.light-mode .theme-title {
    color: #1A202C;
}

body.light-mode .theme-subtitle {
    color: #4A5568;
}

body.light-mode .theme-chapter-card {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(250, 251, 252, 0.9), rgba(245, 247, 250, 0.95));
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
}

body.light-mode .theme-chapter-content {
    border-color: rgba(133, 187, 235, 0.15);
}

body.light-mode .theme-card-title {
    color: #1A202C;
}

body.light-mode .theme-text-box {
    background-color: rgba(240, 244, 248, 0.7);
}

body.light-mode .theme-text-content {
    color: #2D3748;
}

body.light-mode .theme-info-box {
    background-color: rgba(133, 187, 235, 0.08);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-correction-item {
    background: linear-gradient(to right, rgba(234, 179, 8, 0.08), transparent);
}

body.light-mode .theme-correction-item:hover {
    background: linear-gradient(to right, rgba(234, 179, 8, 0.12), transparent);
}

body.light-mode .theme-correction-text {
    color: #1A202C;
}

body.light-mode .theme-empty-state {
    background-color: rgba(255, 255, 255, 0.8);
    border-color: rgba(133, 187, 235, 0.15);
    color: #4A5568;
}

body.light-mode .theme-btn-outline {
    background-color: rgba(255, 255, 255, 0.7);
    border-color: rgba(133, 187, 235, 0.3);
    color: #2D3748;
}

body.light-mode .theme-btn-outline:hover {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.5);
}

body.light-mode #themeToggle {
    border-color: rgba(245, 158, 11, 0.3);
    color: #F59E0B;
    background-color: rgba(255, 237, 213, 0.4);
}

body.light-mode #themeToggle:hover {
    background-color: rgba(255, 237, 213, 0.6);
    border-color: rgba(245, 158, 11, 0.4);
}

body.light-mode .corrected-text {
    color: #000000;
}

body.light-mode .corrected-index {
    color: #000000;
}

/* Light mode gradient text */
body.light-mode .gradient-text-navbar {
    background: linear-gradient(to right, #000000, #85BBEB, #000000);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ==================== ANIMATIONS ==================== */

@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient-shift {
    background-size: 200% 200%;
    animation: gradient-shift 15s ease infinite;
}

@keyframes gradient-text {
    0%, 100% { background-position: 0% center; }
    50% { background-position: 100% center; }
}

.animate-gradient-text {
    animation: gradient-text 3s linear infinite;
}

@keyframes pulse-subtle {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

.animate-pulse-subtle { 
    animation: pulse-subtle 2s ease-in-out infinite; 
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
}

.fade-in-up.visible {
    animation: fadeInUp 0.8s ease-out forwards;
}

/* ==================== CUSTOM SCROLLBAR ==================== */

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(133, 187, 235, 0.1);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(133, 187, 235, 0.4);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(133, 187, 235, 0.6);
}

body.light-mode .custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(133, 187, 235, 0.05);
}

body.light-mode .custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(133, 187, 235, 0.3);
}

body.light-mode .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(133, 187, 235, 0.5);
}
</style>

<script>
// Theme Toggle Function
function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');
    
    body.classList.toggle('light-mode');
    
    const isLightMode = body.classList.contains('light-mode');
    
    // Update icon
    const moonPath = 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z';
    const sunPath = 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z';
    
    if (isLightMode) {
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        localStorage.setItem('theme', 'light');
    } else {
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${moonPath}"/>`;
        localStorage.setItem('theme', 'dark');
    }
}

// Load saved theme on page load
function loadTheme() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        const themeIcon = document.getElementById('themeIcon');
        const sunPath = 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z';
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
    }
}

function downloadDocument() {
    window.location.href = '{{ route("document.download", $document->id) }}';
}

function chapterCorrector() {
    return {};
}

function chapterItem(id, initialStatus, initialDetails, hasCorrected, correctUrl, statusUrl) {
    return {
        id: id,
        isOpen: false,
        status: initialStatus,
        details: initialDetails,
        correctedText: '',
        correctionsList: [],
        pollInterval: null,

        init() {
            if (this.status === 'Queued' || this.status === 'Processing') {
                this.startPolling();
            }
            if (this.status === 'Completed' && hasCorrected) {
                this.fetchCompletedText();
            }
        },

        statusText() {
            const map = {
                'Pending': 'Menunggu',
                'Queued': 'Antrian',
                'Processing': 'Memproses',
                'Completed': 'Selesai',
                'Failed': 'Gagal'
            };
            return map[this.status] || this.status;
        },

        startCorrection() {
            if (this.status === 'Processing' || this.status === 'Queued') return;
            
            this.status = 'Queued';
            this.details = 'Mengantri...';
            this.isOpen = true; 

            fetch(correctUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'Queued') {
                    this.startPolling();
                } else {
                    this.status = 'Failed';
                    this.details = 'Gagal memulai job.';
                }
            })
            .catch(err => {
                this.status = 'Failed';
                this.details = 'Error jaringan saat memulai.';
                console.error(err);
            });
        },

        startPolling() {
            if (this.pollInterval) clearInterval(this.pollInterval);

            this.pollInterval = setInterval(() => {
                fetch(statusUrl, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    this.status = data.status;
                    this.details = data.details;

                    if (data.status === 'Completed') {
                        clearInterval(this.pollInterval);
                        this.correctedText = data.corrected_text;
                        this.parseCorrections(data.corrected_text);
                    }
                    if (data.status === 'Failed') {
                        clearInterval(this.pollInterval);
                    }
                })
                .catch(err => {
                    clearInterval(this.pollInterval);
                    this.status = 'Failed';
                    this.details = 'Error polling status.';
                    console.error(err);
                });
            }, 3000);
        },
        
        fetchCompletedText() {
            fetch(statusUrl, { headers: { 'Accept': 'application/json' }})
            .then(res => res.json())
            .then(data => {
                if (data.status === 'Completed') {
                    this.correctedText = data.corrected_text;
                    this.parseCorrections(data.corrected_text);
                }
            });
        },

        parseCorrections(text) {
            // Reset array
            this.correctionsList = [];
            
            if (!text || text.trim() === '') return;
            
            // Check jika tidak ada koreksi
            if (text.includes('tidak ada yang perlu dikoreksi') || 
                text.includes('Tidak ada koreksi')) {
                return;
            }

            // Pattern untuk menangkap format:
            // - "teks asli"
            //   -> "teks perbaikan"
            const pattern = /-\s*"([^"]+)"\s*(?:->|→)\s*"([^"]+)"/g;
            let match;

            while ((match = pattern.exec(text)) !== null) {
                const original = match[1].trim();
                const corrected = match[2].trim();
                
                // Skip jika keduanya sama
                if (original !== corrected) {
                    this.correctionsList.push({
                        original: original,
                        corrected: corrected
                    });
                }
            }

            console.log('Parsed corrections:', this.correctionsList);
        }
    };
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load theme
    loadTheme();
    
    // Scroll Animation Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection