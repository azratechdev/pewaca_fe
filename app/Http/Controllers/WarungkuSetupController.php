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

        // Insert stores (logo null akan menampilkan icon)
        $stores = [
            ['id' => 1, 'name' => 'Toko Sembako Makmur', 'description' => 'Menyediakan berbagai kebutuhan sembako dan bahan pokok sehari-hari dengan harga terjangkau', 'logo' => null, 'address' => 'Jl. Raya Residence No. 12, Jakarta Selatan', 'phone' => '021-12345678', 'email' => 'sembako.makmur@mail.com', 'rating' => 4.80, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Warung Snack & Minuman', 'description' => 'Pusat jajanan, snack, dan minuman favorit keluarga Indonesia', 'logo' => null, 'address' => 'Jl. Residence Block C No. 8, Jakarta Selatan', 'phone' => '021-87654321', 'email' => 'snackminuman@mail.com', 'rating' => 4.60, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Toko Sayur & Buah Segar', 'description' => 'Sayuran dan buah-buahan segar langsung dari kebun pilihan', 'logo' => null, 'address' => 'Jl. Residence Block B No. 15, Jakarta Selatan', 'phone' => '021-11223344', 'email' => 'sayurbuah.segar@mail.com', 'rating' => 4.90, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Toko Perlengkapan Rumah', 'description' => 'Lengkap dengan berbagai perlengkapan dan peralatan rumah tangga', 'logo' => null, 'address' => 'Jl. Residence Block A No. 5, Jakarta Selatan', 'phone' => '021-99887766', 'email' => 'perlengkapan.rumah@mail.com', 'rating' => 4.70, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('stores')->insert($stores);

        // Insert products (image null akan menampilkan icon)
        $products = [
            // Toko Sembako Makmur
            ['store_id' => 1, 'name' => 'Beras Premium 5kg', 'description' => 'Beras kualitas premium pilihan petani lokal', 'image' => null, 'price' => 75000, 'stock' => 50, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Minyak Goreng 2L', 'description' => 'Minyak goreng berkualitas tanpa kolesterol', 'image' => null, 'price' => 35000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Gula Pasir 1kg', 'description' => 'Gula pasir murni tanpa campuran', 'image' => null, 'price' => 18000, 'stock' => 40, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Telur Ayam 1kg', 'description' => 'Telur ayam negeri segar setiap hari', 'image' => null, 'price' => 28000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Tepung Terigu 1kg', 'description' => 'Tepung terigu protein sedang untuk segala keperluan', 'image' => null, 'price' => 12000, 'stock' => 35, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Garam Dapur 500g', 'description' => 'Garam beryodium untuk kesehatan keluarga', 'image' => null, 'price' => 5000, 'stock' => 60, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Kecap Manis 600ml', 'description' => 'Kecap manis berkualitas rasa mantap', 'image' => null, 'price' => 15000, 'stock' => 20, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 1, 'name' => 'Mie Instan 1 Dus', 'description' => 'Mie instan isi 40 pcs berbagai rasa', 'image' => null, 'price' => 120000, 'stock' => 15, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Warung Snack & Minuman
            ['store_id' => 2, 'name' => 'Keripik Singkong', 'description' => 'Keripik singkong renyah berbagai rasa', 'image' => null, 'price' => 12000, 'stock' => 45, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Coklat Batangan', 'description' => 'Coklat premium isi 10 batang', 'image' => null, 'price' => 25000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Biskuit Kaleng', 'description' => 'Biskuit kelapa premium dalam kaleng', 'image' => null, 'price' => 35000, 'stock' => 20, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Kopi Sachet 1 Box', 'description' => 'Kopi instant isi 20 sachet', 'image' => null, 'price' => 18000, 'stock' => 40, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Teh Celup 1 Box', 'description' => 'Teh celup premium isi 25 pcs', 'image' => null, 'price' => 12000, 'stock' => 35, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Air Mineral 1 Dus', 'description' => 'Air mineral kemasan 600ml isi 24 botol', 'image' => null, 'price' => 42000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Susu UHT 1 Dus', 'description' => 'Susu UHT rasa coklat isi 40 kotak', 'image' => null, 'price' => 85000, 'stock' => 18, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 2, 'name' => 'Wafer Coklat', 'description' => 'Wafer berlapis coklat isi 12 pack', 'image' => null, 'price' => 22000, 'stock' => 28, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Toko Sayur & Buah Segar
            ['store_id' => 3, 'name' => 'Jeruk Manis 1kg', 'description' => 'Jeruk manis segar pilihan premium', 'image' => null, 'price' => 28000, 'stock' => 35, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Apel Fuji 1kg', 'description' => 'Apel fuji import segar dan renyah', 'image' => null, 'price' => 45000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Pisang Cavendish 1kg', 'description' => 'Pisang cavendish manis dan bergizi', 'image' => null, 'price' => 22000, 'stock' => 40, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Tomat Segar 1kg', 'description' => 'Tomat merah segar kaya vitamin', 'image' => null, 'price' => 15000, 'stock' => 50, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Wortel 1kg', 'description' => 'Wortel segar kaya beta karoten', 'image' => null, 'price' => 12000, 'stock' => 45, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Bayam Hijau 1 Ikat', 'description' => 'Bayam hijau segar kaya zat besi', 'image' => null, 'price' => 5000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Kentang 1kg', 'description' => 'Kentang berkualitas untuk berbagai masakan', 'image' => null, 'price' => 18000, 'stock' => 38, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 3, 'name' => 'Bawang Merah 1kg', 'description' => 'Bawang merah segar langsung dari petani', 'image' => null, 'price' => 32000, 'stock' => 28, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Toko Perlengkapan Rumah
            ['store_id' => 4, 'name' => 'Sapu Lantai', 'description' => 'Sapu lantai berkualitas tahan lama', 'image' => null, 'price' => 25000, 'stock' => 20, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Pel Lantai Set', 'description' => 'Pel lantai lengkap dengan ember lipat', 'image' => null, 'price' => 65000, 'stock' => 15, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Tempat Sampah 50L', 'description' => 'Tempat sampah plastik dengan tutup', 'image' => null, 'price' => 55000, 'stock' => 18, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Rak Piring Stainless', 'description' => 'Rak piring stainless anti karat 2 tingkat', 'image' => null, 'price' => 85000, 'stock' => 12, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Gantungan Baju Set', 'description' => 'Gantungan baju plastik isi 12 pcs', 'image' => null, 'price' => 18000, 'stock' => 25, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Ember Plastik 15L', 'description' => 'Ember plastik kokoh berbagai warna', 'image' => null, 'price' => 28000, 'stock' => 30, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Lap Microfiber Set', 'description' => 'Lap microfiber premium isi 5 pcs', 'image' => null, 'price' => 35000, 'stock' => 22, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['store_id' => 4, 'name' => 'Sikat WC Set', 'description' => 'Sikat WC lengkap dengan wadah', 'image' => null, 'price' => 22000, 'stock' => 18, 'is_available' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('products')->insert($products);
    }

    public function updateImages(Request $request)
    {
        try {
            // Validasi base URL
            $baseUrl = $request->input('base_url');
            
            if (!$baseUrl) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter base_url harus diisi! Contoh: ?base_url=https://your-bucket.cos.ap-jakarta.myqcloud.com/warungku/'
                ], 400);
            }

            // Pastikan base URL diakhiri dengan /
            if (!str_ends_with($baseUrl, '/')) {
                $baseUrl .= '/';
            }

            // Update logo toko
            $storeLogos = [
                1 => 'logo_toko_sembako.png',
                2 => 'logo_warung_snack.png',
                3 => 'logo_toko_sayur.png',
                4 => 'logo_perlengkapan_rumah.png',
            ];

            foreach ($storeLogos as $storeId => $logoFile) {
                DB::table('stores')
                    ->where('id', $storeId)
                    ->update(['logo' => $baseUrl . $logoFile]);
            }

            // Update gambar produk (mapping berdasarkan nama produk)
            $productImages = [
                'Beras Premium 5kg' => 'beras_premium_5kg.png',
                'Minyak Goreng 2L' => 'minyak_goreng_2l.png',
                'Gula Pasir 1kg' => 'gula_pasir_1kg.png',
                'Telur Ayam 1kg' => 'telur_ayam_1kg.png',
                'Tepung Terigu 1kg' => 'tepung_terigu_1kg.png',
                'Garam Dapur 500g' => 'garam_dapur_500g.png',
                'Kecap Manis 600ml' => 'kecap_manis_600ml.png',
                'Mie Instan 1 Dus' => 'mie_instan_1_dus.png',
                'Keripik Singkong' => 'keripik_singkong.png',
                'Coklat Batangan' => 'coklat_batangan.png',
                'Biskuit Kaleng' => 'biskuit_kaleng.png',
                'Kopi Sachet 1 Box' => 'kopi_sachet_1_box.png',
                'Teh Celup 1 Box' => 'teh_celup_1_box.png',
                'Air Mineral 1 Dus' => 'air_mineral_1_dus.png',
                'Susu UHT 1 Dus' => 'susu_uht_1_dus.png',
                'Wafer Coklat' => 'wafer_coklat.png',
                'Jeruk Manis 1kg' => 'jeruk_manis_1kg.png',
                'Apel Fuji 1kg' => 'apel_fuji_1kg.png',
                'Pisang Cavendish 1kg' => 'pisang_cavendish_1kg.png',
                'Tomat Segar 1kg' => 'tomat_segar_1kg.png',
                'Wortel 1kg' => 'wortel_1kg.png',
                'Bayam Hijau 1 Ikat' => 'bayam_hijau_1_ikat.png',
                'Kentang 1kg' => 'kentang_1kg.png',
                'Bawang Merah 1kg' => 'bawang_merah_1kg.png',
                'Sapu Lantai' => 'sapu_lantai.png',
                'Pel Lantai Set' => 'pel_lantai_set.png',
                'Tempat Sampah 50L' => 'tempat_sampah_50l.png',
                'Rak Piring Stainless' => 'rak_piring_stainless.png',
                'Gantungan Baju Set' => 'gantungan_baju_set.png',
                'Ember Plastik 15L' => 'ember_plastik_15l.png',
                'Lap Microfiber Set' => 'lap_microfiber_set.png',
                'Sikat WC Set' => 'sikat_wc_set.png',
            ];

            $updatedProducts = 0;
            foreach ($productImages as $productName => $imageFile) {
                $updated = DB::table('products')
                    ->where('name', $productName)
                    ->update(['image' => $baseUrl . $imageFile]);
                $updatedProducts += $updated;
            }

            return response()->json([
                'success' => true,
                'message' => 'Semua gambar berhasil diupdate!',
                'details' => [
                    'store_logos_updated' => count($storeLogos),
                    'product_images_updated' => $updatedProducts,
                    'base_url' => $baseUrl
                ],
                'redirect' => '/warungku'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function setupCart()
    {
        try {
            // Create carts table if not exists
            if (!Schema::hasTable('carts')) {
                DB::statement("
                    CREATE TABLE `carts` (
                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                      `user_email` varchar(255) NOT NULL,
                      `created_at` timestamp NULL DEFAULT NULL,
                      `updated_at` timestamp NULL DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `carts_user_email_unique` (`user_email`),
                      KEY `carts_user_email_index` (`user_email`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
            }

            // Create cart_items table if not exists
            if (!Schema::hasTable('cart_items')) {
                DB::statement("
                    CREATE TABLE `cart_items` (
                      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                      `cart_id` bigint unsigned NOT NULL,
                      `product_id` bigint unsigned NOT NULL,
                      `quantity` int NOT NULL DEFAULT '1',
                      `price` decimal(10,2) NOT NULL,
                      `created_at` timestamp NULL DEFAULT NULL,
                      `updated_at` timestamp NULL DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
                      KEY `cart_items_cart_id_foreign` (`cart_id`),
                      KEY `cart_items_product_id_foreign` (`product_id`),
                      CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
                      CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart database setup completed! Tabel carts dan cart_items berhasil dibuat.',
                'redirect' => '/warungku'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
