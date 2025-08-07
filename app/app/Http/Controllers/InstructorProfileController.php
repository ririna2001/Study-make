<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\FaceType;
use App\Models\PersonalColor;

class InstructorProfileController extends Controller
{
    // プロフィール表示
    public function show($id)
    {
    $profile = auth()->guard('instructor')->user()->profile;
    return view('profile.show', compact('profile'));
    }

    // プロフィール編集画面表示
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        $faceTypes = FaceType::all();
        $personalColors = PersonalColor::all();

        return view('profile.edit', compact('profile', 'faceTypes', 'personalColors'));
    }

    // プロフィール更新処理
    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'name' => 'required|max:255',
            'age' => 'required|max:10',
            'gender' => 'nullable',
            'occupation' => 'nullable',
            'face_type_id' => 'nullable|exists:face_types,id',
            'personal_color_id' => 'nullable|exists:personal_colors,id',
        ]);

        $profile->update($request->only([
            'name',
            'age',
            'gender',
            'occupation',
            'face_type_id',
            'personal_color_id',
        ]));

        return redirect()->route('instructor.profile.show', ['profile' => $profile->id])
            ->with('success', 'プロフィールを更新しました！');
    }

    // プロフィール作成画面
    public function create()
    {
        $faceTypes = FaceType::all();
        $personalColors = PersonalColor::all();
        return view('profile.create', compact('faceTypes', 'personalColors'));
    }

    // プロフィール保存処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'age' => 'required|max:10',
            'gender' => 'nullable',
            'occupation' => 'nullable',
            'face_type_id' => 'nullable|exists:face_types,id',
            'personal_color_id' => 'nullable|exists:personal_colors,id',
        ]);

        $profile = Profile::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'face_type_id' => $request->face_type_id,
            'personal_color_id' => $request->personal_color_id,
            // もし講師ユーザーIDがprofilesテーブルに必要ならここに入れる
            // 'instructor_id' => Auth::guard('instructor')->id(),
        ]);

        return redirect()->route('instructor.profile.show', ['profile' => $profile->id])
            ->with('success', 'プロフィールを登録しました！');
    }
}
