@props(['appliedPromo', 'promos', 'inputId' => 'voucher_input', 'formId' => 'voucherForm'])

<form method="POST" action="{{ route('cart.voucher.apply') }}" class="relative mt-6 voucher-form-ajax" id="{{ $formId }}">
    @csrf
    <input name="kode_voucher" id="{{ $inputId }}" value="{{ $appliedPromo->kode_voucher ?? old('kode_voucher') }}"
        placeholder="KODE VOUCHER" required
        class="w-full py-3.5 pr-20 pl-4 border-2 border-g100 rounded-2xl outline-none text-xs font-bold text-g900 uppercase focus:border-primary transition-all">
    <button type="submit" class="absolute right-2 top-2 bottom-2 px-4 rounded-xl bg-g900 text-white text-[10px] font-bold uppercase hover:bg-primary transition-colors">Pakai</button>
</form>

@if ($appliedPromo)
    <div class="flex justify-between items-center mt-3 bg-green-50 py-2 px-4 rounded-xl border border-green-100">
        <span class="text-[11px] font-bold text-green-700 flex items-center gap-2"><i class="fi fi-rr-ticket"></i> {{ $appliedPromo->kode_voucher }}</span>
        <form method="POST" action="{{ route('cart.voucher.remove') }}" class="m-0 voucher-form-ajax">
            @csrf @method('DELETE')
            <button type="submit" class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Hapus</button>
        </form>
    </div>
@endif

@if (!$appliedPromo && $promos->isNotEmpty())
    <div class="mt-6 pt-6 border-t border-g100">
        <h4 class="text-[11px] font-extrabold text-g400 uppercase tracking-widest mb-3">Voucher Tersedia</h4>
        <div class="space-y-2">
            @foreach ($promos as $p)
                <div class="flex items-center justify-between p-3 bg-g50 rounded-xl border border-g100 group hover:border-primary transition-colors">
                    <div class="min-w-0">
                        <div class="text-[12px] font-bold text-g800 uppercase">{{ $p->kode_voucher }}</div>
                        <div class="text-[10px] text-g500 font-medium">
                            Diskon {{ $p->tipe_diskon === 'persen' ? $p->nilai_diskon . '%' : 'Rp ' . number_format($p->nilai_diskon, 0, ',', '.') }}
                        </div>
                    </div>
                    <button type="button" 
                        onclick="document.getElementById('{{ $inputId }}').value='{{ $p->kode_voucher }}'; document.getElementById('{{ $formId }}').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));"
                        class="text-[10px] font-bold text-primary uppercase hover:underline">Gunakan</button>
                </div>
            @endforeach
        </div>
    </div>
@endif
