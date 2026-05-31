@extends('layouts.app')

@section('title', 'Edit Customer – Admin Elektronik Modern')

@section('head')
@endsection

@section('header')
@endsection

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen bg-g50">
        @include('partials.admin-sidebar')

        <div class="flex-1 w-full min-w-0 flex flex-col p-6 md:p-8 overflow-y-auto h-screen relative">
            <div class="flex items-center gap-1.5 mb-6 text-[13px] pt-12 md:pt-0">
                <a href="{{ route('admin.index') }}" class="text-g500 hover:text-primary transition-colors flex items-center gap-1.5"><i class="fi fi-rr-apps"></i> Dashboard</a> 
                <i class="fi fi-rr-angle-small-right text-g400"></i> 
                <a href="{{ route('admin.users.index') }}" class="text-g500 hover:text-primary transition-colors">Kelola Customer</a>
                <i class="fi fi-rr-angle-small-right text-g400"></i>
                <span class="text-g800 font-semibold">Edit</span>
            </div>

            <div class="flex justify-between items-center mb-8">
                <h1 class="font-heading text-[24px] font-extrabold text-g900">Edit Customer</h1>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-g100 max-w-2xl">
                <div class="p-6 border-b border-g100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center font-extrabold text-[15px] text-blue-600 border border-blue-100 shrink-0">
                        {{ strtoupper(substr($user->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-heading text-[16px] font-extrabold text-g900">{{ $user->nama }}</h3>
                        <div class="text-[13px] text-g500 font-medium">{{ $user->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6">
                    @csrf @method('PUT')
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Nama</label>
                            <input name="nama" value="{{ old('nama', $user->nama) }}" required 
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Password Baru (Opsional)</label>
                            <input type="password" name="password" 
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                            <div class="text-[11px] text-g500 mt-1.5 font-medium flex items-center gap-1"><i class="fi fi-rr-info text-primary"></i> Kosongkan jika tidak ingin mengubah password.</div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="inline-flex py-2.5 px-5 bg-primary text-white rounded-lg font-bold text-[13px] shadow-sm hover:bg-primary-dark hover:-translate-y-px transition-all items-center gap-2">
                            <i class="fi fi-rr-disk"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex py-2.5 px-5 bg-white text-g700 border-[1.5px] border-g200 rounded-lg font-bold text-[13px] hover:border-primary hover:text-primary transition-all items-center gap-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
