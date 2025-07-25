<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index(Request $request){
        $query = User::withTrashed();

        //キーワード検索
        if($request->filled('keyword')){
            $query->where('name','like','%'. $request->keyword . '%');
        }

        //性別
        if($request->filled('gender')){
            $query->where('gender', $request->role);
        }

        //権限
        if($request->filled('role')){
            $query->where('role', $request->role);
        }

        //削除状態
        if($request->filled('deleted')){
            if($request->deleted == '済')
                $query->onlyTrashed();
        }elseif($request->deleted == '未'){
                $query->withoutTrashed();
        }

          $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function softDelete($id){
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'ユーザーを削除しました。');
    }

    public function restore($id){
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return back()->with('success', 'ユーザーを復元しました。');
    }

    public function forceDelete($id){
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return back()->with('success', 'ユーザーを完全に削除しました。');
    }
}
