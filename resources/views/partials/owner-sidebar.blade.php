<div class="w-full md:w-[240px] bg-dark shrink-0 flex flex-col md:sticky md:top-0 md:h-screen overflow-y-auto">
    <div class="p-6 border-b border-white/10">
        <div class="font-heading text-lg font-extrabold text-white flex items-center gap-2">
            <span class="text-yellow-500 text-xl"><i class="fi fi-rr-crown"></i></span>
            Elektronik Modern
        </div>
        <div class="text-[11px] text-g500 mt-1">Panel Owner</div>
    </div>
    <div class="px-5 pt-5 pb-2 text-[10px] font-bold text-g600 tracking-wider uppercase">Menu Utama</div>
    <a href="{{ route('owner.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('owner.index') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-chart-histogram"></i></span> Dashboard
    </a>
    <div class="px-5 pt-5 pb-2 text-[10px] font-bold text-g600 tracking-wider uppercase">Akun</div>
    <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left text-g500 hover:text-white hover:bg-white/5 bg-transparent">
            <span class="w-[18px] text-center text-base"><i class="fi fi-rr-sign-out-alt"></i></span> Keluar
        </button>
    </form>
</div>
