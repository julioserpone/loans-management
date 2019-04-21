<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Company;
use Blade;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('hasrole', function($expression) {

            $expression = explode(',',str_replace(['(',')',"'"], '', $expression));

            return "<?php if(".(Auth::user() && Auth::user()->hasRole($expression)?1:0)."): ?>";

        });

        Blade::directive('endhasrole', function() {
            return "<?php endif; ?>";
        });

        if (\Schema::hasTable("companies")) {
            $main_company = Company::find(1);
            \View::share('main_company', $main_company);
        }
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