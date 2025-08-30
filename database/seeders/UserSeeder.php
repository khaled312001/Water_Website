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
            'name' => 'مدير النظام',
            'email' => 'admin@makkah-water.com',
            'phone' => '0501234567',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'address' => 'مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        // Supplier Users
        $supplier1 = User::create([
            'name' => 'أحمد محمد المورد',
            'email' => 'supplier1@makkah-water.com',
            'phone' => '0501234568',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع الملك عبدالله، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        $supplier2 = User::create([
            'name' => 'فاطمة أحمد الموردة',
            'email' => 'supplier2@makkah-water.com',
            'phone' => '0501234569',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        $supplier3 = User::create([
            'name' => 'علي حسن المورد',
            'email' => 'supplier3@makkah-water.com',
            'phone' => '0501234570',
            'password' => Hash::make('12345678'),
            'role' => 'supplier',
            'address' => 'شارع المنصور، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        // Delivery Men Users
        $delivery1 = User::create([
            'name' => 'محمد علي المندوب',
            'email' => 'delivery1@makkah-water.com',
            'phone' => '0501234571',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        $delivery2 = User::create([
            'name' => 'عبدالله أحمد المندوب',
            'email' => 'delivery2@makkah-water.com',
            'phone' => '0501234572',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        $delivery3 = User::create([
            'name' => 'يوسف محمد المندوب',
            'email' => 'delivery3@makkah-water.com',
            'phone' => '0501234573',
            'password' => Hash::make('12345678'),
            'role' => 'delivery',
            'address' => 'حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        // Customer Users
        $customer1 = User::create([
            'name' => 'أحمد العميل',
            'email' => 'customer1@makkah-water.com',
            'phone' => '0501234574',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        $customer2 = User::create([
            'name' => 'فاطمة العميلة',
            'email' => 'customer2@makkah-water.com',
            'phone' => '0501234575',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        $customer3 = User::create([
            'name' => 'علي العميل',
            'email' => 'customer3@makkah-water.com',
            'phone' => '0501234576',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => 'حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'is_active' => true,
        ]);

        // Create Supplier Records
        Supplier::create([
            'user_id' => $supplier1->id,
            'company_name' => 'شركة مياه العزيزية',
            'commercial_license' => 'CR123456789',
            'tax_number' => '300123456789',
            'contact_person' => 'أحمد محمد',
            'phone' => '0501234568',
            'email' => 'supplier1@makkah-water.com',
            'address' => 'شارع الملك عبدالله، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'أفضل مورد للمياه العذبة في مكة المكرمة',
            'status' => 'active',
            'rating' => 4.8,
            'total_orders' => 150,
        ]);

        Supplier::create([
            'user_id' => $supplier2->id,
            'company_name' => 'مؤسسة مياه الشوقية',
            'commercial_license' => 'CR987654321',
            'tax_number' => '300987654321',
            'contact_person' => 'فاطمة أحمد',
            'phone' => '0501234569',
            'email' => 'supplier2@makkah-water.com',
            'address' => 'شارع العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'مؤسسة رائدة في مجال توزيع المياه',
            'status' => 'active',
            'rating' => 4.6,
            'total_orders' => 120,
        ]);

        Supplier::create([
            'user_id' => $supplier3->id,
            'company_name' => 'شركة مياه المنصور',
            'commercial_license' => 'CR456789123',
            'tax_number' => '300456789123',
            'contact_person' => 'علي حسن',
            'phone' => '0501234570',
            'email' => 'supplier3@makkah-water.com',
            'address' => 'شارع المنصور، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'description' => 'شركة متخصصة في المياه المعدنية',
            'status' => 'active',
            'rating' => 4.7,
            'total_orders' => 90,
        ]);

        // Create Delivery Man Records
        DeliveryMan::create([
            'user_id' => $delivery1->id,
            'national_id' => '1234567890',
            'vehicle_type' => 'سيارة صغيرة',
            'vehicle_number' => 'مكة 1234',
            'license_number' => 'DL123456789',
            'emergency_contact' => 'أحمد علي',
            'emergency_phone' => '0501234580',
            'address' => 'حي العزيزية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.9,
            'total_deliveries' => 200,
            'total_earnings' => 5000.00,
        ]);

        DeliveryMan::create([
            'user_id' => $delivery2->id,
            'national_id' => '0987654321',
            'vehicle_type' => 'دراجة نارية',
            'vehicle_number' => 'مكة 5678',
            'license_number' => 'DL987654321',
            'emergency_contact' => 'محمد أحمد',
            'emergency_phone' => '0501234581',
            'address' => 'حي الشوقية، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.7,
            'total_deliveries' => 180,
            'total_earnings' => 4500.00,
        ]);

        DeliveryMan::create([
            'user_id' => $delivery3->id,
            'national_id' => '1122334455',
            'vehicle_type' => 'سيارة صغيرة',
            'vehicle_number' => 'مكة 9012',
            'license_number' => 'DL112233445',
            'emergency_contact' => 'علي محمد',
            'emergency_phone' => '0501234582',
            'address' => 'حي المسفلة، مكة المكرمة',
            'city' => 'مكة المكرمة',
            'status' => 'available',
            'rating' => 4.8,
            'total_deliveries' => 160,
            'total_earnings' => 4200.00,
        ]);
    }
} 