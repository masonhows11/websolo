<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\BackEnd;
use App\Models\FrontEnd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminFrontEndController extends Controller
{

    public function index()
    {
        $front_ends = FrontEnd::paginate(10);
        return view('dash.admin_front_end.index')
            ->with('front_ends', $front_ends);
    }


    public function create()
    {
        //
        return view('dash.admin_front_end.create');
    }


    public function store(Request $request)
    {
        //
        $request->validate([
            'title_persian' => ['required', 'unique:front_ends,title_persian', 'min:2', 'max:30'],
            'title_english' => ['required', 'unique:front_ends,title_english', 'min:2', 'max:30']
        ], $messages = [
            'title_english.required' => 'عنوان زبان را به انگلیسی وارد کنید.',
            'title_english.min' => 'حداقل ۲ کارکتر.',
            'title_english.max' => 'حداکثر ۳۰ کاراکتر.',
            'title_english.unique' => 'عنوان وارد شده تکراری است.',

            'title_persian.required' => 'عنوان زبان را به فارسی وارد کنید.',
            'title_persian.min' => 'حداقل ۲ کارکتر.',
            'title_persian.max' => 'حداکثر ۳۰  کاراکتر.',
            'title_persian.unique' => 'عنوان وارد شده تکراری است.',
        ]);

        try {

            FrontEnd::create([
                'title_persian' => $request->title_persian,
                'title_english' => $request->title_english,
            ]);
            session()->flash('success', 'زبان جدید با موفقیت ذخیره شد.');
            return redirect()->route('admin.frontIndex');

        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }


    public function edit(FrontEnd $frontEnd)
    {
        //
        return view('dash.admin_front_end.edit')
            ->with('frontEnd', $frontEnd);
    }


    public function update(Request $request, FrontEnd $frontEnd)
    {
        //
        $request->validate([
            'title_persian' => ['required', Rule::unique('front_ends')->ignore($request->id), 'min:2', 'max:30'],
            'title_english' => ['required', Rule::unique('front_ends')->ignore($request->id), 'min:2', 'max:30']
        ], $messages = [
            'title_english.required' => 'عنوان تگ را به انگلیسی وارد کنید.',
            'title_english.min' => 'حداقل ۲ کارکتر.',
            'title_english.max' => 'حداکثر ۳۰ کاراکتر.',
            'title_english.unique' => 'عنوان وارد شده تکراری است.',

            'title_persian.required' => 'عنوان تگ را به فارسی وارد کنید.',
            'title_persian.min' => 'حداقل ۲ کارکتر.',
            'title_persian.max' => 'حداکثر ۳۰  کاراکتر.',
            'title_persian.unique' => 'عنوان وارد شده تکراری است.',
        ]);
        try {

            $tag = FrontEnd::findOrfail($request->id);
            $tag->title_persian = $request->title_persian;
            $tag->title_english = $request->title_english;
            $tag->save();

            session()->flash('success', 'زبان مورد نطر با موفقیت بروز رسانی شد.');
            return redirect()->route('admin.frontIndex');
        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }


    public function destroy(Request $request)
    {
        //
        try {
            $front = FrontEnd::findOrFail($request->id);
            $front->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }
}
