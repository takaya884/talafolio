<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{
    /**
     * モーダルの例を表示
     */
    public function index()
    {
        return view('modal.index');
    }

    /**
     * モーダルからのデータを処理
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // フラッシュメッセージをセット
        return redirect()->route('modal.index')
            ->with('status', 'メッセージが送信されました！');
    }
}
