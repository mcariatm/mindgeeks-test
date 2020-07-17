<?php

namespace App\Providers;

use App\Observers\ItemObserver;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ItemsRepository;
use App\Repositories\ItemsRepositoryInterface;
use App\Item;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ItemsRepositoryInterface::class, ItemsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Item::observe(ItemObserver::class);
    }
}
