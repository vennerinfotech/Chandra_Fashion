<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Heritage;
use App\Models\QuickLink;
use App\Models\FeatureCard;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use App\Models\CollectionSection;
use App\Models\FeaturedCollection;
use App\Models\SubscriptionSection;

class HomeController extends Controller
{
    // public function index()
    // {
    //     // Fetch active categories
    //      $categories = Category::where('status', 1)->take(5)->get();

    //     // Fetch featured collections
    //     $featuredCollections = FeaturedCollection::orderBy('created_at', 'desc')->take(3)->get();

    //     // Pass to the home view
    //     return view('home', compact('categories', 'featuredCollections'));
    // }


public function index()
{
    // Categories (active ones)
    $categories = Category::where('status', 1)->take(5)->get();
     $collections = CollectionSection::first(); // gets the first row
    // Hero section
    $hero = HeroSection::first();

    // Collections section (uncomment if model exists)
    // $collections = CollectionSection::first();

    // Featured collections
    $featuredCollections = FeaturedCollection::orderBy('created_at', 'desc')->take(3)->get();
    $featureCards = FeatureCard::orderBy('created_at', 'desc')->get();
    // Heritage section
    $heritage = Heritage::first();  // Your model is `Heritage`, not `HeritageSection`

    // Section-level main title/subtitle
    $featured = FeaturedCollection::first();
    // Card-level collections
    $featuredCards = FeaturedCollection::all();

    // Clients
    $clients = Client::orderBy('created_at', 'desc')->get();

    // Subscription section
    $subscription = SubscriptionSection::first();  // Your model is `SubscriptionSection`, not `Subscription`

    // Footer & related data
    $footer = Setting::first();  // Your model is `Setting`, not `Footer`
    $services = Service::all();
    $quickLinks = QuickLink::all();

    return view('home', compact(
        'categories', 'hero', 'collections','featuredCollections',
        'heritage', 'clients', 'subscription', 'footer', 'services', 'quickLinks', 'featureCards','featured', 'featuredCards'
    ));
}

}
