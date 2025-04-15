<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    /**
     * Display the cookie explanation page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cookie.index');
    }

    /**
     * Set a sample cookie for demonstration purposes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setCookie(Request $request)
    {
        $minutes = 60;
        $response = redirect()->route('cookie.index')->with('status', 'クッキーを設定しました！');
        return $response->cookie('sample_cookie', 'サンプル値', $minutes);
    }

    /**
     * Remove the sample cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeCookie(Request $request)
    {
        $response = redirect()->route('cookie.index')->with('status', 'クッキーを削除しました！');
        return $response->cookie('sample_cookie', '', -1);
    }
}
