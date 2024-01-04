@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Products</h3>
                        <div class="card-body">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="input-group">
                                    <select name="sort" id="sort" class="form-select">
                                        <option selected value="random" {{ $sort === 'random' ? 'selected' : '' }}>Price
                                            Sort By</option>
                                        <option value="asc" {{ $sort === 'asc' ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ $sort === 'desc' ? 'selected' : '' }}>Descending</option>

                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>

                            </form>

                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Products Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $no++ }}</th>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->slug }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>
                                                @if ($product->assets->count() > 0)
                                                    @foreach ($product->assets as $asset)
                                                        <img src="storage/{{ $asset->image }}" alt="Product Image"
                                                            width="100">
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
