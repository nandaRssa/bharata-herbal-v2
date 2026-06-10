# 🔔 Panduan Testing Midtrans Webhook — Bharata Herbal ID

## Kondisi Saat Ini

Website berjalan di **localhost** (development).  
Midtrans membutuhkan URL **publik** yang dapat diakses dari internet untuk mengirim notifikasi webhook.

> **Endpoint Webhook:** `POST /payment/notification`  
> **CSRF:** Dikecualikan otomatis via `bootstrap/app.php`

---

## Opsi 1 — ngrok (Paling Mudah)

### Instalasi
```bash
# Windows (via Chocolatey)
choco install ngrok

# Atau download langsung: https://ngrok.com/download
# Extract dan jalankan dari folder manapun
```

### Langkah Penggunaan

**1. Pastikan Laravel berjalan:**
```bash
# Di terminal 1
cd d:\xampp\htdocs\bharata
php artisan serve --port=8000
```

**2. Jalankan ngrok di terminal lain:**
```bash
ngrok http 8000
```

**3. Salin URL forwarding ngrok**, contoh:
```
https://abc123.ngrok-free.app
```

**4. Set Notification URL di Midtrans Dashboard:**
- Login ke: https://dashboard.sandbox.midtrans.com
- Menu: **Settings → Configuration**
- Isi **Payment Notification URL**:
  ```
  https://abc123.ngrok-free.app/payment/notification
  ```
- Klik **Update**

**5. Test alur pembayaran:**
- Buka: `https://abc123.ngrok-free.app/pesan`
- Buat order dengan metode selain COD
- Klik **Bayar Sekarang** di halaman sukses
- Selesaikan pembayaran di Midtrans Snap (gunakan kartu test di bawah)
- Midtrans akan mengirim webhook ke ngrok → diteruskan ke Laravel

---

## Opsi 2 — Cloudflare Tunnel (Lebih Stabil, Gratis)

### Instalasi
```bash
# Windows (via winget)
winget install Cloudflare.cloudflared

# Atau download: https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/downloads/
```

### Langkah Penggunaan

**1. Jalankan Laravel:**
```bash
php artisan serve --port=8000
```

**2. Buat tunnel sementara:**
```bash
cloudflared tunnel --url http://localhost:8000
```

**3. Output akan menampilkan URL seperti:**
```
https://random-name.trycloudflare.com
```

**4. Set di Midtrans Dashboard** (sama seperti ngrok):
```
https://random-name.trycloudflare.com/payment/notification
```

---

## Kartu Test Midtrans Sandbox

### Kartu Kredit (Sukses)
| Field | Value |
|---|---|
| Nomor Kartu | `4811 1111 1111 1114` |
| Expiry | `01/25` (bulan/tahun apa saja di masa depan) |
| CVV | `123` |
| OTP/3DS | `112233` |

### Kartu Kredit (Gagal)
| Field | Value |
|---|---|
| Nomor Kartu | `4911 1111 1111 1113` |
| CVV | `123` |

### GoPay Simulator
- Setelah memilih GoPay di Snap, klik **Pay with GoPay**
- Gunakan simulator: pilih **Approve** untuk sukses, **Reject** untuk gagal

### QRIS
- Snap akan menampilkan QR code
- Gunakan **Midtrans Simulator**: https://simulator.sandbox.midtrans.com/qris/index

---

## Verifikasi Webhook Berhasil

Setelah pembayaran test berhasil, cek log Laravel:

```bash
php artisan pail
# atau
tail -f storage/logs/laravel.log
```

Log sukses akan terlihat seperti:
```
[INFO] Midtrans Notification {
  "order_number": "BHI-20260610-0001",
  "transaction_status": "settlement",
  "payment_status": "confirmed"
}
```

Di admin panel `/admin/pesanan`, status pesanan akan berubah ke **"Diproses"** dan payment status **"Dikonfirmasi"**.

---

## Tanpa Webhook (Manual Testing)

Jika belum setup ngrok/tunnel, Anda masih bisa:

1. Test **tampilan Snap popup** — buat order, klik bayar, popup muncul
2. Test **Snap payment flow** — bayar sampai selesai di popup
3. Update status **manual** dari admin: `/admin/pesanan/{id}` → ubah payment status ke "Dikonfirmasi"

Webhook hanya diperlukan untuk **update otomatis status** setelah pembayaran.

---

## Catatan Penting

- **Sandbox credentials** sudah diset di `.env`:
  ```
  MIDTRANS_SERVER_KEY=your-server-key
  MIDTRANS_CLIENT_KEY=your-client-key
  MIDTRANS_IS_PRODUCTION=false
  ```
- Untuk go-live ke Production: ubah `MIDTRANS_IS_PRODUCTION=true` dan ganti kedua key dengan Production key dari Midtrans Dashboard
- URL Snap JS otomatis menyesuaikan: Sandbox menggunakan `app.sandbox.midtrans.com`, Production menggunakan `app.midtrans.com`
