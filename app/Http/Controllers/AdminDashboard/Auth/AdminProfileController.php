<?php

namespace App\Http\Controllers\AdminDashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminAuthNotification;
use App\Rules\MobileValidationRule;
use App\Services\ConvertPerToEn;
use App\Services\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{

    public function profile()
    {
        $admin = DB::table('admins')
            ->where('id', Auth::guard('admin')->id())
            ->first();
        return view('dash.profile.profile')->with('admin', $admin);
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' =>
                ['required', 'min:3', 'max:20', Rule::unique('admins')->ignore($request->id)],
            'first_name' =>
                ['required', 'min:3', 'max:20', Rule::unique('admins')->ignore($request->id)],
            'last_name' =>
                ['required', 'min:3', 'max:20', Rule::unique('admins')->ignore($request->id)],
            'email' =>
                ['nullable', 'email', Rule::unique('admins')->ignore($request->id)],
            'image_path' =>
                ['image', 'mimes:jpg,png,jpeg', 'max:2048']
            // ,'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
        ], $message = [
            'name.required' => 'نام کاربری الزامی است.',
            'name.min' => 'حداقل ۳ کاراکتر.',
            'name.max' => 'حداکثر ۲۰ کاراکتر.',
            'first_name.required' => 'نام الزامی است.',
            'first_name.min' => 'حداقل ۳ کاراکتر.',
            'first_name.max' => 'حداکثر ۲۰ کاراکتر.',
            'last_name.required' => 'نام خانوادگی الزامی است.',
            'last_name.min' => 'حداقل ۳ کاراکتر.',
            'last_name.max' => 'حداکثر ۲۰ کاراکتر.',
            'image_path.image' => 'فایل انتخابی معتبر نمی باشد.',
            'image.mimes' => 'فرمت فایل انتخابی معتبر نمی باشد.',
            'image_path.max' => 'حداکثر 2mb حجم فایل انتخابی.',
        ]);
        try {
            $admin = Admin::find($request->id);
            $admin->name = $request->name;
            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->email = $request->email;
            $save_path = null;

            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $file_name = $file->getClientOriginalName();

                // delete old image file from directory
                if (Storage::disk('local')->exists('public/admin_images/' . $admin->image_path)) {
                    Storage::disk('local')->delete('public/admin_images/' . $admin->image_path);
                }
                // store new image file to directory
                $save_path = Storage::putFileAs('public/admin_images', $request->file('image_path'), $file_name);
                // get image name from save_path image directory
                // or we could skip this
                $image_name = str_replace('public/admin_images/', '', $save_path);
                // save  new image file name into database
                $admin->image_path = $image_name;
            }
            $admin->save();
            session()->flash('success', 'پروفایل با موفقیت بروز رسانی شد.');
            return redirect()->back();
        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }

    public function editMobile()
    {
        $admin = DB::table('admins')
            ->where('id', Auth::guard('admin')->id())
            ->first();
        return view('dash.profile.change_mobile')
            ->with(['admin' => $admin]);
    }

    public function updateMobile(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'unique:admins', new MobileValidationRule()],
        ], $messages = [
            'mobile.required' => 'شماره موبایل جدید  را وارد کنید.',
            'mobile.unique' => 'شماره موبایل وارد شده تکراری است.',
        ]);
        try {
            $token = GenerateToken::generateToken();
            $mobile = ConvertPerToEn::convert($request->mobile);
            $admin = Admin::where('id', Auth::guard('admin')->id())->first();
            $admin->mobile = $mobile;
            $admin->token = $token;
            $admin->token_verified_at = null;
            $admin->remember_token = null;
            $admin->save();
            session(['admin_mobile' => $admin->mobile]);
            // for send code via sms
            $admin->notify(new AdminAuthNotification($admin));
            $request->session()->flash('success', 'کد فعال سازی به شماره موبایل ارسال شد.');
            return redirect()->route('validateMobileForm');
        } catch (\Exception $ex) {
            return view('errors_custom.register_error')
                ->with(['error' => $ex->getMessage()]);
        }
    }
}
