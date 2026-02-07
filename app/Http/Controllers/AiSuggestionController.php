<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Demo AI Gift Suggestion Controller.
 *
 * Simulates AI-powered gift recommendations using pre-built
 * context-aware templates. No external API calls — designed
 * to feel intelligent for demo purposes.
 */
class AiSuggestionController extends Controller
{
    public function index()
    {
        return view('ai.suggestions');
    }

    /**
     * Generate demo AI gift suggestions based on user input.
     */
    public function suggest(Request $request)
    {
        $request->validate([
            'recipient_type' => ['required', 'string', 'max:100'],
            'occasion'       => ['required', 'string', 'max:100'],
            'budget'         => ['required', 'string', 'max:50'],
            'interests'      => ['nullable', 'string', 'max:500'],
        ]);

        $recipientType = $request->input('recipient_type');
        $occasion = $request->input('occasion');
        $budget = $request->input('budget');
        $interests = $request->input('interests', '');

        // Demo: generate context-aware suggestions
        $suggestions = $this->generateSuggestions($recipientType, $occasion, $budget, $interests);

        return view('ai.results', compact('suggestions', 'recipientType', 'occasion', 'budget', 'interests'));
    }

    /**
     * Generate mock AI suggestions that feel personalized and thoughtful.
     */
    private function generateSuggestions(string $recipientType, string $occasion, string $budget, string $interests): array
    {
        $budgetRanges = [
            'under_1000'   => ['min' => 500,   'max' => 1000,  'label' => 'Under Rs. 1,000'],
            '1000_3000'    => ['min' => 1000,  'max' => 3000,  'label' => 'Rs. 1,000 - 3,000'],
            '3000_5000'    => ['min' => 3000,  'max' => 5000,  'label' => 'Rs. 3,000 - 5,000'],
            '5000_10000'   => ['min' => 5000,  'max' => 10000, 'label' => 'Rs. 5,000 - 10,000'],
            'above_10000'  => ['min' => 10000, 'max' => 25000, 'label' => 'Rs. 10,000+'],
        ];

        $range = $budgetRanges[$budget] ?? $budgetRanges['3000_5000'];

        // Build contextual suggestion pools
        $pool = $this->getSuggestionPool($recipientType, $occasion, $interests);

        // Filter by budget range and return top suggestions
        $filtered = array_filter($pool, function ($item) use ($range) {
            return $item['price'] >= $range['min'] && $item['price'] <= $range['max'];
        });

        // If no matches in range, pick closest items
        if (empty($filtered)) {
            usort($pool, function ($a, $b) use ($range) {
                $aDist = min(abs($a['price'] - $range['min']), abs($a['price'] - $range['max']));
                $bDist = min(abs($b['price'] - $range['min']), abs($b['price'] - $range['max']));
                return $aDist <=> $bDist;
            });
            $filtered = array_slice($pool, 0, 3);
        } else {
            $filtered = array_slice($filtered, 0, 3);
        }

        return array_values($filtered);
    }

