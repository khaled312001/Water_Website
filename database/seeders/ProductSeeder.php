<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get all suppliers
        $suppliers = Supplier::all();

        // Products for Supplier 1 - مؤسسة مياه العزيزية للتموين
        $supplier1 = $suppliers->first();
        
        Product::create([
            'supplier_id' => $supplier1->id,
            'name' => 'مياه زمزم المعدنية',
            'description' => 'مياه زمزم الطبيعية من بئر زمزم المبارك، مياه نقية وطبيعية 100%',
            'brand' => 'زمزم',
            'size' => '500 مل',
            'quantity_per_box' => 24,
            'price_per_box' => 45.00,
            'price_per_bottle' => 2.50,
            'image' => 'products/zamzam-water-500ml.jpg',
            'barcode' => '6281000001234',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 500,
            'rating' => 4.9,
            'total_sales' => 1200,
            'is_featured' => true,
        ]);

        Product::create([
            'supplier_id' => $supplier1->id,
            'name' => 'مياه زمزم الكبيرة',
            'description' => 'مياه زمزم في عبوات كبيرة مناسبة للعائلات والمطاعم',
            'brand' => 'زمزم',
            'size' => '1.5 لتر',
            'quantity_per_box' => 12,
            'price_per_box' => 60.00,
            'price_per_bottle' => 5.00,
            'image' => 'products/zamzam-water-1.5l.jpg',
            'barcode' => '6281000001235',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 300,
            'rating' => 4.8,
            'total_sales' => 800,
            'is_featured' => false,
        ]);

        // Products for Supplier 2 - شركة مياه الشوقية المحدودة
        $supplier2 = $suppliers->skip(1)->first();
        
        Product::create([
            'supplier_id' => $supplier2->id,
            'name' => 'مياه نوفا المعدنية',
            'description' => 'مياه نوفا الطبيعية من جبال مكة المكرمة، غنية بالمعادن الطبيعية',
            'brand' => 'نوفا',
            'size' => '600 مل',
            'quantity_per_box' => 20,
            'price_per_box' => 50.00,
            'price_per_bottle' => 2.75,
            'image' => 'products/nova-water-600ml.jpg',
            'barcode' => '6281000001236',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 400,
            'rating' => 4.7,
            'total_sales' => 950,
            'is_featured' => true,
        ]);

        Product::create([
            'supplier_id' => $supplier2->id,
            'name' => 'مياه نوفا المقطرة',
            'description' => 'مياه نوفا المقطرة النقية، مثالية للاستخدام في الأجهزة الطبية',
            'brand' => 'نوفا',
            'size' => '500 مل',
            'quantity_per_box' => 24,
            'price_per_box' => 55.00,
            'price_per_bottle' => 2.90,
            'image' => 'products/nova-distilled-500ml.jpg',
            'barcode' => '6281000001237',
            'type' => 'distilled',
            'status' => 'available',
            'stock_quantity' => 200,
            'rating' => 4.6,
            'total_sales' => 450,
            'is_featured' => false,
        ]);

        // Products for Supplier 3 - مؤسسة مياه المسفلة التجارية
        $supplier3 = $suppliers->skip(2)->first();
        
        Product::create([
            'supplier_id' => $supplier3->id,
            'name' => 'مياه القلعة القلوية',
            'description' => 'مياه القلعة القلوية الفاخرة، تساعد في توازن حموضة الجسم',
            'brand' => 'القلعة',
            'size' => '750 مل',
            'quantity_per_box' => 16,
            'price_per_box' => 65.00,
            'price_per_bottle' => 4.25,
            'image' => 'products/alkaline-water-750ml.jpg',
            'barcode' => '6281000001238',
            'type' => 'alkaline',
            'status' => 'available',
            'stock_quantity' => 250,
            'rating' => 4.8,
            'total_sales' => 600,
            'is_featured' => true,
        ]);

        Product::create([
            'supplier_id' => $supplier3->id,
            'name' => 'مياه القلعة العادية',
            'description' => 'مياه القلعة الطبيعية من ينابيع مكة المكرمة',
            'brand' => 'القلعة',
            'size' => '500 مل',
            'quantity_per_box' => 24,
            'price_per_box' => 48.00,
            'price_per_bottle' => 2.50,
            'image' => 'products/alkaline-water-500ml.jpg',
            'barcode' => '6281000001239',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 350,
            'rating' => 4.5,
            'total_sales' => 750,
            'is_featured' => false,
        ]);

        // Products for Supplier 4 - شركة مياه العتيبية للاستثمار
        $supplier4 = $suppliers->skip(3)->first();
        
        Product::create([
            'supplier_id' => $supplier4->id,
            'name' => 'مياه العتيبية المقطرة',
            'description' => 'مياه العتيبية المقطرة النقية، مناسبة للاستخدام في البطاريات والأجهزة',
            'brand' => 'العتيبية',
            'size' => '1 لتر',
            'quantity_per_box' => 18,
            'price_per_box' => 58.00,
            'price_per_bottle' => 3.25,
            'image' => 'products/atibiya-distilled-1l.jpg',
            'barcode' => '6281000001240',
            'type' => 'distilled',
            'status' => 'available',
            'stock_quantity' => 180,
            'rating' => 4.4,
            'total_sales' => 320,
            'is_featured' => false,
        ]);

        Product::create([
            'supplier_id' => $supplier4->id,
            'name' => 'مياه العتيبية المعدنية',
            'description' => 'مياه العتيبية المعدنية الطبيعية من جبال مكة',
            'brand' => 'العتيبية',
            'size' => '600 مل',
            'quantity_per_box' => 20,
            'price_per_box' => 52.00,
            'price_per_bottle' => 2.80,
            'image' => 'products/atibiya-mineral-600ml.jpg',
            'barcode' => '6281000001241',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 280,
            'rating' => 4.3,
            'total_sales' => 420,
            'is_featured' => false,
        ]);

        // Products for Supplier 5 - مؤسسة مياه المنصور العالمية
        $supplier5 = $suppliers->skip(4)->first();
        
        Product::create([
            'supplier_id' => $supplier5->id,
            'name' => 'مياه المنصور الفاخرة',
            'description' => 'مياه المنصور الفاخرة من ينابيع مكة المكرمة، مياه نقية وطبيعية',
            'brand' => 'المنصور',
            'size' => '500 مل',
            'quantity_per_box' => 24,
            'price_per_box' => 70.00,
            'price_per_bottle' => 3.50,
            'image' => 'products/mansour-premium-500ml.jpg',
            'barcode' => '6281000001242',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 150,
            'rating' => 4.9,
            'total_sales' => 280,
            'is_featured' => true,
        ]);

        Product::create([
            'supplier_id' => $supplier5->id,
            'name' => 'مياه المنصور العادية',
            'description' => 'مياه المنصور العادية، جودة عالية بسعر مناسب',
            'brand' => 'المنصور',
            'size' => '500 مل',
            'quantity_per_box' => 24,
            'price_per_box' => 45.00,
            'price_per_bottle' => 2.25,
            'image' => 'products/mansour-regular-500ml.jpg',
            'barcode' => '6281000001243',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 400,
            'rating' => 4.6,
            'total_sales' => 850,
            'is_featured' => false,
        ]);

        Product::create([
            'supplier_id' => $supplier5->id,
            'name' => 'مياه المنصور القلوية',
            'description' => 'مياه المنصور القلوية، تساعد في تحسين صحة الجسم',
            'brand' => 'المنصور',
            'size' => '750 مل',
            'quantity_per_box' => 16,
            'price_per_box' => 75.00,
            'price_per_bottle' => 4.75,
            'image' => 'products/mansour-alkaline-750ml.jpg',
            'barcode' => '6281000001244',
            'type' => 'alkaline',
            'status' => 'available',
            'stock_quantity' => 120,
            'rating' => 4.8,
            'total_sales' => 180,
            'is_featured' => true,
        ]);

        // Additional products for variety
        Product::create([
            'supplier_id' => $supplier1->id,
            'name' => 'مياه زمزم للرياضيين',
            'description' => 'مياه زمزم مخصصة للرياضيين، غنية بالأملاح المعدنية',
            'brand' => 'زمزم',
            'size' => '1 لتر',
            'quantity_per_box' => 18,
            'price_per_box' => 55.00,
            'price_per_bottle' => 3.25,
            'image' => 'products/zamzam-sports-1l.jpg',
            'barcode' => '6281000001245',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 200,
            'rating' => 4.7,
            'total_sales' => 350,
            'is_featured' => false,
        ]);

        Product::create([
            'supplier_id' => $supplier2->id,
            'name' => 'مياه نوفا للعائلات',
            'description' => 'مياه نوفا في عبوات كبيرة مناسبة للعائلات',
            'brand' => 'نوفا',
            'size' => '2 لتر',
            'quantity_per_box' => 8,
            'price_per_box' => 80.00,
            'price_per_bottle' => 10.00,
            'image' => 'products/nova-family-2l.jpg',
            'barcode' => '6281000001246',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 100,
            'rating' => 4.5,
            'total_sales' => 150,
            'is_featured' => false,
        ]);

        Product::create([
            'supplier_id' => $supplier3->id,
            'name' => 'مياه القلعة للضيافة',
            'description' => 'مياه القلعة في عبوات أنيقة مناسبة للضيافة',
            'brand' => 'القلعة',
            'size' => '330 مل',
            'quantity_per_box' => 30,
            'price_per_box' => 60.00,
            'price_per_bottle' => 2.25,
            'image' => 'products/alkaline-hospitality-330ml.jpg',
            'barcode' => '6281000001247',
            'type' => 'mineral',
            'status' => 'available',
            'stock_quantity' => 150,
            'rating' => 4.6,
            'total_sales' => 220,
            'is_featured' => false,
        ]);

        Product::create([
            'supplier_id' => $supplier4->id,
            'name' => 'مياه العتيبية للاستخدام الطبي',
            'description' => 'مياه العتيبية المقطرة للاستخدام في الأجهزة الطبية',
            'brand' => 'العتيبية',
            'size' => '500 مل',
            'quantity_per_box' => 24,
            'price_per_box' => 65.00,
            'price_per_bottle' => 3.50,
            'image' => 'products/atibiya-medical-500ml.jpg',
            'barcode' => '6281000001248',
            'type' => 'distilled',
            'status' => 'available',
            'stock_quantity' => 80,
            'rating' => 4.8,
            'total_sales' => 120,
            'is_featured' => false,
        ]);
    }
} 