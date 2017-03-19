<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeasonController extends Controller
{
    public function season3info()
    {
        return view('season3/overview');
    }

    public function season3rules()
    {
        return view('season3/rules');
    }
}