    /**
     * Return a pool of gift suggestions tailored to recipient + occasion + interests.
     */
    private function getSuggestionPool(string $recipientType, string $occasion, string $interests): array
    {
        $interestsLower = strtolower($interests);

        // Base pools by recipient type
        $gifts = [
            // Mother / Parent
            'mother' => [
                ['name' => 'Premium Flower Bouquet', 'price' => 5000, 'category' => 'Flowers', 'reason' => "A beautiful arrangement of fresh roses and lilies — a timeless way to show you care. Moms love flowers that brighten up the home.", 'image' => 'https://images.unsplash.com/photo-1562690868-60bbe7293e94?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Luxury Scented Candle Set', 'price' => 2000, 'category' => 'Home', 'reason' => "Vanilla and lavender scented candles create a relaxing atmosphere — perfect for someone who deserves to unwind after a long day.", 'image' => 'https://images.unsplash.com/photo-1602874801002-3932e673f446?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Personalized Photo Frame', 'price' => 1500, 'category' => 'Personalized', 'reason' => "A custom photo frame with a cherished family photo makes a sentimental gift she'll treasure on her bedside table.", 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e35ca?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Spa Gift Basket', 'price' => 4500, 'category' => 'Self-Care', 'reason' => "A curated spa basket with bath bombs, essential oils, and a plush robe — because she deserves pampering.", 'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Kitchen Appliance Set', 'price' => 8000, 'category' => 'Home', 'reason' => "A modern kitchen gadget set for someone who loves cooking — practical and thoughtful.", 'image' => 'https://images.unsplash.com/photo-1585515320310-259814833e62?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Gold-Plated Jewelry Set', 'price' => 12000, 'category' => 'Accessories', 'reason' => "An elegant necklace and earring set in gold plating — a gift that feels special for any occasion.", 'image' => 'https://images.unsplash.com/photo-1515562141589-67f0d569b4a6?auto=format&fit=crop&q=80&w=400'],
            ],
            // Father / Dad
            'father' => [
                ['name' => 'Leather Wallet & Belt Set', 'price' => 4500, 'category' => 'Accessories', 'reason' => "Genuine leather wallet and reversible belt — a classic combination that's always appreciated by dads.", 'image' => 'https://images.unsplash.com/photo-1627123424574-181ce5171c98?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Smart Watch Gen 2', 'price' => 12500, 'category' => 'Electronics', 'reason' => "A fitness tracking smartwatch with heart rate monitor — great for an active dad who values health.", 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Premium Coffee Set', 'price' => 3000, 'category' => 'Food & Drink', 'reason' => "Specialty coffee beans with a pour-over set — perfect for the dad who takes his morning coffee seriously.", 'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Wireless Earbuds Pro', 'price' => 6000, 'category' => 'Electronics', 'reason' => "Noise-cancelling wireless earbuds for commutes, workouts, or peaceful moments at home.", 'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12f032f55?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Travel Grooming Kit', 'price' => 2500, 'category' => 'Personal Care', 'reason' => "A compact grooming kit with premium tools — practical for the dad who travels.", 'image' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Desk Organizer Set', 'price' => 1800, 'category' => 'Office', 'reason' => "A sleek wooden desk organizer — perfect for the dad who values a tidy workspace.", 'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&q=80&w=400'],
            ],
            // Friend
            'friend' => [
                ['name' => 'Customized Mug', 'price' => 1200, 'category' => 'Personalized', 'reason' => "A custom-printed mug with an inside joke or shared memory — it's the thought that counts, and this shows it.", 'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Board Game Collection', 'price' => 3500, 'category' => 'Entertainment', 'reason' => "A curated selection of board games for memorable game nights — perfect for friends who love hanging out.", 'image' => 'https://images.unsplash.com/photo-1611371805429-8b5c1b2c34ba?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Luxury Chocolate Box', 'price' => 3500, 'category' => 'Food', 'reason' => "Imported dark and milk chocolates in a beautifully packaged box — sweet gifts never miss.", 'image' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Bluetooth Speaker', 'price' => 5000, 'category' => 'Electronics', 'reason' => "A portable Bluetooth speaker for beach trips, park hangs, and spontaneous dance parties.", 'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Succulent Plant Set', 'price' => 800, 'category' => 'Plants', 'reason' => "A set of mini succulents in decorative pots — low maintenance, high vibes. Perfect desk companion.", 'image' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Scented Candle Collection', 'price' => 2000, 'category' => 'Home', 'reason' => "Three artisanal scented candles — because everyone loves coming home to a great-smelling space.", 'image' => 'https://images.unsplash.com/photo-1602874801002-3932e673f446?auto=format&fit=crop&q=80&w=400'],
            ],
            // Partner / Significant Other
            'partner' => [
                ['name' => 'Gold-Plated Jewelry Set', 'price' => 12000, 'category' => 'Accessories', 'reason' => "An elegant necklace and earring set — a romantic gesture that shows you thought about what they'd love.", 'image' => 'https://images.unsplash.com/photo-1515562141589-67f0d569b4a6?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Premium Flower Bouquet', 'price' => 5000, 'category' => 'Flowers', 'reason' => "Red roses mixed with lilies — classic, romantic, and always makes an impression.", 'image' => 'https://images.unsplash.com/photo-1562690868-60bbe7293e94?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Couple\'s Spa Kit', 'price' => 7000, 'category' => 'Self-Care', 'reason' => "A spa experience for two — bath bombs, face masks, and aromatherapy oils for a relaxing evening together.", 'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Personalized Star Map', 'price' => 3500, 'category' => 'Personalized', 'reason' => "A custom star map showing the night sky from the date you first met — deeply personal and unique.", 'image' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Luxury Chocolate Box', 'price' => 3500, 'category' => 'Food', 'reason' => "Premium imported chocolates — a sweet indulgence to share (or not!) together.", 'image' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Leather Journal', 'price' => 2000, 'category' => 'Stationery', 'reason' => "A handcrafted leather journal — perfect for your partner who loves writing or journaling their thoughts.", 'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&q=80&w=400'],
            ],
            // Sibling
            'sibling' => [
                ['name' => 'Wireless Earbuds', 'price' => 6000, 'category' => 'Electronics', 'reason' => "Noise-cancelling earbuds — because siblings know when you need your personal space (and soundtrack).", 'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12f032f55?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Customized T-Shirt', 'price' => 1500, 'category' => 'Apparel', 'reason' => "A custom tee with an inside joke or shared memory — sibling gifts should make you both laugh.", 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Board Game', 'price' => 3500, 'category' => 'Entertainment', 'reason' => "A competitive strategy game — fuel the sibling rivalry in a fun way.", 'image' => 'https://images.unsplash.com/photo-1611371805429-8b5c1b2c34ba?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Backpack', 'price' => 4000, 'category' => 'Accessories', 'reason' => "A stylish, durable backpack — practical and trendy for school, work, or weekend trips.", 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Smart Watch Gen 2', 'price' => 12500, 'category' => 'Electronics', 'reason' => "A fitness-tracking smartwatch — great for the sibling who's into health and tech.", 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Luxury Chocolate Box', 'price' => 3500, 'category' => 'Food', 'reason' => "Imported chocolates in a premium box — sweet, simple, and universally loved.", 'image' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=400'],
            ],
            // Colleague / Boss
            'colleague' => [
                ['name' => 'Premium Desk Plant', 'price' => 1200, 'category' => 'Plants', 'reason' => "A small desk plant adds life to any workspace — professional yet thoughtful.", 'image' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Leather Notebook', 'price' => 2000, 'category' => 'Office', 'reason' => "A premium leather-bound notebook — elegant and useful for any professional.", 'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Coffee Sampler Box', 'price' => 2500, 'category' => 'Food & Drink', 'reason' => "A selection of specialty coffees from around the world — fuels productivity and shows good taste.", 'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Luxury Chocolate Box', 'price' => 3500, 'category' => 'Food', 'reason' => "Premium chocolates in an elegant box — a safe yet impressive choice for professional gifting.", 'image' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Wireless Charger Pad', 'price' => 3000, 'category' => 'Electronics', 'reason' => "A sleek wireless charger for the desk — practical and modern.", 'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&q=80&w=400'],
                ['name' => 'Scented Candle Set', 'price' => 2000, 'category' => 'Home', 'reason' => "Artisanal candles — a universally appreciated gift that's never too personal for a colleague.", 'image' => 'https://images.unsplash.com/photo-1602874801002-3932e673f446?auto=format&fit=crop&q=80&w=400'],
            ],
        ];

        // Default fallback pool
        $defaultPool = [
            ['name' => 'Luxury Chocolate Box', 'price' => 3500, 'category' => 'Food', 'reason' => "Imported chocolates are a universally loved gift — elegant, sweet, and always appreciated.", 'image' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Scented Candle Set', 'price' => 2000, 'category' => 'Home', 'reason' => "Artisanal candles bring warmth and ambiance to any space — a thoughtful and versatile gift.", 'image' => 'https://images.unsplash.com/photo-1602874801002-3932e673f446?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Premium Flower Bouquet', 'price' => 5000, 'category' => 'Flowers', 'reason' => "Fresh flowers always brighten someone's day — a timeless gesture that works for any occasion.", 'image' => 'https://images.unsplash.com/photo-1562690868-60bbe7293e94?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Customized Mug', 'price' => 1200, 'category' => 'Personalized', 'reason' => "A personalized mug with a special message — a daily reminder that someone cares.", 'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Leather Wallet & Belt Set', 'price' => 4500, 'category' => 'Accessories', 'reason' => "A classic leather set that combines style with daily utility — always a solid choice.", 'image' => 'https://images.unsplash.com/photo-1627123424574-181ce5171c98?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Smart Watch Gen 2', 'price' => 12500, 'category' => 'Electronics', 'reason' => "A feature-rich smartwatch for fitness and connectivity — impressive and modern.", 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=400'],
        ];

        $pool = $gifts[$recipientType] ?? $defaultPool;

        // Boost relevance based on interests keywords
        if (!empty($interestsLower)) {
            $interestKeywords = array_map('trim', explode(',', $interestsLower));

            foreach ($pool as &$item) {
                $categoryLower = strtolower($item['category']);
                $nameLower = strtolower($item['name']);
                foreach ($interestKeywords as $keyword) {
                    if (str_contains($categoryLower, $keyword) || str_contains($nameLower, $keyword)) {
                        // Boost: prepend interest-related note to reason
                        $item['reason'] = "Based on their interest in \"{$keyword}\": " . $item['reason'];
                        break;
                    }
                }
            }
        }

        // Add occasion-specific context to reasons
        $occasionLabels = [
            'birthday' => 'birthday',
            'anniversary' => 'anniversary',
            'wedding' => 'wedding celebration',
            'graduation' => 'graduation milestone',
            'holiday' => 'holiday season',
            'thank_you' => 'appreciation',
            'just_because' => 'spontaneous joy',
        ];
        $occasionLabel = $occasionLabels[$occasion] ?? $occasion;

        foreach ($pool as &$item) {
            $item['occasion_note'] = "Great choice for a {$occasionLabel} gift.";
        }

        return $pool;
    }
}
