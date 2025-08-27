<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;

class AdminArticleController extends Controller
{
      public function __construct(){
      $this->middleware(['auth', 'can:admin']);
    }

    public function index(Request $request){
        $query = Article::with('instructor')->withTrashed(); // 削除済み含む

        // キーワード
        if ($request->filled('keyword')) {
            $key = $request->keyword;
            $query->where('title', 'like', "%{$key}%")
                  ->orWhere('content', 'like', "%{$key}%");
        }

        // 講師名
        if ($request->filled('instructor')) {
            $query->whereHas('instructor', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->instructor}%");
            });
        }

        // 投稿日期間
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        // 顔タイプ
        if ($request->filled('face_type_id')) {
            $query->where('face_type_id', $request->face_type_id);
        }

        // パーソナルカラー
        if ($request->filled('personal_color_id')) {
            $query->where('personal_color_id', $request->personal_color_id);
        }

        // 削除状態
        if ($request->filled('deleted_state')) {
            if ($request->deleted_state === 'only') {
                $query->onlyTrashed();
            } elseif ($request->deleted_state === 'without') {
                $query->withoutTrashed();
            }
        }

        $articles = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    // ソフト削除
    public function softDelete($id) {
        Article::findOrFail($id)->delete();
        return back()->with('success', '記事を削除しました');
    }

 
    //復元
    public function restore($id){
        Article::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', '記事を復元しました');
    }

   //完全削除
    public function forceDelete($id){
        $article = Article::onlyTrashed()->findOrFail($id);

        // 画像ファイルも削除
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        $article->forceDelete();
        return back()->with('success', '記事を完全に削除しました');
    }
}

