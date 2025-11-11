<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run()
    {
        // Get existing stores from WarungkuSeeder
        $stores = Store::all();
        
        if ($stores->isEmpty()) {
            $this->command->warn('No stores found. Please run WarungkuSeeder first.');
            return;
        }
        
        // Create/update 3 seller users (idempotent - safe for reruns)
        $seller1 = User::firstOrCreate(
            ['email' => 'budi.seller@pewaca.test'],
            [
                'name' => 'Budi Seller',
                'password' => Hash::make('password'),
            ]
        );
        $seller1->update(['is_seller' => true]);
        
        $seller2 = User::firstOrCreate(
            ['email' => 'siti.seller@pewaca.test'],
            [
                'name' => 'Siti Seller',
                'password' => Hash::make('password'),
            ]
        );
        $seller2->update(['is_seller' => true]);
        
        $seller3 = User::firstOrCreate(
            ['email' => 'ahmad.seller@pewaca.test'],
            [
                'name' => 'Ahmad Seller',
                'password' => Hash::make('password'),
            ]
        );
        $seller3->update(['is_seller' => true]);
        
        // Dynamically attach sellers to stores using sync (handles reruns)
        if ($stores->count() >= 1) {
            $seller1->stores()->sync($stores->take(2)->pluck('id')->toArray());
        }
        
        if ($stores->count() >= 3) {
            $seller2->stores()->sync([$stores->get(2)->id]);
        }
        
        if ($stores->count() >= 4) {
            $seller3->stores()->sync([$stores->get(3)->id]);
        }
        
        // Create sample orders for each store (clear existing sample orders first)
        foreach ($stores->take(4) as $store) {
            Order::where('store_id', $store->id)
                 ->where('notes', 'like', 'Order sample #%')
                 ->delete();
            $this->createSampleOrders($store->id);
        }
    }
    
    private function createSampleOrders($storeId)
    {
        $store = Store::find($storeId);
        if (!$store) return;
        
        $products = $store->products()->where('is_available', true)->take(3)->get();
        if ($products->isEmpty()) return;
        
        // Create or get sample customer users for orders
        $customers = [];
        for ($i = 1; $i <= 5; $i++) {
            $customers[] = User::firstOrCreate(
                ['email' => "customer{$i}@pewaca.test"],
                [
                    'name' => "Customer {$i}",
                    'password' => Hash::make('password'),
                ]
            );
        }
        
        // Create 5 sample orders
        for ($i = 1; $i <= 5; $i++) {
            $statuses = ['pending', 'processing', 'completed', 'completed', 'completed'];
            $paymentStatuses = ['unpaid', 'paid', 'paid', 'paid', 'paid'];
            $paymentMethods = ['cash', 'transfer', 'qris', 'cash', 'transfer'];
            
            $order = Order::create([
                'order_number' => 'ORD-' . $storeId . '-' . now()->format('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'store_id' => $storeId,
                'user_id' => $customers[$i - 1]->id,
                'customer_name' => 'Customer ' . $i,
                'customer_phone' => '08123456789' . $i,
                'customer_address' => 'Jl. Contoh No. ' . $i . ', Jakarta',
                'total_amount' => 0, // Will be calculated below
                'status' => $statuses[$i - 1],
                'payment_status' => $paymentStatuses[$i - 1],
                'payment_method' => $paymentMethods[$i - 1],
                'notes' => 'Order sample #' . $i,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
            
            // Add 1-3 random products to each order
            $numProducts = rand(1, min(3, $products->count()));
            $orderTotal = 0;
            
            foreach ($products->random($numProducts) as $product) {
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
                
                $orderTotal += $subtotal;
            }
            
            // Update order total
            $order->update(['total_amount' => $orderTotal]);
        }
    }
}
