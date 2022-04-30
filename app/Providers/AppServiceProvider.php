<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\CentralLogics\Helpers;
use App\Models\Language;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        if (Schema::hasTable('languages')) {
            $languages = DB::table('languages')
                ->where('is_active', Language::STATUS_ACTIVE)
                ->orderBy('is_default', 'desc')
                ->get();

            $language_default =  DB::table('languages')
                ->where('is_default', Language::IS_DEFAULT)
                ->first();
        } else {
            $languages = [];
        }
        View::share([
            'languages' => $languages,
            'language_default' => $language_default,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        try
        {
            Paginator::useBootstrap();
            foreach(Helpers::get_view_keys() as $key=>$value)
            {
                view()->share($key, $value);
            }
        }
        catch(\Exception $e)
        {

        }
        
    }
}
