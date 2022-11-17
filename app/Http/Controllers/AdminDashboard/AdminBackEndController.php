<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\BackEnd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminBackEndController extends Controller
{

    public function index()
    {
        //
        $back_ends = BackEnd::paginate(10);
        return view('dash.admin_back_end.index')
            ->with('back_ends', $back_ends);
    }

    public function create()
    {
        //
        return view('dash.admin_back_end.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_persian' => ['required', 'unique:back_ends,title_persian', 'min:2', 'max:30'],
            'title_english' => ['required', 'unique:back_ends,title_english', 'min:2', 'max:30']
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

            BackEnd::create([
                'title_persian' => $request->title_persian,
                'title_english' => $request->title_english,
            ]);
            session()->flash('success', 'زبان جدید با موفقیت ذخیره شد.');
            return redirect()->route('admin.backIndex');

        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }

    public function edit(BackEnd $backEnd)
    {
        return view('dash.admin_back_end.edit')
            ->with('backEnd', $backEnd);
    }

    public function update(Request $request, BackEnd $backEnd)
    {
        //
        $request->validate([
            'title_persian' => ['required', Rule::unique('back_ends')->ignore($request->id), 'min:2', 'max:30'],
            'title_english' => ['required', Rule::unique('back_ends')->ignore($request->id), 'min:2', 'max:30']
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

            $tag = BackEnd::findOrfail($request->id);
            $tag->title_persian = $request->title_persian;
            $tag->title_english = $request->title_english;
            $tag->save();

            session()->flash('success', 'زبان مورد نطر با موفقیت بروز رسانی شد.');
            return redirect()->route('admin.backIndex');
        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }

    public function destroy(Request $request)
    {
        //
        try {
            $back = BackEnd::findOrFail($request->id);
            $back->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }
}
