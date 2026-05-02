// ========== SHARED STATE ==========
const CART = JSON.parse(localStorage.getItem('eh_cart') || '[]');
const NOTIFICATIONS = [
  { id:1, icon:'🎉', title:'Pesanan Dikonfirmasi', msg:'Pesanan #ORD-003 sudah diproses admin.', time:'5 menit lalu', read:false },
  { id:2, icon:'🚚', title:'Paket Dikirim', msg:'Pesanan #ORD-002 sudah dikirim via JNE.', time:'2 jam lalu', read:false },
  { id:3, icon:'✅', title:'Pesanan Selesai', msg:'Pesanan #ORD-001 telah diterima.', time:'1 hari lalu', read:true },
  { id:4, icon:'🏷️', title:'Promo Spesial!', msg:'Diskon 20% untuk Smart TV hari ini saja!', time:'2 hari lalu', read:true },
];

const PRODUCTS = [
  { id:1, name:'Samsung Smart TV 43" 4K UHD', cat:'Smart TV', price:6499000, oldPrice:7650000, stock:12, img:'https://images.unsplash.com/photo-1593784991095-a205069470b6?w=400&q=80', badge:'−15%' },
  { id:2, name:'LG Kulkas 2 Pintu 380L Inverter', cat:'Kulkas', price:5199000, oldPrice:5799000, stock:8, img:'https://images.unsplash.com/photo-1571175443880-49e1d25b2bc5?w=400&q=80', badge:'−10%' },
  { id:3, name:'Panasonic Mesin Cuci Front Load 7KG', cat:'Mesin Cuci', price:4299000, oldPrice:null, stock:5, img:'https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?w=400&q=80', badge:null },
  { id:4, name:'Daikin AC Split 1PK Inverter 5-Star', cat:'AC / Pendingin', price:3850000, oldPrice:4200000, stock:20, img:'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=400&q=80', badge:'HOT' },
  { id:5, name:'Sony BRAVIA 55" OLED 4K Google TV', cat:'Smart TV', price:14999000, oldPrice:null, stock:3, img:'https://images.unsplash.com/photo-1509281373149-e957c6296406?w=400&q=80', badge:null },
  { id:6, name:'Sharp Freezer Box 200L', cat:'Kulkas', price:2350000, oldPrice:null, stock:15, img:'https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?w=400&q=80', badge:'BARU' },
  { id:7, name:'Rinnai Kompor Gas 2 Tungku Stainless', cat:'Dapur', price:689000, oldPrice:null, stock:34, img:'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&q=80', badge:null },
  { id:8, name:'Philips LED Smart Bulb 12W Wi-Fi', cat:'Penerangan', price:249000, oldPrice:null, stock:60, img:'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=80', badge:null },
];

function saveCart() { localStorage.setItem('eh_cart', JSON.stringify(CART)); }

function addToCart(productId, qty=1) {
  const prod = PRODUCTS.find(p => p.id === productId);
  if (!prod) return;
  const existing = CART.find(c => c.id === productId);
  if (existing) { existing.qty += qty; } 
  else { CART.push({ ...prod, qty }); }
  saveCart();
  updateCartBadge();
  showCartToast(prod.name);
  if (typeof renderCart === 'function') renderCart();
}

function removeFromCart(productId) {
  const idx = CART.findIndex(c => c.id === productId);
  if (idx > -1) { CART.splice(idx, 1); saveCart(); }
  updateCartBadge();
  if (typeof renderCart === 'function') renderCart();
}

function updateQty(productId, delta) {
  const item = CART.find(c => c.id === productId);
  if (!item) return;
  item.qty = Math.max(1, item.qty + delta);
  saveCart();
  if (typeof renderCart === 'function') renderCart();
}

function cartTotal() { return CART.reduce((s,i) => s + i.price * i.qty, 0); }
function cartCount() { return CART.reduce((s,i) => s + i.qty, 0); }
function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

function updateCartBadge() {
  document.querySelectorAll('.cart-badge').forEach(el => {
    const c = cartCount();
    el.textContent = c;
    el.style.display = c > 0 ? 'flex' : 'none';
  });
}

function showCartToast(name) {
  let t = document.getElementById('cart-toast');
  if (!t) { t = document.createElement('div'); t.id='cart-toast'; t.className='cart-toast'; document.body.appendChild(t); }
  t.innerHTML = `<span>🛒</span> <strong>${name.substring(0,28)}...</strong> ditambahkan!`;
  t.classList.add('show');
  clearTimeout(t._timer);
  t._timer = setTimeout(() => t.classList.remove('show'), 3000);
}

function unreadCount() { return NOTIFICATIONS.filter(n => !n.read).length; }
function updateNotifBadge() {
  document.querySelectorAll('.notif-badge').forEach(el => {
    const c = unreadCount();
    el.textContent = c;
    el.style.display = c > 0 ? 'flex' : 'none';
  });
}

// Navigation helper
function goTo(page) { window.location.href = page; }

// ========== ADDRESS CRUD ==========
const DEFAULT_ADDRESSES = [
  { id:1, label:'Rumah', name:'Budi Santoso', phone:'0812-3456-7890', street:'Jl. Raya Bangkalan No. 45 RT 02/RW 03', province:'Jawa Timur', city:'Bangkalan', district:'Bangkalan', village:'Pejagan', postal:'69116', isDefault:true },
  { id:2, label:'Kantor', name:'Budi Santoso', phone:'0812-3456-7890', street:'Jl. Trunojoyo No. 1 Kampus UTM', province:'Jawa Timur', city:'Bangkalan', district:'Burneh', village:'Burneh', postal:'69162', isDefault:false },
];

function getAddresses() {
  const saved = localStorage.getItem('eh_addresses');
  return saved ? JSON.parse(saved) : DEFAULT_ADDRESSES;
}
function saveAddresses(arr) { localStorage.setItem('eh_addresses', JSON.stringify(arr)); }
function getDefaultAddress() { return getAddresses().find(a => a.isDefault) || getAddresses()[0] || null; }

function addAddress(data) {
  const addresses = getAddresses();
  const newAddr = { ...data, id: Date.now() };
  if (newAddr.isDefault || addresses.length === 0) {
    addresses.forEach(a => a.isDefault = false);
    newAddr.isDefault = true;
  }
  addresses.push(newAddr);
  saveAddresses(addresses);
  return newAddr;
}

function updateAddress(id, data) {
  const addresses = getAddresses();
  const idx = addresses.findIndex(a => a.id === id);
  if (idx === -1) return;
  if (data.isDefault) addresses.forEach(a => a.isDefault = false);
  addresses[idx] = { ...addresses[idx], ...data };
  saveAddresses(addresses);
}

function deleteAddress(id) {
  let addresses = getAddresses();
  const wasDefault = addresses.find(a => a.id === id)?.isDefault;
  addresses = addresses.filter(a => a.id !== id);
  if (wasDefault && addresses.length > 0) addresses[0].isDefault = true;
  saveAddresses(addresses);
}

function setDefaultAddress(id) {
  const addresses = getAddresses();
  addresses.forEach(a => a.isDefault = (a.id === id));
  saveAddresses(addresses);
}

// ========== USER PROFILE ==========
const DEFAULT_USER = { name:'Budi Santoso', email:'budi.s@email.com', phone:'0812-3456-7890', avatar:'BS', joined:'November 2024' };
function getUser() { return JSON.parse(localStorage.getItem('eh_user') || JSON.stringify(DEFAULT_USER)); }
