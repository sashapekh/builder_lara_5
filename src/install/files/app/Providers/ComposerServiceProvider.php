<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.header', 'App\Http\ViewComposers\HeaderComposer');
        View::composer('partials.footer', 'App\Http\ViewComposers\FooterComposer');
        View::composer('partials.breadcrumbs', 'App\Http\ViewComposers\BreadcrumbsComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
