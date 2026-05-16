<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Fix "key too long" on MySQL < 5.7.7 / MariaDB < 10.2
        Builder::defaultStringLength(191);
    }
}
