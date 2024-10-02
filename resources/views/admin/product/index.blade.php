<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Notifikasi sukses -->
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="ml-auto d-flex">
                            <!-- Tombol Add Product -->
                            <a href="{{ route('admin/products/create') }}" class="btn btn-primary mr-2">Add Product</a>

                            <!-- Form Pencarian Produk -->
                            <form action="{{ route('admin/products') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search product..." value="{{ request()->get('search') }}">
                                <button class="btn btn-primary ml-2" type="submit">Search</button>
                            </form>
                        </div>
                    </div>

                    <hr />

                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Image</th> <!-- Tambahkan kolom gambar -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $product->title }}</td>
                                    <td class="align-middle">{{ $product->category }}</td>
                                    <td class="align-middle">{{ $product->price }}</td>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('images/' . $product->image) }}"
                                                alt="{{ $product->title }}" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('admin/products/edit', ['id' => $product->id]) }}"
                                                type="button" class="btn btn-secondary">Edit</a>
                                            {{-- <a href="{{ route('admin/products/delete', ['id' => $product->id]) }}"type="button"
                                                class="btn btn-danger">Delete</a> --}}
                                            <a href="javascript:void(0)" onclick="deleteFunction({{ $product->id }})"
                                                type="button" class="btn btn-danger">Delete</a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">Product not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function deleteFunction(id) {
        // Set the product ID in the hidden input field
        document.getElementById('delete_id').value = id;

        // Update the form action dynamically
        var form = document.getElementById('deleteForm');
        form.action = '/admin/products/delete/' + id;

        // Show the modal
        $("#modalDelete").modal('show');
    }
</script>

<!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="post" id="deleteForm">
                @csrf
                @method('DELETE')
                <input type="hidden" name="product_id" id="delete_id">

                <!-- Header Modal -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalDeleteTitle">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body text-center">
                    <p class="fs-5">Are you sure you want to delete this product?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>

                <!-- Footer Modal -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
