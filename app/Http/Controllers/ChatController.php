<?php

namespace App\Http\Controllers;

use App\Models\City;
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
    public function getStates($countryId)
    {
        return response()->json(State::where('country_id', $countryId)->get());
    }

    public function getCities($stateId)
    {
        return response()->json(City::where('state_id', $stateId)->get());
    }


}
