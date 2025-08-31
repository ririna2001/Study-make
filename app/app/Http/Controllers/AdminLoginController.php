<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
      public function showLoginForm(Request $request){
        return view('admin.login',['loginRoute' => 'login.admin.submit',
    ]);
    }

    public function login(Request $request){
         $request->validate([
            'email' => 'required|email',
            'password' => 'required'
         ]);

         if(Auth::guard('admin')->attempt([
             'email' => $request->email,
             'password' => $request->password
         ])){
            return redirect()->route('admin.top.index');
         }
         

         return back()->withErrors([
              'login' => 'メールアドレスまたはパスワードが正しくありません'        
         ])->withInput();
    }

}

