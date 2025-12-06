@extends('layouts.app')

@section('content')
<div class="min-h-screen transition-colors duration-500 relative overflow-hidden flex flex-col items-center p-4 sm:p-6" id="mainContainer">
    
    {{-- Animated Gradient Background --}}
    <div class="fixed inset-0 bg-gradient-to-br transition-colors duration-500" id="gradientBg"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 opacity-5 transition-opacity duration-500" id="gridPattern"></div>
    
    {{-- Theme Toggle Button - Top Center --}}
    <button onclick="toggleTheme()" class="relative z-50 w-10 h-10 rounded-full border-2 transition-all duration-300 flex items-center justify-center group overflow-hidden mt-4 mb-8" id="themeToggle">
        <svg class="w-5 h-5 transition-all duration-300" id="themeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
    </button>

    {{-- Main Content Card --}}
    <div class="relative z-10 w-full max-w-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
        
        <div class="relative backdrop-blur-xl p-6 sm:p-8 md:p-10 lg:p-12 rounded-3xl shadow-2xl border text-center transition-colors duration-500 theme-card">
            
            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 transition-colors duration-500 theme-title" id="main-title">
                Sedang Memproses Dokumen ⏳
            </h1>
            
            {{-- Document Info --}}
            <p class="text-base sm:text-lg md:text-xl mb-6 sm:mb-8 transition-colors duration-500 theme-subtitle" id="doc-info">
                Dokumen <strong class="text-[#85BBEB]">{{ $document->file_name }}</strong> sedang dianalisis.
            </p>

            {{-- Status Display --}}
            <div class="flex flex-col items-center">
                <div id="status-display" class="mb-4">
                    <div class="relative inline-flex items-center justify-center">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-full blur-xl opacity-50 animate-pulse-subtle"></div>
                        <svg id="processing-spinner" class="relative animate-spin h-12 w-12 sm:h-14 sm:w-14 text-[#85BBEB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                
                {{-- Status Message --}}
                <p id="status-message" class="text-base sm:text-lg font-semibold text-[#85BBEB] mb-2">
                    Status: {{ $document->upload_status }}...
                </p>
                <p id="status-details" class="text-sm sm:text-base transition-colors duration-500 theme-subtitle">{{ $document->details ?? '' }}</p>
                
                {{-- Action Button --}}
                <div class="w-full mt-6 flex gap-3 justify-center">
                    <a href="{{ route('correction.original', $document->id) }}" target="_blank" rel="noopener noreferrer"
                       class="px-6 py-3 backdrop-blur-md border-2 rounded-full transition-all duration-300 font-medium relative overflow-hidden group theme-btn-view">
                        <span class="relative z-10">Lihat Dokumen Asli</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                </div>
                
                {{-- Progress Panel --}}
                <div id="progress-panel" class="w-full mt-6 text-left">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/10 to-transparent rounded-xl blur"></div>
                        <div class="relative backdrop-blur-sm p-4 rounded-xl border transition-colors duration-500 theme-progress-panel">
                            <h4 class="text-sm font-semibold text-[#85BBEB] mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Progres
                            </h4>
                            <ul id="progress-list" class="text-sm space-y-2 max-h-40 overflow-auto pr-2 custom-scrollbar transition-colors duration-500 theme-progress-list">
                                @foreach(array_slice($document->progress_log ?? [], -10) as $entry)
                                    <li class="flex gap-2 items-start hover:text-[#85BBEB] transition-colors duration-200">
                                        <span class="text-xs text-[#85BBEB]/70 font-mono">[{{ \Carbon\Carbon::parse($entry['ts'] ?? now())->format('H:i:s') }}]</span>
                                        <span>{{ $entry['message'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Error Message --}}
            <div id="error-message" class="mt-4 p-4 border rounded-xl font-semibold hidden transition-colors duration-500 theme-error-msg"></div>
        </div>
    </div>

    <script>
        function redirectToCorrection(url) {
            window.location.replace(url);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkUrl = "{{ route('correction.check-status', $document->id) }}";
            const statusMessage = document.getElementById('status-message');
            const statusDisplay = document.getElementById('status-display');
            const mainTitle = document.getElementById('main-title');
            const docInfo = document.getElementById('doc-info');
            
            const intervalDuration = 5000;
            let pollingIntervalId = null;

            function createRedirectButton(url) {
                return `<button onclick="redirectToCorrection('${url}')"
                            class="group px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2 justify-center">
                                Lihat Hasil Koreksi
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>`;
            }

            function checkProcessingStatus() {
                fetch(checkUrl, { headers: { 'Accept': 'application/json' } })
                .then(response => response.json())
                .then(data => {
                    statusMessage.innerText = `Status: ${data.status}...`;
                    
                    if (data.done) {
                        if (pollingIntervalId !== null) {
                            clearInterval(pollingIntervalId); 
                            pollingIntervalId = null; 
                        }
                        
                        mainTitle.innerText = "Pemrosesan Selesai!";
                        statusDisplay.innerHTML = createRedirectButton(data.redirect_url);
                        statusMessage.innerText = "Klik tombol di atas untuk melihat perubahannya.";
                    
                    } else if (data.status === 'No_Chapters') {
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        
                        docInfo.classList.add('hidden');
                        mainTitle.innerText = "Format Dokumen Salah 📄";
                        statusDisplay.innerHTML = `
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                                    </svg>
                                    Kembali ke Beranda
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                        `;
                        statusMessage.innerText = "Gagal memecah dokumen.";
                        
                        const errorEl = document.getElementById('error-message');
                        if (data.details) {
                            errorEl.innerText = data.details;
                            errorEl.classList.remove('hidden');
                        }
                    } 
                    else if (data.status === 'Invalid_Format') {
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        
                        docInfo.classList.add('hidden');
                        mainTitle.innerText = "Dokumen Bukan Format TA 📄";
                        statusDisplay.innerHTML = `
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-20 h-20 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div class="text-center space-y-2">
                                    <p class="text-lg font-semibold text-red-400">File yang Anda unggah bukan Tugas Akhir yang valid</p>
                                    <p class="text-sm theme-subtitle">Pastikan file PDF berisi struktur TA lengkap:</p>
                                    <ul class="text-sm theme-subtitle text-left inline-block">
                                        <li>✓ Halaman Judul</li>
                                        <li>✓ Abstrak</li>
                                        <li>✓ Daftar Isi</li>
                                        <li>✓ BAB I, BAB II, dst (minimal 3 BAB)</li>
                                        <li>✓ Minimal 20 halaman</li>
                                    </ul>
                                </div>
                                <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                    <span class="relative z-10 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                                        </svg>
                                        Unggah Dokumen Baru
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                </a>
                            </div>
                        `;
                        statusMessage.innerText = "Dokumen tidak memenuhi kriteria TA.";
                        
                        const errorEl = document.getElementById('error-message');
                        if (data.details) {
                            errorEl.innerText = data.details;
                            errorEl.classList.remove('hidden');
                        }
                    }
                    
                    else if (data.status === 'Failed') {
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        
                        docInfo.classList.add('hidden');
                        mainTitle.innerText = "Pemrosesan Gagal ❌";
                        statusDisplay.innerHTML = `
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                                    </svg>
                                    Kembali ke Beranda
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                        `;
                        statusMessage.innerText = "Terjadi kesalahan. Silakan coba unggah dokumen lagi.";
                        const errorEl = document.getElementById('error-message');
                        if (data.details) {
                            errorEl.innerText = 'Error: ' + data.details;
                            errorEl.classList.remove('hidden');
                        }
                    }
                    else if (data.status === 'Deleted') {
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        mainTitle.innerText = "Dokumen Dihapus 🗑️";
                        statusDisplay.innerHTML = `
                            <a href="{{ route('history') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Kembali ke Riwayat
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                        `;
                        statusMessage.innerText = data.details || 'Dokumen telah dihapus.';
                        docInfo.classList.add('hidden');
                    }
                    
                    const detailsEl = document.getElementById('status-details');
                    if (data.details && detailsEl) {
                        detailsEl.innerText = data.details;
                    }

                    if (data.progress && Array.isArray(data.progress)) {
                        const list = document.getElementById('progress-list');
                        if (list) {
                            list.innerHTML = '';
                            data.progress.slice().reverse().forEach(entry => {
                                const li = document.createElement('li');
                                li.className = 'flex gap-2 items-start hover:text-[#85BBEB] transition-colors duration-200';
                                const ts = document.createElement('span');
                                ts.className = 'text-xs text-[#85BBEB]/70 font-mono';
                                let date = new Date(entry.ts);
                                let timeString = [date.getHours(), date.getMinutes(), date.getSeconds()]
                                    .map(v => v < 10 ? '0' + v : v)
                                    .join(':');
                                ts.innerText = '[' + (timeString || '...') + ']';
                                const msg = document.createElement('span');
                                msg.innerText = entry.message || '';
                                li.appendChild(ts);
                                li.appendChild(msg);
                                list.appendChild(li);
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    statusMessage.innerText = 'Gagal terhubung ke server. Mencoba lagi...';
                });
            }
            
            checkProcessingStatus(); 
            pollingIntervalId = setInterval(checkProcessingStatus, intervalDuration);
        });
    </script>

    <style>
    /* Dark Mode (Default) */
    #mainContainer {
        background-image: linear-gradient(to bottom right, #0A0A2E, #1a1a40, #0A0A2E);
    }

    #gradientBg {
        background-image: linear-gradient(to bottom right, #0A0A2E, #1a1a40, #0A0A2E);
    }

    #gridPattern {
        background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .theme-card {
        background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
        border-color: rgba(133, 187, 235, 0.3);
    }

    .theme-title {
        color: #FFFFFF;
    }

    .theme-subtitle {
        color: #C0C0C0;
    }

    .theme-btn-view {
        background-color: rgba(254, 249, 240, 0.1);
        border-color: rgba(133, 187, 235, 0.4);
        color: #FEF9F0;
    }

    .theme-btn-view:hover {
        background-color: rgba(254, 249, 240, 0.2);
        border-color: rgba(133, 187, 235, 0.6);
        box-shadow: 0 10px 15px -3px rgba(133, 187, 235, 0.3);
    }

    .theme-progress-panel {
        background-color: rgba(10, 10, 46, 0.5);
        border-color: rgba(133, 187, 235, 0.2);
    }

    .theme-progress-list {
        color: #C0C0C0;
    }

    .theme-error-msg {
        background-color: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.3);
        color: #FCA5A5;
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

    /* Light Mode */
    body.light-mode #gradientBg {
        background-image: linear-gradient(to bottom right, #FAFBFC, #F0F4F8, #E8EEF5);
    }

    body.light-mode #gridPattern {
        background-image: linear-gradient(#4A5568  1px, transparent 1px), linear-gradient(90deg, #4A5568 1px, transparent 1px);
        opacity: 0.05;
    }

    body.light-mode .theme-card {
        background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(250, 251, 252, 0.9), rgba(245, 247, 250, 0.95));
        border-color: rgba(133, 187, 235, 0.2);
        box-shadow: 0 4px 12px rgba(133, 187, 235, 0.1), 0 2px 4px rgba(0, 0, 0, 0.03);
    }

    body.light-mode .theme-title {
        color: #1A202C;
    }

    body.light-mode .theme-subtitle {
        color: #4A5568;
    }

    body.light-mode .theme-btn-view {
        background-color: rgba(255, 255, 255, 0.7);
        border-color: rgba(133, 187, 235, 0.3);
        color: #2D3748;
    }

    body.light-mode .theme-btn-view:hover {
        background-color: rgba(255, 255, 255, 0.95);
        border-color: rgba(133, 187, 235, 0.5);
        box-shadow: 0 10px 15px -3px rgba(133, 187, 235, 0.2);
    }

    body.light-mode .theme-progress-panel {
        background-color: rgba(250, 251, 252, 0.6);
        border-color: rgba(133, 187, 235, 0.2);
    }

    body.light-mode .theme-progress-list {
        color: #4A5568;
    }

    body.light-mode .theme-error-msg {
        background-color: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.25);
        color: #DC2626;
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

    /* Animations */
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animate-gradient-shift {
        background-size: 200% 200%;
        animation: gradient-shift 15s ease infinite;
    }

    @keyframes pulse-subtle {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 0.8; }
    }

    .animate-pulse-subtle { 
        animation: pulse-subtle 2s ease-in-out infinite; 
    }

    /* Custom Scrollbar - Dark Mode */
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

    /* Custom Scrollbar - Light Mode */
    body.light-mode .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(133, 187, 235, 0.08);
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

    // Load theme immediately
    loadTheme();
    </script>
</div>
@endsection