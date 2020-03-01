<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Request;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        
        app('view')->composer('backend.template-metro', function ($view) {
            
            $action = app('request')->route()->getAction();
            $fullActionName = class_basename($action['controller']);
            
            list($controller, $action) = explode('@', $fullActionName);
            $controller = str_replace('controller', '', strtolower($controller));
            
            $view->with(compact('controller', 'action', 'fullActionName'));
        });

        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
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
