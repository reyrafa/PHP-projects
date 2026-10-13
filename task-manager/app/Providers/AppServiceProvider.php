<?php

namespace App\Providers;

use DB;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
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
        Model::preventLazyLoading(!$this->app->isProduction());
        DB::listen(function (QueryExecuted $query) {
            logger()->debug($query->toRawSql(), [
                'time_ms' => $query->time
            ]);
        });
        DB::whenQueryingForLongerThan(
            500,
            function (Connection $connection, QueryExecuted $query) {
                logger()->warning('Database query time exceeded threshold', [
                    'sql' => $query->toRawSql(),
                    'time_ms' => $query->time
                ]);
            }
        );
    }
}
