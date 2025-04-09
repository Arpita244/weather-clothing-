<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ClothingImageController extends Controller
{
    public function generateImage(Request $request)
    {
        // Get the season from the user input or detect it automatically
        $selectedSeason = $request->input('season');
        $season = $selectedSeason ?? $this->getSeason(Carbon::now()->month);

        // Generate clothing description based on season
        $clothingPrompt = $this->getClothingSuggestion($season);

        // Generate image using Pollinations AI
        $imageUrl = "https://image.pollinations.ai/prompt/" . urlencode($clothingPrompt);

        return view('weather', compact('imageUrl', 'season', 'clothingPrompt'));
    }

    private function getSeason($month)
    {
        if (in_array($month, [12, 1, 2])) {
            return 'Winter';
        } elseif (in_array($month, [3, 4, 5])) {
            return 'Spring';
        } elseif (in_array($month, [6, 7, 8])) {
            return 'Summer';
        } else {
            return 'Autumn';
        }
    }

    private function getClothingSuggestion($season)
    {
        switch ($season) {
            case 'Winter':
                return "warm winter coat, gloves, scarf, and boots for snowy weather";
            case 'Spring':
                return "light jacket and jeans for mild spring weather";
            case 'Summer':
                return "t-shirt, shorts, and sunglasses for hot summer weather";
            case 'Autumn':
                return "sweater, jeans, and boots for cool autumn weather";
        }
    }
}
