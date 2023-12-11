<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Editor;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

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
        view()->composer('*', function ($view) {
            Blade::directive('price', function ($price) {
                return "<?php echo number_format($price); ?>";
            });

            $locales = Config::get('translatable.locales');
            $view->with('locales', $locales);
            
            $view->with('brand', 'RAQI');

            $loggin = false;
            if (auth('admin')->check()) {
                $user = Admin::find(auth('admin')->user()->id);
                $loggin = true;
            } else if (auth('web')->check()) {
                $user = User::find(auth('web')->user()->id);
                $loggin = true;
            } else if (auth('editor')->check()) {
                $user = Editor::find(auth('editor')->user()->id);
                $loggin = true;
            }

            if ($loggin) {
                $view->with('number_notifications', 0);
                $view->with('notis', []);
            }
        });
    }
}
