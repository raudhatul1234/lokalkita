<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori beserta jumlah produknya
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        // Query produk beserta kategorinya
        $query = Product::with('category');

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($categoryQuery) use ($request) {
                $categoryQuery->where('slug', $request->category);
            });
        }

        // Pencarian produk, deskripsi, dan nama penjual
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($productQuery) use ($search) {
                $productQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('seller_name', 'like', "%{$search}%");
            });
        }

        // Ambil maksimal 8 produk terbaru
        $products = $query
            ->latest()
            ->take(8)
            ->get();

        // Tampilkan halaman beranda
        return view('home', compact('categories', 'products'));
    }
}