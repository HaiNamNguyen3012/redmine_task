<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on'); // this line
            \URL::forceScheme('https');
        }


        $mobile = 0;
        $user_agent = strtolower(@$_SERVER['HTTP_USER_AGENT']);
        if (preg_match("/phone|iphone|itouch|ipod|ipad|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent)) {
            $mobile = 1;
        }
        View::share("mobile", $mobile);
    }
}
