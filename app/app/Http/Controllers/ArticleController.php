<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\FaceType;
use App\Models\PersonalColor;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; 

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     //一覧表示
    public function index()
    {
        $articles = Article::with('instructor')->latest()->get();
        return view ('articles.index',compact('articles'));
    }


    //作成画面表示
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $facetypes = FaceType::all();  
        $personalColors = PersonalColor::all();

        return view('articles.create', compact('facetypes','personalColors'));
    }


    //保存処理
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:500',
            'youtube_video_id' => 'nullable|string',
        ]);

        $article = new Article();
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->youtube_video_id = $request->input('youtube_video_id');
        $article->instructor_id = Auth::guard('instructor')->id();
        $article->save();

        if ($request->hasFile('image')) {
           $path = $request->file('image')->store('articles', 'public');
           $article->image_path = $path;
           $article->save();
        }

        return redirect()->route('top.index')->with('success','記事を投稿しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $article = Article::with('comments')->findOrFail($id);

    $isFavorited = false;

    if (auth()->guard('web')->check()) {
        $user = auth()->guard('web')->user();
        $isFavorited = $user->favorites->contains($article->id);
    }

    return view('articles.show', compact('article', 'isFavorited'));
}

    //編集画面
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit',compact('article'));
    }

    //更新処理
    /**
     * Update the specified resource in storage.
     */


    public function confirm(Request $request){
        $inputs = $request->all();

        $request->validate([
        'title' => 'required|string|max:255',
        'face_type_id' => 'nullable|exists:face_types,id',
        'personal_color_id' => 'nullable|exists:personal_colors,id',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $facetypes = FaceType::all();
    $personalColors = PersonalColor::all();

      return view('articles.confirm', compact('inputs', 'facetypes', 'personalColors'));

    }



    public function update(Request $request, Article $article)
    {
         $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'youtube_video_id' => 'nullable|string',
        ]);

        $article->fill($request->only(['title', 'content', 'youtube_video_id']));

        if ($request->hasFile('image')) {
        // 古い画像を削除
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
           }

            $path = $request->file('image')->store('articles', 'public');
            $article->image_path = $path;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success','記事を更新しました！');

    }

    //ダウンロード
    public function download($id){
        $article = Article::findOrFail($id);
        $pdf = PDF::loadView('articles.pdf', compact('article'));
        $fileName = 'article_' . $article->id . '.pdf';
        
        return $pdf->download($fileName);

    }


    //削除
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article){
         if ($article->image_path) {
        Storage::disk('public')->delete($article->image_path);
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success','記事を削除しました！');
    }
}
