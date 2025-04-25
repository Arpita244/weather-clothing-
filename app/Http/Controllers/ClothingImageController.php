<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClothingImageController extends Controller
{
    private const MAX_SEARCH_COUNT = 5;

    public function generateImage(Request $request)
    {
        $season = $request->input('season', 'Summer');
        $gender = $request->input('gender', 'Female');
        $occasion = $request->input('occasion', 'Casual');

        // Normalize values
        $season = ucfirst(strtolower($season));
        $gender = ucfirst(strtolower($gender));
        $occasion = ucfirst(strtolower($occasion));

        // Validate against allowed inputs
        $validSeasons = ['Winter', 'Summer', 'Spring', 'Autumn'];
        $validGenders = ['Male', 'Female'];
        $validOccasions = ['Casual', 'Formal', 'Party'];

        if (!in_array($season, $validSeasons)) $season = 'Winter';
        if (!in_array($gender, $validGenders)) $gender = 'Female';
        if (!in_array($occasion, $validOccasions)) $occasion = 'Casual';

        // Get prompt and image
        $clothingPrompt = $this->getClothingSuggestion($season, $gender, $occasion);
        $imageUrls = $this->getImageUrls($clothingPrompt);

        // Season tips
        $tips = $this->getTips($season);

        return view('weather', compact('season', 'gender', 'occasion', 'clothingPrompt', 'imageUrls', 'tips'));
    }

    private function getClothingSuggestion($season, $gender, $occasion)
    {
        $data = [
            'Winter' => [
                'Male' => [
                    'Casual' => 'a man wearing a warm wool coat, knitted scarf, thermal jeans, and winter boots',
                    'Formal' => 'a man dressed in a grey wool suit, cashmere overcoat, and leather dress shoes',
                    'Party' => 'a man in a festive sweater, black jeans, and stylish Chelsea boots'
                ],
                'Female' => [
                    'Casual' => 'a woman in a cozy oversized sweater, fleece leggings, and fur-lined boots',
                    'Formal' => 'a woman in a classy wool coat over a midi dress with ankle boots',
                    'Party' => 'a woman in a glittery dress with tights and heeled boots'
                ],
            ],
            'Summer' => [
                'Male' => [
                    'Casual' => 'a man in khaki shorts and a breathable floral shirt with sneakers',
                    'Formal' => 'a man in a cream linen suit, open collar shirt, and suede loafers',
                    'Party' => 'a man wearing stylish chino shorts, tropical print shirt, and sunglasses'
                ],
                'Female' => [
                    'Casual' => 'a woman in a sleeveless cotton dress with a sunhat and sandals',
                    'Formal' => 'a woman in a pastel chiffon gown with delicate jewelry and heels',
                    'Party' => 'a woman in a sparkly summer crop top with a high-waisted skirt and wedges'
                ],
            ],
            'Spring' => [
                'Male' => [
                    'Casual' => 'a man in a denim jacket, slim-fit jeans, and white sneakers',
                    'Formal' => 'a man in a light grey blazer, shirt, and formal trousers',
                    'Party' => 'a man in a pastel blazer, casual tee, and chinos for a garden party'
                ],
                'Female' => [
                    'Casual' => 'a woman in a floral midi dress with a light cardigan and flats',
                    'Formal' => 'a woman in a sleek spring wrap dress with matching heels',
                    'Party' => 'a woman in a pastel dress with floral accessories and wedges'
                ],
            ],
            'Autumn' => [
                'Male' => [
                    'Casual' => 'a man in a plaid shirt, light jacket, and boots',
                    'Formal' => 'a man in a tweed blazer, dress pants, and leather shoes',
                    'Party' => 'a man in a dark button-down, corduroy pants, and dress boots'
                ],
                'Female' => [
                    'Casual' => 'a woman in a long sleeve tunic, scarf, and ankle boots',
                    'Formal' => 'a woman in a fitted midi dress, trench coat, and heels',
                    'Party' => 'a woman in a burgundy party dress with tights and ankle heels'
                ],
            ]
        ];

        return $data[$season][$gender][$occasion] ?? 'a trendy seasonal outfit';
    }

    private function getImageUrls($prompt)
    {
        $searchCount = Session::get('search_count', 0);
        $variations = [
            $prompt,
            "$prompt with accessories",
            "trendy $prompt",
            "modern $prompt in natural background",
            "vogue style $prompt"
        ];

        $selectedPrompt = $variations[$searchCount % self::MAX_SEARCH_COUNT];

        $imageUrl = "https://image.pollinations.ai/prompt/" . urlencode($selectedPrompt);

        Session::put('search_count', ($searchCount + 1) % self::MAX_SEARCH_COUNT);

        return [$imageUrl]; // Just return one new image each time
    }

    private function getTips($season)
    {
        $tips = [
            'Winter' => ['Layer up with thermals', 'Wear insulated boots', 'Use moisturizers for dry skin', 'Choose wool and fleece', 'Stay covered from wind'],
            'Summer' => ['Prefer light cotton', 'Use sunscreen daily', 'Stay hydrated', 'Wear sunglasses and hats', 'Avoid dark colors'],
            'Spring' => ['Choose pastel colors', 'Carry a light jacket', 'Wear comfy shoes', 'Use floral prints', 'Keep an umbrella'],
            'Autumn' => ['Try earthy tones', 'Use light layering', 'Wear scarves and boots', 'Stay warm in chilly mornings', 'Pick cozy knits']
        ];

        return $tips[$season] ?? [];
    }
}

