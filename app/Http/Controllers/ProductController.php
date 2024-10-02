<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('search');

        // Query produk dengan pencarian (jika ada) dan pagination
        $products = Product::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->paginate(3); // Pagination 3 produk per halaman

        $total = Product::count();

        // Return view dengan hasil pencarian dan pagination
        return view('admin.product.index', compact('products', 'total', 'search')); // ubah ke index
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function save(Request $request)
    {
        // Validasi termasuk gambar
        $validation = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // Simpan gambar ke folder public/images
            $validation['image'] = $imageName; // Tambahkan nama file gambar ke data validasi
        }

        // Simpan data produk
        $product = Product::create($validation);

        if ($product) {
            session()->flash('success', 'Product added successfully');
            return redirect(route('admin/products'));
        } else {
            session()->flash('error', 'Some problem occurred');
            return redirect(route('admin/products/create'));
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);  // Ambil data produk berdasarkan ID
        $categories = Category::all();        // Ambil semua kategori dari database
        return view('admin.product.edit', compact('product', 'categories')); // ubah ke edit
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi termasuk gambar
        $validation = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload gambar baru
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            // Hapus gambar lama jika ada
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }

            // Set gambar baru
            $product->image = $imageName;
        }

        // Update data produk lainnya
        $product->update([
            'title' => $request->title,
            'category' => $request->category,
            'price' => $request->price,
        ]);

        session()->flash('success', 'Product updated successfully');
        return redirect(route('admin/products'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image) {
            if (file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
        }

        // Hapus produk
        $product->delete();

        session()->flash('success', 'Product deleted successfully');
        return redirect(route('admin/products'));
    }
}
