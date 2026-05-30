@extends('layouts.app')

@section('title', 'Kelola Customer – Admin Elektronik Modern')

@section('head')
@endsection

@section('header')
@endsection

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen bg-g50">
        @include('partials.admin-sidebar')

        <div class="flex-1 w-full min-w-0 flex flex-col p-6 md:p-8 overflow-y-auto h-screen">
            <div class="flex justify-between items-center mb-8">
                <h1 class="font-heading text-[24px] font-extrabold text-g900">Kelola Customer</h1>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-green-50 text-green-600"><i class="fi fi-rr-users"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Customer</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $users->total() }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-blue-50 text-blue-600"><i class="fi fi-rr-shopping-cart"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Punya Pesanan</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $users->getCollection()->where('pesanans_count', '>', 0)->count() }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-teal-50 text-teal-600"><i class="fi fi-rr-box"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Pesanan</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $users->getCollection()->sum('pesanans_count') }}</div>
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="bg-green-50 text-green-700 py-3 px-4 rounded-xl text-[13px] font-bold mb-6 flex items-center gap-2 border border-green-200">
                    <i class="fi fi-rr-check-circle text-lg"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-200">
                    <div class="font-bold flex items-center gap-2 mb-1 text-[14px]"><i class="fi fi-rr-triangle-warning"></i> Gagal menyimpan data customer.</div>
                    <ul class="list-disc pl-5 text-[12px] font-semibold space-y-1 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-g100 mb-8">
                <div class="p-6 border-b border-g100">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-user-add text-primary"></i> Tambah Customer
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-end">
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Nama</label>
                            <input name="nama" required class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Email</label>
                            <input type="email" name="email" required class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Password</label>
                            <input type="password" name="password" required class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <button type="submit" class="inline-flex py-2.5 px-5 bg-primary text-white rounded-lg font-bold text-[13px] shadow-sm hover:bg-primary-dark hover:-translate-y-px transition-all items-center justify-center gap-2 h-[42px] w-full md:w-auto">
                                <i class="fi fi-rr-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-g100">
                <div class="p-6 border-b border-g100 flex justify-between items-center">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-users text-primary"></i> Daftar Customer
                    </h3>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full min-w-[800px] text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">ID</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Nama</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Email</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Role</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Jumlah Pesanan</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="group hover:bg-g50/50 transition-colors">
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-bold text-g400 text-[12px]">#{{ $user->id_users }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center font-extrabold text-[12px] text-blue-600 border border-blue-100">
                                                {{ strtoupper(substr($user->nama, 0, 2)) }}
                                            </div>
                                            <span class="font-bold text-g800 text-[13px]">{{ $user->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="text-[13px] font-medium text-g500">{{ $user->email }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-600 border border-green-200 py-1 px-2 rounded text-[11px] font-extrabold tracking-widest uppercase">
                                            <i class="fi fi-rr-user text-[10px]"></i> {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-2 rounded text-[11px] font-extrabold tracking-widest uppercase">
                                            {{ $user->pesanans_count }} pesanan
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex py-1.5 px-3 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg font-bold text-[12px] hover:bg-blue-600 hover:text-white transition-colors items-center gap-1.5">
                                                <i class="fi fi-rr-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus customer ini? Semua data pesanan miliknya juga akan terhapus.')" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex py-1.5 px-3 bg-red-50 text-red-600 border border-red-100 rounded-lg font-bold text-[12px] hover:bg-red-600 hover:text-white transition-colors items-center gap-1.5">
                                                    <i class="fi fi-rr-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 px-6 text-center text-g500 font-semibold text-[13px]">
                                        Belum ada customer terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="p-6 border-t border-g100 flex justify-center w-full overflow-hidden">
                    <div class="inline-flex max-w-full bg-white rounded-xl shadow-sm border border-g200 p-1">
                        {{ $users->links('pagination::tailwind') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection