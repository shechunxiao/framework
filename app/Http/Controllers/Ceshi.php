<?php
namespace App\Http\Controllers;

class Ceshi extends Controller{
    public function index(FirstController $first){
        return $first->test();
    }
}
