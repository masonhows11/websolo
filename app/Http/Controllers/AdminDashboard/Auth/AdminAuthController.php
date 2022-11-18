<?php

namespace App\Http\Controllers\AdminDashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminAuthNotification;
use App\Rules\MobileValidationRule;
use App\Services\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function loginAdminForm()
    {
        return view('auth_dash.login_admin');
    }

    public function loginAdmin(Request $request)
    {
        // return $request;
        $request->validate([
            'mobile' => ['required', 'exists:admins', new MobileValidationRule()],
        ], $messages = [
            'mobile.required' => 'شماره موبایل خود را وارد کنید.',
            'mobile.regex' => 'شماره موبایل وارد شده معتبر نمی باشد.',
            'mobile.exists' => 'کاربری با شماره موبایل وارد شده وجود ندارد.',
        ]);

        try {
            $token = GenerateToken::generateToken();
            $admin = Admin::where('mobile', $request->mobile)->first();
            $admin->token = $token;
            $admin->save();
            session(['admin_mobile' => $admin->mobile]);
            // for send code via sms
            $admin->notify(new AdminAuthNotification($admin));
            $request->session()
                ->flash('success', 'کد فعال سازی به شماره موبایل ارسال شد.');
            return redirect()->route('validateMobileForm');
        }catch (\Exception $ex){
            $request->session()
                ->flash('error',$ex->getMessage());
            return redirect()->back();
        }
    }

    public function logOut(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $admin->token = null;
        $admin->token_verified_at = null;
        $admin->remember_token = null;
        $admin->save();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('adminLoginForm');
    }
}
