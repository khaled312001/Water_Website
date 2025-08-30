<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\DeliveryMan;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'أحمد محمد العتيبي',
            'email' => 'admin@makkah-water.com',
            'phone' => '0501234567',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/admin-ahmed.jpg',
            'is_active' => true,
        ]);

        // Supplier Users - محلات مكة المشهورة
        $supplier1 = User::create([
            'name' => 'عبدالله محمد الزهراني',
            'email' => 'supplier1@makkah-water.com',
            'phone' => '0501234568',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع الملك عبدالله، حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/supplier-abdullah.jpg',
            'is_active' => true,
        ]);

        $supplier2 = User::create([
            'name' => 'فاطمة أحمد الغامدي',
            'email' => 'supplier2@makkah-water.com',
            'phone' => '0501234569',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع العزيزية، حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/supplier-fatima.jpg',
            'is_active' => true,
        ]);

        $supplier3 = User::create([
            'name' => 'علي حسن المطيري',
            'email' => 'supplier3@makkah-water.com',
            'phone' => '0501234570',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع المنصور، حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/supplier-ali.jpg',
            'is_active' => true,
        ]);

        $supplier4 = User::create([
            'name' => 'محمد سعد القحطاني',
            'email' => 'supplier4@makkah-water.com',
            'phone' => '0501234571',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع العتيبية، حي العتيبية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/supplier-mohammed.jpg',
            'is_active' => true,
        ]);

        $supplier5 = User::create([
            'name' => 'خالد عبدالرحمن الحربي',
            'email' => 'supplier5@makkah-water.com',
            'phone' => '0501234572',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع الشوقية، حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/supplier-khalid.jpg',
            'is_active' => true,
        ]);

        // Delivery Men Users - مناديب توصيل من مكة
        $delivery1 = User::create([
            'name' => 'يوسف محمد العتيبي',
            'email' => 'delivery1@makkah-water.com',
            'phone' => '0501234573',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/delivery-yousef.jpg',
            'is_active' => true,
        ]);

        $delivery2 = User::create([
            'name' => 'عبدالرحمن أحمد الزهراني',
            'email' => 'delivery2@makkah-water.com',
            'phone' => '0501234574',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/delivery-abdulrahman.jpg',
            'is_active' => true,
        ]);

        $delivery3 = User::create([
            'name' => 'سعد علي المطيري',
            'email' => 'delivery3@makkah-water.com',
            'phone' => '0501234575',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/delivery-saad.jpg',
            'is_active' => true,
        ]);

        $delivery4 = User::create([
            'name' => 'فهد محمد القحطاني',
            'email' => 'delivery4@makkah-water.com',
            'phone' => '0501234576',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي العتيبية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/delivery-fahad.jpg',
            'is_active' => true,
        ]);

        $delivery5 = User::create([
            'name' => 'سلطان عبدالله الحربي',
            'email' => 'delivery5@makkah-water.com',
            'phone' => '0501234577',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي المنصور، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/delivery-sultan.jpg',
            'is_active' => true,
        ]);

        // Customer Users - عملاء من مكة
        $customer1 = User::create([
            'name' => 'أحمد علي العتيبي',
            'email' => 'customer1@makkah-water.com',
            'phone' => '0501234578',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/customer-ahmed.jpg',
            'is_active' => true,
        ]);

        $customer2 = User::create([
            'name' => 'فاطمة محمد الزهراني',
            'email' => 'customer2@makkah-water.com',
            'phone' => '0501234579',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/customer-fatima.jpg',
            'is_active' => true,
        ]);

        $customer3 = User::create([
            'name' => 'علي أحمد المطيري',
            'email' => 'customer3@makkah-water.com',
            'phone' => '0501234580',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/customer-ali.jpg',
            'is_active' => true,
        ]);

        $customer4 = User::create([
            'name' => 'خديجة سعد القحطاني',
            'email' => 'customer4@makkah-water.com',
            'phone' => '0501234581',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي العتيبية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/customer-khadija.jpg',
            'is_active' => true,
        ]);

        $customer5 = User::create([
            'name' => 'محمد خالد الحربي',
            'email' => 'customer5@makkah-water.com',
            'phone' => '0501234582',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي المنصور، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'profile_image' => 'profile-images/customer-mohammed.jpg',
            'is_active' => true,
        ]);

        // Create Supplier Records - محلات مكة المشهورة
        Supplier::create([
            'user_id' => $supplier1->id,
            'company_name' => 'مؤسسة مياه العزيزية للتموين',
            'commercial_license' => 'CR123456789',
            'tax_number' => '300123456789',
            'contact_person' => 'عبدالله محمد الزهراني',
            'phone' => '0501234568',
            'email' => 'supplier1@makkah-water.com',
            'address' => 'شارع الملك عبدالله، حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'أكبر مورد للمياه العذبة في حي العزيزية، نخدم أهالي مكة منذ أكثر من 15 عام',
            'status' => 'active',
            'rating' => 4.8,
            'total_orders' => 250,
        ]);

        Supplier::create([
            'user_id' => $supplier2->id,
            'company_name' => 'شركة مياه الشوقية المحدودة',
            'commercial_license' => 'CR987654321',
            'tax_number' => '300987654321',
            'contact_person' => 'فاطمة أحمد الغامدي',
            'phone' => '0501234569',
            'email' => 'supplier2@makkah-water.com',
            'address' => 'شارع العزيزية، حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'مؤسسة رائدة في مجال توزيع المياه المعدنية والطبيعية في حي الشوقية',
            'status' => 'active',
            'rating' => 4.6,
            'total_orders' => 180,
        ]);

        Supplier::create([
            'user_id' => $supplier3->id,
            'company_name' => 'مؤسسة مياه المسفلة التجارية',
            'commercial_license' => 'CR456789123',
            'tax_number' => '300456789123',
            'contact_person' => 'علي حسن المطيري',
            'phone' => '0501234570',
            'email' => 'supplier3@makkah-water.com',
            'address' => 'شارع المنصور، حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'شركة متخصصة في المياه المعدنية والقلوية، نخدم حي المسفلة منذ 10 سنوات',
            'status' => 'active',
            'rating' => 4.7,
            'total_orders' => 120,
        ]);

        Supplier::create([
            'user_id' => $supplier4->id,
            'company_name' => 'شركة مياه العتيبية للاستثمار',
            'commercial_license' => 'CR789123456',
            'tax_number' => '300789123456',
            'contact_person' => 'محمد سعد القحطاني',
            'phone' => '0501234571',
            'email' => 'supplier4@makkah-water.com',
            'address' => 'شارع العتيبية، حي العتيبية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'مؤسسة حديثة متخصصة في المياه المقطرة والمعدنية، نخدم حي العتيبية',
            'status' => 'active',
            'rating' => 4.5,
            'total_orders' => 90,
        ]);

        Supplier::create([
            'user_id' => $supplier5->id,
            'company_name' => 'مؤسسة مياه المنصور العالمية',
            'commercial_license' => 'CR321654987',
            'tax_number' => '300321654987',
            'contact_person' => 'خالد عبدالرحمن الحربي',
            'phone' => '0501234572',
            'email' => 'supplier5@makkah-water.com',
            'address' => 'شارع الشوقية، حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'شركة عالمية متخصصة في المياه الفاخرة والطبيعية، نخدم جميع أحياء مكة',
            'status' => 'active',
            'rating' => 4.9,
            'total_orders' => 300,
        ]);

        // Create Delivery Man Records - مناديب توصيل من مكة
        DeliveryMan::create([
            'user_id' => $delivery1->id,
            'national_id' => '1234567890',
            'vehicle_type' => 'سيارة صغيرة',
            'vehicle_number' => 'مكة 1234',
            'license_number' => 'DL123456789',
            'emergency_contact' => 'أحمد يوسف',
            'emergency_phone' => '0501234583',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.9,
            'total_deliveries' => 350,
            'total_earnings' => 8500.00,
        ]);

        DeliveryMan::create([
            'user_id' => $delivery2->id,
            'national_id' => '0987654321',
            'vehicle_type' => 'دراجة نارية',
            'vehicle_number' => 'مكة 5678',
            'license_number' => 'DL987654321',
            'emergency_contact' => 'محمد عبدالرحمن',
            'emergency_phone' => '0501234584',
            'address' => 'حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.7,
            'total_deliveries' => 280,
            'total_earnings' => 7200.00,
        ]);

        DeliveryMan::create([
            'user_id' => $delivery3->id,
            'national_id' => '1122334455',
            'vehicle_type' => 'سيارة صغيرة',
            'vehicle_number' => 'مكة 9012',
            'license_number' => 'DL112233445',
            'emergency_contact' => 'علي سعد',
            'emergency_phone' => '0501234585',
            'address' => 'حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.8,
            'total_deliveries' => 320,
            'total_earnings' => 7800.00,
        ]);

        DeliveryMan::create([
            'user_id' => $delivery4->id,
            'national_id' => '2233445566',
            'vehicle_type' => 'دراجة نارية',
            'vehicle_number' => 'مكة 3456',
            'license_number' => 'DL223344556',
            'emergency_contact' => 'فهد محمد',
            'emergency_phone' => '0501234586',
            'address' => 'حي العتيبية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.6,
            'total_deliveries' => 240,
            'total_earnings' => 6500.00,
        ]);

        DeliveryMan::create([
            'user_id' => $delivery5->id,
            'national_id' => '3344556677',
            'vehicle_type' => 'سيارة صغيرة',
            'vehicle_number' => 'مكة 7890',
            'license_number' => 'DL334455667',
            'emergency_contact' => 'سلطان عبدالله',
            'emergency_phone' => '0501234587',
            'address' => 'حي المنصور، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.9,
            'total_deliveries' => 380,
            'total_earnings' => 9200.00,
        ]);
    }
} 