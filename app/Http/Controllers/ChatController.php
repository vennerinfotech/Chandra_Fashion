<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function sendChat(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'user', 'content' => $request->message],
                    ],
                ]);

            $botReply = $response->json()['choices'][0]['message']['content'] ?? 'No reply';
            return response()->json(['reply' => $botReply]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Server error: '.$e->getMessage()], 500);
        }
    }


        // Fetch states based on selected country
    public function getStates($countryName)
    {
        $country = Country::where('name', $countryName)->first();

        if ($country) {
            $states = $country->states; // Assuming 'states' relationship exists
            return response()->json($states);
        }

        return response()->json(['message' => 'No states found for the selected country'], 404);
    }

    // Fetch cities based on selected state
    public function getCities($stateId)
    {
        // Ensure the state exists
        $state = State::find($stateId);

        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        // Retrieve the cities associated with this state
        $cities = $state->cities;

        if ($cities->isEmpty()) {
            return response()->json(['message' => 'No cities found for the selected state'], 404);
        }

        return response()->json($cities);
    }

}
