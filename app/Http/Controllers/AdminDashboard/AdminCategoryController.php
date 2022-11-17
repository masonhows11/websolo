<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{

    public function index()
    {
        $categories = Category::tree()->get()->toTree();
        return view('dash.admin_category.index')
            ->with('categories', $categories);
    }


    public function create()
    {
        $categories = Category::all();
        return view('dash.admin_category.create')
            ->with(['categories' => $categories]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title_english' => ['required', 'min:2', 'max:50', 'alpha_dash'],
            'title_persian' => ['required', 'min:2', 'max:50']
        ], $messages = [
            'title_english.required' => 'عنوان دسته بندی را به انگلیسی وارد کنید.',
            'title_english.min' => 'حداقل ۲ کارکتر.',
            'title_english.max' => 'حداکثر ۵۰ کاراکتر.',

            'title_english.alpha_dash' => ' فقط حروف ، خط فاصله ، زیر خط و به انگلیسی وارد کنید.',

            'title_persian.required' => 'عنوان دسته بندی را به فارسی وارد کنید.',
            'title_persian.min' => 'حداقل ۲ کارکتر.',
            'title_persian.max' => 'حداکثر ۵۰ کاراکتر.',
        ]);
        try {
            if ($request->filled('parent')) {
                Category::create([
                    'title_persian' => $request->title_persian,
                    'title_english' => $request->title_english,
                    'parent_id' => $request->parent,
                ]);

            } else {
                Category::create([
                    'title_persian' => $request->title_persian,
                    'title_english' => $request->title_english,
                ]);
            }
            $request->session()->flash('success', 'دسته بندی مورد نظر با موفقیت ذخیره شد.');
            return redirect()->route('admin.categoryIndex');
        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }


    public function edit(Category $category)
    {
        try {
            $categories = Category::all();
            $parent = Category::getParent($category->parent_id);
            return  view('dash.admin_category.edit')
                ->with(['category'=>$category,
                    'parent'=>$parent
                ,'categories' => $categories]);

        } catch (\Exception $ex) {
            return view('errors_custom.model_not_found');
        }
    }


    public function update(Request $request)
    {

        $request->validate([
            'title_english' => ['required', 'min:2', 'max:50', 'alpha_dash',
                Rule::unique('categories')->ignore($request->id)],
            'title_persian' => ['required', 'min:2', 'max:50',
                Rule::unique('categories')->ignore($request->id)]
        ], $messages = [
            'title_english.required' => 'عنوان دسته بندی را به انگلیسی وارد کنید.',
            'title_english.min' => 'حداقل ۲ کارکتر.',
            'title_english.max' => 'حداکثر ۵۰ کاراکتر.',
            'title_english.alpha_dash' => ' فقط حروف ، خط فاصله ، زیر خط و به انگلیسی وارد کنید.',

            'title_persian.required' => 'عنوان دسته بندی را به فارسی وارد کنید.',
            'title_persian.min' => 'حداقل ۲ کارکتر.',
            'title_persian.max' => 'حداکثر ۵۰ کاراکتر.',
        ]);

        try {
            if (!$request->has('parent')) {
                Category::where('id', $request->id)
                    ->update([
                        'title_persian' => $request->title_persian,
                        'title_english' => $request->title_english,
                    ]);
            }
            Category::where('id', $request->id)
                ->update([
                    'title_persian' => $request->title_persian,
                    'title_english' => $request->title_english,
                    'parent_id' => $request->parent
                ]);
            $request->session()
                ->flash('success', 'دسته بندی مورد نظر با موفقیت بروز رسانی شد.');
            return redirect()->route('admin.categoryIndex');

        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }


    public function destroy(Request $request)
    {
        try {
            $category = Category::findOrFail($request->id);
            if ($category->parent_id == null) {
                return response()
                    ->json(['message' => 'امکان حذف دسته بندی مورد نظر وجود ندارد.', 'status' => 202], 200);
            }
            $category->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }

    public function detach(Category $category)
    {
        try {
            if ($category->parent_id !== null) {
                $category->parent_id = null;
                $category->save();
                session()->flash('success', 'دسته بندی مورد از والد خود حذف شد.');
                return redirect()->back();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'دسته بندی مورد نظر وجود ندارد');
            return redirect()->back();
        }
    }

    public function activate(Category $category)
    {
        try {
            if ($category->is_active == 1) {
                $category->is_active = false;
            } elseif
            ($category->is_active == 0) {
                $category->is_active = true;
            }
            $category->save();
            session()->flash('success', 'وضعیت دسته بندی مورد نظر با موفقیت بروز رسانی شد.');
            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'دسته بندی مورد نظر وجود ندارد');
            return redirect()->back();
        }


    }
}
