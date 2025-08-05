<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{

    public function form(){
        return view('auth.register');
    }
    public function confirm(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'nullable|integer|min:10|max:100',
        'gender' => 'nullable|in:男性,女性',
        'occupation' => 'nullable|string',
        'email' => 'required|email|unique:users,email|unique:instructors,email',
        'password' => 'required|confirmed|min:8',
        'face_type' => 'nullable|string',
        'personal_color' => 'nullable|string',
        'role' => 'required|in:一般,メイク講師',
    ]);

    return view('auth.confirm', ['input' => $validated]);
}

public function back(Request $request)
{
    return redirect()->route('register.form')->withInput($request->all());
}

  public function complete(Request $request)
    {
        $data = $request->except('password_confirmation');
        $data['password'] = bcrypt($data['password']);
        $data['name'] = $request->input('name');


        $profileData = [
        'age' => $request->input('age'),
        'gender' => $request->input('gender'),
        'occupation' => $request->input('occupation'),
        'face_type' => $request->input('face_type'),
        'personal_color' => $request->input('personal_color'),
        
    ];

        if ($data['role'] === 'メイク講師') {
            $instructor = Instructor::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
            ]);
             $instructor->profile()->create($profileData);
            return redirect()->route('login.instructor')->with('message', '登録が完了しました!');
        } else {
            $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
            ]);
            $user->profile()->create($profileData);
             return redirect()->route('login.user')->with('message', '登録が完了しました!');
        }

    }

   
}
