@extends('layouts.app')

@section('title', 'Lupa Password - Elektronik Modern')

@section('header')
    <!-- no header -->
@endsection

@section('content')
    <div class="min-h-screen bg-g50 flex items-center justify-center p-5">
        <x-card class="w-full max-w-[420px] relative">
            <a href="{{ route('index') }}" class="absolute top-5 left-5 w-10 h-10 rounded-full bg-g50 flex items-center justify-center text-g500 hover:text-primary hover:bg-primary-light transition-all">
                <i class="fi fi-rr-angle-small-left text-xl"></i>
            </a>

            <div class="w-14 h-14 bg-primary-light text-primary rounded-2xl flex items-center justify-center text-[28px] mx-auto mb-5 mt-4">
                <i class="fi fi-rr-key"></i>
            </div>
            <h1 class="font-heading text-2xl font-extrabold text-g900 text-center mb-1.5">Lupa Password</h1>
            <p class="text-sm text-g500 text-center mb-8">Masukkan email akun Anda untuk melanjutkan reset password</p>

            <form method="POST" action="{{ route('password.email.verify') }}">
                @csrf
                <div class="mb-5">
                    <x-label for="email">Email</x-label>
                    <x-input type="email" id="email" name="email" :value="old('email')" placeholder="nama@email.com" 
                        :error="$errors->has('email')" required autofocus />
                    <x-error :messages="$errors->get('email')" />
                </div>
                <x-button type="submit" class="w-full">
                    Lanjutkan <i class="fi fi-rr-arrow-right"></i>
                </x-button>
            </form>

            <div class="flex items-center my-6 gap-3 before:flex-1 before:h-px before:bg-g200 after:flex-1 after:h-px after:bg-g200 text-xs font-bold text-g400 uppercase tracking-widest text-center">atau</div>
            
            <div class="text-center text-[13px] font-semibold text-g500">
                Ingat password? <a href="{{ route('login') }}" class="text-primary font-extrabold hover:underline">Masuk di sini</a>
            </div>
        </x-card>
    </div>
@endsection

@section('footer')
    <!-- no footer -->
@endsection

