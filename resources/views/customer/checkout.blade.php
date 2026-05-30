@extends('layouts.app')

@section('title', 'Checkout – Elektronik Modern')

@section('head')
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="py-8 md:py-[72px] bg-g50 min-h-screen px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex items-center gap-1.5 mb-6 text-[13px]">
                <a href="{{ route('index') }}" class="text-g500 hover:text-primary transition-colors flex items-center gap-1.5"><i class="fi fi-rr-home"></i> Beranda</a> 
                <i class="fi fi-rr-angle-small-right text-g400"></i> 
                <a href="{{ route('cart.index') }}" class="text-g500 hover:text-primary transition-colors">Keranjang</a>
                <i class="fi fi-rr-angle-small-right text-g400"></i>
                <span class="text-g800 font-semibold">Checkout</span>
            </div>
            
            <div class="mb-8">
                <h1 class="font-heading text-[28px] md:text-[32px] font-extrabold text-g900 mb-2 flex items-center gap-3">
                    <i class="fi fi-rr-shopping-bag text-primary"></i> Checkout
                </h1>
                <p class="text-g500 text-[15px]">Periksa pesanan Anda sebelum melanjutkan pembayaran</p>
            </div>

            @if (session('error'))
                <x-alert type="danger" class="mb-6">
                    {{ session('error') }}
                </x-alert>
            @endif

            <x-error :messages="$errors->all()" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl" />

            <form method="POST" action="{{ route('customer.placeOrder') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    <div class="flex-1 w-full space-y-5">
                        <!-- Items -->
                        <x-card class="p-6">
                            <h3 class="font-heading text-lg font-extrabold text-g900 mb-5 flex items-center gap-2">
                                <i class="fi fi-rr-box text-primary"></i> Produk Dipesan
                            </h3>
                            <div class="flex flex-col divide-y divide-g100">
                            @foreach ($items as $item)
                                <div class="py-3.5 flex items-center gap-4 group">
                                    <div class="w-16 h-16 rounded-xl bg-g50 border border-g100 p-1 flex items-center justify-center shrink-0">
                                        @if($item->produk->gambar)
                                            <img src="{{ asset('storage/products/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" loading="lazy" decoding="async" class="w-full h-full object-contain mix-blend-multiply">
                                        @else
                                            <i class="fi fi-rr-picture text-2xl text-g300"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[13px] font-bold text-g800 line-clamp-2 mb-1">{{ $item->produk->nama_produk }}</div>
                                        <div class="text-xs text-g500">{{ $item->qty }} × Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="font-heading font-extrabold text-primary text-[15px] whitespace-nowrap pl-4">
                                        Rp {{ number_format($item->lineTotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </x-card>

                        <!-- Alamat Pengiriman -->
                        <x-card class="p-6">
                            <h3 class="font-heading text-lg font-extrabold text-g900 mb-5 flex items-center gap-2">
                                <i class="fi fi-rr-map-marker text-primary"></i> Alamat Pengiriman
                            </h3>
                            @if ($alamats->count())
                                <div class="space-y-3">
                                @foreach ($alamats as $alamat)
                                    <label class="flex items-start gap-3 p-4 bg-white rounded-xl cursor-pointer border-[1.5px] border-g200 hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-primary-light/50 has-[:checked]:ring-4 has-[:checked]:ring-primary/10">
                                        <input type="radio" name="id_alamat" value="{{ $alamat->id_alamat }}"
                                            {{ $loop->first ? 'checked' : '' }}
                                            class="w-4 h-4 mt-0.5 accent-primary shrink-0 rounded-full text-primary focus:ring-primary">
                                        <div>
                                            <div class="text-[14px] font-bold text-g800 mb-0.5">{{ $alamat->label_alamat }}</div>
                                            <div class="text-[13px] text-g600 leading-relaxed mb-1">{{ $alamat->detail_alamat }}</div>
                                            <div class="text-[12px] font-semibold text-g500 flex items-center gap-1.5"><i class="fi fi-rr-phone-call"></i> {{ $alamat->nomor_telepon }}</div>
                                        </div>
                                    </label>
                                @endforeach
                                </div>
                            @else
                                <x-alert type="warning" class="mb-4">
                                    Anda belum memiliki alamat pengiriman. Tambahkan alamat terlebih dahulu melalui halaman profil.
                                </x-alert>
                                <x-button variant="outline" onclick="window.location='{{ route('customer.profile') }}?tab=alamat'">
                                    <i class="fi fi-rr-plus"></i> Tambah Alamat
                                </x-button>
                            @endif
                        </x-card>

                        <!-- Ekspedisi -->
                        <x-card class="p-6">
                            <h3 class="font-heading text-lg font-extrabold text-g900 mb-5 flex items-center gap-2">
                                <i class="fi fi-rr-truck-side text-primary"></i> Pilih Ekspedisi
                            </h3>
                            <div class="space-y-3" id="ekspedisiList">
                            @foreach ($ekspedisis as $ekspedisi)
                                <label class="flex items-center gap-3 p-4 bg-white rounded-xl cursor-pointer border-[1.5px] border-g200 hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-primary-light/50 has-[:checked]:ring-4 has-[:checked]:ring-primary/10">
                                    <input type="radio" name="id_ekspedisi" value="{{ $ekspedisi->id_ekspedisi }}"
                                        data-biaya="{{ $ekspedisi->biaya_pengiriman }}"
                                        {{ $loop->first ? 'checked' : '' }}
                                        onchange="calculateTotal()"
                                        class="w-4 h-4 accent-primary shrink-0 rounded-full text-primary focus:ring-primary">
                                    <div class="flex-1">
                                        <div class="text-[14px] font-bold text-g800">{{ $ekspedisi->nama_ekspedisi }}</div>
                                    </div>
                                    <div class="font-heading font-extrabold text-primary text-[15px]">
                                        Rp {{ number_format($ekspedisi->biaya_pengiriman, 0, ',', '.') }}
                                    </div>
                                </label>
                            @endforeach
                            </div>
                        </x-card>

                        <!-- Pembayaran & Upload -->
                        <x-card class="p-6">
                            <h3 class="font-heading text-lg font-extrabold text-g900 mb-5 flex items-center gap-2">
                                <i class="fi fi-rr-credit-card text-primary"></i> Metode & Bukti Pembayaran
                            </h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="pay-opt flex items-center gap-3.5 p-4 bg-white rounded-xl cursor-pointer border-[1.5px] transition-all border-primary bg-primary-light shadow-[0_0_0_4px_rgba(26,92,255,0.1)]" onclick="selectPay(this, 'bank')">
                                    <input type="radio" name="metode_pembayaran" value="Transfer Bank" checked class="w-4 h-4 accent-primary shrink-0" />
                                    <div class="text-[28px] text-primary flex items-center justify-center bg-white w-12 h-12 rounded-full shadow-sm"><i class="fi fi-rr-bank"></i></div>
                                    <div>
                                        <div class="font-bold text-[14px] text-g800 mb-0.5">Transfer Bank</div>
                                        <div class="text-[11px] font-medium text-g500 uppercase tracking-wider">BCA · BRI · BNI · Mandiri</div>
                                    </div>
                                </label>
                                <label class="pay-opt flex items-center gap-3.5 p-4 bg-white rounded-xl cursor-pointer border-[1.5px] border-g200 transition-all hover:border-g300" onclick="selectPay(this, 'ewallet')">
                                    <input type="radio" name="metode_pembayaran" value="E-Wallet" class="w-4 h-4 accent-primary shrink-0" />
                                    <div class="text-[28px] text-green-500 flex items-center justify-center bg-green-50 w-12 h-12 rounded-full border border-green-100"><i class="fi fi-rr-wallet"></i></div>
                                    <div>
                                        <div class="font-bold text-[14px] text-g800 mb-0.5">E-Wallet</div>
                                        <div class="text-[11px] font-medium text-g500 uppercase tracking-wider">DANA · ShopeePay · GoPay</div>
                                    </div>
                                </label>
                            </div>
                            
                            <div id="bankDetail" class="mt-4 bg-primary-light/50 border border-primary/20 rounded-xl p-5 border-l-4 border-l-primary">
                                <div class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fi fi-rr-document"></i> Detail Transfer Bank:</div>
                                <div class="text-[14px] text-g800 mb-1"><strong>Bank BCA</strong> – No. Rek: <strong class="text-primary font-heading text-lg ml-1 tracking-wider">1234-5678-90</strong></div>
                                <div class="text-[13px] font-medium text-g500">a.n. Elektronik Modern Store</div>
                            </div>

                            <div id="ewalletDetail" class="mt-4 bg-green-50 border border-green-200 rounded-xl p-5 border-l-4 border-l-green-500 hidden">
                                <div class="font-bold text-green-700 mb-2 flex items-center gap-2"><i class="fi fi-rr-smartphone"></i> Detail E-Wallet:</div>
                                <div class="text-[14px] text-g800 mb-1"><strong>DANA / ShopeePay</strong> – No. HP: <strong class="text-green-600 font-heading text-lg ml-1 tracking-wider">0812-3456-7890</strong></div>
                                <div class="text-[13px] font-medium text-g500">a.n. Elektronik Modern Admin</div>
                            </div>

                            <div class="mt-8">
                                <x-label class="mb-3">Upload Bukti Pembayaran</x-label>
                                <div class="border-2 border-dashed border-g300 rounded-2xl p-8 text-center text-g500 cursor-pointer transition-all hover:border-primary hover:bg-primary-light group" onclick="document.getElementById('bukti_bayar').click()">
                                    <div class="text-[40px] mb-3 text-g300 group-hover:text-primary transition-colors inline-flex"><i class="fi fi-rr-cloud-upload"></i></div>
                                    <div class="font-bold text-[15px] mb-1.5 text-g700 group-hover:text-primary transition-colors">Klik atau seret file ke sini</div>
                                    <div class="text-[12px] font-medium">Format: JPG, PNG, PDF · Maks. 5MB</div>
                                    <input type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*,.pdf" class="hidden" onchange="handleUpload(this); validateCheckoutReady()" required />
                                </div>
                                <div id="uploadPreview" class="hidden mt-4 bg-green-50 border border-green-200 rounded-xl p-3 text-[13px] text-green-700 font-bold flex items-center gap-2">
                                    <i class="fi fi-rr-check-circle text-lg"></i> <span id="uploadPreviewMsg"></span>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    <!-- Summary -->
                    <x-card class="w-full lg:w-[380px] shrink-0 p-6 lg:sticky lg:top-[84px]">
                        <h3 class="font-heading text-lg font-extrabold text-g900 mb-5 flex items-center gap-2">
                            <i class="fi fi-rr-receipt text-primary"></i> Ringkasan Pembayaran
                        </h3>
                        
                        <div class="flex justify-between items-center mb-3 text-[13px]">
                            <span class="text-g500">Subtotal ({{ count($items) }} produk)</span>
                            <span class="font-bold text-g800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        @if ($appliedPromo)
                            <div class="flex justify-between items-center mb-3 text-[13px]">
                                <span class="font-bold text-green-600 flex items-center gap-1.5"><i class="fi fi-rr-ticket"></i> Voucher {{ $appliedPromo->kode_voucher }}</span>
                                <span class="font-bold text-green-600">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center mb-3 text-[13px]">
                            <span class="text-g500">Ongkos Kirim</span>
                            <span class="font-bold text-g800" id="shippingCost">Rp 0</span>
                        </div>
                        
                        <div class="flex justify-between items-center mt-5 pt-4 border-t-2 border-g100">
                            <span class="text-sm font-bold text-g500">Total Pembayaran</span>
                            <span class="font-heading text-[22px] font-extrabold text-primary" id="totalPayment">Rp {{ number_format(max(0, $subtotal - $discount), 0, ',', '.') }}</span>
                        </div>

                        <x-button type="submit" id="btnSubmitCheckout" class="w-full mt-6 opacity-60 cursor-not-allowed pointer-events-none">
                            Buat Pesanan <i class="fi fi-rr-arrow-right"></i>
                        </x-button>

                        <div class="text-center text-[11px] font-semibold text-g400 mt-4 flex items-center justify-center gap-1.5">
                            <i class="fi fi-rr-lock"></i> Transaksi aman & terenkripsi
                        </div>
                    </x-card>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
    <script>
        const baseSubtotal = {{ max(0, $subtotal - $discount) }};
        
        function formatRupiah(amount) {
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateTotal() {
            const selectedEkspedisi = document.querySelector('input[name="id_ekspedisi"]:checked');
            if (selectedEkspedisi) {
                const ongkir = parseInt(selectedEkspedisi.getAttribute('data-biaya')) || 0;
                const total = baseSubtotal + ongkir;
                
                document.getElementById('shippingCost').textContent = formatRupiah(ongkir);
                document.getElementById('totalPayment').textContent = formatRupiah(total);
            }
        }

        function validateCheckoutReady() {
            const btn = document.getElementById('btnSubmitCheckout');
            const fileInput = document.getElementById('bukti_bayar');
            const hasAlamat = {{ $alamats->isNotEmpty() ? 'true' : 'false' }};
            
            if (hasAlamat && fileInput && fileInput.files.length > 0) {
                btn.classList.remove('opacity-60', 'cursor-not-allowed', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-60', 'cursor-not-allowed', 'pointer-events-none');
            }
        }

        // Initialize total on load
        document.addEventListener('DOMContentLoaded', () => {
            calculateTotal();
            validateCheckoutReady();
        });
    </script>
    @endpush
@endsection
