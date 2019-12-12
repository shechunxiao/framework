<?php
namespace App\Http\Controllers;

class Ceshi extends Controller{
    public function index(FirstController2 $first){
        return $first->test();
    }
}
