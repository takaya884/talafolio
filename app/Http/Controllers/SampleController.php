<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends Controller
{
    /**
     * Display the sample page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sample.index');
    }
}
