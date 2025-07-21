<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Article $article)
{
     $user = auth()->user();          // ログインユーザ
        $favorites = $user->favorites(); 
        
        if ($favorites->where('article_id', $article->id)->exists()) {
            // 解除
            $favorites->detach($article->id);
            $msg = 'お気に入りを解除しました';
        } else {
            // 登録
            $favorites->attach($article->id);
            $msg = 'お気に入りに追加しました';
        }

        return back()->with('success', $msg);
    }
}
