@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Category</h3>
                        <div>
                            <div class="card-body">
                                <form action="{{ route('categories.index') }}" method="GET">

                                    <div class="input-group">
                                        {{-- <label for="sort">Urutkan berdasarkan:</label> --}}
                                        <select name="sort" id="sort" class="form-select" id=""
                                            aria-label="">
                                            <option value="random" {{ $sort === 'random' ? 'selected' : '' }}>Sort By
                                            </option>
                                            <option value="asc" {{ $sort === 'asc' ? 'selected' : '' }}>Ascending
                                            </option>
                                            <option value="desc" {{ $sort === 'desc' ? 'selected' : '' }}>Descending
                                            </option>

                                        </select>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                                <table class="table mt-2">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Kategori</th>
                                            <th scope="col">Total Produk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($categories as $category)
                                            <tr>
                                                <th scope="row">{{ $no++ }}</th>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->products_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
