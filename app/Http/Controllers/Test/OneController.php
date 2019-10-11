<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OneController extends Controller
{
    //
    public function index(Request $request){
        $all = $request->all();
        $path = $request->path();

        dump($all);
        dump($path);
    }
}
