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
    public function create($articleId)
    {
        $article = Article::findOrFail($articleId);
        return view('comments.create',compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nickname' => 'required|string|max:50',
            'content' => 'required|max:500',
            'article_id' => 'required|exists:articles,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'nickname' => $request->nickname,
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

    public function reply(Request $request, $commentId)
    {
    $comment = Comment::findOrFail($commentId);
    $article = $comment->article;

    // ★ 自分が投稿した記事でなければ403
    if (Auth::guard('instructor')->id() !== $article->instructor_id) {
        abort(403, 'この記事の投稿者のみ返信できます');
    }

    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    $reply = new Comment([
        'content' => $request->content,
        'nickname' => Auth::guard('instructor')->user()->name,
        'parent_id' => $comment->id,
        'instructor_id'   => Auth::guard('instructor')->id(),  // ★ 講師のIDを入れる
        'article_id'=> $article->id,      
    ]);

    $reply->article_id = $article->id;
    $reply->save();

    return back()->with('success', '返信をしました！');
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
    public function destroy(Comment $comment)
    {

        $user = auth()->user();
        $instructor = auth()->guard('instructor')->user();

       if (
          ($user && $comment->user_id === $user->id) ||
          ($instructor && $comment->article->instructor_id === $instructor->id)
        ) {
          $comment->delete();
          return back()->with('success', 'コメントを削除しました。');
        }

    abort(403, '権限がありません。');
}
}




