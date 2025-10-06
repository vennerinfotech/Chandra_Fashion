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
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = public_path('images/' . $subFolder);
        if (!file_exists($path)) mkdir($path, 0755, true);
        $file->move($path, $filename);
        return 'images/' . $subFolder . '/' . $filename;
    }

    // Manage homepage settings
    public function manage()
    {
        $hero          = HeroSection::firstOrNew([]);
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
            'hero',
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
        $hero = HeroSection::firstOrNew([]);
        $hero->title    = $request->hero_title;
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

        /* ================= COLLECTIONS ================= */
        $collections = CollectionSection::firstOrNew([]);
        $collections->title = $request->collections_title;
        $collections->subtitle = $request->collections_subtitle;
        $collections->save();

        /* ================= HERITAGE ================= */
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

        /* ================= SUBSCRIPTION ================= */
        $subscription = SubscriptionSection::firstOrNew([]);
        $subscription->title = $request->subscription_title;
        $subscription->subtitle = $request->subscription_subtitle;
        $subscription->save();

        /* ================= FOOTER ================= */
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

        /* ================= QUICK LINKS ================= */
        if ($request->has('footer_quick')) {
            // update existing
            foreach ($request->footer_quick['existing'] ?? [] as $id => $data) {
                $ql = QuickLink::find($id);
                if ($ql) $ql->update(['text' => $data['text'], 'url' => $data['url']]);
            }
            // add new
            foreach ($request->footer_quick['new']['text'] ?? [] as $index => $text) {
                if (!empty($text)) {
                    QuickLink::create([
                        'text' => $text,
                        'url'  => $request->footer_quick['new']['url'][$index] ?? '#',
                    ]);
                }
            }
        }

        /* ================= SERVICES ================= */
        if ($request->has('footer_service')) {
            foreach ($request->footer_service['existing'] ?? [] as $id => $data) {
                $service = Service::find($id);
                if ($service) $service->update(['text' => $data['text'], 'url' => $data['url']]);
            }
            foreach ($request->footer_service['new']['text'] ?? [] as $index => $text) {
                if (!empty($text)) {
                    Service::create([
                        'text' => $text,
                        'url'  => $request->footer_service['new']['url'][$index] ?? '#',
                    ]);
                }
            }
        }

        /* ================= FEATURE CARDS ================= */
        if ($request->has('cards')) {
            foreach ($request->cards as $cardData) {
                if (empty($cardData['title'])) continue;

                $featureCard = !empty($cardData['id']) ? FeatureCard::find($cardData['id']) : new FeatureCard();
                if ($featureCard) {
                    $featureCard->title = $cardData['title'];
                    $featureCard->description = $cardData['description'] ?? '';
                    if (isset($cardData['svg']) && $cardData['svg']) {
                        if ($featureCard->svg_path && file_exists(public_path($featureCard->svg_path))) {
                            unlink(public_path($featureCard->svg_path));
                        }
                        $featureCard->svg_path = $this->storeImagePublic($cardData['svg'], 'cards');
                    }
                    $featureCard->save();
                }
            }
        }

        /* ================= FEATURED COLLECTIONS ================= */
        $main = FeaturedCollection::find(1);
        if ($main) {
            $main->main_title = $request->featured_main_title;
            $main->main_subtitle = $request->featured_main_subtitle;
            $main->save();
        }

        if ($request->has('featured_collections')) {
            foreach ($request->featured_collections as $cardData) {
                if (!empty($cardData['id'])) {
                    $card = FeaturedCollection::find($cardData['id']);
                    if ($card) {
                        $card->title = $cardData['title'] ?? '';
                        $card->subtitle = $cardData['subtitle'] ?? '';
                        if (isset($cardData['image']) && $cardData['image']) {
                            if ($card->image && file_exists(public_path($card->image))) {
                                unlink(public_path($card->image));
                            }
                            $card->image = $this->storeImagePublic($cardData['image'], 'collections');
                        }
                        $card->save();
                    }
                }
            }
        }

        /* ================= CLIENTS ================= */
        if ($request->has('clients')) {
            // existing
            foreach ($request->clients['existing']['name'] ?? [] as $id => $name) {
                $client = Client::find($id);
                if ($client) {
                    $client->name = $name;
                    $client->designation = $request->clients['existing']['designation'][$id] ?? '';
                    $client->quote = $request->clients['existing']['quote'][$id] ?? '';
                    if (isset($request->clients['existing']['image'][$id]) && $request->clients['existing']['image'][$id]) {
                        $client->image = $this->storeImagePublic($request->clients['existing']['image'][$id], 'clients');
                    }
                    $client->save();
                }
            }
            // new
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


        /* ================= CONTACT INFOS ================= */
        if ($request->has('contact_infos')) {
            foreach ($request->contact_infos as $data) {
                if (!empty($data['id'])) {
                    $contact = \App\Models\ContactInfo::find($data['id']);
                    if ($contact) {
                        $contact->update([
                            'title' => $data['title'] ?? '',
                            'type'  => $data['type'] ?? 'address',
                            'details' => $data['details'] ?? '',
                        ]);
                    }
                } else {
                    \App\Models\ContactInfo::create([
                        'title' => $data['title'] ?? '',
                        'type'  => $data['type'] ?? 'address',
                        'details' => $data['details'] ?? '',
                        'order' => \App\Models\ContactInfo::max('order') + 1,
                    ]);
                }
            }
        }


        return back()->with('success', 'Settings Updated Successfully!');
    }
}
