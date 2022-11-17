<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use mysql_xdevapi\Table;

class AdminTagController extends Controller
{

    public function index()
    {

        $tags = Tag::paginate(10);
        return view('dash.admin_tag.index')
            ->with('tags', $tags);
    }


    public function create()
    {

        return view('dash.admin_tag.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'title_persian' => ['required', 'unique:tags,title_persian', 'min:2', 'max:30'],
            'title_english' => ['required', 'unique:tags,title_english', 'min:2', 'max:30']
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

            Tag::create([
                'title_persian' => $request->title_persian,
                'title_english' => $request->title_english,
            ]);
            session()->flash('success', 'تگ جدید با موفقیت ذخیره شد.');
            return redirect()->route('admin.tagIndex');

        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }


    public function edit(Tag $tag)
    {
        return view('dash.admin_tag.edit')
            ->with('tag', $tag);
    }


    public function update(Request $request)
    {

       /* $request->validate([
            'title_persian' => ['required', 'unique:tags,title_persian', 'min:2', 'max:30'],
            'title_english' => ['required', 'unique:tags,title_english', 'min:2', 'max:30']
        ], $messages = [
            'title_english.required' => 'عنوان تگ را به انگلیسی وارد کنید.',
            'title_english.min' => 'حداقل ۲ کارکتر.',
            'title_english.max' => 'حداکثر ۳۰ کاراکتر.',
            'title_english.unique' => 'عنوان وارد شده تکراری است.',

            'title_persian.required' => 'عنوان تگ را به فارسی وارد کنید.',
            'title_persian.min' => 'حداقل ۲ کارکتر.',
            'title_persian.max' => 'حداکثر ۳۰  کاراکتر.',
            'title_persian.unique' => 'عنوان وارد شده تکراری است.',
        ]);*/
        $request->validate([
            'title_persian' => ['required',Rule::unique('tags')->ignore($request->id), 'min:2', 'max:30'],
            'title_english' => ['required',Rule::unique('tags')->ignore($request->id), 'min:2', 'max:30']
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

            $tag = Tag::findOrfail($request->id);
            $tag->title_persian = $request->title_persian;
            $tag->title_english = $request->title_english;
            $tag->save();

            session()->flash('success','تگ مورد نطر با موفقیت بروز رسانی شد.');
            return redirect()->route('admin.tagIndex');
        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }

    }


    public function destroy(Request $request)
    {
        try {
            $tag = Tag::findOrFail($request->id);
            $tag->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }
}
