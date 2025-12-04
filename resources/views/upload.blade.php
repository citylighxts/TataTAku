@extends('layouts.app')

@section('content')
<div class="min-h-screen transition-colors duration-500" id="mainContainer">
    
    {{-- Animated Gradient Background --}}
    <div class="fixed inset-0 bg-gradient-to-br transition-colors duration-500" id="gradientBg"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 opacity-5 transition-opacity duration-500" id="gridPattern"></div>
    
    {{-- Navbar --}}
    <header class="relative z-50 backdrop-blur-xl border-b shadow-lg transition-colors duration-500" id="navbar">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer flex-shrink-0">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo" class="relative w-10 h-10 sm:w-12 sm:h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>

                {{-- TataTAku - Centered --}}
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <span class="text-lg sm:text-xl md:text-2xl font-bold gradient-text-navbar animate-gradient-text whitespace-nowrap bg-[length:200%_auto]">
                        TataTAku
                    </span>
                </div>

                {{-- Desktop Actions --}}
                <div class="hidden md:flex gap-3 items-center flex-shrink-0">
                    {{-- Theme Toggle Button --}}
                    <button onclick="toggleTheme()" class="w-10 h-10 rounded-full border-2 transition-all duration-300 flex items-center justify-center group relative overflow-hidden" id="themeToggle">
                        <svg class="w-5 h-5 transition-all duration-300" id="themeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- Profil --}}
                    <div class="relative flex items-center group cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] flex items-center justify-center shadow-lg shadow-[#85BBEB]/30 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 border text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl theme-tooltip">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                            <div class="absolute -top-1 right-3 w-2 h-2 border-l border-t transform rotate-45 theme-tooltip-arrow"></div>
                        </div>
                    </div>

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

                {{-- Mobile Menu Button --}}
                <button class="md:hidden w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300 flex-shrink-0 theme-btn-mobile" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div id="mobileMenu" class="md:hidden hidden backdrop-blur-xl border-t transition-colors duration-500 theme-mobile-menu">
            <div class="px-4 py-4 space-y-3">
                {{-- Theme Toggle for Mobile --}}
                <button onclick="toggleTheme()" class="w-full px-6 py-3 border-2 rounded-full transition-all duration-300 font-medium text-center flex items-center justify-center gap-2 theme-btn-secondary">
                    <svg class="w-5 h-5" id="themeIconMobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <span id="themeTextMobile">Mode Terang</span>
                </button>

                {{-- Profile Info --}}
                <div class="w-full px-6 py-3 border-2 rounded-full transition-all duration-300 text-center theme-btn-secondary">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                </div>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-semibold text-center">
                        Keluar
                    </button>
                </form>
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
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

            {{-- Page Title --}}
            <div class="text-center mb-8 sm:mb-12 fade-in-up" style="animation-delay: 0.1s;">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 transition-colors duration-500 theme-title">
                    Unggah Dokumen
                </h1>
                <p class="text-lg transition-colors duration-500 theme-subtitle">
                    Upload dokumen Anda untuk analisis tata bahasa
                </p>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
            <div class="mb-6 fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative">
                    <div class="absolute inset-0 bg-green-500/20 rounded-2xl blur-xl"></div>
                    <div class="relative backdrop-blur-xl border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 theme-success-msg">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative">
                    <div class="absolute inset-0 bg-red-500/20 rounded-2xl blur-xl"></div>
                    <div class="relative backdrop-blur-xl border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 theme-error-msg">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- Upload Form Card --}}
            <div class="relative fade-in-up" style="animation-delay: 0.3s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
                <div class="relative backdrop-blur-xl rounded-3xl p-6 sm:p-8 lg:p-10 border shadow-2xl transition-colors duration-500 theme-upload-card">
                    
                    <form id="document-upload" method="POST" action="{{ route('upload.post') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Document Name Input --}}
                        <div class="space-y-2">
                            <label for="document_name" class="block font-medium text-sm theme-label">
                                Nama Dokumen
                            </label>
                            <input type="text" 
                                   name="document_name" 
                                   id="document_name"
                                   placeholder="Masukkan nama dokumen"
                                   required
                                   class="w-full px-5 py-3.5 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#85BBEB] focus:border-transparent transition-all duration-300 theme-input"
                                   value="{{ old('document_name') }}">
                            @error('document_name')
                                <p class="text-red-400 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- File Upload Area --}}
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#85BBEB]/5 rounded-2xl blur-xl"></div>
                            <div class="relative backdrop-blur-sm border-2 border-dashed rounded-2xl p-8 sm:p-12 text-center transition-all duration-300 group theme-upload-area">
                                
                                <input type="file" 
                                       name="file" 
                                       id="document"
                                       accept=".pdf,.doc,.docx"
                                       required
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       onchange="updateFileName(this)">
                                
                                {{-- Default State --}}
                                <div id="upload-default" class="pointer-events-none">
                                    <div class="relative inline-block mb-4">
                                        <div class="absolute inset-0 bg-[#85BBEB] rounded-full blur-lg opacity-30 group-hover:opacity-50 transition-opacity"></div>
                                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-full flex items-center justify-center shadow-xl shadow-[#85BBEB]/30 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold mb-2 theme-upload-title">
                                        Tarik & lepas dokumen Tugas Akhir disini
                                    </h3>
                                    <p class="text-sm mb-3 theme-upload-subtitle">
                                        atau klik untuk memilih file
                                    </p>
                                    <div class="flex items-center justify-center gap-2 text-[#85BBEB] text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Format: PDF (Max: 2MB)</span>
                                    </div>
                                </div>

                                {{-- Success State --}}
                                <div id="upload-success" class="pointer-events-none hidden">
                                    <div class="relative inline-block mb-4">
                                        <div class="absolute inset-0 bg-green-500 rounded-2xl blur-lg opacity-40"></div>
                                        <div class="relative w-20 h-24 sm:w-24 sm:h-28 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/40 mx-auto">
                                            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-[#0A0A2E]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                            </svg>
                                            <div class="absolute -top-2 -right-2 bg-green-500 rounded-full w-8 h-8 flex items-center justify-center shadow-lg shadow-green-500/50">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold mb-2 theme-upload-title" id="file-name">Dokumen.pdf</h3>
                                    <p class="text-sm mb-3 theme-upload-subtitle">
                                        Klik untuk mengganti file
                                    </p>
                                    <div class="flex items-center justify-center gap-2 text-green-400 text-sm font-medium">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>File siap diunggah</span>
                                    </div>
                                </div>
                            </div>
                            @error('file')
                                <p class="text-red-400 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="{{ route('dashboard') }}" 
                               class="flex-1 px-6 py-3.5 backdrop-blur-md border-2 rounded-xl transition-all duration-300 font-semibold text-center relative overflow-hidden group theme-btn-cancel">
                                <span class="relative z-10">Batal</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                            
                            <button type="submit" 
                                    class="flex-1 px-6 py-3.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-xl hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-semibold relative overflow-hidden group">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    Unggah dan Periksa
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </button>
                        </div>
                    </form>

                    {{-- PEMISAH DAN TOMBOL DEBUG --}}
                    <div class="relative flex items-center justify-center my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t theme-divider"></div>
                        </div>
                        <div class="relative px-4">
                            <span class="text-sm theme-divider-text">Atau</span>
                        </div>
                    </div>
                
                    {{-- TOMBOL DEBUG BARU --}}
                    <a href="{{ route('upload.debug') }}" 
                       class="w-full flex-1 px-6 py-3.5 backdrop-blur-md border-2 text-[#85BBEB] rounded-xl transition-all duration-300 font-semibold text-center relative overflow-hidden group flex items-center justify-center gap-2 theme-btn-debug">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.43a4 4 0 00-5.656 0L12 17.256l-1.772-1.826a4 4 0 00-5.656 0 4 4 0 000 5.656L12 24l7.428-7.914a4 4 0 000-5.656zM12 2a4 4 0 014 4v2a4 4 0 11-8 0V6a4 4 0 014-4z"></path></svg>
                        <span class="relative z-10">Gunakan File Testcase</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/10 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>

                </div>
            </div>

        </div>
    </main>
</div>

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

#navbar {
    background-color: rgba(10, 10, 46, 0.7);
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 10px 15px -3px rgba(133, 187, 235, 0.05);
}

.theme-btn-secondary {
    border-color: rgba(133, 187, 235, 0.4);
    color: #FEF9F0;
    background-color: rgba(254, 249, 240, 0);
}

.theme-btn-secondary:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.6);
}

