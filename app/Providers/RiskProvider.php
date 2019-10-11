<?php

namespace App\Providers;

use App\Http\Controllers\InterfaceTest;
use App\Http\Controllers\TestImplement;
use Illuminate\Support\ServiceProvider;

class RiskProvider extends ServiceProvider
{
    /**
     * 延迟加载
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(InterfaceTest::class,function($app){
            return new TestImplement();
        });
    }
}
