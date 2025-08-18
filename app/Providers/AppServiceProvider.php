<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Http\Responses\CustomLoginResponse;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->singleton(LoginResponseContract::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    

public function boot()
{
   if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
}
