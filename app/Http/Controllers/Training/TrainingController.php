<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;

class TrainingController extends Controller
{
    public function index()
    {
        return view('training.index');
    }
}
