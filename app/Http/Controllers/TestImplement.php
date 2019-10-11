<?php
namespace App\Http\Controllers;
use App\Http\Controllers\InterfaceTest;

class TestImplement implements InterfaceTest{
    public function all(){
        return 'TestImplement';
    }
}