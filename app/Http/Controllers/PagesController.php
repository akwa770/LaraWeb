<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    
    // public function index()
    // {
    //     return view('layouts.front');
    // }

    public function getInvoice(){
        return view('invoice');
    }
    public function getFront(){
        return view('layouts.front');
    }
    public function getNsa(){
        return view('nsa');
    }

}
