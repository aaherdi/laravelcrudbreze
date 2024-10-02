<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-0">Edit Product</h1>
                    <hr />
                    <form action="{{ route('admin/products/update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Input untuk nama produk -->
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="title" class="form-control" placeholder="Title"
                                    value="{{ $product->title }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Dropdown untuk kategori -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" class="form-control" id="category">
                                    @foreach ($categories as $category)
                                        <option value="">{{ $product->category }}</option>
                                        <option value="{{ $category->name }}"
                                            {{ $product->category == $category->name ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input untuk harga produk -->
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Product Price"
                                    value="{{ $product->price }}">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Tampilkan gambar saat ini jika ada -->
                        @if ($product->image)
                            <div class="mb-3">
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->title }}"
                                    width="100">
                            </div>
                        @endif

                        <!-- Input untuk gambar baru -->
                        <div class="row mb-3">
                            <div class="col">
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Update -->
                        <div class="row">
                            <div class="d-grid">
                                <button class="btn btn-warning">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
