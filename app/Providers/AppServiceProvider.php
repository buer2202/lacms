<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\App\Category $category)
    {
        // 页脚菜单
        view()->composer('home.*', function ($view) use ($category) {
            // 获取导航栏
            $mainMenu = $category->treeLevel2();

            $view->with('mainMenu', $mainMenu);
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
