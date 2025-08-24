<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;


class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(Auth::guard('admin')->check(), Auth::guard('admin')->id());
        $inquiries = Inquiry::latest()->get();
        return view('admn.Inquiries.index',compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inquiry.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
           'name' => 'required|max:255',
           'email' => 'required|email|max:255',
           'category' => 'required|max:254',
           'content' => 'required|max:500',
           'parent_id' => 'nullable|exists:inquiries,id',
        ]);

        $userId = auth()->guard('user')->check() ? auth()->id() : null;
        $instructorId = auth()->guard('instructor')->check() ? auth()->guard('instructor')->id() : null;

        Inquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'category' => $request->category,
            'content' => $request->content,
            'status' => '未対応',
            'parent_id' => $request->parent_id ?? null,
            'user_id' => $userId,
            'instructor_id' => $instructorId,
        ]);
        
    if ($instructorId) {
        return redirect()->route('instructor.top.index')->with('success', '問い合わせを送信しました！');
    } else {
        return redirect()->route('top.index')->with('success', '問い合わせを送信しました！');
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        return view('inquiry.show',compact('inquiry'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
          'name' => 'required|max:255',
          'email' => 'required|email',
          'category' => 'required|max:254',
          'content' => 'required|max:255',
        ]);

    // 入力内容をビューに渡す（確認画面）
        return view('inquiry.confirm', ['inputs' => $request->all(),]);
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
    public function delete(string $id)
    {
         $inquiry = Inquiry::findOrFail($id);
         return redirect()->route('inquiry.index')->with('success','問い合わせを削除しました');
    }
}
