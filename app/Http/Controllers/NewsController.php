<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    /**
     * ニュース一覧を表示
     */
    public function index()
    {
        $apiKey = env('NEWS_API_KEY');
        
        // APIキーが設定されていない場合はエラーメッセージを表示
        if (!$apiKey) {
            return view('news.index', [
                'articles' => [],
                'error' => 'NEWS_API_KEYが設定されていません。.envファイルに追加してください。'
            ]);
        }
        
        try {
            // 現在の日付から1週間前の日付を取得
            $fromDate = date('Y-m-d', strtotime('-7 days'));
            
            // News APIからデータを取得（everythingエンドポイントを使用）
            $response = Http::get('https://newsapi.org/v2/everything', [
                'q' => 'Japan OR 日本', // 日本関連のニュースを検索
                'language' => 'jp', // 日本語の記事
                'from' => $fromDate,
                'sortBy' => 'publishedAt', // 公開日順
                'apiKey' => $apiKey,
                'pageSize' => 20, // 取得する記事数
            ]);

            // レスポンスをJSONとして解析
            $newsData = $response->json();
            
            // 記事データをビューに渡す
            return view('news.index', [
                'articles' => $newsData['articles'] ?? [],
                'error' => null
            ]);
        } catch (\Exception $e) {
            // エラーが発生した場合
            return view('news.index', [
                'articles' => [],
                'error' => 'ニュースの取得に失敗しました: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * カテゴリ別のニュースを表示
     */
    public function category($category)
    {
        $apiKey = env('NEWS_API_KEY');
        
        // APIキーが設定されていない場合はエラーメッセージを表示
        if (!$apiKey) {
            return view('news.category', [
                'articles' => [],
                'category' => $category,
                'error' => 'NEWS_API_KEYが設定されていません。.envファイルに追加してください。'
            ]);
        }
        
        // 有効なカテゴリのリスト
        $validCategories = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];
        
        // 無効なカテゴリの場合はリダイレクト
        if (!in_array($category, $validCategories)) {
            return redirect()->route('news.index');
        }
        
        try {
            // 現在の日付から1週間前の日付を取得
            $fromDate = date('Y-m-d', strtotime('-7 days'));
            
            // News APIからカテゴリ別のデータを取得
            $response = Http::get('https://newsapi.org/v2/everything', [
                'q' => $category, // カテゴリをキーワードとして検索
                'language' => 'jp', // 日本語の記事
                'from' => $fromDate,
                'sortBy' => 'publishedAt', // 公開日順
                'apiKey' => $apiKey,
                'pageSize' => 20,
            ]);
            
            // レスポンスをJSONとして解析
            $newsData = $response->json();
            
            // 記事データをビューに渡す
            return view('news.category', [
                'articles' => $newsData['articles'] ?? [],
                'category' => $category,
                'error' => null
            ]);
        } catch (\Exception $e) {
            // エラーが発生した場合
            return view('news.category', [
                'articles' => [],
                'category' => $category,
                'error' => 'ニュースの取得に失敗しました: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * キーワード検索
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        
        // キーワードが空の場合はトップページにリダイレクト
        if (empty($keyword)) {
            return redirect()->route('news.index');
        }
        
        $apiKey = env('NEWS_API_KEY');
        
        // APIキーが設定されていない場合はエラーメッセージを表示
        if (!$apiKey) {
            return view('news.search', [
                'articles' => [],
                'keyword' => $keyword,
                'error' => 'NEWS_API_KEYが設定されていません。.envファイルに追加してください。'
            ]);
        }
        
        try {
            // 現在の日付から1ヶ月前の日付を取得
            $fromDate = date('Y-m-d', strtotime('-1 month'));
            
            // News APIからキーワード検索の結果を取得
            $response = Http::get('https://newsapi.org/v2/everything', [
                'q' => $keyword,
                'language' => 'jp', // 日本語の記事
                'from' => $fromDate,
                'sortBy' => 'publishedAt', // 公開日順
                'apiKey' => $apiKey,
                'pageSize' => 20,
            ]);
            
            // レスポンスをJSONとして解析
            $newsData = $response->json();
            
            // 記事データをビューに渡す
            return view('news.search', [
                'articles' => $newsData['articles'] ?? [],
                'keyword' => $keyword,
                'error' => null
            ]);
        } catch (\Exception $e) {
            // エラーが発生した場合
            return view('news.search', [
                'articles' => [],
                'keyword' => $keyword,
                'error' => 'ニュースの取得に失敗しました: ' . $e->getMessage()
            ]);
        }
    }
}
