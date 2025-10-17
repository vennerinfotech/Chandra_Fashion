<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\ContactInfo;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\FeaturedCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // public function sendChat(Request $request)
    // {
    //     $request->validate(['message' => 'required|string']);

    //     try {
    //         $response = Http::withToken(env('OPENAI_API_KEY'))
    //             ->post('https://api.openai.com/v1/chat/completions', [
    //                 'model' => 'gpt-4o-mini',
    //                 'messages' => [
    //                     ['role' => 'user', 'content' => $request->message],
    //                 ],
    //             ]);

    //         $botReply = $response->json()['choices'][0]['message']['content'] ?? 'No reply';
    //         return response()->json(['reply' => $botReply]);

    //     } catch (\Exception $e) {
    //         return response()->json(['reply' => 'Server error: '.$e->getMessage()], 500);
    //     }
    // }


    public function sendChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        try {
            $message = strtolower($request->message);
            $dbInfo = "";

            // Fetch Products when user asks about products
            $products = collect();
            if (str_contains($message, 'product')) {
                $products = Product::with(['variants', 'category', 'subCategory'])->get();
            }

            // Product Details
            foreach ($products as $p) {
                $dbInfo .= "**Product:** {$p->name}\n";
                $dbInfo .= "- Price: {$p->price}\n";
                $dbInfo .= "- Description: {$p->description}\n";
                $dbInfo .= "- Materials: {$p->materials}\n";
                $dbInfo .= "- Delivery Time: {$p->delivery_time}\n";
                $dbInfo .= "- Category: " . ($p->category->name ?? "N/A") . "\n";
                $dbInfo .= "- Subcategory: " . ($p->subCategory->name ?? "N/A") . "\n";

                if ($p->variants) {
                    foreach ($p->variants as $v) {
                        $images = json_decode($v->images, true) ?? [];
                        $imgStr = "";

                        if (count($images)) {
                            foreach ($images as $img) {
                                $imgStr .= "![](" . asset($img) . ") ";
                            }
                        }

                        $dbInfo .= "  - Variant Code: {$v->product_code}, MOQ: {$v->moq}\n";
                        if ($imgStr) {
                            $dbInfo .= "    Images: {$imgStr}\n";
                        }
                    }
                }

                $dbInfo .= "- Product Link: " . url("products/" . $p->id) . "\n\n";
            }

            // Fetch Categories when user asks about categories
            $categories = collect();
            if (str_contains($message, 'category')) {
                $categories = Category::with('subCategories')->get();
            }

            if ($categories->count()) {
                $dbInfo .= "**Categories List:**\n";
                foreach ($categories as $c) {
                    $dbInfo .= "- {$c->name}\n";
                    foreach ($c->subCategories as $sc) {
                        $dbInfo .= "  - {$sc->name}\n";
                    }
                }
            }

            // Fetch Collections when user asks about collections
            $collections = collect();
            if (str_contains($message, 'collection')) {
                $collections = FeaturedCollection::all();
            }

            if ($collections->count()) {
                $dbInfo .= "\n**Collections List:**\n";
                foreach ($collections as $c) {
                    $dbInfo .= "- {$c->title} (" . url('allcollection') . ")\n";
                }
            }

            // Fetch Contact Info
            $contactDetails = ContactInfo::all();
            if ($contactDetails->count()) {
                $dbInfo .= "\n**Contact Information:**\n";
                foreach ($contactDetails as $c) {
                    $dbInfo .= "- {$c->title}: {$c->details}\n";
                }
            }

            // Social Links
            $dbInfo .= "\n**Social Media Links:**\n";
            $dbInfo .= "- Facebook: https://www.facebook.com/ChandraFabrics/\n";
            $dbInfo .= "- Instagram: https://www.instagram.com/chandrafashionofficial/\n";
            $dbInfo .= "- LinkedIn: https://in.linkedin.com/company/chandrafashion\n";
            $dbInfo .= "- YouTube: https://www.youtube.com/@chandrafashion\n";


            // AI System Prompt

            $systemPrompt = "
                            You are a helpful AI assistant for a Textile Fabric eCommerce Website.
                            Always respond line by line with clear formatting using bullet points.
                            If user asks about inquiry, reply:
                            'Go to any product → click **Get Price / Inquiry** → fill your details → Submit.'
                            Show image markdown properly. Show product links also.

                            Database Info:
                            $dbInfo
                            ";

            // OpenAI API Call

            $response = Http::withToken(env('OPENAI_API_KEY'))->timeout(60)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message],
                    ]
                ]);

            $botReply = $response->json()['choices'][0]['message']['content'] ?? 'No reply';

            return response()->json(['reply' => nl2br($botReply)]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Error: ' . $e->getMessage()], 500);
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
