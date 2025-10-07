<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Heritage;
use App\Models\QuickLink;
use App\Models\ContactInfo;
use App\Models\FeatureCard;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use App\Models\CollectionSection;
use App\Models\FeaturedCollection;
use App\Models\SubscriptionSection;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    // --- Helper to store images in public/images/<subFolder> ---
    protected function storeImagePublic($file, $subFolder)
    {
        // Ensure we have an UploadedFile instance
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('images/' . $subFolder);
            if (!file_exists($path)) mkdir($path, 0755, true);
            $file->move($path, $filename);
            return 'images/' . $subFolder . '/' . $filename;
        }

        // If it's an array or null, return null safely
        return null;
    }



    // Manage homepage settings
public function manage()
{
    $heroSections  = HeroSection::orderBy('id')->get(); // Fetch all hero sections
    $cards         = FeatureCard::orderBy('id', 'desc')->get(); // Feature Cards
    $heritage      = Heritage::firstOrNew([]);
    $clients       = Client::orderBy('id', 'desc')->take(3)->get();
    $subscription  = SubscriptionSection::firstOrNew([]);
    $footer        = Setting::firstOrNew([]);
    $quick_links   = QuickLink::all();
    $services      = Service::all();

    $featured      = FeaturedCollection::find(1); // Main section (row 1)
    $featuredCards = FeaturedCollection::all();   // All featured collection cards

    $collections   = CollectionSection::latest()->first();
    $contact_infos = ContactInfo::orderBy('id')->get();

    return view('admin.settings.manage', compact(
        'heroSections',  // pass all hero sections
        'cards',
        'heritage',
        'clients',
        'subscription',
        'footer',
        'quick_links',
        'services',
        'featured',
        'featuredCards',
        'collections',
        'contact_infos'
    ));
}


    // Update homepage settings
