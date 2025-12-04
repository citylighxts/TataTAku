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
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo" class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>

                {{-- TataTAku - Centered --}}
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <span class="text-2xl font-bold gradient-text-navbar animate-gradient-text bg-[length:200%_auto] whitespace-nowrap">TataTAku</span>
                </div>

                {{-- Desktop Actions --}}
                <div class="hidden md:flex gap-3 items-center">
                    {{-- Theme Toggle Button --}}
                    <button onclick="toggleTheme()" class="w-10 h-10 rounded-full border-2 transition-all duration-300 flex items-center justify-center group relative overflow-hidden" id="themeToggle">
                        <svg class="w-5 h-5 transition-all duration-300" id="themeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <a href="{{ route('register') }}" class="px-6 py-2.5 border-2 rounded-full transition-all duration-300 font-medium backdrop-blur-sm relative overflow-hidden group theme-btn-secondary">
                        <span class="relative z-10">Daftar</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button class="md:hidden w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300 theme-btn-mobile" onclick="toggleMobileMenu()">
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
                <a href="{{ route('register') }}" class="block w-full px-6 py-3 border-2 rounded-full transition-all duration-300 font-medium text-center theme-btn-secondary">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    {{-- Login Section --}}
    <section class="relative z-10 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 min-h-[calc(100vh-88px)]">
        <div class="w-full max-w-6xl">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                {{-- Left Content - Info Section --}}
                <div class="hidden lg:block space-y-6 fade-in-up">
                    <div class="space-y-4">
                        <div class="inline-block relative">
                            <div class="absolute inset-0 bg-[#85BBEB]/20 blur-xl rounded-full"></div>
                            <span class="relative px-5 py-2.5 bg-gradient-to-r from-[#85BBEB]/30 via-[#85BBEB]/20 to-transparent backdrop-blur-md border border-[#85BBEB]/40 rounded-full text-[#0088ff] text-sm font-medium shadow-lg shadow-[#85BBEB]/10 flex items-center gap-2 w-fit">
                                <span class="animate-pulse">👋</span>
                                <span>Selamat Datang Kembali</span>
                            </span>
                        </div>
                        
                        <h1 class="text-4xl lg:text-5xl font-black leading-tight transition-colors duration-500 theme-title">
                            <span class="inline-block">Masuk ke</span><br>
                            <span class="relative inline-block">
                                <span class="absolute inset-0 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] blur-2xl opacity-20"></span>
                                <span class="relative gradient-text-hero animate-gradient-text bg-[length:200%_auto]">Akun Anda</span>
                            </span>
                        </h1>
                        
                        <p class="text-lg leading-relaxed relative pl-4 transition-colors duration-500 theme-subtitle">
                            <span class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-[#85BBEB] to-transparent rounded-full"></span>
                            Lanjutkan perjalanan menyempurnakan tulisan Anda dengan teknologi AI terdepan.
                        </p>
                    </div>


                    {{-- Decorative Image --}}
                    <div class="relative mt-8 flex justify-center">
                        <div class="absolute inset-0 bg-[#85BBEB]/20 rounded-full blur-3xl"></div>
                        <img src="{{ asset('images/logo-tatakata.png') }}" alt="Logo" class="relative w-64 h-64 object-contain opacity-30 animate-spin-slow">
                    </div>
                </div>

                {{-- Right Content - Login Form --}}
                <div class="relative fade-in-up" style="animation-delay: 0.2s;">
                    {{-- Mobile Logo --}}
                    <div class="lg:hidden text-center mb-6">
                        <h1 class="text-3xl font-bold gradient-text-hero animate-gradient-text bg-[length:200%_auto]">
                            TataTAku
                        </h1>
                        <p class="mt-2 transition-colors duration-500 theme-subtitle">Masuk ke akun Anda</p>
                    </div>

                    {{-- Form Card --}}
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/30 via-[#FEF9F0]/20 to-[#85BBEB]/30 rounded-3xl blur-2xl opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-20 blur"></div>
                        
                        <div class="relative backdrop-blur-xl rounded-3xl p-8 sm:p-10 border shadow-2xl transition-all duration-500 theme-card-inner">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl sm:text-3xl font-bold mb-2 transition-colors duration-500 theme-title">Selamat Datang</h2>
                                <p class="transition-colors duration-500 theme-subtitle">Masuk untuk melanjutkan</p>
                            </div>

                            {{-- Status Messages --}}
                            @if (session('status'))
                                <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/30 backdrop-blur-sm">
                                    <p class="text-green-300 text-sm flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ session('status') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Error Messages --}}
                            @if ($errors->any())
                                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 backdrop-blur-sm">
                                    <ul class="space-y-2">
                                        @foreach ($errors->all() as $error)
                                            <li class="flex items-start gap-2 text-red-300 text-sm">
                                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>{{ $error }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Login Form --}}
                            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                                @csrf

                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-semibold transition-colors duration-500 theme-label">
                                        Alamat Email
                                    </label>
                                    <div class="relative group">
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                            class="w-full px-4 py-3 rounded-xl border outline-none transition-all duration-300 backdrop-blur-sm theme-input"
                                            placeholder="nama@email.com">
                                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/5 to-[#85BBEB]/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold transition-colors duration-500 theme-label">
                                        Kata Sandi
                                    </label>
                                    <div class="relative group">
                                        <input id="password" type="password" name="password" required
                                            class="w-full px-4 py-3 rounded-xl border outline-none transition-all duration-300 backdrop-blur-sm pr-12 theme-input password-input">
                                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/5 to-[#85BBEB]/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-[#85BBEB] focus:outline-none transition-colors duration-300 theme-eye-icon z-10">
                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Remember Me & Forgot Password --}}
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="checkbox" name="remember" id="remember_me"
                                            class="w-4 h-4 rounded border-[#85BBEB]/30 bg-[#0A0A2E]/50 text-[#85BBEB] focus:ring-[#85BBEB] focus:ring-offset-0 transition-all">
                                        <span class="text-sm transition-colors duration-500 theme-subtitle group-hover:text-[#FEF9F0]">Ingat saya</span>
                                    </label>

                                    <!-- @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-sm text-[#85BBEB] transition-colors duration-300 forgot-password-link">
                                            Lupa kata sandi?
                                        </a>
                                    @endif -->
                                </div>

                                {{-- Submit Button --}}
                                <div class="pt-2">
                                    <button type="submit"
                                        class="w-full group px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-bold flex items-center justify-center gap-2 relative overflow-hidden">
                                        <span class="relative z-10 flex items-center gap-2">
                                            Masuk
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                    </button>
                                </div>
                            </form>

                            {{-- Register Link --}}
                            <div class="text-center mt-6">
                                <p class="transition-colors duration-500 theme-subtitle">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="text-[#85BBEB] font-semibold transition-colors duration-300 register-link">
                                        Daftar sekarang
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Remove browser default password reveal icon */
.password-input::-ms-reveal,
.password-input::-ms-clear {
    display: none;
}

.password-input::-webkit-contacts-auto-fill-button,
.password-input::-webkit-credentials-auto-fill-button {
    visibility: hidden;
    display: none !important;
    pointer-events: none;
    height: 0;
    width: 0;
    margin: 0;
}

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

.theme-mobile-menu {
    background-color: rgba(10, 10, 46, 0.95);
}

.theme-title {
    color: #FFFFFF;
}

.theme-subtitle {
    color: #C0C0C0;
}

.theme-label {
    color: #FEF9F0;
}

.theme-card-inner {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(133, 187, 235, 0.1));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-input {
    background-color: rgba(10, 10, 46, 0.5);
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-input::placeholder {
    color: #C0C0C0;
}

.theme-input:focus {
    border-color: #85BBEB;
    ring: 2px;
    ring-color: rgba(133, 187, 235, 0.5);
}

.theme-eye-icon {
    color: #85BBEB;
}

.theme-eye-icon:hover {
    color: #FEF9F0;
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

body.light-mode .theme-mobile-menu {
    background-color: rgba(255, 255, 255, 0.95);
}

body.light-mode .theme-title {
    color: #1A202C;
}

body.light-mode .theme-subtitle {
    color: #4A5568;
}

body.light-mode .theme-label {
    color: #2D3748;
}

body.light-mode .theme-card-inner {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.98), rgba(250, 251, 252, 0.95), rgba(245, 247, 250, 0.98));
    border-color: rgba(133, 187, 235, 0.25);
    box-shadow: 0 4px 12px rgba(133, 187, 235, 0.1), 0 2px 4px rgba(0, 0, 0, 0.03);
}

body.light-mode .theme-input {
    background-color: rgba(255, 255, 255, 0.9);
    border-color: rgba(133, 187, 235, 0.25);
    color: #1A202C;
}

body.light-mode .theme-input::placeholder {
    color: #718096;
}

body.light-mode .theme-input:focus {
    border-color: #85BBEB;
    background-color: #FFFFFF;
}

body.light-mode .theme-eye-icon {
    color: #85BBEB;
}

body.light-mode .theme-eye-icon:hover {
    color: #2C5282;
}

/* Light mode hover colors for links */
body.light-mode .theme-subtitle.group-hover\:text-\[\#FEF9F0\] {
    color: #4A5568;
}

body.light-mode label.group:hover .theme-subtitle {
    color: #2C5282 !important;
}

body.light-mode a.forgot-password-link {
    color: #85BBEB;
}

body.light-mode a.forgot-password-link:hover {
    color: #2C5282 !important;
}

body.light-mode a.register-link {
    color: #85BBEB;
}

body.light-mode a.register-link:hover {
    color: #2C5282 !important;
    text-decoration: underline;
}

/* Dark mode link hovers */
a.forgot-password-link:hover {
    color: #FEF9F0;
}

a.register-link:hover {
    color: #FEF9F0;
    text-decoration: underline;
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
    0%, 100% {
        opacity: 0.5;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-subtle {
    animation: pulse-subtle 2s ease-in-out infinite;
}

/* Spin Animation */
@keyframes spin-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin-slow {
    animation: spin-slow 20s linear infinite;
}

/* Scroll Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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

    // Password Toggle Function
    function setEyeIcon(iconEl, isShown) {
        if (!iconEl) return;
        if (isShown) {
            iconEl.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12s-4.5 7.5-10.5 7.5S1.5 12 1.5 12z" />
                <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round" />`;
        } else {
            iconEl.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }

    // Password field
    const passwordField = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    // Set initial icon
    if (eyeIcon && passwordField) setEyeIcon(eyeIcon, passwordField.type === 'text');

    // Toggle password
    if (togglePassword && passwordField && eyeIcon) {
        togglePassword.addEventListener('click', function () {
            const willShow = passwordField.type === 'password';
            passwordField.type = willShow ? 'text' : 'password';
            setEyeIcon(eyeIcon, willShow);
        });
    }
});
</script>
@endsection