<?php
/**
 * Script verifikasi komponen Midtrans & Payment Settings
 * Jalankan: php verify_midtrans.php (dari folder project)
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$passed = 0;
$failed = 0;

function check(string $label, bool $result, string $detail = ''): void {
    global $passed, $failed;
    $icon = $result ? '✅' : '❌';
    echo "$icon  $label";
    if ($detail) echo " — $detail";
    echo PHP_EOL;
    $result ? $passed++ : $failed++;
}

echo PHP_EOL . "═══════════════════════════════════════════════════" . PHP_EOL;
echo "  VERIFIKASI MIDTRANS + PAYMENT SETTINGS" . PHP_EOL;
echo "  Bharata Herbal ID" . PHP_EOL;
echo "═══════════════════════════════════════════════════" . PHP_EOL . PHP_EOL;

// ── 1. ENV & Config ─────────────────────────────────
echo "📋 [1] Konfigurasi .env & config/midtrans.php" . PHP_EOL;

$serverKey  = config('midtrans.server_key');
$clientKey  = config('midtrans.client_key');
$isProd     = config('midtrans.is_production');
$isSanitized = config('midtrans.is_sanitized');
$is3ds      = config('midtrans.is_3ds');

check('MIDTRANS_SERVER_KEY terisi',  !empty($serverKey),  substr($serverKey ?? '', 0, 15) . '...');
check('MIDTRANS_CLIENT_KEY terisi',  !empty($clientKey),  substr($clientKey ?? '', 0, 15) . '...');
check('MIDTRANS_IS_PRODUCTION=false', $isProd === false,  $isProd ? 'PRODUCTION ⚠️' : 'Sandbox ✓');
check('is_sanitized=true',  $isSanitized === true);
check('is_3ds=true',        $is3ds === true);

echo PHP_EOL;

// ── 2. Midtrans Package ──────────────────────────────
echo "📦 [2] Package midtrans/midtrans-php" . PHP_EOL;

check('Class Midtrans\\Config exist',    class_exists('Midtrans\\Config'));
check('Class Midtrans\\Snap exist',      class_exists('Midtrans\\Snap'));
check('Class Midtrans\\Notification exist', class_exists('Midtrans\\Notification'));

echo PHP_EOL;

// ── 3. MidtransService ───────────────────────────────
echo "⚙️  [3] App\\Services\\MidtransService" . PHP_EOL;

try {
    $svc = new App\Services\MidtransService();
    check('MidtransService dapat diinstansiasi', true);
    check('Config::$serverKey terisi setelah konstruktor', !empty(\Midtrans\Config::$serverKey));
    check('Config::$isProduction = false', \Midtrans\Config::$isProduction === false);
} catch (\Throwable $e) {
    check('MidtransService dapat diinstansiasi', false, $e->getMessage());
}

echo PHP_EOL;

// ── 4. Database — Orders table ───────────────────────
echo "🗄️  [4] Tabel orders (kolom Midtrans)" . PHP_EOL;

$orderCols = \Illuminate\Support\Facades\Schema::getColumnListing('orders');
check('Kolom midtrans_snap_token ada',      in_array('midtrans_snap_token', $orderCols));
check('Kolom midtrans_transaction_id ada',  in_array('midtrans_transaction_id', $orderCols));
check('Kolom payment_method ada',           in_array('payment_method', $orderCols));
check('Kolom payment_status ada',           in_array('payment_status', $orderCols));
check('Kolom order_status ada',             in_array('order_status', $orderCols));

echo PHP_EOL;

// ── 5. Database — StoreSetting ───────────────────────
echo "🏪 [5] StoreSetting & payment_methods toggle" . PHP_EOL;

$settingCols = \Illuminate\Support\Facades\Schema::getColumnListing('store_settings');
check('Kolom payment_methods ada',  in_array('payment_methods', $settingCols));

$setting = App\Models\StoreSetting::getInstance();
check('StoreSetting::getInstance() berhasil', $setting !== null);

$available = App\Models\StoreSetting::availablePaymentMethods();
$expected = ['bank_transfer', 'qris', 'gopay', 'dana', 'ovo', 'brimo', 'cod'];
foreach ($expected as $key) {
    check("Method '$key' ada di availablePaymentMethods()", array_key_exists($key, $available));
}

$enabled = $setting->enabledPaymentMethods();
check('enabledPaymentMethods() mengembalikan array', is_array($enabled));
check('COD tersedia secara default', array_key_exists('cod', $enabled));

$viaM = array_filter($available, fn($m) => $m['via_midtrans']);
$notM = array_filter($available, fn($m) => !$m['via_midtrans']);
check('COD via_midtrans=false (tidak pakai Snap)', count($notM) === 1 && array_key_exists('cod', $notM));
check('Metode non-COD semuanya via_midtrans=true', count($viaM) === 6);

echo PHP_EOL;

// ── 6. Model Order $fillable ─────────────────────────
echo '📝 [6] Model Order — $fillable & casting' . PHP_EOL;

$order = new App\Models\Order();
$fillable = $order->getFillable();
check('midtrans_snap_token ada di $fillable',     in_array('midtrans_snap_token', $fillable));
check('midtrans_transaction_id ada di $fillable', in_array('midtrans_transaction_id', $fillable));
check('payment_method ada di $fillable',          in_array('payment_method', $fillable));
check('payment_status ada di $fillable',          in_array('payment_status', $fillable));

echo PHP_EOL;

// ── 7. Webhook config ────────────────────────────────
echo "🔔 [7] Webhook & CSRF Exception" . PHP_EOL;

// Cek bootstrap/app.php content
$bootstrapContent = file_get_contents(__DIR__ . '/bootstrap/app.php');
check('payment/notification dikecualikan dari CSRF', str_contains($bootstrapContent, "'payment/notification'"));
check('Route payment.notification terdaftar', \Illuminate\Support\Facades\Route::has('payment.notification'));
check('Route payment.snap-token terdaftar',  \Illuminate\Support\Facades\Route::has('payment.snap-token'));

echo PHP_EOL;

// ── 8. Products ──────────────────────────────────────
echo "🌿 [8] Produk Bharata Herbal" . PHP_EOL;

$productCount = App\Models\Product::count();
$activeCount  = App\Models\Product::where('is_active', true)->count();
check("Ada produk di database ($productCount total)", $productCount > 0, "$productCount produk");
check("Produk aktif tersedia ($activeCount aktif)", $activeCount > 0, "$activeCount aktif");

// Cek produk dengan BPOM
$withBpom = App\Models\Product::where('description', 'like', '%BPOM%')->count();
check("Produk dengan info BPOM ($withBpom produk)", $withBpom > 0, "$withBpom memiliki nomor BPOM");

// Cek tidak ada duplikasi
$uniqueNames = App\Models\Product::distinct()->count('name');
check("Tidak ada duplikasi nama produk", $uniqueNames === $productCount, "$uniqueNames unik dari $productCount total");

echo PHP_EOL;

// ── 9. Signature Verification logic ─────────────────
echo "🔐 [9] Midtrans Signature Verification Logic" . PHP_EOL;

$fakeOrderId    = 'BHI-20260610-0001-1234567890';
$fakeStatusCode = '200';
$fakeAmount     = '100000.00';
$key            = config('midtrans.server_key');
$expectedSig    = hash('sha512', $fakeOrderId . $fakeStatusCode . $fakeAmount . $key);

// Simulasi handleNotification dengan signature yang benar
try {
    $svc2 = new App\Services\MidtransService();
    $result = $svc2->handleNotification([
        'order_id'          => $fakeOrderId,
        'status_code'       => $fakeStatusCode,
        'gross_amount'      => $fakeAmount,
        'signature_key'     => $expectedSig,
        'transaction_status'=> 'settlement',
        'fraud_status'      => 'accept',
    ]);
    check('handleNotification() lolos dengan signature valid', true);
} catch (\Exception $e) {
    check('handleNotification() lolos dengan signature valid', false, $e->getMessage());
}

// Test dengan signature salah
try {
    $svc3 = new App\Services\MidtransService();
    $svc3->handleNotification([
        'order_id'      => $fakeOrderId,
        'status_code'   => $fakeStatusCode,
        'gross_amount'  => $fakeAmount,
        'signature_key' => 'wrong_signature',
    ]);
    check('handleNotification() menolak signature salah', false, 'Seharusnya throw Exception!');
} catch (\Exception $e) {
    check('handleNotification() menolak signature salah', str_contains($e->getMessage(), 'signature'));
}

echo PHP_EOL;

// ── 10. Payment Status Resolver ──────────────────────
echo "🔄 [10] resolvePaymentStatus() mapping" . PHP_EOL;

$svc4 = new App\Services\MidtransService();
check("settlement → confirmed",  $svc4->resolvePaymentStatus('settlement', 'accept') === 'confirmed');
check("capture → confirmed",     $svc4->resolvePaymentStatus('capture', 'accept') === 'confirmed');
check("capture+deny → pending (fraud review)", $svc4->resolvePaymentStatus('capture', 'deny') === 'pending');
check("cancel → failed",         $svc4->resolvePaymentStatus('cancel') === 'failed');
check("expire → failed",         $svc4->resolvePaymentStatus('expire') === 'failed');
check("pending → pending",       $svc4->resolvePaymentStatus('pending') === 'pending');

echo PHP_EOL;

// ── Summary ──────────────────────────────────────────
echo "═══════════════════════════════════════════════════" . PHP_EOL;
$total = $passed + $failed;
echo "  HASIL: $passed/$total test passed" . PHP_EOL;
if ($failed > 0) {
    echo "  ⚠️  $failed test GAGAL — periksa output di atas" . PHP_EOL;
} else {
    echo "  🎉 Semua komponen berjalan dengan baik!" . PHP_EOL;
}
echo "═══════════════════════════════════════════════════" . PHP_EOL . PHP_EOL;
