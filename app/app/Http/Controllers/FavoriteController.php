<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\FaceType;
use App\Models\PersonalColor;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller{


    public function index()
{

    $user = auth()->user();
    $faceTypes = FaceType::all();
     $personalColors = PersonalColor::all();

    $favorites = $user->favorites()->with('instructor')->get(); 

    return view('favorites.index', compact('favorites','faceTypes','personalColors'));
}


   public function toggle(Article $article){


    $user = auth()->user();

     if (!$user) {
       return response()->json(['error' => 'ログインしてください'], 401);
    }

    if ($user->favorites()->where('article_id', $article->id)->exists()) {
        $user->favorites()->detach($article->id);
        $status = 'removed';
    } else {
        $user->favorites()->attach($article->id);
        $status = 'added';
    }

    $article->loadCount('favorites');
    $favorites_count = $article->favorites_count;

    return response()->json([
        'status' => $status,
        'favorites_count' => $favorites_count
    ]);
    }
    
}
