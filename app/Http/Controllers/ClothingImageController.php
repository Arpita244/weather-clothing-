<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClothingImageController extends Controller
{
    protected $weatherService;

    private const MAX_SEARCH_COUNT = 5;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function generateImage(Request $request)
    {
        $city = $request->input('city', 'New York');
        $gender = $request->input('gender', 'Male');
        $occasion = $request->input('occasion', 'Casual');
        
        // Get weather data
        $weatherData = $this->weatherService->getWeatherByCity($city);
        
        if ($weatherData) {
            $temperature = $weatherData['main']['temp'];
            $season = $this->weatherService->getSeasonFromTemperature($temperature);
            $weatherDescription = $weatherData['weather'][0]['description'];
            $humidity = $weatherData['main']['humidity'];
            $weather = $weatherDescription;
        } else {
            $season = $request->input('season', 'Summer');
            $temperature = null;
            $weatherDescription = null;
            $humidity = null;
            $weather = null;
        }

        // Generate tips based on weather
        $tips = $this->generateTips($season, $temperature, $humidity);

        // Get clothing suggestion and generate image URLs
        $suggestedOutfit = $this->getClothingSuggestion($season, $gender, $occasion);
        $imageUrls = $this->getImageUrls($suggestedOutfit);

        return view('weather', compact(
            'season',
            'gender',
            'occasion',
            'imageUrls',
            'tips',
            'temperature',
            'weatherDescription',
            'humidity',
            'city',
            'suggestedOutfit',
            'weather'
        ));
    }

    protected function generateTips($season, $temperature, $humidity)
    {
        $tips = [];

        if ($temperature !== null) {
            if ($temperature < 10) {
                $tips[] = "It's quite cold! Layer up with warm clothing.";
                $tips[] = "Consider wearing thermal undergarments.";
                $tips[] = "Don't forget gloves and a warm hat.";
            } elseif ($temperature < 20) {
                $tips[] = "Mild weather - perfect for layering.";
                $tips[] = "A light jacket or sweater would be ideal.";
                $tips[] = "Consider bringing an umbrella just in case.";
            } else {
                $tips[] = "Warm weather - light and breathable fabrics recommended.";
                $tips[] = "Stay hydrated and wear sunscreen.";
                $tips[] = "Consider wearing a hat for sun protection.";
            }
        }

        if ($humidity !== null) {
            if ($humidity > 70) {
                $tips[] = "High humidity - choose breathable fabrics.";
            } elseif ($humidity < 30) {
                $tips[] = "Low humidity - consider moisturizing your skin.";
            }
        }

        return $tips;
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
}

