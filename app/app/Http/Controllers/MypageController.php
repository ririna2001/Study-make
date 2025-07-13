<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use App\Models\Article;

class MypageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    if (Auth::guard('user')->check()) {
        $user = Auth::guard('user')->user();
        return $this->userMypage($user);

    } elseif (Auth::guard('instructor')->check()) {
        $instructor = Auth::guard('instructor')->user();
        return $this->instructorMypage($instructor);

    } elseif (Auth::guard('admin')->check()) {
        $admin = Auth::guard('admin')->user();
        return $this->adminMypage($admin);
    }

    abort(403, '認証されていません');
}




    // 一般ユーザーのマイページ

    private function userMypage($user)
    {
        $favorites = $user->favorites()->with('article')->get();
        $diaries = $user->diaries()->latest()->get();
        $profile = $user->profile;
        $notifications = $user->notifications()->latest()->take(10)->get();

        return view('mypage.user', compact('user', 'favorites', 'diaries', 'profile', 'notification'));

    }



    // メイク講師のマイページ

    private function instructorMypage($user)
    {
        $articles = $user->articles()->latest()->get(); // 投稿した記事
        $totalFavorites = $articles->sum(function ($article) {
            return $article->favorites->count();
        });
        $notifications = $user->notifications()->latest()->take(10)->get();
        $profile = $user->profile;

        return view('mypage.instructor', compact('user', 'articles', 'totalFavorites', 'notifications'));
    
    }



    // 管理者のマイページ

    private function adminMypage($user)
    {
        $notifications = Notification::latest()->take(10)->get();
        $userCount = User::count();
        $monthlyUsers = User::whereMonth('created_at', now()->month)->count();

        // 男女比
        $maleCount = User::where('gender', 'male')->count();
        $femaleCount = User::where('gender', 'female')->count();
        $otherCount = User::whereNotIn('gender', ['male', 'female'])->count();

        $totalArticles = Article::count();

        return view('mypage.admin', compact('user', 'notifications', 'totalUsers', 'monthlyUsers', 'maleCount', 'femaleCount', 'otherCount', 'totalArticles'));

    }
    }

   

