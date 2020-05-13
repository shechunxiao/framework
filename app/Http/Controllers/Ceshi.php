<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Ceshi extends Controller{
    public function index(FirstController2 $first){
        return $first->test();
    }

}
