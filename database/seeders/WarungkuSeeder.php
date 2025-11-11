<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Product;

class WarungkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = [
            [
                'name' => 'Toko Sembako Makmur',
                'description' => 'Menyediakan berbagai kebutuhan sembako dan bahan pokok sehari-hari dengan harga terjangkau',
                'logo' => '/images/warungku/stores/sembako.jpg',
                'address' => 'Jl. Raya Residence No. 12, Jakarta Selatan',
                'phone' => '021-12345678',
                'email' => 'sembako.makmur@mail.com',
                'rating' => 4.8,
                'products' => [
                    ['name' => 'Beras Premium 5kg', 'description' => 'Beras kualitas premium pilihan petani lokal', 'price' => 75000, 'stock' => 50],
                    ['name' => 'Minyak Goreng 2L', 'description' => 'Minyak goreng berkualitas tanpa kolesterol', 'price' => 35000, 'stock' => 30],
                    ['name' => 'Gula Pasir 1kg', 'description' => 'Gula pasir murni tanpa campuran', 'price' => 18000, 'stock' => 40],
                    ['name' => 'Telur Ayam 1kg', 'description' => 'Telur ayam negeri segar setiap hari', 'price' => 28000, 'stock' => 25],
                    ['name' => 'Tepung Terigu 1kg', 'description' => 'Tepung terigu protein sedang untuk segala keperluan', 'price' => 12000, 'stock' => 35],
                    ['name' => 'Garam Dapur 500g', 'description' => 'Garam beryodium untuk kesehatan keluarga', 'price' => 5000, 'stock' => 60],
                    ['name' => 'Kecap Manis 600ml', 'description' => 'Kecap manis berkualitas rasa mantap', 'price' => 15000, 'stock' => 20],
                    ['name' => 'Mie Instan 1 Dus', 'description' => 'Mie instan isi 40 pcs berbagai rasa', 'price' => 120000, 'stock' => 15],
                ],
            ],
            [
                'name' => 'Warung Snack & Minuman',
                'description' => 'Pusat jajanan, snack, dan minuman favorit keluarga Indonesia',
                'logo' => '/images/warungku/stores/snack.jpg',
                'address' => 'Jl. Residence Block C No. 8, Jakarta Selatan',
                'phone' => '021-87654321',
                'email' => 'snackminuman@mail.com',
                'rating' => 4.6,
                'products' => [
                    ['name' => 'Keripik Singkong', 'description' => 'Keripik singkong renyah berbagai rasa', 'price' => 12000, 'stock' => 45],
                    ['name' => 'Coklat Batangan', 'description' => 'Coklat premium isi 10 batang', 'price' => 25000, 'stock' => 30],
                    ['name' => 'Biskuit Kaleng', 'description' => 'Biskuit kelapa premium dalam kaleng', 'price' => 35000, 'stock' => 20],
                    ['name' => 'Kopi Sachet 1 Box', 'description' => 'Kopi instant isi 20 sachet', 'price' => 18000, 'stock' => 40],
                    ['name' => 'Teh Celup 1 Box', 'description' => 'Teh celup premium isi 25 pcs', 'price' => 12000, 'stock' => 35],
                    ['name' => 'Air Mineral 1 Dus', 'description' => 'Air mineral kemasan 600ml isi 24 botol', 'price' => 42000, 'stock' => 25],
                    ['name' => 'Susu UHT 1 Dus', 'description' => 'Susu UHT rasa coklat isi 40 kotak', 'price' => 85000, 'stock' => 18],
                    ['name' => 'Wafer Coklat', 'description' => 'Wafer berlapis coklat isi 12 pack', 'price' => 22000, 'stock' => 28],
                ],
            ],
            [
                'name' => 'Toko Sayur & Buah Segar',
                'description' => 'Sayuran dan buah-buahan segar langsung dari kebun pilihan',
                'logo' => '/images/warungku/stores/sayur.jpg',
                'address' => 'Jl. Residence Block B No. 15, Jakarta Selatan',
                'phone' => '021-11223344',
                'email' => 'sayurbuah.segar@mail.com',
                'rating' => 4.9,
                'products' => [
                    ['name' => 'Jeruk Manis 1kg', 'description' => 'Jeruk manis segar pilihan premium', 'price' => 28000, 'stock' => 35],
                    ['name' => 'Apel Fuji 1kg', 'description' => 'Apel fuji import segar dan renyah', 'price' => 45000, 'stock' => 25],
                    ['name' => 'Pisang Cavendish 1kg', 'description' => 'Pisang cavendish manis dan bergizi', 'price' => 22000, 'stock' => 40],
                    ['name' => 'Tomat Segar 1kg', 'description' => 'Tomat merah segar kaya vitamin', 'price' => 15000, 'stock' => 50],
                    ['name' => 'Wortel 1kg', 'description' => 'Wortel segar kaya beta karoten', 'price' => 12000, 'stock' => 45],
                    ['name' => 'Bayam Hijau 1 Ikat', 'description' => 'Bayam hijau segar kaya zat besi', 'price' => 5000, 'stock' => 30],
                    ['name' => 'Kentang 1kg', 'description' => 'Kentang berkualitas untuk berbagai masakan', 'price' => 18000, 'stock' => 38],
                    ['name' => 'Bawang Merah 1kg', 'description' => 'Bawang merah segar langsung dari petani', 'price' => 32000, 'stock' => 28],
                ],
            ],
            [
                'name' => 'Toko Perlengkapan Rumah',
                'description' => 'Lengkap dengan berbagai perlengkapan dan peralatan rumah tangga',
                'logo' => '/images/warungku/stores/rumah.jpg',
                'address' => 'Jl. Residence Block A No. 5, Jakarta Selatan',
                'phone' => '021-99887766',
                'email' => 'perlengkapan.rumah@mail.com',
                'rating' => 4.7,
                'products' => [
                    ['name' => 'Sapu Lantai', 'description' => 'Sapu lantai berkualitas tahan lama', 'price' => 25000, 'stock' => 20],
                    ['name' => 'Pel Lantai Set', 'description' => 'Pel lantai lengkap dengan ember lipat', 'price' => 65000, 'stock' => 15],
                    ['name' => 'Tempat Sampah 50L', 'description' => 'Tempat sampah plastik dengan tutup', 'price' => 55000, 'stock' => 18],
                    ['name' => 'Rak Piring Stainless', 'description' => 'Rak piring stainless anti karat 2 tingkat', 'price' => 85000, 'stock' => 12],
                    ['name' => 'Gantungan Baju Set', 'description' => 'Gantungan baju plastik isi 12 pcs', 'price' => 18000, 'stock' => 25],
                    ['name' => 'Ember Plastik 15L', 'description' => 'Ember plastik kokoh berbagai warna', 'price' => 28000, 'stock' => 30],
                    ['name' => 'Lap Microfiber Set', 'description' => 'Lap microfiber premium isi 5 pcs', 'price' => 35000, 'stock' => 22],
                    ['name' => 'Sikat WC Set', 'description' => 'Sikat WC lengkap dengan wadah', 'price' => 22000, 'stock' => 18],
                ],
            ],
        ];

        $productImageIndex = 1;
        
        foreach ($stores as $storeData) {
            $products = $storeData['products'];
            unset($storeData['products']);

            $store = Store::create($storeData);

            foreach ($products as $productData) {
                $productData['store_id'] = $store->id;
                $productData['image'] = '/images/warungku/products/default-' . $productImageIndex . '.jpg';
                Product::create($productData);
                
                $productImageIndex++;
                if ($productImageIndex > 5) {
                    $productImageIndex = 1;
                }
            }
        }
    }
}
