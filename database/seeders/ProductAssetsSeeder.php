<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProductAssetsSeeder extends Seeder
{
    public function run()
    {
        $productAssets = [
            [
                'product_id' => 1,
                'image' => $this->downloadAndSaveImage('https://example.com/your-image-url.jpg'),
            ],
            // Tambahkan data asset lainnya di sini
        ];

        ProductAsset::insert($productAssets);
    }

    private function downloadAndSaveImage($url)
    {
        $contents = file_get_contents($url);
        $path = 'product_assets/' . uniqid() . '.jpg'; // Simpan di folder 'product_assets', nama file unik
        Storage::disk('local')->put($path, $contents);

        return $path;
    }
}
