<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomNotification;
use App\Models\NotificationUser;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Notifications\DatabaseNotification;


class NotificationController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth:user');
    }
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
        } elseif (Auth::guard('instructor')->check()) {
            $user = Auth::guard('instructor')->user();
        } else {
            return redirect()->route('login'); 
        }
        
        
    $notifications = $user->notifications;

    $unreadNotifications = $user->unreadNotifications;

    $unreadCount = $user->unreadNotifications()->count();

    return view('notifications.index', compact('notifications', 'unreadCount', 'unreadNotifications'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    public function confirm(Request $request)
{
    if ($request->isMethod('post')) {
        // POST時：バリデーションしてセッションに保存
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date', 
            'content' => 'required|max:800',
        ]);

        $request->session()->put('admin_notifications_inputs', $validated);

        return redirect()->route('admin.notifications.confirm'); 
    }

        $inputs = $request->session()->get('admin_notifications_inputs');

        if (!$inputs) {
         return redirect()->route('admin.notifications.create')
                         ->with('error', '入力内容が見つかりません。');
    }
        return view('admin.notifications.confirm', compact('inputs'));
    }
    
   

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
           'title' => 'required|max:254',
           'date' => 'required|date', 
           'content' => 'required|max:800',           
        ]);

    // ユーザーと講師を取得
    $users = User::cursor();
    $instructors = Instructor::cursor();

    // ユーザーへ通知
    $users->each(function($user) use ($validated) {
        $user->notify(new CustomNotification(
            $validated['title'],
            $validated['content'],
            $validated['date']
        ));
    });

    // 講師へ通知
    $instructors->each(function($instructor) use ($validated) {
        $instructor->notify(new CustomNotification(
            $validated['title'],
            $validated['content'],
            $validated['date']
        ));
    });

    return redirect()->route('admin.mypage.index')
        ->with('success', 'お知らせを送信しました！');
}

  

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


       $user = Auth::guard('user')->user() ?? Auth::guard('instructor')->user();

       if (!$user) {
          return redirect()->route('login');
    }

        $notification = $user->notifications()->findOrFail($id);

        if ($notification->unread()) {
           $notification->markAsRead();
        }
        return view('notifications.show',compact('notification'));
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notifications = NotificationUser::where('user_id', $user->id)->notifications()->findOrFail($id);
        $notifications->markAsRead();

        return redirect()->back()->with('success', '通知を既読にしました');
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
        $user = Auth::user();
        NotificationUser::where('user_id', $user->id)->notifications()->findOrFail($id)->delete();

        return redirect()->back()->with('success','通知を削除しました');


    }
}

