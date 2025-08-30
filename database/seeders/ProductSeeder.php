<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();

        $products = [
            [
                'name' => 'مياه العين الزرقاء المعدنية',
                'description' => 'مياه معدنية طبيعية من عين زمزم، غنية بالمعادن الطبيعية المفيدة للصحة',
                'brand' => 'العين الزرقاء',
                'size' => '19 لتر',
                'quantity_per_box' => 1,
                'price_per_box' => 25.00,
                'price_per_bottle' => 25.00,
                'type' => 'mineral',
                'stock_quantity' => 100,
                'is_featured' => true,
            ],
            [
                'name' => 'مياه النقاء المقطرة',
                'description' => 'مياه مقطرة عالية النقاء، مثالية للاستخدام في الأجهزة الطبية والصناعية',
                'brand' => 'النقاء',
                'size' => '5 لتر',
                'quantity_per_box' => 4,
                'price_per_box' => 30.00,
                'price_per_bottle' => 7.50,
                'type' => 'distilled',
                'stock_quantity' => 50,
                'is_featured' => false,
            ],
            [
                'name' => 'مياه الجبل العذبة',
                'description' => 'مياه عين طبيعية من جبال مكة المكرمة، طازجة ونقية',
                'brand' => 'الجبل',
                'size' => '19 لتر',
                'quantity_per_box' => 1,
                'price_per_box' => 20.00,
                'price_per_bottle' => 20.00,
                'type' => 'spring',
                'stock_quantity' => 75,
                'is_featured' => true,
            ],
            [
                'name' => 'مياه القلوية الصحية',
                'description' => 'مياه قلوية بدرجة حموضة 8.5، مفيدة لتحسين الصحة العامة',
                'brand' => 'الصحة',
                'size' => '1.5 لتر',
                'quantity_per_box' => 12,
                'price_per_box' => 45.00,
                'price_per_bottle' => 3.75,
                'type' => 'alkaline',
                'stock_quantity' => 200,
                'is_featured' => false,
            ],
            [
                'name' => 'مياه زمزم المقدسة',
                'description' => 'مياه زمزم المباركة من بئر زمزم في الحرم المكي الشريف',
                'brand' => 'زمزم',
                'size' => '5 لتر',
                'quantity_per_box' => 6,
                'price_per_box' => 60.00,
                'price_per_bottle' => 10.00,
                'type' => 'mineral',
                'stock_quantity' => 30,
                'is_featured' => true,
            ],
            [
                'name' => 'مياه النقاء للشرب',
                'description' => 'مياه شرب نقية ومعقمة، آمنة للاستهلاك اليومي',
                'brand' => 'النقاء',
                'size' => '19 لتر',
                'quantity_per_box' => 1,
                'price_per_box' => 18.00,
                'price_per_bottle' => 18.00,
                'type' => 'distilled',
                'stock_quantity' => 150,
                'is_featured' => false,
            ],
            [
                'name' => 'مياه العين الطبيعية',
                'description' => 'مياه عين طبيعية من مصادر جوفية نقية في مكة المكرمة',
                'brand' => 'العين',
                'size' => '10 لتر',
                'quantity_per_box' => 2,
                'price_per_box' => 35.00,
                'price_per_bottle' => 17.50,
                'type' => 'spring',
                'stock_quantity' => 80,
                'is_featured' => false,
            ],
            [
                'name' => 'مياه القلوية الرياضية',
                'description' => 'مياه قلوية مخصصة للرياضيين، تساعد في تحسين الأداء الرياضي',
                'brand' => 'الرياضة',
                'size' => '500 مل',
                'quantity_per_box' => 24,
                'price_per_box' => 40.00,
                'price_per_bottle' => 1.67,
                'type' => 'alkaline',
                'stock_quantity' => 300,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $productData) {
            $supplier = $suppliers->random();
            
            Product::create([
                'supplier_id' => $supplier->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'brand' => $productData['brand'],
                'size' => $productData['size'],
                'quantity_per_box' => $productData['quantity_per_box'],
                'price_per_box' => $productData['price_per_box'],
                'price_per_bottle' => $productData['price_per_bottle'],
                'type' => $productData['type'],
                'status' => 'available',
                'stock_quantity' => $productData['stock_quantity'],
                'rating' => rand(35, 50) / 10,
                'total_sales' => rand(10, 100),
                'is_featured' => $productData['is_featured'],
            ]);
        }
    }
} 