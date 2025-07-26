<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRegisterController extends Controller
{
      public function showForm()
    {
        return view('admin.users.register'); 
    }

    // 確認画面表示
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email', 
            'password' => 'required|confirmed|min:8',
        ]);

        return view('admin.users.confirm', ['data' => $validated]);
    }
}
