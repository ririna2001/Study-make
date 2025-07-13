<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     //一覧表示
    public function index()
    {
        $articles = Article::latest()->get();
        return view ('articles.index',compact('articles'));
    }


    //作成画面表示
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
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
        ]);

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('articles.index')->with('success','記事を投稿しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show',compact('article'));
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
    public function update(Request $request, Article $article)
    {
         $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $article->update($request->only(['title','content']));

        return redirect()->route('articles.index')->with('success','記事を更新しました！');

    }


    //削除
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success','記事を削除しました！');
    }
}
