<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Tampilkan isi keranjang.
     */
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cart->load('items.product.category');

        $total = $cart->items->sum(function ($item) {
            return (float) $item->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Tambahkan produk ke keranjang.
     */
    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->input('quantity', 1);

        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return back()->with('error', 'Maaf, produk sedang habis.');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $newQuantity = $quantity + ($item ? $item->quantity : 0);

        if ($newQuantity > $product->stock) {
            return back()->with(
                'error',
                'Jumlah barang melebihi stok yang tersedia.'
            );
        }

        if ($item) {
            $item->update([
                'quantity' => $newQuantity,
                'price' => $product->price,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Ubah jumlah produk dalam keranjang.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item = CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('product')
            ->firstOrFail();

        if (!$item->product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($validated['quantity'] > $item->product->stock) {
            return back()->with(
                'error',
                'Jumlah barang melebihi stok yang tersedia.'
            );
        }

        $item->update([
            'quantity' => $validated['quantity'],
            'price' => $item->product->price,
        ]);

        return back()->with(
            'success',
            'Jumlah produk berhasil diperbarui.'
        );
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function remove($id)
    {
        $item = CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->firstOrFail();

        $item->delete();

        return back()->with(
            'success',
            'Produk berhasil dihapus dari keranjang.'
        );
    }

    /**
     * Kosongkan seluruh keranjang.
     */
    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with(
            'success',
            'Keranjang berhasil dikosongkan.'
        );
    }

    /**
     * Checkout dan simpan pesanan ke database.
     */
    public function checkout()
    {
        $userId = auth()->id();

        $order = DB::transaction(function () use ($userId) {
            $cart = Cart::where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (!$cart) {
                throw ValidationException::withMessages([
                    'cart' => 'Keranjang belanja kamu kosong.',
                ]);
            }

            $items = CartItem::where('cart_id', $cart->id)->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Keranjang belanja kamu kosong.',
                ]);
            }

            $orderItems = [];
            $total = 0;

            // Periksa stok dan harga terbaru.
            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw ValidationException::withMessages([
                        'cart' => 'Ada produk yang sudah tidak tersedia.',
                    ]);
                }

                if (
                    $item->quantity < 1 ||
                    $product->stock < $item->quantity
                ) {
                    throw ValidationException::withMessages([
                        'cart' => 'Stok produk "' . $product->name .
                            '" tidak mencukupi. Perbarui keranjang kamu.',
                    ]);
                }

                $price = (float) $product->price;
                $subtotal = $price * $item->quantity;

                $total += $subtotal;

                $orderItems[] = [
                    'product' => $product,
                    'name' => $product->name,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            // Buat pesanan utama.
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'LK-' .
                    now()->format('YmdHis') . '-' .
                    Str::upper(Str::random(6)),
                'total' => $total,
                'status' => 'pending',
            ]);

            // Simpan detail pesanan dan kurangi stok.
            foreach ($orderItems as $row) {
                $order->items()->create([
                    'product_id' => $row['product']->id,
                    'product_name' => $row['name'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'subtotal' => $row['subtotal'],
                ]);

                $row['product']->decrement(
                    'stock',
                    $row['quantity']
                );
            }

            // Hapus item keranjang setelah pesanan dibuat.
            $cart->items()->delete();

            return $order;
        });

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Checkout berhasil! Nomor pesanan: ' .
                    $order->order_number
            );
    }
}

