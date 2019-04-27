<?php

namespace App\Providers;

use Illuminate\View\ViewServiceProvider as BaseViewServiceProvider;
use Illuminate\View\FileViewFinder;

class ViewServiceProvider extends BaseViewServiceProvider
{
    /*
    * Register the view finder implementation.
    *
    * @return void
    */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            $paths = $app['config']['view']['paths'];
            // // add new view paths like polyloans models: core, jurisdiction/country, organization

            array_unshift(
                $paths,
                resource_path('views/project/'),
                resource_path('views/core')
            );
            return new FileViewFinder($app['files'], $paths);
        });
    }
}
