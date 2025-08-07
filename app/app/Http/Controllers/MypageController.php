<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use App\Models\Article;
use App\Models\Instructor;
use App\Models\Admin;

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
        $favorites = $user->favorites()->get();
        $diaries = $user->diaries()->latest()->get();
        $profile = $user->profile;
        $unreadCount = $user->notifications()->whereNull('read_at')->count();
        $notifications = $user->notifications()->latest()->take(10)->get();

        return view('mypage.user', compact('user', 'favorites', 'diaries', 'profile', 'notifications','unreadCount'));

    }



    // メイク講師のマイページ
    private function instructorMypage($instructor)
    {        
        $articles = $instructor->articles()->with('favorites')->latest()->get(); // 投稿した記事
        $totalFavorites = $articles->sum(function ($article) {
            return $article->favorites->count();
        });
        $notifications = $instructor->notifications()->latest()->take(10)->get();
        $unreadCount = $instructor->unreadNotifications->count(); 
        $profile = $instructor->profile;

        return view('mypage.instructor', compact('instructor', 'articles', 'totalFavorites', 'notifications','profile','unreadCount'));
    
    }



    // 管理者のマイページ

    private function adminMypage($admin)
    {
        $notifications = Notification::latest()->take(10)->get();
        $userCount = User::count();
        $instructorCount = Instructor::count();
        $adminCount = Admin::count(); 
        $monthlyUsers = User::whereMonth('created_at', now()->month)->count();
        $newRegistrations = User::whereMonth('created_at', now()->month)->count(); 
        $totalUsers = $userCount + $instructorCount + $adminCount;

        // 男女比
        $maleCount = User::where('gender', 'male')->count();
        $femaleCount = User::where('gender', 'female')->count();
        $otherCount = User::whereNotIn('gender', ['male', 'female'])->count();

        $totalArticles = Article::count();

        return view('mypage.admin', compact('admin', 'notifications', 'userCount', 'instructorCount', 'adminCount', 'totalUsers','monthlyUsers', 'maleCount', 'femaleCount', 'otherCount', 'totalArticles','newRegistrations'));
    }
    }

   

