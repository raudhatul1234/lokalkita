<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Folder penyimpanan gambar produk.
     */
    private string $imageDirectory = 'images/products';

    /**
     * Menampilkan daftar produk untuk admin.
     *
     * Route:
     * GET /admin/produk
     * Method: adminIndex
     */
    public function adminIndex(Request $request): View
    {
        $query = Product::with('category');

        // Pencarian produk.
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('seller_name', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan kategori.
        if ($request->filled('category_id')) {
            $query->where(
                'category_id',
                $request->input('category_id')
            );
        }

        // Pengurutan produk.
        switch ($request->input('sort', 'latest')) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'stock':
                $query->orderBy('stock', 'asc');
                break;

            default:
                $query->latest();
                break;
        }

        // Pagination.
        $products = $query->paginate(12)->withQueryString();

        // Data kategori untuk filter.
        $categories = Category::orderBy('name')->get();

        return view('admin.products', compact(
            'products',
            'categories'
        ));
    }

    /**
     * Menampilkan daftar produk untuk pelanggan.
     *
     * Route:
     * GET /produk
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('seller_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where(
                'category_id',
                $request->input('category_id')
            );
        }

        $products = $query->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories'
        ));
    }

    /**
     * Menampilkan detail produk.
     *
     * Route:
     * GET /produk/{id}
     */
    public function show(int $id): View
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan formulir tambah produk.
     *
     * Route:
     * GET /admin/produk/tambah
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products-create', compact('categories'));
    }

    /**
     * Menyimpan produk baru.
     *
     * Route:
     * POST /admin/produk
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'seller_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ]);

        // Membuat slug dari nama produk.
        $validated['slug'] = $this->makeUniqueSlug(
            $validated['name']
        );

        // Upload gambar jika ada.
        if ($request->hasFile('image')) {
            $imageName = $this->uploadProductImage(
                $request->file('image')
            );

            $validated['image_url'] = '/' .
                $this->imageDirectory . '/' . $imageName;
        } else {
            $validated['image_url'] = null;
        }

        // Kolom image adalah input upload, bukan kolom database.
        unset($validated['image']);

        // Checkbox yang tidak dicentang bernilai false.
        $validated['is_featured'] = $request->boolean('is_featured');

        Product::create($validated);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit produk.
     *
     * Route:
     * GET /admin/produk/{id}/edit
     */
    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);

        $categories = Category::orderBy('name')->get();

        return view('admin.products-edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Memperbarui produk.
     *
     * Route:
     * PUT /admin/produk/{id}
     */
    public function update(
        Request $request,
        int $id
    ): RedirectResponse {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'seller_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ]);

        // Perbarui slug jika nama produk berubah.
        if ($product->name !== $validated['name']) {
            $validated['slug'] = $this->makeUniqueSlug(
                $validated['name'],
                $product->id
            );
        }

        $oldImage = $product->image_url;
        $newImageUploaded = false;

        // Ganti gambar hanya jika pengguna memilih gambar baru.
        if ($request->hasFile('image')) {
            $imageName = $this->uploadProductImage(
                $request->file('image')
            );

            $validated['image_url'] = '/' .
                $this->imageDirectory . '/' . $imageName;

            $newImageUploaded = true;
        } else {
            // Pertahankan gambar sebelumnya.
            $validated['image_url'] = $product->image_url;
        }

        unset($validated['image']);

        $validated['is_featured'] = $request->boolean('is_featured');

        $product->update($validated);

        // Hapus gambar lama setelah data berhasil diperbarui.
        if ($newImageUploaded && $oldImage) {
            $this->deleteProductImage($oldImage);
        }

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     *
     * Route:
     * DELETE /admin/produk/{id}
     */
    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $imagePath = $product->image_url;

        $product->delete();

        // Hapus gambar produk jika file berada di folder gambar produk.
        if ($imagePath) {
            $this->deleteProductImage($imagePath);
        }

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Mengunggah gambar ke public/images/products.
     */
    private function uploadProductImage($image): string
    {
        $directory = public_path($this->imageDirectory);

        if (!File::isDirectory($directory)) {
            File::makeDirectory(
                $directory,
                0755,
                true
            );
        }

        $extension = strtolower(
            $image->getClientOriginalExtension()
        );

        $fileName = Str::uuid()->toString() . '.' . $extension;

        $image->move($directory, $fileName);

        return $fileName;
    }

    /**
     * Menghapus file gambar produk.
     *
     * Hanya menghapus file di public/images/products,
     * bukan file dari lokasi lain.
     */
    private function deleteProductImage(string $imagePath): void
    {
        $fileName = basename(
            str_replace('\\', '/', $imagePath)
        );

        // Cegah nama file yang tidak aman.
        if (
            $fileName === '' ||
            $fileName === '.' ||
            $fileName === '..'
        ) {
            return;
        }

        $fullPath = public_path(
            $this->imageDirectory . DIRECTORY_SEPARATOR . $fileName
        );

        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }

    /**
     * Membuat slug unik.
     */
    private function makeUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'produk';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when(
                    $ignoreId,
                    function (Builder $query) use ($ignoreId) {
                        $query->where('id', '!=', $ignoreId);
                    }
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
