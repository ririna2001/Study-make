<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::latest()->get();
        return view('comments.index',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        return view('comments.create',compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'content' => 'required|max:500',
            'article_id' => 'required|exists:articles,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'content' => $request->content,
            'article_id' => $request->article_id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id, 
        ]);
       
        return redirect()->route('articles.show', $request->article_id)->with('success','コメントを投稿しました！');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.show',compact('comment'));
    }

    public function reply(Request $request, Comment $comment)
    {
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $comment->replies()->create([
        'user_id' => Auth::id(),
        'instructor_id' => Auth::user()->is_instructor ? Auth::id() : null,
        'article_id' => $comment->article_id,
        'content' => $request->content,
        'reply' => $comment->id, 
    ]);

    return back()->with('success', '返信を投稿しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment -> delete();

        return redirect()->route('articles.show', $comment->article_id)->with('success','コメントを削除しました');

    }
}
