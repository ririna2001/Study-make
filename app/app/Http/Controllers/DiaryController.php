<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Diary;

class DiaryController extends Controller
{

    //一覧表示
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diaries = Diary::where('user_id',Auth::id())->latest()->get();
        return view('diaries.index',compact('diaries'));
    }


    //作成画面表示
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diaries.create');
    }

    //保存処理
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Diary::create([
            'title' => $request -> title,
            'content' => $request -> content,
            'user_id' => Auth::id(),
        ]);

        return redirect() -> route('diaries.index') -> with('success','日記を投稿しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diaries = Diary::findOrFail($id);
        return view('diaries.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   /* public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
   /* public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diary $diary)
    {
        $diary -> delete();
        return redirect() -> route('diaries.index') -> with('success','日記を削除しました！');
    }
}
