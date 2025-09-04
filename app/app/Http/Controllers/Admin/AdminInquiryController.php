<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\InquiryReply;

class AdminInquiryController extends Controller
{

  public function index(Request $request){

    $admin = Auth::guard('admin')->user();
    
    $query = Inquiry::query();

    // キーワード検索（名前・メール）
    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%')
              ->orWhere('email', 'like', '%' . $keyword . '%');
        });
    }

    // 対応状況の絞り込み
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // 日付範囲の検索
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->input('date_from'));
    }
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->input('date_to'));
    }

    // 最新順・ページネーション
    $inquiries = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.inquiries.index', compact('inquiries'));
  }

  public function show($id){
    $inquiry = Inquiry::with('replies')->findOrFail($id);

    return view('admin.inquiries.show', compact('inquiry'));
  }

  public function replyForm($id)
{
    $inquiry = Inquiry::findOrFail($id);
    return view('admin.inquiries.reply', compact('inquiry'));
}

//返信
public function reply(Request $request, $id)
{
    $request->validate([
        'reply' => 'required|string',
    ]);

    $inquiry = Inquiry::findOrFail($id);
    $inquiry->reply = $request->input('reply');
    $inquiry->replied_at = Carbon::now(); 
    $inquiry->is_replied = true; 
    $inquiry->save();

    return redirect()->route('admin.inquiries.index')->with('success', '返信を送信しました。');
}

//お知らせ作成
public function create()
{
    return view('admin.inquiries.create');
}

//確認画面
public function confirm(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'reply' => 'required|string',
    ]);

    $validated['date'] = Carbon::now()->format('Y-m-d');

     return view('admin.inquiries.reply_confirm', [
        'title'   => $validated['title'],
        'reply'   => $validated['reply'],
        'date'    => Carbon::now()->format('Y-m-d'),
        'inquiry' => Inquiry::findOrFail($id),
    ]);
}

//保存
/*public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'date' => 'required|date',
    ]);

    Inquiry::create($validated);

    return redirect()->route('admin.inquiries.index')->with('success', 'お知らせを作成しました！');
}*/

//問い合わせ返信
public function storeReply(Request $request, $inquiryId)
{    
    $request->validate(['reply' => 'required|string']);

    $inquiry = Inquiry::findOrFail($inquiryId);

    InquiryReply::create([
        'inquiry_id' => $inquiryId,
        'admin_id' => auth('admin')->id(),
        'user_id' => $inquiry->user_id, 
        'instructor_id' => $inquiry->instructor_id,
        'title' => $request->title,
        'content' => $request->reply,
    ]);

    return redirect()->route('admin.inquiries.index')->with('success', '返信を送信しました');
}

}
