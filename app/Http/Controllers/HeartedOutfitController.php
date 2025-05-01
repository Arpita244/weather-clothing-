<?php

namespace App\Http\Controllers;

use App\Models\HeartedOutfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HeartedOutfitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function heartOutfit(Request $request)
    {
        try {
            // Log the incoming request data
            Log::info('Heart outfit request data:', $request->all());

            $validated = $request->validate([
                'outfit_description' => 'required|string',
                'weather_condition' => 'nullable|string',
                'temperature' => 'nullable|string',
                'image_url' => 'required|string',
            ]);

            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('Unauthenticated user tried to heart an outfit');
                return response()->json(['success' => false, 'message' => 'Please login to save outfits'], 401);
            }

            // Check if the outfit is already hearted
            $existingOutfit = HeartedOutfit::where('user_id', Auth::id())
                ->where('image_url', $validated['image_url'])
                ->first();

            if ($existingOutfit) {
                Log::info('Outfit already hearted:', ['outfit_id' => $existingOutfit->id]);
                return response()->json(['success' => false, 'message' => 'Outfit already saved']);
            }

            // Create new hearted outfit
            $heartedOutfit = new HeartedOutfit();
            $heartedOutfit->user_id = Auth::id();
            $heartedOutfit->outfit_description = $validated['outfit_description'];
            $heartedOutfit->weather_condition = $validated['weather_condition'] ?? '';
            $heartedOutfit->temperature = $validated['temperature'] ?? '';
            $heartedOutfit->image_url = $validated['image_url'];
            $heartedOutfit->save();

            Log::info('Successfully hearted outfit:', ['outfit_id' => $heartedOutfit->id]);
            return response()->json(['success' => true, 'outfit' => $heartedOutfit]);

        } catch (\Exception $e) {
            Log::error('Error saving hearted outfit: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to save outfit: ' . $e->getMessage()], 500);
        }
    }

    public function unheartOutfit(Request $request)
    {
        try {
            // Log the incoming request data
            Log::info('Unheart outfit request data:', $request->all());

            // Check if user is authenticated
            if (!Auth::check()) {
                Log::warning('Unauthenticated user tried to unheart an outfit');
                return response()->json(['success' => false, 'message' => 'Please login to manage outfits'], 401);
            }

            // Find outfit by image URL if outfit_id is not provided
            if ($request->has('image_url')) {
                $outfit = HeartedOutfit::where('user_id', Auth::id())
                    ->where('image_url', $request->image_url)
                    ->first();
            } else {
                $validated = $request->validate([
                    'outfit_id' => 'required|integer',
                ]);
                $outfit = HeartedOutfit::where('user_id', Auth::id())
                    ->where('id', $validated['outfit_id'])
                    ->first();
            }

            if (!$outfit) {
                Log::warning('Outfit not found for unheart request', ['request_data' => $request->all()]);
                return response()->json(['success' => false, 'message' => 'Outfit not found'], 404);
            }

            $outfit->delete();
            Log::info('Successfully unhearted outfit', ['outfit_id' => $outfit->id]);
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error removing hearted outfit: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to remove outfit: ' . $e->getMessage()], 500);
        }
    }

    public function getHeartedOutfits()
    {
        try {
            $heartedOutfits = HeartedOutfit::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return view('home', ['heartedOutfits' => $heartedOutfits]);
        } catch (\Exception $e) {
            Log::error('Error fetching hearted outfits: ' . $e->getMessage());
            return view('home', ['heartedOutfits' => collect()]);
        }
    }
}
