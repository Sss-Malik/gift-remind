<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gifts = [
            [
                'name' => 'Premium Flower Bouquet',
                'description' => 'A curated selection of fresh red roses and lilies, perfect for anniversaries.',
                'price' => 5000.00,
                'category' => 'Flowers',
                'image_path' => 'https://images.unsplash.com/photo-1562690868-60bbe7293e94?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'name' => 'Luxury Chocolate Box',
                'description' => 'Imported dark and milk chocolates in a gold-foiled box.',
                'price' => 3500.00,
                'category' => 'Food',
                'image_path' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'name' => 'Leather Wallet & Belt Set',
                'description' => 'Genuine leather wallet and reversible belt set in a gift box.',
                'price' => 4500.00,
                'category' => 'Accessories',
                'image_path' => 'https://images.unsplash.com/photo-1627123424574-181ce5171c98?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'name' => 'Customized Mug',
                'description' => 'Ceramic mug with custom print. Great for birthdays.',
                'price' => 1200.00,
                'category' => 'Personalized',
                'image_path' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'name' => 'Smart Watch Gen 2',
                'description' => 'Fitness tracking, heart rate monitor, and sleek design.',
                'price' => 12500.00,
                'category' => 'Electronics',
                'image_path' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'name' => 'Scented Candle Set',
                'description' => 'Vanilla and Lavender scented candles for a relaxing vibe.',
                'price' => 2000.00,
                'category' => 'Home',
                'image_path' => 'https://images.unsplash.com/photo-1602874801002-3932e673f446?auto=format&fit=crop&q=80&w=400',
            ],
        ];

        foreach ($gifts as $gift) {
            Gift::create($gift);
        }
    }
}
