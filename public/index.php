<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/
/**
 * 引入composer的自动加载，所谓自动加载就是自动帮我们引入类，比如require xxx.php
 */
require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/
/**
 * 获取App实例，并且参数绑定一些常用的服务
 */
$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/
/**
 * make作用是实例化，这里是实例化Illuminate\Contracts\Http\Kernel的抽象类,从而实现后面的调动
 */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
var_dump($kernel);

/**
 * 获取request和response实例
 */
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
/**
 * 如果在这之前使用echo，var_dump,print,print_r等则会直接输出
 * send方法是输出return返回的内容,可以参考thinkphp的实现方法
 */
$response->send();

/**
 * 存储session等操作
 */
$kernel->terminate($request, $response);
