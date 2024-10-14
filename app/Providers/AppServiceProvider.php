<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DonationItem;
use App\Observers\DonationItemObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        DonationItem::observe(DonationItemObserver::class);
    }
}
