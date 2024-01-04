<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $sort = $request->query('sort', 'random'); // Mengambil parameter sort dari query string, defaultnya adalah 'random'
        if ($request->is('api/*')) {
            // Logika untuk permintaan API
            $categories = Category::withCount('products')
                ->when($sort === 'asc', function ($query) {
                    $query->orderBy('products_count', 'asc');
                })
                ->when($sort === 'desc', function ($query) {
                    $query->orderBy('products_count', 'desc');
                })
                ->when($sort === 'random', function ($query) {
                    $query->inRandomOrder();
                })
                ->get();
            return CategoryResource::collection($categories);
        } else {
            $categories = Category::withCount('products')
                ->when($sort === 'asc', function ($query) {
                    $query->orderBy('products_count', 'asc');
                })
                ->when($sort === 'desc', function ($query) {
                    $query->orderBy('products_count', 'desc');
                })
                ->when($sort === 'random', function ($query) {
                    $query->inRandomOrder();
                })
                ->get();

            return view('categories.index', [
                'categories' => $categories,
                'sort' => $sort
            ]);
        }
    }



    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
