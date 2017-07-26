<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.admin', function($view){
            // $view->with('newOrder', DB::table('notifications')->where('type', 'App\Notifications\OrderSuccess')->where('read_at', null)->count());
            // $view->with('newMessage', Auth::user()->unreadNotifications->count());
            $view->with('newOrder', 0);
            $view->with('newMessage', 0);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
