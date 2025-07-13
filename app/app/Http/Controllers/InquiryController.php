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
        $inquiries = Inquiry::latest()->get();
        return view('Inquiries.index',compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inquiries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
           'category' => 'required|max:254',
           'content' => 'required|max:255',
           'status' => 'required|max:20',
           'parent_id' => 'nullable|exists:inquiries,id',
        ]);

        Inquiry::create([
            'category' => $request->category,
            'content' => $request->content,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('inquiries.index')->with('success','問い合わせを送信しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        return view('inquiries.show',compact('inquiry'));
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
         $inquiry = Inquiry::findOrFail($id);
         return redirect()->route('inquiries.index')->with('success','問い合わせを削除しました');
    }
}
