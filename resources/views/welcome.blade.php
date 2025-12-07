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

                    <a href="{{ route('login') }}" class="px-4 lg:px-6 py-2 lg:py-2.5 border-2 rounded-full transition-all duration-300 font-medium backdrop-blur-sm relative overflow-hidden group text-sm lg:text-base theme-btn-secondary">
                        <span class="relative z-10">Masuk</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                    <a href="{{ route('register') }}" class="px-4 lg:px-6 py-2 lg:py-2.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-medium relative overflow-hidden group text-sm lg:text-base">
                        <span class="relative z-10 font-semibold">Daftar</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
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
                <a href="{{ route('login') }}" class="block w-full px-6 py-3 border-2 rounded-full transition-all duration-300 font-medium text-center theme-btn-secondary">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full px-6 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-semibold text-center">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            {{-- Left Content --}}
            <div class="space-y-8 fade-in-up">
                <div class="inline-block relative">
                    <div class="absolute inset-0 bg-[#85BBEB]/20 blur-xl rounded-full"></div>
                    <span class="relative px-5 py-2.5 bg-gradient-to-r from-[#85BBEB]/30 via-[#85BBEB]/20 to-transparent backdrop-blur-md border border-[#85BBEB]/40 rounded-full text-[#85BBEB] text-sm font-medium shadow-lg shadow-[#85BBEB]/10 flex items-center gap-2">
                        <span class="animate-pulse">✨</span>
                        <span>Powered by AI Technology</span>
                    </span>
                </div>
                
                <div class="space-y-6">
                    <h1 class="text-5xl lg:text-7xl font-black leading-tight transition-colors duration-500" id="heroTitle">
                        <span class="inline-block hover:scale-105 transition-transform duration-300">Periksa</span> 
                        <span class="inline-block hover:scale-105 transition-transform duration-300">Kata,</span><br>
                        <span class="relative inline-block">
                            <span class="absolute inset-0 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] blur-2xl opacity-20"></span>
                            <span class="relative gradient-text-hero animate-gradient-text bg-[length:200%_auto]">Sempurnakan Bahasa</span>
                        </span>
                    </h1>
                    <p class="text-xl leading-relaxed max-w-xl relative transition-colors duration-500" id="heroDesc">
                        <span class="absolute -left-3 top-0 w-1 h-full bg-gradient-to-b from-[#85BBEB] to-transparent rounded-full"></span>
                        Platform koreksi tata bahasa berbasis AI yang membantu menyempurnakan tulisan <strong>tugas akhir</strong> Anda dengan akurat dan efisien.
                    </p>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="group px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-semibold flex items-center gap-2 relative overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            Mulai Gratis
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                    <a href="#features" class="px-8 py-4 backdrop-blur-md border-2 rounded-full transition-all duration-300 font-semibold relative overflow-hidden group theme-btn-outline">
                        <span class="relative z-10">Pelajari Lebih Lanjut</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                </div>
            </div>

            {{-- Right Content - Logo --}}
            <div class="relative flex items-center justify-center fade-in-up" style="animation-delay: 0.2s;">
                <div class="absolute inset-0 bg-[#85BBEB]/20 rounded-full blur-2xl animate-spin-slow"></div>
                <div class="relative group cursor-pointer">
                    <img src="{{ asset('images/logo-tatakata.png') }}" 
                         alt="Logo Tata Kata" 
                         class="relative w-full max-w-md lg:max-w-lg drop-shadow-2xl transition-all duration-[2000ms] ease-in-out group-hover:scale-110 group-hover:rotate-[360deg]">
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-4xl lg:text-5xl font-bold mb-4 transition-colors duration-500 theme-title">
                Fitur <span class="gradient-text-section">Unggulan</span>
            </h2>
            <p class="text-xl transition-colors duration-500 theme-subtitle">
                Teknologi AI terdepan untuk analisis bahasa yang komprehensif
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Feature Cards --}}
            <div class="group relative fade-in-up theme-card" style="animation-delay: 0.1s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-2xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                <div class="relative backdrop-blur-xl rounded-2xl p-8 border transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/20 theme-card-inner">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg shadow-[#85BBEB]/50">
                        <svg class="w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-[#85BBEB] transition-colors duration-300 theme-card-title">Pemeriksaan Tata Bahasa</h3>
                    <p class="leading-relaxed theme-card-text">Deteksi otomatis kesalahan tata bahasa, ejaan, dan struktur kalimat dengan akurasi tinggi menggunakan AI terbaru.</p>
                </div>
            </div>

            <div class="group relative fade-in-up theme-card" style="animation-delay: 0.2s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="relative backdrop-blur-xl rounded-2xl p-8 border transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl theme-card-inner">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-[#85BBEB] transition-colors duration-300 theme-card-title">Analisis Real-time</h3>
                    <p class="leading-relaxed theme-card-text">Proses dokumen dengan cepat dan dapatkan hasil analisis komprehensif dalam hitungan detik dengan teknologi AI canggih.</p>
                </div>
            </div>

            <div class="group relative fade-in-up theme-card" style="animation-delay: 0.3s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="relative backdrop-blur-xl rounded-2xl p-8 border transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl theme-card-inner">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#85BBEB] to-[#C0C0C0] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-[#85BBEB] transition-colors duration-300 theme-card-title">Aman & Privat</h3>
                    <p class="leading-relaxed theme-card-text">Dokumen Anda tersimpan dengan enkripsi tingkat tinggi dan tidak akan dibagikan kepada pihak lain. Privasi terjamin 100%.</p>
                </div>
            </div>

            <div class="group relative fade-in-up theme-card" style="animation-delay: 0.4s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="relative backdrop-blur-xl rounded-2xl p-8 border transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl theme-card-inner">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-[#85BBEB] transition-colors duration-300 theme-card-title">100% Gratis</h3>
                    <p class="leading-relaxed theme-card-text">Semua fitur premium dapat diakses secara gratis tanpa biaya tersembunyi. Tidak ada batasan penggunaan atau watermark.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-4xl lg:text-5xl font-bold mb-4 transition-colors duration-500 theme-title">
                Cara <span class="gradient-text-section">Kerja</span>
            </h2>
            <p class="text-xl transition-colors duration-500 theme-subtitle">
                Tiga langkah sederhana untuk menyempurnakan tulisan Anda
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            <div class="hidden md:block absolute top-24 left-0 right-0 h-0.5">
                <div class="h-full w-full bg-gradient-to-r from-transparent via-[#85BBEB]/50 to-transparent"></div>
            </div>
            
            <div class="relative text-center fade-in-up" style="animation-delay: 0.1s;">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-2xl blur-md opacity-50 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/80 rounded-2xl text-[#0A0A2E] text-2xl font-bold shadow-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                        1
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-3 transition-colors duration-500 theme-title">Unggah Dokumen Tugas Akhir</h3>
                <p class="transition-colors duration-500 theme-subtitle">Upload file PDF yang ingin Anda periksa</p>
            </div>

            <div class="relative text-center fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-2xl blur-md opacity-50 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-2xl text-[#0A0A2E] text-2xl font-bold shadow-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                        2
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-3 transition-colors duration-500 theme-title">AI Menganalisis</h3>
                <p class="transition-colors duration-500 theme-subtitle">Sistem AI kami memproses dan menganalisis dokumen Anda</p>
            </div>

            <div class="relative text-center fade-in-up" style="animation-delay: 0.3s;">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB] to-[#C0C0C0] rounded-2xl blur-md opacity-50 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#C0C0C0] rounded-2xl text-[#0A0A2E] text-2xl font-bold shadow-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                        3
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-3 transition-colors duration-500 theme-title">Terima Hasil</h3>
                <p class="transition-colors duration-500 theme-subtitle">Dapatkan laporan saran perbaikan</p>
            </div>
        </div>
    </section>

    {{-- Tutorial Section --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20" id="tutorial">
        <div class="text-center mb-12 fade-in-up">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4 transition-colors duration-500 theme-title">
                Panduan <span class="gradient-text-section">Penggunaan</span>
            </h2>
            <p class="text-xl transition-colors duration-500 theme-subtitle">
                Pelajari cara menggunakan fitur TataTAku
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="relative group fade-in-up" style="animation-delay: 0.1s;">
                <div class="absolute inset-0 bg-[#85BBEB]/20 blur-2xl rounded-2xl group-hover:bg-[#85BBEB]/30 transition-all duration-500"></div>
                <div class="relative rounded-2xl overflow-hidden border border-[#85BBEB]/30 shadow-2xl bg-black">
                    <a href="https://youtu.be/CDeVoO-POnA" target="_blank" class="block relative w-full h-[300px] sm:h-[400px] group cursor-pointer overflow-hidden">
                        
                        <img 
                            src="https://img.youtube.com/vi/CDeVoO-POnA/maxresdefault.jpg" 
                            alt="Tutorial Preview" 
                            class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
                        >

                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors duration-300"></div>

                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="relative w-20 h-20 flex items-center justify-center">
                                <div class="absolute inset-0 bg-[#FF0000] rounded-full animate-ping opacity-20 group-hover:opacity-40"></div>
                                <div class="relative w-16 h-16 bg-[#FF0000] rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white fill-current ml-1" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="absolute bottom-6 left-0 right-0 text-center">
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black/60 backdrop-blur-md border border-white/10 text-white text-sm font-medium group-hover:bg-black/80 transition-colors">
                                <svg class="w-4 h-4 text-[#FF0000]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                </svg>
                                Tonton Tutorial
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative theme-card rounded-2xl p-8 border backdrop-blur-xl transition-all duration-500 theme-card-inner">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold theme-card-title">Buku Petunjuk Lengkap</h3>
                            <p class="leading-relaxed theme-card-text">
                                Lebih suka membaca? Unduh dokumen panduan lengkap (PDF) yang berisi instruksi langkah demi langkah, tips penggunaan, dan penjelasan fitur secara mendetail.
                            </p>
                            
                            <div class="pt-2">
                                <a href="{{ asset('files/Buku-Petunjuk.pdf') }}" target="_blank" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-lg hover:shadow-[#85BBEB]/40 hover:-translate-y-1 transition-all duration-300 font-semibold group relative overflow-hidden">
                                    <span class="relative z-10 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Unduh PDF
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="relative fade-in-up">
            <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/30 via-[#FEF9F0]/20 to-[#85BBEB]/30 rounded-3xl blur-3xl opacity-60"></div>
            <div class="absolute -inset-1 bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-20 blur"></div>
            <div class="relative backdrop-blur-xl rounded-3xl p-12 border text-center shadow-2xl transition-all duration-500 theme-cta">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 transition-colors duration-500 theme-title">
                    Siap Menyempurnakan<br/>
                    <span class="gradient-text-cta animate-gradient-text bg-[length:200%_auto]">Tugas Akhir Anda?</span>
                </h2>
                <p class="text-xl mb-8 max-w-1xl mx-auto leading-relaxed transition-colors duration-500 theme-subtitle">
                    Bergabunglah dengan <span class="text-[#85BBEB] font-semibold">mahasiswa</span> yang telah mempercayai <span class="text-[#85BBEB] font-semibold">TataTAku</span> untuk menyempurnakan tugas akhir mereka.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] text-lg rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        Mulai Sekarang - Gratis
                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="relative z-10 border-t backdrop-blur-xl mt-20 transition-all duration-500 theme-footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#85BBEB] rounded-lg blur opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <img src="{{ asset('images/logofix.png') }}" alt="Logo" class="relative w-10 h-10 rounded-lg">
                        </div>
                        <span class="text-xl font-bold gradient-text-footer">TataTAku</span>
                    </div>
                    <p class="leading-relaxed transition-colors duration-500 theme-footer-text">
                        Platform koreksi tata bahasa berbasis AI untuk menyempurnakan tulisan <strong>tugas akhir</strong> Anda.
                    </p>
                    
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold transition-colors duration-500 theme-title">Lompat Ke</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="transition-colors duration-300 flex items-center gap-2 group theme-link">
                            <span class="w-0 group-hover:w-2 h-0.5 bg-[#85BBEB] transition-all duration-300"></span>
                            Fitur
                        </a></li>
                        <li><a href="{{ route('register') }}" class="transition-colors duration-300 flex items-center gap-2 group theme-link">
                            <span class="w-0 group-hover:w-2 h-0.5 bg-[#85BBEB] transition-all duration-300"></span>
                            Daftar
                        </a></li>
                        <li><a href="{{ route('login') }}" class="transition-colors duration-300 flex items-center gap-2 group theme-link">
                            <span class="w-0 group-hover:w-2 h-0.5 bg-[#85BBEB] transition-all duration-300"></span>
                            Masuk
                        </a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold transition-colors duration-500 theme-title">Tutorial Penggunaan Website</h3>
                    <ul class="space-y-3 theme-footer-text">

                        <!--ICON VIDEO -->
                        <li class="flex items-center gap-3 group hover:text-[#85BBEB] transition-colors duration-300">
                            <div class="w-8 h-8 rounded-lg bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center group-hover:bg-[#85BBEB]/20 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <!-- Ikon Video -->
                                    <path d="M4 4h8a2 2 0 012 2v2l4-2v8l-4-2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <a href="https://youtu.be/CDeVoO-POnA?si=pgJUyJas9ra3UUbI" class="hover:text-[#85BBEB] transition-colors duration-300">Panduan Penggunaan Website TataTAku</a>
                        </li>

                    </ul>
                </div>

            </div>

            <div class="border-t pt-8 flex flex-col md:flex-row justify-between items-center gap-4 transition-colors duration-500 theme-footer-border">
                <p class="text-sm theme-footer-text">&copy; {{ date('Y') }} TataTAku. Semua hak dilindungi.</p>
                <!-- <div class="flex gap-6 text-xl theme-footer-text">
                    <a class="hover:text-[#85BBEB] transition-colors duration-300">Tutorial Penggunaan Website:</a>
                    <a href="https://youtu.be/CDeVoO-POnA?si=pgJUyJas9ra3UUbI" class="hover:text-[#85BBEB] transition-colors duration-300">Klik Di sini</a>
                </div> -->
            </div>
        </div>
    </footer>
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

.theme-btn-outline {
    background-color: rgba(254, 249, 240, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-btn-outline:hover {
    background-color: rgba(254, 249, 240, 0.2);
    border-color: rgba(133, 187, 235, 0.5);
}

#heroTitle {
    color: #FFFFFF;
}

#heroDesc {
    color: #C0C0C0;
}

.theme-title {
    color: #FFFFFF;
}

.theme-subtitle {
    color: #C0C0C0;
}

.theme-card-inner {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-card-inner:hover {
    border-color: rgba(133, 187, 235, 0.6);
}

.theme-card-title {
    color: #FFFFFF;
}

.theme-card-text {
    color: #C0C0C0;
}

.theme-cta {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(133, 187, 235, 0.1));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-footer {
    border-color: rgba(133, 187, 235, 0.2);
    background-color: rgba(10, 10, 46, 0.8);
}

.theme-footer-text {
    color: #C0C0C0;
}

.theme-footer-border {
    border-color: rgba(133, 187, 235, 0.2);
}

.theme-link {
    color: #C0C0C0;
}

.theme-link:hover {
    color: #85BBEB;
}

.theme-mobile-menu {
    background-color: rgba(10, 10, 46, 0.95);
    border-color: rgba(133, 187, 235, 0.2);
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

.gradient-text-hero {
    background: linear-gradient(to right, #85BBEB, #FFFFFF, #85BBEB);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.gradient-text-section {
    background: linear-gradient(to right, #85BBEB, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.gradient-text-cta {
    background: linear-gradient(to right, #85BBEB, #FFFFFF, #85BBEB);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.gradient-text-footer {
    background: linear-gradient(to right, #FFFFFF, #85BBEB);
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

body.light-mode .theme-btn-outline {
    background-color: rgba(255, 255, 255, 0.7);
    border-color: rgba(133, 187, 235, 0.3);
    color: #2D3748;
}

body.light-mode .theme-btn-outline:hover {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.5);
}

body.light-mode .theme-mobile-menu {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.15);
}

body.light-mode #heroTitle {
    color: #1A202C;
}

body.light-mode #heroDesc {
    color: #4A5568;
}

body.light-mode .theme-title {
    color: #1A202C;
}

body.light-mode .theme-subtitle {
    color: #4A5568;
}

body.light-mode .theme-card-inner {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(250, 251, 252, 0.9), rgba(245, 247, 250, 0.95));
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
}

body.light-mode .theme-card-inner:hover {
    border-color: rgba(133, 187, 235, 0.35);
    box-shadow: 0 8px 16px rgba(133, 187, 235, 0.12), 0 2px 4px rgba(0, 0, 0, 0.04);
}

body.light-mode .theme-card-title {
    color: #1A202C;
}

body.light-mode .theme-card-text {
    color: #4A5568;
}

body.light-mode .theme-cta {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.98), rgba(250, 251, 252, 0.95), rgba(245, 247, 250, 0.98));
    border-color: rgba(133, 187, 235, 0.25);
    box-shadow: 0 4px 12px rgba(133, 187, 235, 0.1), 0 2px 4px rgba(0, 0, 0, 0.03);
}

body.light-mode .theme-footer {
    border-color: rgba(133, 187, 235, 0.15);
    background-color: rgba(255, 255, 255, 0.92);
}

body.light-mode .theme-footer-text {
    color: #4A5568;
}

body.light-mode .theme-footer-border {
    border-color: rgba(133, 187, 235, 0.15);
}

body.light-mode .theme-link {
    color: #4A5568;
}

body.light-mode .theme-link:hover {
    color: #85BBEB;
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

body.light-mode .gradient-text-hero {
    background: linear-gradient(to right, #85BBEB, #000000, #85BBEB);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

body.light-mode .gradient-text-section {
    background: linear-gradient(to right, #85BBEB, #000000);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

body.light-mode .gradient-text-cta {
    background: linear-gradient(to right, #85BBEB, #000000, #85BBEB);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

body.light-mode .gradient-text-footer {
    background: linear-gradient(to right, #000000, #85BBEB);
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

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin-slow { 
    animation: spin-slow 20s linear infinite; 
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
</script>

@endsection