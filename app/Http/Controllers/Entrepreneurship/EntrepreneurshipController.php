<?php

namespace App\Http\Controllers\Entrepreneurship;

use App\Http\Controllers\Controller;

class EntrepreneurshipController extends Controller
{
    public function index()
    {
        return view('entrepreneurship.index');
    }
}
