@extends('layouts.app')

@section('title', 'Daftar – Elektronik Modern')

@section('header')
    <!-- no header -->
@endsection

@section('content')
<div class="min-h-screen bg-g50 flex items-center justify-center p-5">
    <x-card class="w-full max-w-[460px] md:p-10 relative">
        <a href="{{ route('index') }}"
            class="absolute top-5 left-5 w-10 h-10 rounded-full bg-g50 flex items-center justify-center text-g500 hover:text-primary hover:bg-primary-light transition-all">
            <i class="fi fi-rr-angle-small-left text-xl"></i>
        </a>

        <div
            class="w-14 h-14 bg-primary-light text-primary rounded-2xl flex items-center justify-center text-[28px] mx-auto mb-5 mt-4">
            <i class="fi fi-rr-edit"></i>
        </div>
        <h1 class="font-heading text-2xl font-extrabold text-g900 text-center mb-1.5">Buat Akun Baru</h1>
        <p class="text-sm text-g500 text-center mb-8">Bergabung dengan Elektronik Modern — gratis!</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <x-label for="nama">Nama Lengkap</x-label>
                <x-input type="text" id="nama" name="nama" :value="old('nama')" placeholder="Masukkan nama lengkap..."
                    :error="$errors->has('nama')" required autofocus />
                <x-error :messages="$errors->get('nama')" />
            </div>

            <div class="mb-4">
                <x-label for="email">Email</x-label>
                <x-input type="email" id="email" name="email" :value="old('email')" placeholder="nama@email.com"
                    :error="$errors->has('email')" required />
                <x-error :messages="$errors->get('email')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <x-label for="password">Password</x-label>
                    <x-input type="password" id="password" name="password" placeholder="Min. 8 karakter"
                        :error="$errors->has('password')" required />
                    <x-error :messages="$errors->get('password')" />
                </div>
                <div>
                    <x-label for="password_confirmation">Konfirmasi</x-label>
                    <x-input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi..." required />
                </div>
            </div>

            <div class="flex items-start gap-3 mb-6">
                <input type="checkbox" id="terms" required
                    class="w-4 h-4 mt-0.5 accent-primary shrink-0 rounded text-primary focus:ring-primary">
                <label for="terms" class="text-[13px] text-g600 leading-relaxed cursor-pointer">
                    Saya menyetujui <a href="#" class="text-primary font-bold hover:underline">Syarat & Ketentuan</a>
                    dan <a href="#" class="text-primary font-bold hover:underline">Kebijakan Privasi</a>
                </label>
            </div>

            <x-button type="submit" class="w-full">
                <i class="fi fi-rr-user-add"></i> Daftar Sekarang
            </x-button>
        </form>

        <div
            class="flex items-center my-6 gap-3 before:flex-1 before:h-px before:bg-g200 after:flex-1 after:h-px after:bg-g200 text-xs font-bold text-g400 uppercase tracking-widest text-center">
            atau</div>

        <div class="text-center text-[13px] font-semibold text-g500">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-extrabold hover:underline">Masuk
                di sini</a>
        </div>
    </x-card>
</div>
@endsection

@section('footer')
    <!-- no footer -->
@endsection