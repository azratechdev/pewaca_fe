<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WarungkuSetupController extends Controller
{
    public function setup()
    {
        try {
            // Create stores table if not exists
            if (!Schema::hasTable('stores')) {
                DB::statement("
                    CREATE TABLE `stores` (
                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                      `name` varchar(255) NOT NULL,
                      `description` text,
                      `logo` varchar(255) DEFAULT NULL,
                      `address` varchar(255) DEFAULT NULL,
                      `phone` varchar(255) DEFAULT NULL,
                      `email` varchar(255) DEFAULT NULL,
                      `rating` decimal(3,2) NOT NULL DEFAULT '4.50',
                      `is_active` tinyint(1) NOT NULL DEFAULT '1',
                      `created_at` timestamp NULL DEFAULT NULL,
                      `updated_at` timestamp NULL DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
            }

            // Create products table if not exists
            if (!Schema::hasTable('products')) {
                DB::statement("
                    CREATE TABLE `products` (
                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                      `store_id` bigint unsigned NOT NULL,
                      `name` varchar(255) NOT NULL,
                      `description` text,
                      `image` varchar(255) DEFAULT NULL,
                      `price` decimal(15,2) NOT NULL,
                      `stock` int NOT NULL DEFAULT '0',
                      `is_available` tinyint(1) NOT NULL DEFAULT '1',
                      `created_at` timestamp NULL DEFAULT NULL,
                      `updated_at` timestamp NULL DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      KEY `products_store_id_foreign` (`store_id`),
                      CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
            }

            // Seed data
            $this->seedData();

            return response()->json([
                'success' => true,
                'message' => 'Warungku database setup completed! 4 toko dan 32 produk berhasil dibuat.',
                'redirect' => '/warungku'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function seedData()
    {
        // Check if data already exists
        if (DB::table('stores')->count() > 0) {
            return;
        }

        // Insert stores
        $stores = [
            ['id' => 1, 'name' => 'Toko Sembako Makmur', 'description' => 'Menyediakan berbagai kebutuhan sembako dan bahan pokok sehari-hari dengan harga terjangkau', 'logo' => 'https://via.placeholder.com/100?text=SEMBAKO', 'address' => 'Jl. Raya Residence No. 12, Jakarta Selatan', 'phone' => '021-12345678', 'email' => 'sembako.makmur@mail.com', 'rating' => 4.80, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Warung Snack & Minuman', 'description' => 'Pusat jajanan, snack, dan minuman favorit keluarga Indonesia', 'logo' => 'https://via.placeholder.com/100?text=SNACK', 'address' => 'Jl. Residence Block C No. 8, Jakarta Selatan', 'phone' => '021-87654321', 'email' => 'snackminuman@mail.com', 'rating' => 4.60, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Toko Sayur & Buah Segar', 'description' => 'Sayuran dan buah-buahan segar langsung dari kebun pilihan', 'logo' => 'https://via.placeholder.com/100?text=SAYUR', 'address' => 'Jl. Residence Block B No. 15, Jakarta Selatan', 'phone' => '021-11223344', 'email' => 'sayurbuah.segar@mail.com', 'rating' => 4.90, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Toko Perlengkapan Rumah', 'description' => 'Lengkap dengan berbagai perlengkapan dan peralatan rumah tangga', 'logo' => 'https://via.placeholder.com/100?text=RUMAH', 'address' => 'Jl. Residence Block A No. 5, Jakarta Selatan', 'phone' => '021-99887766', 'email' => 'perlengkapan.rumah@mail.com', 'rating' => 4.70, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('stores')->insert($stores);

        // Insert products
        $products = [
            // Toko Sembako Makmur
            ['store_id' => 1, 'name' => 'Beras Premium 5kg', 'description' => 'Beras kualitas premium pilihan petani lokal', 'image' => 'https://via.placeholder.com/300x200?text=Beras+Premium+5kg', 'price' => 75000, 'stock' => 50, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Minyak Goreng 2L', 'description' => 'Minyak goreng berkualitas tanpa kolesterol', 'image' => 'https://via.placeholder.com/300x200?text=Minyak+Goreng+2L', 'price' => 35000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Gula Pasir 1kg', 'description' => 'Gula pasir murni tanpa campuran', 'image' => 'https://via.placeholder.com/300x200?text=Gula+Pasir+1kg', 'price' => 18000, 'stock' => 40, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Telur Ayam 1kg', 'description' => 'Telur ayam negeri segar setiap hari', 'image' => 'https://via.placeholder.com/300x200?text=Telur+Ayam+1kg', 'price' => 28000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Tepung Terigu 1kg', 'description' => 'Tepung terigu protein sedang untuk segala keperluan', 'image' => 'https://via.placeholder.com/300x200?text=Tepung+Terigu+1kg', 'price' => 12000, 'stock' => 35, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Garam Dapur 500g', 'description' => 'Garam beryodium untuk kesehatan keluarga', 'image' => 'https://via.placeholder.com/300x200?text=Garam+Dapur+500g', 'price' => 5000, 'stock' => 60, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Kecap Manis 600ml', 'description' => 'Kecap manis berkualitas rasa mantap', 'image' => 'https://via.placeholder.com/300x200?text=Kecap+Manis+600ml', 'price' => 15000, 'stock' => 20, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Mie Instan 1 Dus', 'description' => 'Mie instan isi 40 pcs berbagai rasa', 'image' => 'https://via.placeholder.com/300x200?text=Mie+Instan+1+Dus', 'price' => 120000, 'stock' => 15, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Warung Snack & Minuman
            ['store_id' => 2, 'name' => 'Keripik Singkong', 'description' => 'Keripik singkong renyah berbagai rasa', 'image' => 'https://via.placeholder.com/300x200?text=Keripik+Singkong', 'price' => 12000, 'stock' => 45, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Coklat Batangan', 'description' => 'Coklat premium isi 10 batang', 'image' => 'https://via.placeholder.com/300x200?text=Coklat+Batangan', 'price' => 25000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Biskuit Kaleng', 'description' => 'Biskuit kelapa premium dalam kaleng', 'image' => 'https://via.placeholder.com/300x200?text=Biskuit+Kaleng', 'price' => 35000, 'stock' => 20, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Kopi Sachet 1 Box', 'description' => 'Kopi instant isi 20 sachet', 'image' => 'https://via.placeholder.com/300x200?text=Kopi+Sachet+1+Box', 'price' => 18000, 'stock' => 40, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Teh Celup 1 Box', 'description' => 'Teh celup premium isi 25 pcs', 'image' => 'https://via.placeholder.com/300x200?text=Teh+Celup+1+Box', 'price' => 12000, 'stock' => 35, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Air Mineral 1 Dus', 'description' => 'Air mineral kemasan 600ml isi 24 botol', 'image' => 'https://via.placeholder.com/300x200?text=Air+Mineral+1+Dus', 'price' => 42000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Susu UHT 1 Dus', 'description' => 'Susu UHT rasa coklat isi 40 kotak', 'image' => 'https://via.placeholder.com/300x200?text=Susu+UHT+1+Dus', 'price' => 85000, 'stock' => 18, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Wafer Coklat', 'description' => 'Wafer berlapis coklat isi 12 pack', 'image' => 'https://via.placeholder.com/300x200?text=Wafer+Coklat', 'price' => 22000, 'stock' => 28, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Toko Sayur & Buah Segar
            ['store_id' => 3, 'name' => 'Jeruk Manis 1kg', 'description' => 'Jeruk manis segar pilihan premium', 'image' => 'https://via.placeholder.com/300x200?text=Jeruk+Manis+1kg', 'price' => 28000, 'stock' => 35, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Apel Fuji 1kg', 'description' => 'Apel fuji import segar dan renyah', 'image' => 'https://via.placeholder.com/300x200?text=Apel+Fuji+1kg', 'price' => 45000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Pisang Cavendish 1kg', 'description' => 'Pisang cavendish manis dan bergizi', 'image' => 'https://via.placeholder.com/300x200?text=Pisang+Cavendish+1kg', 'price' => 22000, 'stock' => 40, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Tomat Segar 1kg', 'description' => 'Tomat merah segar kaya vitamin', 'image' => 'https://via.placeholder.com/300x200?text=Tomat+Segar+1kg', 'price' => 15000, 'stock' => 50, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Wortel 1kg', 'description' => 'Wortel segar kaya beta karoten', 'image' => 'https://via.placeholder.com/300x200?text=Wortel+1kg', 'price' => 12000, 'stock' => 45, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Bayam Hijau 1 Ikat', 'description' => 'Bayam hijau segar kaya zat besi', 'image' => 'https://via.placeholder.com/300x200?text=Bayam+Hijau+1+Ikat', 'price' => 5000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Kentang 1kg', 'description' => 'Kentang berkualitas untuk berbagai masakan', 'image' => 'https://via.placeholder.com/300x200?text=Kentang+1kg', 'price' => 18000, 'stock' => 38, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Bawang Merah 1kg', 'description' => 'Bawang merah segar langsung dari petani', 'image' => 'https://via.placeholder.com/300x200?text=Bawang+Merah+1kg', 'price' => 32000, 'stock' => 28, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Toko Perlengkapan Rumah
            ['store_id' => 4, 'name' => 'Sapu Lantai', 'description' => 'Sapu lantai berkualitas tahan lama', 'image' => 'https://via.placeholder.com/300x200?text=Sapu+Lantai', 'price' => 25000, 'stock' => 20, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Pel Lantai Set', 'description' => 'Pel lantai lengkap dengan ember lipat', 'image' => 'https://via.placeholder.com/300x200?text=Pel+Lantai+Set', 'price' => 65000, 'stock' => 15, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Tempat Sampah 50L', 'description' => 'Tempat sampah plastik dengan tutup', 'image' => 'https://via.placeholder.com/300x200?text=Tempat+Sampah+50L', 'price' => 55000, 'stock' => 18, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Rak Piring Stainless', 'description' => 'Rak piring stainless anti karat 2 tingkat', 'image' => 'https://via.placeholder.com/300x200?text=Rak+Piring+Stainless', 'price' => 85000, 'stock' => 12, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Gantungan Baju Set', 'description' => 'Gantungan baju plastik isi 12 pcs', 'image' => 'https://via.placeholder.com/300x200?text=Gantungan+Baju+Set', 'price' => 18000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Ember Plastik 15L', 'description' => 'Ember plastik kokoh berbagai warna', 'image' => 'https://via.placeholder.com/300x200?text=Ember+Plastik+15L', 'price' => 28000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Lap Microfiber Set', 'description' => 'Lap microfiber premium isi 5 pcs', 'image' => 'https://via.placeholder.com/300x200?text=Lap+Microfiber+Set', 'price' => 35000, 'stock' => 22, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Sikat WC Set', 'description' => 'Sikat WC lengkap dengan wadah', 'image' => 'https://via.placeholder.com/300x200?text=Sikat+WC+Set', 'price' => 22000, 'stock' => 18, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('products')->insert($products);
    }
}
