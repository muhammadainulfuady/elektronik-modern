<!-- FOOTER -->
<footer class="bg-dark text-g400 pt-[60px] px-4 md:px-8 pb-7">
    <div class="max-w-[1280px] mx-auto grid grid-cols-1 md:grid-cols-[2fr_1fr_1fr_1fr] gap-12 mb-12">
        <div>
            <div class="font-heading text-[22px] font-extrabold text-white mb-3 flex items-center gap-1.5">
                <i class="fi fi-rr-bolt text-yellow-500"></i> Elektronik Modern
            </div>
            <p class="text-[13px] leading-[1.8] mb-5 text-g500">
                Platform belanja elektronik rumah tangga terpercaya. Produk
                original, harga bersaing, pengiriman cepat ke seluruh Indonesia.
            </p>
            <div class="flex gap-2 flex-wrap">
                <a href="#" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] bg-white/5 text-white border border-white/10 hover:bg-white/10 transition-all">
                    <i class="fi fi-brands-facebook"></i> Facebook
                </a>
                <a href="#" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] bg-white/5 text-white border border-white/10 hover:bg-white/10 transition-all">
                    <i class="fi fi-brands-instagram"></i> Instagram
                </a>
            </div>
        </div>
        <div>
            <h4 class="text-g300 text-xs font-bold tracking-wider uppercase mb-3.5">Belanja</h4>
            <a href="{{ route('products.index') }}" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Semua Produk</a>
            <a href="{{ route('cart.index') }}" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Keranjang</a>
        </div>
        <div>
            <h4 class="text-g300 text-xs font-bold tracking-wider uppercase mb-3.5">Bantuan</h4>
            <a href="#" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Cara Pemesanan</a>
            <a href="#" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Kebijakan Retur</a>
        </div>
        <div>
            <h4 class="text-g300 text-xs font-bold tracking-wider uppercase mb-3.5">Perusahaan</h4>
            <a href="#" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Tentang Kami</a>
            <a href="#" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Kontak</a>
            <a href="#" class="block text-g500 text-sm mb-2 transition-colors hover:text-white">Syarat & Ketentuan</a>
        </div>
    </div>
    <div class="max-w-[1280px] mx-auto pt-6 border-t border-white/5 text-[13px] flex flex-col md:flex-row justify-between items-center text-g600 gap-2 text-center md:text-left">
        <span>© 2024 Elektronik Modern - Kelompok 2 IF4E Universitas Trunojoyo Madura</span>
        <span>Rekayasa Perangkat Lunak</span>
    </div>
</footer>