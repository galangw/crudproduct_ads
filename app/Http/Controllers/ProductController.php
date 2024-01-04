<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\ProductAsset;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        try {
            $sort = $request->query('sort', 'random');
            if (request()->is('api/*')) {
                $products = Product::with('assets')->when($sort === 'asc', function ($query) {
                    $query->orderBy('price', 'asc');
                })
                    ->when($sort === 'desc', function ($query) {
                        $query->orderBy('price', 'desc');
                    })
                    ->when($sort === 'random', function ($query) {
                        $query->inRandomOrder();
                    })
                    ->get();
                return response()->json([
                    'message' => 'Product List fetched',
                    'data' => ProductResource::collection($products)
                ]);
            } else {
                $products = Product::with('category', 'assets')->when($sort === 'asc', function ($query) {
                    $query->orderBy('price', 'asc');
                })
                    ->when($sort === 'desc', function ($query) {
                        $query->orderBy('price', 'desc');
                    })
                    ->when($sort === 'random', function ($query) {
                        $query->inRandomOrder();
                    })
                    ->get();
                return view('products.index', [
                    'products' => $products,
                    'sort' => $sort
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required|numeric',
                'asset' => 'required|array',
                'asset.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048000', // Satu gambar dengan batasan jenis dan ukuran
            ]);
            $product = Product::create($validatedData);
            if ($request->hasFile('asset')) {
                foreach ($request->file('asset') as $asset) {
                    $path = $asset->store();
                    $product->assets()->create(['image' => $path]);
                }
            }
            return response()->json([
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validatedData = $request->validate([
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required|numeric',
                'asset' => 'sometimes|array',
                'asset.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048000',
            ]);

            $product->update($validatedData);

            if ($request->hasFile('asset')) {
                foreach ($product->assets as $asset) {
                    Storage::delete('public/' . $asset->image);
                    $asset->delete();
                }
                foreach ($request->file('asset') as $asset) {
                    $path = $asset->store('assets', 'public'); // specify directory name and visibility
                    $product->assets()->create(['image' => $path]);
                }
            }

            return response()->json([
                'message' => 'Product updated successfully',
                'data' => new ProductResource($product)
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500); // return a 500 status code for server errors
        }
    }



    public function destroy(Product $product)
    {
        try {
            foreach ($product->assets as $asset) {
                Storage::delete($asset->image);
                $asset->delete();
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
    public function addAsset(Request $request, Product $product)
    {
        try {
            $request->validate([
                'asset' => 'required|array',
                'asset.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048000', // One image with type and size limit
            ]);

            if ($request->hasFile('asset')) {
                foreach ($request->file('asset') as $asset) {
                    $path = $asset->store();
                    $product->assets()->create(['image' => $path]);
                }
            }

            return response()->json([
                'message' => 'Asset added successfully',
                'data' => new ProductResource($product)
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function destroyAsset(Product $product, $assetId)
    {
        try {

            $asset = $product->assets()->find($assetId);
            if (!$asset) {
                return response()->json(['message' => 'Asset not found'], 404);
            }

            Storage::delete($asset->image);

            $asset->delete();

            return response()->json(['message' => 'Asset deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
