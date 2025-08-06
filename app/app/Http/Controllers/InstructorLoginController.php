<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InstructorLoginController extends Controller
{
    public function showLoginForm(Request $request){
        return view('auth.login',['loginRoute' => 'login.instructor.submit',
    ]);
    }

    public function login(Request $request){
         $request->validate([
            'email' => 'required|email',
            'password' => 'required'
         ]);

         if(Auth::guard('instructor')->attempt([
             'email' => $request->email,
             'password' => $request->password
         ])){
            return redirect()->route('top.index');
         }
         

         return back()->withErrors([
              'login' => 'メールアドレスまたはパスワードが正しくありません'        
         ])->withInput();
    }

}