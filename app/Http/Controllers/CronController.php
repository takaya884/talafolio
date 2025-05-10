<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CronController extends Controller
{
    /**
     * cronジョブの管理画面を表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cron.index');
    }
}
