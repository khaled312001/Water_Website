<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $customers = User::where('role', 'customer')->get();
        $orders = Order::all();

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'مياه زمزم ممتازة جداً، طعمها طبيعي ونقية 100%',
                'customer_name' => 'أحمد علي العتيبي'
            ],
            [
                'rating' => 5,
                'comment' => 'أفضل مياه شربت في حياتي، أنصح الجميع بها',
                'customer_name' => 'فاطمة محمد الزهراني'
            ],
            [
                'rating' => 4,
                'comment' => 'مياه جيدة، سعر مناسب وجودة عالية',
                'customer_name' => 'علي أحمد المطيري'
            ],
            [
                'rating' => 5,
                'comment' => 'مياه زمزم المباركة، أشعر بالبركة عند شربها',
                'customer_name' => 'خديجة سعد القحطاني'
            ],
            [
                'rating' => 4,
                'comment' => 'مياه نقية وطازجة، أوصي بها للعائلات',
                'customer_name' => 'محمد خالد الحربي'
            ],
            [
                'rating' => 5,
                'comment' => 'مياه نوفا ممتازة، طعمها طبيعي جداً',
                'customer_name' => 'أحمد علي العتيبي'
            ],
            [
                'rating' => 4,
                'comment' => 'جودة عالية وسعر معقول، أنصح بها',
                'customer_name' => 'فاطمة محمد الزهراني'
            ],
            [
                'rating' => 5,
                'comment' => 'مياه القلعة القلوية مفيدة جداً للصحة',
                'customer_name' => 'علي أحمد المطيري'
            ],
            [
                'rating' => 4,
                'comment' => 'مياه طبيعية من ينابيع مكة، ممتازة',
                'customer_name' => 'خديجة سعد القحطاني'
            ],
            [
                'rating' => 5,
                'comment' => 'مياه المنصور الفاخرة تستحق كل ريال',
                'customer_name' => 'محمد خالد الحربي'
            ],
            [
                'rating' => 4,
                'comment' => 'مياه العتيبية المقطرة مناسبة للأجهزة الطبية',
                'customer_name' => 'أحمد علي العتيبي'
            ],
            [
                'rating' => 5,
                'comment' => 'مياه زمزم للرياضيين ممتازة، تعطي طاقة',
                'customer_name' => 'فاطمة محمد الزهراني'
            ],
            [
                'rating' => 4,
                'comment' => 'مياه نوفا للعائلات اقتصادية ومفيدة',
                'customer_name' => 'علي أحمد المطيري'
            ],
            [
                'rating' => 5,
                'comment' => 'مياه القلعة للضيافة أنيقة ومميزة',
                'customer_name' => 'خديجة سعد القحطاني'
            ],
            [
                'rating' => 4,
                'comment' => 'مياه العتيبية للاستخدام الطبي عالية الجودة',
                'customer_name' => 'محمد خالد الحربي'
            ],
        ];

        foreach ($products as $product) {
            // Add 2-4 reviews per product
            $numReviews = rand(2, 4);
            for ($i = 0; $i < $numReviews; $i++) {
                $review = $reviews[array_rand($reviews)];
                $customer = $customers->random();
                $order = $orders->random();
                
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $customer->id,
                    'order_id' => $order->id,
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'type' => 'product',
                    'is_approved' => true,
                ]);
            }
        }
    }
} 