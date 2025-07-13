<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomNotification;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;


class NotificationController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('notification.index',compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required|max:254',
           'body' => 'required|max:255',
           'user_id' => 'required|exists:users,id',
           'instructor_id' => 'required|exists:instructors,id',
           'admin_id' => 'required|exists:admins,id',          
        ]);

          $user = User::find($request->user_id);
          $user->notify(new CustomNotification($request->title, $request->body));

          return redirect()->route('notifications.index')->with('success','通知を送信しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notification = Notification::findOrFail($id);
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

