<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('dash.admin_users.index')->with('users', $users);
    }


    public function status(User $user)
    {
        try {
            if ($user->banned == 0) {
                $user->banned = 1;
            } elseif ($user->banned == 1) {
                $user->banned = 0;
            }
            $user->save();
            ;session()->flash('success','وصعیت کاربر با موفقیت بروز رسانی شد.');
            return redirect()->back();
        }catch (\Exception $ex){
            ;session()->flash('error','خطایی هنگام بروز رسانی رخ داده.');
            return redirect()->back();
        }

    }

    public function destroy(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }

    }


}
