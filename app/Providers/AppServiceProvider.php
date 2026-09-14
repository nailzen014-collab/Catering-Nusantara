<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        // Mencegah relasi dipanggil dengan Lazy Loading saat development.
        // Jika ada relasi yang belum di-eager-load, Laravel akan memberi tahu.
        Model::preventLazyLoading(! app()->isProduction());
    }
}
