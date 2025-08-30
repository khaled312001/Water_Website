<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\DeliveryMan;
use App\Models\Supplier;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $customers = User::where('role', 'customer')->get();
        $deliveryMen = DeliveryMan::all();
        $suppliers = Supplier::all();

        $orderStatuses = ['pending', 'confirmed', 'preparing', 'assigned', 'picked_up', 'delivered', 'cancelled'];
        $paymentMethods = ['cash', 'card', 'online'];
        $deliveryAddresses = [
            'حي العزيزية، شارع الملك عبدالله، مكة المكرمة',
            'حي الشوقية، شارع العزيزية، مكة المكرمة',
            'حي المسفلة، شارع المنصور، مكة المكرمة',
            'حي العتيبية، شارع العتيبية، مكة المكرمة',
            'حي المنصور، شارع الشوقية، مكة المكرمة',
        ];

        // Create 50 orders
        for ($i = 0; $i < 50; $i++) {
            $customer = $customers->random();
            $product = $products->random();
            $supplier = $suppliers->where('id', $product->supplier_id)->first();
            $deliveryMan = $deliveryMen->random();
            $status = $orderStatuses[array_rand($orderStatuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $deliveryAddress = $deliveryAddresses[array_rand($deliveryAddresses)];
            
            // Random order date within last 3 months
            $orderDate = now()->subDays(rand(1, 90));
            
            $quantity = rand(1, 5);
            $unitPrice = $product->price_per_bottle;
            $subtotal = $unitPrice * $quantity;
            $deliveryFee = rand(10, 25);
            $commission = $subtotal * 0.1; // 10% commission
            $totalAmount = $subtotal + $deliveryFee;
            
            Order::create([
                'order_number' => 'ORD-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'supplier_id' => $supplier->id,
                'delivery_man_id' => $deliveryMan->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'commission' => $commission,
                'total_amount' => $totalAmount,
                'delivery_address' => $deliveryAddress,
                'delivery_city' => 'مكة المكرمة',
                'customer_phone' => $customer->phone,
                'customer_name' => $customer->name,
                'notes' => rand(0, 1) ? 'يرجى التوصيل في الصباح' : null,
                'status' => $status,
                'payment_status' => $status === 'delivered' ? 'paid' : 'pending',
                'payment_method' => $paymentMethod,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);
        }
    }
} 