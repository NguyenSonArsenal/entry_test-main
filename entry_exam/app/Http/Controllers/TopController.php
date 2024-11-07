<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopController extends Controller
{
    public function index()
    {
        $listPrefecture = Prefecture::all();

        $viewData = [
            'listPrefecture' => $listPrefecture
        ];

        return view('user.home', $viewData);
    }
}
