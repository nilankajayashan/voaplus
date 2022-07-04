<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $packages = Package::all();
        return view('index', ['packages' => $packages]);
    }
}
