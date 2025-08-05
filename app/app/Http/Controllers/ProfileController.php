<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\FaceType;
use App\Models\PersonalColor;
use App\Models\User;

class ProfileController extends Controller
{

    //プロフィール表示
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Auth::user() -> profile;
        return view('profile.index',compact('profile'));
    }

    //作成画面表示
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faceTypes = FaceType::all();
        $personalColors = PersonalColor::all();
        return view ('profile.create',compact('faceTypes','personalColors'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required|max:255',
            'age' => 'required|max:10',
            'gender' => 'nullable',
            'occupation' => 'nullable',
            'email' => 'required|max:255',
            'face_type_id' => 'nullable|exists:face_types_id',
            'pesonal_color_id' => 'nullable|exists:personal_colors_id',
        ]);

        Profile::create([
            'name' => $request -> name,
            'age' => $request -> age,
            'gender' => $request -> gender,
            'occupation' => $request -> occupation,
            'face_type_id' => $request -> face_type_id,
            'pesonal_color_id' => $request -> personal_color_id,
        ]);

        return redirect() -> route('profile.index') ->with('success','プロフィールを登録しました！');
    }

    //
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::findOrFail($id);
        return view('profile.show',compact('profile'));
    }

    //編集画面表示
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $profile = Profile::findOrFail($id);
        $faceTypes = FaceType::all();
        $personalColors = PersonalColor::all();

        return view('profile.edit',compact('profile','faceTypes','personalColors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, profile $profile)
    {
         $request -> validate([
            'name' => 'required|max:255',
            'age' => 'required|max:10',
            'gender' => 'nullable',
            'occupation' => 'nullable',
            'face_type_id' => 'nullable|exists:face_types_id',
            'pesonal_color_id' => 'nullable|exists:personal_colors_id',
        ]);

        $profile -> update($request->only([
            'name',
            'age',
            'gender',
            'occupation',
            'face_type_id',
            'pesonal_color_id',
        ]));

        return redirect() -> route('profiles.index') -> with('success','プロフィールを更新しました！');

    }

    /**
     * Remove the specified resource from storage.
     */
   /* public function destroy(string $id)
    {
        //
    }*/
}
