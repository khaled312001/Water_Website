<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\DeliveryMan;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();
        $suppliers = Supplier::all();
        $deliveryMen = DeliveryMan::all();

        if ($customers->isEmpty() || $products->isEmpty() || $suppliers->isEmpty() || $deliveryMen->isEmpty()) {
            $this->command->info('Skipping order seeding - missing required data');
            return;
        }

        // Create orders for today (delivered)
        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();
            $product = $products->random();
            $supplier = $suppliers->random();
            $deliveryMan = $deliveryMen->random();

            $quantity = rand(1, 5);
            $unitPrice = $product->price_per_bottle;
            $subtotal = $unitPrice * $quantity;
            $deliveryFee = rand(10, 30);
            $totalAmount = $subtotal + $deliveryFee;

            Order::create([
                'order_number' => 'ORD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'supplier_id' => $supplier->id,
                'delivery_man_id' => $deliveryMan->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'commission' => rand(5, 15),
                'total_amount' => $totalAmount,
                'delivery_address' => 'عنوان تجريبي ' . ($i + 1),
                'delivery_city' => 'مكة المكرمة',
                'customer_phone' => $customer->phone ?? '0500000000',
                'customer_name' => $customer->name,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'created_at' => Carbon::today()->addHours(rand(9, 18)),
                'actual_delivery_time' => Carbon::today()->addHours(rand(9, 18))->addMinutes(rand(30, 120)),
            ]);
        }

        // Create orders for this month (delivered)
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers->random();
            $product = $products->random();
            $supplier = $suppliers->random();
            $deliveryMan = $deliveryMen->random();

            $quantity = rand(1, 5);
            $unitPrice = $product->price_per_bottle;
            $subtotal = $unitPrice * $quantity;
            $deliveryFee = rand(10, 30);
            $totalAmount = $subtotal + $deliveryFee;

            Order::create([
                'order_number' => 'ORD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'supplier_id' => $supplier->id,
                'delivery_man_id' => $deliveryMan->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'commission' => rand(5, 15),
                'total_amount' => $totalAmount,
                'delivery_address' => 'عنوان تجريبي ' . ($i + 6),
                'delivery_city' => 'مكة المكرمة',
                'customer_phone' => $customer->phone ?? '0500000000',
                'customer_name' => $customer->name,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'actual_delivery_time' => Carbon::now()->subDays(rand(1, 30))->addMinutes(rand(30, 120)),
            ]);
        }

        // Create some pending orders
        for ($i = 0; $i < 3; $i++) {
            $customer = $customers->random();
            $product = $products->random();
            $supplier = $suppliers->random();
            $deliveryMan = $deliveryMen->random();

            $quantity = rand(1, 5);
            $unitPrice = $product->price_per_bottle;
            $subtotal = $unitPrice * $quantity;
            $deliveryFee = rand(10, 30);
            $totalAmount = $subtotal + $deliveryFee;

            Order::create([
                'order_number' => 'ORD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'supplier_id' => $supplier->id,
                'delivery_man_id' => $deliveryMan->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'commission' => rand(5, 15),
                'total_amount' => $totalAmount,
                'delivery_address' => 'عنوان تجريبي ' . ($i + 21),
                'delivery_city' => 'مكة المكرمة',
                'customer_phone' => $customer->phone ?? '0500000000',
                'customer_name' => $customer->name,
                'status' => 'assigned',
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'created_at' => Carbon::now(),
            ]);
        }

        $this->command->info('Orders seeded successfully!');
    }
} 