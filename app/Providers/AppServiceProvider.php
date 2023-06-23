<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
        // Debugging
        // Logs database queries to a file
//        if (App::environment(['local', 'staging'])) {
//            DB::listen(static function(QueryExecuted $query) {
//                File::append(
//                    storage_path('/logs/query.log'),
//                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . '[' . $query->time . ']' . PHP_EOL
//                );
//            });
//        }
    }
}
