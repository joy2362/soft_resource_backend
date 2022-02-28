<?php

namespace App\Providers;

use App\Enums\SettingName;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


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
       // URL::forceScheme('https');


        view()->composer('*', function ($view)
        {
            $app_name = Setting::where('name',SettingName::APP_NAME())->first();
            $app_email = Setting::select('value')->where('name',SettingName::APP_EMAIL())->first();
            $app_mobile = Setting::select('value')->where('name',SettingName::APP_MOBILE())->first();
            $app_declaimer = Setting::select('value')->where('name',SettingName::APP_DECLAIMER())->first();
            $about_us = Setting::select('value')->where('name',SettingName::ABOUT_US())->first();

            $view->with([
                'app_name'=> $app_name->value,
                'app_logo'=> $app_name->applogo,
                'app_email'=>$app_email->value,
                'app_mobile'=>$app_mobile->value,
                'app_declaimer'=>$app_declaimer->value,
                'about_us'=>$about_us->value,
            ]);
        });
    }
}