public function update(Request $request)
{
    /* ================= HERO SECTION ================= */
    if ($request->has('hero_title')) {
        $heroTitles    = $request->hero_title;
        $heroSubtitles = $request->hero_subtitle ?? [];
        $btn1Texts     = $request->hero_btn1_text ?? [];
        $btn1Links     = $request->hero_btn1_link ?? [];
        $btn2Texts     = $request->hero_btn2_text ?? [];
        $btn2Links     = $request->hero_btn2_link ?? [];
        $btn3Texts     = $request->hero_btn3_text ?? [];
        $btn3Links     = $request->hero_btn3_link ?? [];
        $heroImages    = $request->file('hero_image') ?? [];
        $existingIds   = $request->hero_id ?? [];

        // Delete heroes that were removed from the form
        HeroSection::whereNotIn('id', $existingIds)->delete();

        foreach ($heroTitles as $index => $title) {
            $hero = !empty($existingIds[$index]) ? HeroSection::find($existingIds[$index]) : new HeroSection();
            $hero->title      = $title;
            $hero->subtitle   = $heroSubtitles[$index] ?? '';
            $hero->btn1_text  = $btn1Texts[$index] ?? '';
            $hero->btn1_link  = $btn1Links[$index] ?? '';
            $hero->btn2_text  = $btn2Texts[$index] ?? '';
            $hero->btn2_link  = $btn2Links[$index] ?? '';
            $hero->btn3_text  = $btn3Texts[$index] ?? '';
            $hero->btn3_link  = $btn3Links[$index] ?? '';

            // Handle image upload
            if (!empty($heroImages[$index])) {
                if ($hero->background_image && file_exists(public_path($hero->background_image))) {
                    unlink(public_path($hero->background_image));
                }
                $hero->background_image = $this->storeImagePublic($heroImages[$index], 'hero');
            }

            $hero->save();
        }
    }

    /* ================= FEATURE CARDS ================= */
    if ($request->has('cards')) {
        foreach ($request->cards as $index => $cardData) {
            if (empty($cardData['title'])) continue;

            $featureCard = !empty($cardData['id']) ? FeatureCard::find($cardData['id']) : new FeatureCard();
            $featureCard->title = $cardData['title'];
            $featureCard->description = $cardData['description'] ?? '';

            if ($request->hasFile("cards.{$index}.svg")) {
                if ($featureCard->svg_path && file_exists(public_path($featureCard->svg_path))) {
                    unlink(public_path($featureCard->svg_path));
                }
                $featureCard->svg_path = $this->storeImagePublic($request->file("cards.{$index}.svg"), 'cards');
            }

            $featureCard->save();
        }
    }

    /* ================= FEATURED COLLECTIONS ================= */
    if ($request->has('featured_collections')) {
        foreach ($request->featured_collections as $index => $cardData) {
            if (empty($cardData['title'])) continue;

            $card = !empty($cardData['id']) ? FeaturedCollection::find($cardData['id']) : new FeaturedCollection();
            $card->title = $cardData['title'];
            $card->subtitle = $cardData['subtitle'] ?? '';

            if ($request->hasFile("featured_collections.{$index}.image")) {
                if ($card->image && file_exists(public_path($card->image))) {
                    unlink(public_path($card->image));
                }
                $card->image = $this->storeImagePublic($request->file("featured_collections.{$index}.image"), 'collections');
            }

            $card->save();
        }
    }

    /* ================= CLIENTS ================= */
    if ($request->has('clients')) {
        // Existing clients
        foreach ($request->clients['existing']['name'] ?? [] as $id => $name) {
            $client = Client::find($id);
            if ($client) {
                $client->name = $name;
                $client->designation = $request->clients['existing']['designation'][$id] ?? '';
                $client->quote = $request->clients['existing']['quote'][$id] ?? '';

                if ($request->hasFile("clients.existing.image.{$id}")) {
                    if ($client->image && file_exists(public_path($client->image))) {
                        unlink(public_path($client->image));
                    }
                    $client->image = $this->storeImagePublic($request->file("clients.existing.image.{$id}"), 'clients');
                }

                $client->save();
            }
        }

        // New clients
        foreach ($request->clients['new']['name'] ?? [] as $index => $name) {
            if (!empty($name)) {
                $client = new Client();
                $client->name = $name;
                $client->designation = $request->clients['new']['designation'][$index] ?? '';
                $client->quote = $request->clients['new']['quote'][$index] ?? '';

                if ($request->hasFile("clients.new.image.{$index}")) {
                    $client->image = $this->storeImagePublic($request->file("clients.new.image.{$index}"), 'clients');
                }

                $client->save();
            }
        }
    }

    /* ================= COLLECTIONS SECTION ================= */
    if ($request->has('collections_title')) {
        $collections = \App\Models\CollectionSection::first() ?? new \App\Models\CollectionSection();
        $collections->title = $request->collections_title;
        $collections->subtitle = $request->collections_subtitle ?? '';
        $collections->save();
    }

    /* ================= HERITAGE SECTION ================= */
    if ($request->has('heritage_title')) {
        $heritage = \App\Models\Heritage::first() ?? new \App\Models\Heritage();
        $heritage->title = $request->heritage_title;
        $heritage->paragraph1 = $request->heritage_paragraph1 ?? '';
        $heritage->paragraph2 = $request->heritage_paragraph2 ?? '';
        $heritage->button_text = $request->heritage_btn_text ?? '';

        if ($request->hasFile('heritage_image')) {
            if ($heritage->image && file_exists(public_path($heritage->image))) {
                unlink(public_path($heritage->image));
            }
            $heritage->image = $this->storeImagePublic($request->file('heritage_image'), 'heritage');
        }

        $heritage->save();
    }

    /* ================= SUBSCRIPTION SECTION ================= */
    if ($request->has('subscription_title')) {
        $subscription = \App\Models\SubscriptionSection::first() ?? new \App\Models\SubscriptionSection();
        $subscription->title = $request->subscription_title;
        $subscription->subtitle = $request->subscription_subtitle ?? '';
        $subscription->save();
    }

    return back()->with('success', 'Settings Updated Successfully!');
}




}
