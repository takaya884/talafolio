<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    /**
     * Display the session information page
     */
    public function index(Request $request)
    {
        // セッションデータを取得
        $sessionData = $request->session()->all();
        
        // セッションID
        $sessionId = $request->session()->getId();
        
        // セッションの有効期限
        $sessionLifetime = config('session.lifetime');
        
        return view('session.index', [
            'sessionId' => $sessionId,
            'sessionData' => $sessionData,
            'sessionLifetime' => $sessionLifetime
        ]);
    }

    /**
     * Store a demo value in the session
     */
    public function store(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        
        if ($key && $value) {
            // セッションに値を保存
            $request->session()->put($key, $value);
            return redirect()->route('session.index')->with('success', 'セッションに値を保存しました');
        }
        
        return redirect()->route('session.index')->with('error', 'キーと値を入力してください');
    }

    /**
     * Remove a value from the session
     */
    public function destroy(Request $request, $key)
    {
        // セッションから値を削除
        $request->session()->forget($key);
        
        return redirect()->route('session.index')->with('success', 'セッションから値を削除しました');
    }

    /**
     * Clear all session data
     */
    public function clear(Request $request)
    {
        // セッションをすべてクリア（ただし、フラッシュデータは除く）
        $request->session()->flush();
        
        return redirect()->route('session.index')->with('success', 'セッションをクリアしました');
    }

    /**
     * Regenerate the session ID
     */
    public function regenerate(Request $request)
    {
        // セッションIDを再生成
        $request->session()->regenerate();
        
        return redirect()->route('session.index')->with('success', 'セッションIDを再生成しました');
    }
}
