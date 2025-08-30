<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'أحمد محمد العتيبي',
                'email' => 'ahmed.alotaibi@example.com',
                'phone' => '0501234567',
                'subject' => 'استفسار عن المنتجات',
                'message' => 'أريد معرفة المزيد عن منتجات المياه المتوفرة في الموقع',
                'status' => 'read',
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'فاطمة أحمد الزهراني',
                'email' => 'fatima.zahrani@example.com',
                'phone' => '0501234568',
                'subject' => 'شكوى في التوصيل',
                'message' => 'كان هناك تأخير في توصيل الطلب، أريد معرفة السبب',
                'status' => 'pending',
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'علي حسن المطيري',
                'email' => 'ali.mutairi@example.com',
                'phone' => '0501234569',
                'subject' => 'اقتراح تحسين',
                'message' => 'أقترح إضافة المزيد من أنواع المياه المعدنية',
                'status' => 'read',
                'created_at' => now()->subDays(7),
            ],
            [
                'name' => 'خديجة سعد القحطاني',
                'email' => 'khadija.qhtani@example.com',
                'phone' => '0501234570',
                'subject' => 'طلب انضمام كمورد',
                'message' => 'أريد الانضمام كموزع للمياه في حي العزيزية',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'محمد خالد الحربي',
                'email' => 'mohammed.harbi@example.com',
                'phone' => '0501234571',
                'subject' => 'مشكلة في الحساب',
                'message' => 'لا أستطيع تسجيل الدخول إلى حسابي',
                'status' => 'read',
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
} 