<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewArticleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer(['welcome'],function ($view){
            $view->with('articles',Article::where('approved',1)->orderBy('created_at','asc')->take(4)->get());
        });
    }
}
