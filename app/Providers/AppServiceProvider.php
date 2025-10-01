<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Inquiry;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Share new inquiry count globally with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $newInquiryCount = Inquiry::where('is_read', false)->count();
            $view->with('newInquiryCount', $newInquiryCount);
        });
    }
}
