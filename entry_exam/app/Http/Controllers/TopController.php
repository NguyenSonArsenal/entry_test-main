<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TopController extends Controller
{
    public function index()
    {
        return view('user.home');
    }
}
