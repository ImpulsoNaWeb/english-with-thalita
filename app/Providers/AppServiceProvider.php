<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->booting(function () {
            \Illuminate\Support\Facades\Session::extend('banco_dados_pt', function ($app) {
                $connection = $app['db']->connection($app['config']['session.connection']);
                $table = $app['config']['session.table'];
                $minutes = $app['config']['session.lifetime'];
                
                return new \App\Extensions\ManipuladorSessaoBancoDados($connection, $table, $minutes, $app);
            });
        });
    }

    public function boot(): void
    {
        \Filament\Forms\Components\FileUpload::configureUsing(function (\Filament\Forms\Components\FileUpload $component) {
            $component->extraInputAttributes(['capture' => 'camera']);
        });
    }
}
