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
   /* public function index()
    {
        $articles = Article::with('instructor')->latest()->get();
        return view ('instructor.articles.my_articles',compact('articles'));
    }*/


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

        return redirect()->route('instructor.top.index')->with('success','記事を投稿しました！');
    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
   {
    $article = Article::with(['comments.user','faceType','personalColor'])
                      ->withCount('favorites')
                      ->findOrFail($id);

    $user = auth()->guard('user')->user();
    $instructor = auth()->guard('instructor')->user();
    $admin = auth()->guard('admin')->user();

    if ($user) {
        $user->readArticles()->syncWithoutDetaching([$article->id]);
        $user->load('favorites'); // ここでロード

        $isFavorited = $user->favorites->contains($article->id);
        $completed = $user->readArticles()->find($article->id)?->pivot->completed ?? false;
    } else {
        $isFavorited = false;
        $completed = false;
    }

    return view('articles.show', compact('article', 'isFavorited', 'completed', 'instructor', 'admin'));
}

    public function showInstructor(Article $article)
   {
    $instructor = auth()->guard('instructor')->user();

    if ($article->instructor_id !== $instructor->id) {
        abort(403, 'このページを見る権限がありません。');
    }

    // 講師用もユーザー用Bladeを共用
    return view('articles.show', compact('article'));
   }

    //編集画面
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {

        $facetypes = FaceType::all();          
        $personalcolors = PersonalColor::all(); 

        return view('articles.edit',compact('article','facetypes','personalcolors'));
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

        return redirect()->route('instructor.articles.show',['article' => $article->id])->with('success','記事を更新しました！');

    }

    //ダウンロード
    public function downloadPdf($id){
        $article = Article::findOrFail($id);
        $pdf = PDF::loadView('articles.pdf', compact('article'));
        $fileName = 'article_' . $article->id . '.pdf';
        
        return $pdf->download($fileName);
    }

    //返信
    public function reply(Request $request, Comment $comment)
    {
    if (!auth('instructor')->check()) {
        return redirect()->route('instructor.login'); 

        $request->validate([
        'content' => 'required|string|max:500',
    ]);

    // 返信を作成
    $reply = new Comment();
    $reply->content = $request->input('content');
    $reply->parent_id = $comment->id; // 親コメントID
    $reply->article_id = $comment->article_id;
    $reply->instructor_id = auth('instructor')->id(); // 講師のID
    $reply->nickname = auth('instructor')->user()->name; // 講師の名前
    
    $reply->save();

    return redirect()->back()->with('success', '返信を投稿しました。');

    }
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
        return redirect()->route('instructor.top.index')->with('success','記事を削除しました！');
    }


    //修了
    public function complete(Article $article)
    {
    $user = auth()->user();

   if ($user) {
        $user->readArticles()->updateExistingPivot($article->id, ['completed' => true]);
    }

    return redirect()->back()->with('success', '修了しました！');

    }

    //メイク講師の記事一覧
  public function my_articles(Request $request)
{

    $query = Article::query();

    // ログイン中の講師の記事に絞る
    $query->where('instructor_id', auth()->id());

    // キーワード検索
    if ($keyword = $request->input('keyword')) {
        $query->where('title', 'like', "%{$keyword}%");
    }

    // 投稿日の範囲検索
    if ($dateFrom = $request->input('date_from')) {
        $query->whereDate('created_at', '>=', $dateFrom);
    }
    if ($dateTo = $request->input('date_to')) {
        $query->whereDate('created_at', '<=', $dateTo);
    }

    // 顔タイプで絞り込み
    if ($faceTypeId = $request->input('face_type_id')) {
        $query->where('face_type_id', $faceTypeId);
    }

    // パーソナルカラーで絞り込み
    if ($personalColorId = $request->input('personal_color_id')) {
        $query->where('personal_color_id', $personalColorId);
    }

    // 並び順とページネーション
    $articles = $query->orderBy('created_at', 'desc')
                      ->paginate(10);            

    // 顔タイプとパーソナルカラーを取得（フォーム用）
    $faceTypes = FaceType::all();
    $personalColors = PersonalColor::all();

    return view('instructor.articles.my_articles', compact('articles', 'faceTypes', 'personalColors'));

}
}