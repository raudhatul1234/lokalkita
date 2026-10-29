
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

// ========================================
// HALAMAN UTAMA
// ========================================

Route::get('/', function (Request $request) {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return app(HomeController::class)->index($request);
})->name('home');


// ========================================
// LOGIN
// ========================================

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt(
        $credentials,
        $request->boolean('remember')
    )) {
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password salah.',
        ])
        ->onlyInput('email');
})->middleware('guest')->name('login.submit');


// ========================================
// PENDAFTARAN
// ========================================

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
        ],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()
        ->route('home')
        ->with('success', 'Pendaftaran berhasil!');
})->middleware('guest')->name('register.submit');


// ========================================
// ADMIN
// ========================================

Route::middleware(['auth', 'admin'])->group(function () {

    Route::view('/admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    // KELOLA PRODUK

    Route::get('/admin/produk', [
        ProductController::class, 'adminIndex'
    ])->name('admin.products');

    Route::get('/admin/produk/tambah', [
        ProductController::class, 'create'
    ])->name('admin.products.create');

    Route::post('/admin/produk', [
        ProductController::class, 'store'
    ])->name('admin.products.store');

    Route::get('/admin/produk/{id}/edit', [
        ProductController::class, 'edit'
    ])->whereNumber('id')
      ->name('admin.products.edit');

    Route::put('/admin/produk/{id}', [
        ProductController::class, 'update'
    ])->whereNumber('id')
      ->name('admin.products.update');

    Route::delete('/admin/produk/{id}', [
        ProductController::class, 'destroy'
    ])->whereNumber('id')
      ->name('admin.products.destroy');


    // SEMUA PESANAN UNTUK ADMIN

    Route::get('/admin/pesanan', function () {

        $orders = Order::with([
            'user',
            'items.product',
        ])->latest()->paginate(10);

        $totalPesanan = Order::count();

        $menunggu = Order::whereRaw(
            'LOWER(status) = ?', ['pending']
        )->count();

        $selesai = Order::whereIn(
            DB::raw('LOWER(status)'),
            ['completed', 'complete', 'selesai']
        )->count();

        return view('admin.orders', compact(
            'orders',
            'totalPesanan',
            'menunggu',
            'selesai'
        ));

    })->name('admin.orders');


    // BATALKAN PESANAN ADMIN

    Route::patch('/admin/pesanan/{id}/batal', function ($id) {

        DB::transaction(function () use ($id) {

            $order = Order::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if (strtolower($order->status ?? '') !== 'pending') {
                throw ValidationException::withMessages([
                    'order' => 'Hanya pesanan pending yang dapat dibatalkan.',
                ]);
            }

            $order->load('items');

            foreach ($order->items as $item) {
                if (!$item->product_id) {
                    continue;
                }

                $product = Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
        });

        return back()->with(
            'success',
            'Pesanan dibatalkan dan stok dikembalikan.'
        );

    })->name('admin.orders.cancel');


    // HAPUS PESANAN ADMIN YANG DIBATALKAN

    Route::delete('/admin/pesanan/{id}', function ($id) {

        DB::transaction(function () use ($id) {

            $order = Order::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if (strtolower($order->status ?? '') !== 'cancelled') {
                throw ValidationException::withMessages([
                    'order' => 'Hanya pesanan cancelled yang dapat dihapus.',
                ]);
            }

            $order->items()->delete();
            $order->delete();
        });

        return back()->with('success', 'Pesanan berhasil dihapus.');

    })->name('admin.orders.delete');


    // PROFIL DAN PENGATURAN ADMIN

    Route::view('/admin/profil', 'admin.profile')
        ->name('admin.profile');

    Route::view('/admin/pengaturan', 'admin.settings')
        ->name('admin.settings');

});


// ========================================
// PRODUK DAN TENTANG
// ========================================

Route::middleware('auth')->group(function () {

    Route::get('/produk', [
        ProductController::class, 'index'
    ])->name('products.index');

    Route::get('/produk/{id}', [
        ProductController::class, 'show'
    ])->whereNumber('id')
      ->name('products.show');

    Route::view('/tentang', 'about')
        ->name('about');

});


// ========================================
// KONTAK
// ========================================

Route::post('/kontak', function (Request $request) {

    $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:150'],
        'subject' => ['required', 'string', 'max:150'],
        'message' => ['required', 'string', 'max:3000'],
    ]);

    return back()->with(
        'success',
        'Pesan berhasil divalidasi.'
    );

})->middleware('auth')->name('contact.send');


// ========================================
// KERANJANG, CHECKOUT, PESANAN PEMBELI
// ========================================

Route::middleware('auth')->group(function () {

    // KERANJANG

    Route::get('/keranjang', [
        CartController::class, 'index'
    ])->name('cart.index');

    Route::post('/keranjang/tambah/{id}', [
        CartController::class, 'add'
    ])->whereNumber('id')
      ->name('cart.add');

    Route::patch('/keranjang/item/{id}', [
        CartController::class, 'update'
    ])->whereNumber('id')
      ->name('cart.update');

    Route::delete('/keranjang/item/{id}', [
        CartController::class, 'remove'
    ])->whereNumber('id')
      ->name('cart.remove');

    Route::delete('/keranjang', [
        CartController::class, 'clear'
    ])->name('cart.clear');


    // CHECKOUT

    Route::post('/checkout', [
        CartController::class, 'checkout'
    ])->name('cart.checkout');


    // ====================================
    // PESANAN SAYA
    // ====================================

    Route::get('/pesanan-saya', function () {

        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));

    })->name('orders.index');


    // BATALKAN PESANAN PEMBELI

    Route::patch('/pesanan/{id}/batal', function ($id) {

        DB::transaction(function () use ($id) {

            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            if (strtolower($order->status ?? '') !== 'pending') {
                throw ValidationException::withMessages([
                    'order' => 'Hanya pesanan pending yang dapat dibatalkan.',
                ]);
            }

            $order->load('items');

            foreach ($order->items as $item) {
                if (!$item->product_id) {
                    continue;
                }

                $product = Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');

    })->name('orders.cancel');


    // HAPUS PESANAN PEMBELI YANG DIBATALKAN

    Route::delete('/pesanan/{id}', function ($id) {

        DB::transaction(function () use ($id) {

            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            if (strtolower($order->status ?? '') !== 'cancelled') {
                throw ValidationException::withMessages([
                    'order' => 'Hanya pesanan cancelled yang dapat dihapus.',
                ]);
            }

            $order->items()->delete();
            $order->delete();
        });

        return back()->with('success', 'Pesanan berhasil dihapus.');

    })->name('orders.delete');


    // LOGOUT

    Route::post('/logout', function (Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');

    })->name('logout');

});
