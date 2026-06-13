@extends('layouts.app')

@section('title', 'Reset Password - Elektronik Modern')

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
                <i class="fi fi-rr-unlock"></i>
            </div>
            <h1 class="font-heading text-2xl font-extrabold text-g900 text-center mb-1.5">Password Baru</h1>
            <p class="text-sm text-g500 text-center mb-8">Buat password baru untuk akun {{ $email }}</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-5">
                    <x-label for="password">Password Baru</x-label>
                    <x-input type="password" id="password" name="password" placeholder="Min. 8 karakter" 
                        :error="$errors->has('password')" required autofocus />
                    <x-error :messages="$errors->get('password')" />
                </div>
                <div class="mb-6">
                    <x-label for="password_confirmation">Konfirmasi Password Baru</x-label>
                    <x-input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru..." 
                        required />
                </div>
                <x-button type="submit" class="w-full">
                    Simpan Password Baru <i class="fi fi-rr-check"></i>
                </x-button>
            </form>
        </x-card>
    </div>
@endsection

@section('footer')
    <!-- no footer -->
@endsection

