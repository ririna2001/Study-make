<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\FaceType;
use App\Models\PersonalColor;

class TopController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('user');

        //キーワード検索
        if($request->filled('keyword')){
            $query->where('title','like','%'. $request->keyword.'%');
        }

        //性別
        if($request->filled('gender')){
            $query->whereHas('user',function($q)use($request){
                $q->where('gender',$request->gender);
            });
        }

        //お気に入り
        if (auth()->guard('user')->check() && $request->filled('favorite')) {
            $user = auth()->user();
            $favoriteIds = $user->favorites->pluck('article_id');

           if ($request->favorite == '1') {
               $query->whereIn('id', $favoriteIds);
           } else {
               $query->whereNotIn('id', $favoriteIds);
           }
        }

        //投稿日付の絞り込み
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        //顔タイプ
        if ($request->filled('face_type_id')) {
            $query->where('face_type_id', $request->face_type_id);
        }

        //パーソナルカラー
        if ($request->filled('personal_color_id')) {
            $query->where('personal_color_id', $request->personal_color_id);
        }

        $articles = $query->latest()->paginate(10); // ページネーション 

        $faceTypes = FaceType::all();
        $personalColors = PersonalColor::all();

        if(auth()->guard('user')->check()){
           return view('top.user',compact('articles','faceTypes','personalColors'));
        }

         if(auth()->guard('instructor')->check()){
           return view('top.instructor',compact('articles','faceTypes','personalColors'));
        }

          if(auth()->guard('admin')->check()){
           return view('top.admin',compact('articles','faceTypes','personalColors'));
        }

        return view('top.index', compact('articles', 'faceTypes', 'personalColors'));

    }
}
