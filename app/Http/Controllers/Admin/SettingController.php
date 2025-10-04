<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Heritage;
use App\Models\QuickLink;
use App\Models\FeatureCard;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use App\Models\CollectionSection;
use App\Models\FeaturedCollection;
use App\Models\SubscriptionSection;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    // --- Helper to store images directly in public/images/<subFolder> ---
    protected function storeImagePublic($file, $subFolder)
    {
        $filename = time().'_'.$file->getClientOriginalName();
        $path = public_path('images/'.$subFolder);
        if (!file_exists($path)) mkdir($path, 0755, true);
        $file->move($path, $filename);
        return 'images/'.$subFolder.'/'.$filename;
    }

    // Manage all homepage settings
    public function manage()
    {
        $hero          = HeroSection::firstOrNew([]);
        $cards         = FeatureCard::orderBy('id', 'desc')->get();
        $heritage      = Heritage::firstOrNew([]);
        $clients       = Client::orderBy('id', 'desc')->take(3)->get();
        $subscription  = SubscriptionSection::firstOrNew([]);
        $footer        = Setting::firstOrNew([]);
        $quick_links   = QuickLink::all();
        $services      = Service::all();
        $featured      = FeaturedCollection::first();
        $featuredCards = FeaturedCollection::all();
        $collections   = CollectionSection::latest()->first();

        return view('admin.settings.manage', compact(
            'hero','cards','heritage','clients','subscription','footer','quick_links','services','featured','featuredCards','collections'
        ));
    }

    // Update homepage settings
    public function update(Request $request)
    {
        // --- HERO SECTION ---
        $hero = HeroSection::firstOrNew([]);
        $hero->title = $request->hero_title;
        $hero->subtitle = $request->hero_subtitle;
        $hero->btn1_text = $request->hero_btn1_text;
        $hero->btn1_link = $request->hero_btn1_link;
        $hero->btn2_text = $request->hero_btn2_text;
        $hero->btn2_link = $request->hero_btn2_link;
        $hero->btn3_text = $request->hero_btn3_text;
        $hero->btn3_link = $request->hero_btn3_link;

        if ($request->hasFile('hero_image')) {
            if ($hero->background_image && file_exists(public_path($hero->background_image))) {
                unlink(public_path($hero->background_image));
            }
            $hero->background_image = $this->storeImagePublic($request->file('hero_image'), 'hero');
        }
        $hero->save();

        // --- COLLECTIONS SECTION ---
        $collections = CollectionSection::firstOrNew([]);
        $collections->title = $request->collections_title;
        $collections->subtitle = $request->collections_subtitle;
        $collections->save();

        // --- HERITAGE SECTION ---
        $heritage = Heritage::firstOrNew([]);
        $heritage->title = $request->heritage_title;
        $heritage->paragraph1 = $request->heritage_paragraph1;
        $heritage->paragraph2 = $request->heritage_paragraph2;
        $heritage->button_text = $request->heritage_btn_text;

        if ($request->hasFile('heritage_image')) {
            if ($heritage->image && file_exists(public_path($heritage->image))) {
                unlink(public_path($heritage->image));
            }
            $heritage->image = $this->storeImagePublic($request->file('heritage_image'), 'heritage');
        }
        $heritage->save();

        // --- SUBSCRIPTION SECTION ---
        $subscription = SubscriptionSection::firstOrNew([]);
        $subscription->title = $request->subscription_title;
        $subscription->subtitle = $request->subscription_subtitle;
        $subscription->save();

        // --- FOOTER SETTINGS ---
        $footer = Setting::firstOrNew([]);
        $footer->footer_brand_name = $request->footer_brand_name;
        $footer->footer_brand_desc = $request->footer_brand_desc;
        $footer->footer_facebook   = $request->footer_facebook;
        $footer->footer_instagram  = $request->footer_instagram;
        $footer->footer_linkedin   = $request->footer_linkedin;
        $footer->footer_address    = $request->footer_address;
        $footer->footer_phone      = $request->footer_phone;
        $footer->footer_email      = $request->footer_email;
        $footer->footer_copyright  = $request->footer_copyright;
        $footer->save();

        // --- QUICK LINKS ---
        if ($request->footer_quick && isset($request->footer_quick['text'])) {
            foreach ($request->footer_quick['text'] as $index => $text) {
                if (!empty($text)) {
                    QuickLink::create([
                        'text' => $text,
                        'url'  => $request->footer_quick['url'][$index] ?? '#',
                    ]);
                }
            }
        }

        // --- SERVICES ---
        if ($request->footer_service && isset($request->footer_service['text'])) {
            foreach ($request->footer_service['text'] as $index => $text) {
                if (!empty($text)) {
                    Service::create([
                        'text' => $text,
                        'url'  => $request->footer_service['url'][$index] ?? '#',
                    ]);
                }
            }
        }

        // --- FEATURE CARDS ---
        if ($request->has('cards')) {
            foreach ($request->cards as $cardIndex => $cardData) {
                if (!empty($cardData['title'])) {
                    $featureCard = FeatureCard::firstOrNew(['id' => $cardData['id'] ?? null]);
                    $featureCard->title = $cardData['title'];
                    $featureCard->description = $cardData['description'] ?? '';

                    if (isset($cardData['svg']) && $cardData['svg']) {
                        $featureCard->svg_path = $this->storeImagePublic($cardData['svg'], 'cards');
                    }

                    $featureCard->save();
                }
            }
        }

        // --- CLIENTS ---
        if ($request->has('clients')) {
            foreach ($request->clients['new']['name'] ?? [] as $index => $name) {
                if (!empty($name)) {
                    $client = new Client();
                    $client->name = $name;
                    $client->designation = $request->clients['new']['designation'][$index] ?? '';
                    $client->quote = $request->clients['new']['quote'][$index] ?? '';

                    if (isset($request->clients['new']['image'][$index]) && $request->clients['new']['image'][$index]) {
                        $client->image = $this->storeImagePublic($request->clients['new']['image'][$index], 'clients');
                    }

                    $client->save();
                }
            }
        }

        return back()->with('success', 'Homepage settings updated successfully!');
    }

    // ---- FEATURE CARD CRUD ----
    public function cardStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'svg' => 'nullable|file|mimes:svg',
        ]);

        $path = $request->hasFile('svg') ? $this->storeImagePublic($request->file('svg'), 'cards') : null;

        FeatureCard::create([
            'title' => $request->title,
            'description' => $request->description,
            'svg_path' => $path,
        ]);

        return back()->with('success', 'Feature Card added!');
    }

    public function cardUpdate(Request $request, FeatureCard $card)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'svg' => 'nullable|file|mimes:svg',
        ]);

        if ($request->hasFile('svg')) {
            $card->svg_path = $this->storeImagePublic($request->file('svg'), 'cards');
        }

        $card->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Feature Card updated!');
    }

    public function cardDelete(FeatureCard $card)
    {
        $card->delete();
        return back()->with('success', 'Feature Card deleted!');
    }

    // ---- CLIENT CRUD ----
    public function clientStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'quote' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $path = $request->hasFile('image') ? $this->storeImagePublic($request->file('image'), 'clients') : null;

        Client::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'quote' => $request->quote,
            'image' => $path,
        ]);

        return back()->with('success', 'Client added!');
    }

    public function clientUpdate(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'quote' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $client->image = $this->storeImagePublic($request->file('image'), 'clients');
        }

        $client->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'quote' => $request->quote,
        ]);

        return back()->with('success', 'Client updated!');
    }

    public function clientDelete(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client deleted!');
    }
}
