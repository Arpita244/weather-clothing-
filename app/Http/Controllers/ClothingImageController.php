<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClothingImageController extends Controller
{
    public function generateImage(Request $request)
    {
        $season = $request->input('season', 'Winter');
        $gender = $request->input('gender', 'Unisex');
        $occasion = $request->input('occasion', 'Casual');

        $clothingPrompt = $this->getClothingSuggestion($season, $gender, $occasion);

        $variations = [
            $clothingPrompt,
            $clothingPrompt . ' with accessories',
            'trendy ' . $clothingPrompt
        ];

        $imageUrls = array_map(fn($prompt) => "https://image.pollinations.ai/prompt/" . urlencode($prompt), $variations);

        $tipsMap = [
            'Winter' => ['Layer up with thermals', 'Wear insulated boots', 'Use moisturizers for dry skin'],
            'Summer' => ['Prefer cotton fabrics', 'Wear sunglasses', 'Stay hydrated'],
            'Spring' => ['Use breathable fabrics', 'Pastel shades work best', 'Light jackets for evenings'],
            'Autumn' => ['Earth tone clothes', 'Light layering', 'Boots and cardigans']
        ];

        $tips = $tipsMap[$season] ?? [];

        return view('weather', compact('season', 'gender', 'occasion', 'clothingPrompt', 'imageUrls', 'tips'));
    }

    private function getClothingSuggestion($season, $gender, $occasion)
    {
        $data = [
            'Winter' => [
                'Male' => 'a man in a wool coat and scarf for ' . $occasion,
                'Female' => 'a woman in a cozy jacket and beanie for ' . $occasion,
                'Unisex' => 'a warm coat with boots and gloves for ' . $occasion
            ],
            'Summer' => [
                'Male' => 'a man in shorts and a light shirt for ' . $occasion,
                'Female' => 'a woman in a cotton dress and hat for ' . $occasion,
                'Unisex' => 'light t-shirt and shorts for ' . $occasion
            ],
            'Spring' => [
                'Male' => 'a man in a floral shirt and chinos for ' . $occasion,
                'Female' => 'a woman in a pastel dress with a light scarf for ' . $occasion,
                'Unisex' => 'light jacket and jeans with soft colors for ' . $occasion
            ],
            'Autumn' => [
                'Male' => 'a man in a brown jacket and jeans for ' . $occasion,
                'Female' => 'a woman in an earth-tone cardigan and skirt for ' . $occasion,
                'Unisex' => 'warm flannel and boots for ' . $occasion
            ]
        ];

        return $data[$season][$gender] ?? $data[$season]['Unisex'];
    }
}