.theme-btn-mobile {
    background-color: rgba(133, 187, 235, 0.1);
    border: 1px solid rgba(133, 187, 235, 0.3);
}

.theme-btn-mobile:hover {
    background-color: rgba(133, 187, 235, 0.2);
}

.theme-btn-logout {
    background-color: rgba(133, 187, 235, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-btn-logout:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.5);
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

.theme-mobile-menu {
    background-color: rgba(10, 10, 46, 0.95);
    border-color: rgba(133, 187, 235, 0.2);
}

.theme-breadcrumb {
    color: #85BBEB;
}

.theme-title {
    color: #FFFFFF;
}

.theme-subtitle {
    color: #C0C0C0;
}

.theme-success-msg {
    background: linear-gradient(to bottom right, rgba(16, 185, 129, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
}

.theme-error-msg {
    background: linear-gradient(to bottom right, rgba(239, 68, 68, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
}

.theme-upload-card {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-label {
    color: #FEF9F0;
}

.theme-input {
    background-color: rgba(26, 26, 64, 0.5);
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-input::placeholder {
    color: rgba(192, 192, 192, 0.5);
}

.theme-upload-area {
    background-color: rgba(26, 26, 64, 0.3);
    border-color: rgba(133, 187, 235, 0.4);
}

.theme-upload-area:hover {
    border-color: rgba(133, 187, 235, 0.6);
}

.theme-upload-title {
    color: #FEF9F0;
}

.theme-upload-subtitle {
    color: #C0C0C0;
}

.theme-btn-cancel {
    background-color: rgba(254, 249, 240, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-btn-cancel:hover {
    background-color: rgba(254, 249, 240, 0.2);
    border-color: rgba(133, 187, 235, 0.5);
}

.theme-divider {
    border-color: rgba(133, 187, 235, 0.2);
}

.theme-divider-text {
    color: #C0C0C0;
}

.theme-btn-debug {
    background-color: rgba(26, 26, 64, 0.5);
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-btn-debug:hover {
    background-color: rgba(26, 26, 64, 0.8);
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

/* Dynamic gradient text colors - DARK MODE */
.gradient-text-navbar {
    background: linear-gradient(to right, #FFFFFF, #85BBEB, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Light Mode */
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

body.light-mode .theme-btn-secondary {
    border-color: rgba(133, 187, 235, 0.3);
    color: #2D3748;
    background-color: rgba(255, 255, 255, 0.6);
}

body.light-mode .theme-btn-secondary:hover {
    background-color: rgba(133, 187, 235, 0.8);
    border-color: rgba(133, 187, 235, 0.5);
    color: #FFFFFF;
}

body.light-mode .theme-btn-mobile {
    background-color: rgba(133, 187, 235, 0.08);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-btn-mobile:hover {
    background-color: rgba(133, 187, 235, 0.15);
}

body.light-mode .theme-btn-logout {
    background-color: rgba(133, 187, 235, 0.08);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-btn-logout:hover {
    background-color: rgba(133, 187, 235, 0.15);
    border-color: rgba(133, 187, 235, 0.35);
}

body.light-mode .theme-tooltip {
    background-color: rgba(255, 255, 255, 0.98);
    border-color: rgba(133, 187, 235, 0.2);
    color: #2D3748;
}

body.light-mode .theme-tooltip-arrow {
    background-color: rgba(255, 255, 255, 0.98);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-mobile-menu {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.15);
}

body.light-mode .theme-breadcrumb {
    color: #85BBEB;
}

body.light-mode .theme-title {
    color: #1A202C;
}

body.light-mode .theme-subtitle {
    color: #4A5568;
}

body.light-mode .theme-success-msg {
    background: linear-gradient(to bottom right, rgba(16, 185, 129, 0.15), rgba(255, 255, 255, 0.9), rgba(250, 251, 252, 0.95));
}

body.light-mode .theme-error-msg {
    background: linear-gradient(to bottom right, rgba(239, 68, 68, 0.15), rgba(255, 255, 255, 0.9), rgba(250, 251, 252, 0.95));
}

body.light-mode .theme-upload-card {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(250, 251, 252, 0.9), rgba(245, 247, 250, 0.95));
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 4px 12px rgba(133, 187, 235, 0.1), 0 2px 4px rgba(0, 0, 0, 0.03);
}

body.light-mode .theme-label {
    color: #2D3748;
}

body.light-mode .theme-input {
    background-color: rgba(255, 255, 255, 0.8);
    border-color: rgba(133, 187, 235, 0.25);
    color: #2D3748;
}

body.light-mode .theme-input::placeholder {
    color: rgba(74, 85, 104, 0.5);
}

body.light-mode .theme-upload-area {
    background-color: rgba(250, 251, 252, 0.6);
    border-color: rgba(133, 187, 235, 0.3);
}

body.light-mode .theme-upload-area:hover {
    border-color: rgba(133, 187, 235, 0.5);
}

body.light-mode .theme-upload-title {
    color: #1A202C;
}

body.light-mode .theme-upload-subtitle {
    color: #4A5568;
}

body.light-mode .theme-btn-cancel {
    background-color: rgba(255, 255, 255, 0.7);
    border-color: rgba(133, 187, 235, 0.3);
    color: #2D3748;
}

body.light-mode .theme-btn-cancel:hover {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.5);
}

body.light-mode .theme-divider {
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-divider-text {
    color: #4A5568;
}

body.light-mode .theme-btn-debug {
    background-color: rgba(250, 251, 252, 0.8);
    border-color: rgba(133, 187, 235, 0.3);
}

body.light-mode .theme-btn-debug:hover {
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

/* Light mode gradient text overrides */
body.light-mode .gradient-text-navbar {
    background: linear-gradient(to right, #000000, #85BBEB, #000000);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
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

/* File Upload Animation */
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: scale(1); 
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
// Theme Toggle Function
function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');
    const themeIconMobile = document.getElementById('themeIconMobile');
    const themeTextMobile = document.getElementById('themeTextMobile');
    
    body.classList.toggle('light-mode');
    
    const isLightMode = body.classList.contains('light-mode');
    
    // Update icons
    const moonPath = 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z';
    const sunPath = 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z';
    
    if (isLightMode) {
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeIconMobile.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeTextMobile.textContent = 'Mode Gelap';
        localStorage.setItem('theme', 'light');
    } else {
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${moonPath}"/>`;
        themeIconMobile.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${moonPath}"/>`;
        themeTextMobile.textContent = 'Mode Terang';
        localStorage.setItem('theme', 'dark');
    }
}

// Load saved theme on page load
function loadTheme() {
    const savedTheme = localStorage.getItem('theme');
    // Default is dark mode, only apply light if explicitly saved
    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        const themeIcon = document.getElementById('themeIcon');
        const themeIconMobile = document.getElementById('themeIconMobile');
        const themeTextMobile = document.getElementById('themeTextMobile');
        const sunPath = 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z';
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeIconMobile.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeTextMobile.textContent = 'Mode Gelap';
    }
}

// Toggle mobile menu
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobileMenu');
    const button = event.target.closest('button[onclick="toggleMobileMenu()"]');
    
    if (!button && menu && !menu.classList.contains('hidden')) {
        if (!menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    }
});

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

// File Upload Handler
function updateFileName(input) {
    const defaultState = document.getElementById('upload-default');
    const successState = document.getElementById('upload-success');
    const fileNameDisplay = document.getElementById('file-name');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;

        // Validasi ekstensi file
        const allowedExtensions = ['pdf', 'doc', 'docx'];
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            input.value = ''; // reset input
            
            // Kembalikan ke default
            defaultState.classList.remove('hidden');
            successState.classList.add('hidden');
            return;
        }

        // Kalau format benar → tampilkan nama file
        fileNameDisplay.textContent = fileName;

        // Ubah tampilan jadi "file berhasil dipilih"
        defaultState.classList.add('hidden');
        successState.classList.remove('hidden');
        successState.classList.add('animate-fadeIn');

        // Hilangkan animasi setelah selesai
        setTimeout(() => {
            successState.classList.remove('animate-fadeIn');
        }, 300);
    } else {
        // Jika user batal pilih file → kembalikan ke default
        defaultState.classList.remove('hidden');
        successState.classList.add('hidden');
    }
}

// Drag and Drop Enhancement
const uploadArea = document.querySelector('[id="document"]').parentElement;

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    uploadArea.classList.add('border-[#85BBEB]', 'bg-[#85BBEB]/5');
}

function unhighlight(e) {
    uploadArea.classList.remove('border-[#85BBEB]', 'bg-[#85BBEB]/5');
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    const fileInput = document.getElementById('document');
    fileInput.files = files;
    updateFileName(fileInput);
}
</script>

@endsection