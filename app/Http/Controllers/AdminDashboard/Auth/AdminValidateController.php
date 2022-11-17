<?php

namespace App\Http\Controllers\AdminDashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminAuthNotification;
use App\Services\CheckExpireToken;
use App\Services\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminValidateController extends Controller
{
    //
    public function validateMobileForm()
    {

        return view('auth_dash.validate_token');
    }

    public function validateMobile(Request $request)
    {
        // return $request;
        $request->validate([
            'token' => ['required','numeric','digits:6']
        ], $messages = [
            'token.required' => 'کد فعال سازی را وارد کنید.',
            'token.numeric' => 'مقدار وارد شذه معتبر نمی باشد.',
            'token.digits' => 'کد فعال سازی معتبر نمی باشد.',
        ]);
        $validated = CheckExpireToken::checkAdminToken($request->token,$request->mobile);
        if ($validated == false) {
            return redirect()->route('adminLoginForm')
                ->with(['error' => 'کد فعال سازی معتبر نمی باشد']);
        }
        if ($admin = Admin::where(['mobile' => $request->mobile, 'token' => $request->token])->first()) {
            Auth::guard('admin')->login($admin,$request->remember);

            $request->session()->forget('admin_mobile');
            return redirect()->route('admin.dashboard');
        }
        return view('auth_dash.login_admin');


    }

    public function resendToken(Request $request)
    {

        try {
            $admin = Admin::where('mobile', $request->number)->first();
            $token = GenerateToken::generateToken();
            $admin->token = $token;
            $admin->save();
            //  $admin->notify(new AdminAuthNotification($admin));
            return response()->json(['success' => 'کد فعال سازی مجددا ارسال شد.', 'status' => 200], 200);
        }catch (\Exception $ex){
            return response()->json(['exception' => $ex->getMessage(), 'status' => 500], 500);
        }

    }
}
