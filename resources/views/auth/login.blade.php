@extends('layouts.app')

@section('title', 'Masuk - Elektronik Modern')

@section('header')
    <!-- no header -->
@endsection

@section('content')
<div class="min-h-screen bg-g50 flex items-center justify-center p-5">
    <x-card class="w-full max-w-[420px] relative">
        <a href="{{ route('index') }}"
            class="absolute top-5 left-5 w-10 h-10 rounded-full bg-g50 flex items-center justify-center text-g500 hover:text-primary hover:bg-primary-light transition-all">
            <i class="fi fi-rr-angle-small-left text-xl"></i>
        </a>

        @include('partials.robot-mascot')
        <h1 class="font-heading text-2xl font-extrabold text-g900 text-center mb-1.5">Selamat Datang!</h1>
        <p class="text-sm text-g500 text-center mb-8">Masuk ke akun Elektronik Modern Anda</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5">
                <x-label for="email">Email</x-label>
                <x-input type="email" id="email" name="email" :value="old('email')" placeholder="nama@email.com"
                    :error="$errors->has('email')" required autofocus />
                <x-error :messages="$errors->get('email')" />
            </div>

            <div class="mb-5">
                <x-label for="password">Password</x-label>
                <div class="relative">
                    <x-input type="password" id="password" name="password" placeholder="Masukkan password..."
                        :error="$errors->has('password')" required class="pr-12" />
                    <button type="button" onclick="togglePassword('password', this)" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-g400 hover:text-primary transition-colors focus:outline-none">
                        <i class="fi fi-rr-eye-crossed text-lg"></i>
                    </button>
                </div>
                <x-error :messages="$errors->get('password')" />
            </div>

            <div class="text-right -mt-2 mb-5">
                <a href="{{ route('password.request') }}" class="text-[13px] text-primary font-bold hover:underline">
                    Lupa password?
                </a>
            </div>

            <x-button type="submit" class="w-full">
                Masuk ke Akun <i class="fi fi-rr-arrow-right"></i>
            </x-button>
        </form>

        <div class="mt-8 text-center text-[13px] font-semibold text-g500">
            Belum punya akun? <a href="{{ route('register') }}"
                class="text-primary font-extrabold hover:underline">Daftar sekarang</a>
        </div>
    </x-card>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fi-rr-eye-crossed');
            icon.classList.add('fi-rr-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fi-rr-eye');
            icon.classList.add('fi-rr-eye-crossed');
        }
    }
</script>
@endsection

@section('footer')
    <!-- no footer -->
@endsection