<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Product;
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

    public function index()
    {
        // Hero, categories, collections, etc.
        $heroSections = HeroSection::all();
        $categories = Category::where('status', 1)->take(5)->get();
        $collections = CollectionSection::first();
        $featuredCollections = FeaturedCollection::orderBy('created_at', 'desc')->get();
        $featureCards = FeatureCard::orderBy('created_at', 'desc')->get();
        $heritage = Heritage::first();
        $clients = Client::orderBy('created_at', 'desc')->get();
        $subscription = SubscriptionSection::first();
        $footer = Setting::first();
        $services = Service::all();
        $quickLinks = QuickLink::all();

        // Fetch latest products for "New Arrivals"
        $newArrivals = Product::with('category', 'variants')
                            ->whereHas('category', fn($q) => $q->where('status', 1))
                            ->orderBy('created_at', 'desc')
                            ->take(10) // or remove ->take() to show all
                            ->get();

        return view('home', compact(
            'categories', 'heroSections', 'collections','featuredCollections',
            'heritage', 'clients', 'subscription', 'footer', 'services', 'quickLinks',
            'featureCards', 'newArrivals' // <-- pass products
        ));
    }



}
