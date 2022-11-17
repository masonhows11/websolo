<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\GetImageName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminArticleController extends Controller
{

    public function index()
    {
        $last_article = DB::table('articles')->latest()->first();
        $articles = Article::paginate(6);
        return view('dash.admin_article.index')
            ->with(['articles' => $articles, 'last_article' => $last_article]);
    }


    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('dash.admin_article.create')
            ->with(['categories'=>$categories,'tags'=>$tags]);
    }


    public function store(Request $request)
    {
       //  return $request;
        $request->validate([
            'title_persian' => 'required|min:3|max:30',
            'title_english' => 'required|min:3|max:30',
            'short_description' => 'required|min:10|max:500',
            'description' => 'required|min:10|max:5000',
            'image' => 'required',
            'category' => 'required',
            'tag' => 'nullable',
        ], $message = [
            'title_persian.required' => 'عنوان مقاله الزامی است.',
            'title_persian.min' => 'حداقل ۵ کاراکتر.',
            'title_persian.max' => 'حداکثر ۳۰ کاراکتر.',

            'title_english.required' => 'عنوان مقاله الزامی است.',
            'title_english.min' => 'حداقل ۵ کاراکتر.',
            'title_english.max' => 'حداکثر ۳۰ کاراکتر.',

            'short_description.required' => 'توضیحات الزامی است.',
            'short_description.min' => 'حداقل ۱۰ کاراکتر',
            'short_description.max' => 'حداکثر تعداد کاراکتر.',

            'description.required' => 'توضیحات الزامی است.',
            'description.min' => 'حداقل ۱۰ کاراکتر',
            'description.max' => 'حداکثر تعداد کاراکتر.',

            'image.required' => 'انخاب عکس الزامی است.',
            'category.required' => 'انتخاب دسته بندی الزامی است.',

            'tags.string' => 'مقدار وارد شده نوع رشته باشد.',
            'tags.alpha' => 'مقدار وارد شده حروف الفبا باشد.',

        ]);


        try {
            $image = GetImageName::imageName($request->image);
            DB::transaction(function () use ($image, $request) {
                $article = Article::create([
                    'title_persian' => $request->title_persian,
                    'title_english' => $request->title_english,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'image' => $image,
                    'user_id' => Auth::guard('admin')->user()->id,
                ]);
                $article->categories()->sync($request->category);
                $article->tags()->sync($request->tag);

            });


            session()->flash('success', 'مقاله جدید با موفقیت ذخیره شد.');
            return redirect()->route('admin.articleIndex');

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function edit(Article $article)
    {

        $tags = DB::table('tags')->get();
        $categories = DB::table('categories')->get();

        return view('dash.admin_article.edit')
            ->with(['article' => $article,
                'categories' => $categories,
                'tags'=>$tags]);
    }


    public function update(Request $request)
    {

        $request->validate([
            'title_persian' => 'required|min:3|max:30',
            'title_english' => 'required|min:3|max:30',
            'description' => 'required|min:10|max:5000',
            'image' => 'required',
            'category' => 'required',
        ], $message = [
            'title_persian.required' => 'عنوان مقاله الزامی است.',
            'title_persian.min' => 'حداقل ۵ کاراکتر.',
            'title_persian.max' => 'حداکثر ۳۰ کاراکتر.',

            'title_english.required' => 'عنوان مقاله الزامی است.',
            'title_english.min' => 'حداقل ۵ کاراکتر.',
            'title_english.max' => 'حداکثر ۳۰ کاراکتر.',

            'description.required' => 'توضیحات الزامی است.',
            'description.min' => 'حداقل ۱۰ کاراکتر',
            'description.max' => 'حداکثر تعداد کاراکتر.',

            'image.required' => 'انخاب عکس الزامی است.',
            'category.required' => 'انتخاب دسته بندی الزامی است.',

        ]);

        try {
            $article = Article::findOrFail($request->id);
            $image = GetImageName::imageName($request->image);
            DB::transaction(function () use ($article, $image, $request) {
                $article->title_persian = $request->title_persian;
                $article->title_english = $request->title_english;
                $article->short_description = $request->short_description;
                $article->description = $request->description;
                $article->image = $image;
                $article->user_id = Auth::guard('admin')->user()->id;
                $article->save();
                $article->categories()->sync($request->category);
                $article->tags()->sync($request->tag);

            });

            session()->flash('success', 'مقاله با موفقیت بروز رسانی شد.');
            return redirect()->route('admin.articleIndex');

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function activate(Article $article)
    {
        try {
            if ($article->approved == 0) {
                $article->approved = 1;
            } elseif ($article->approved == 1) {
                $article->approved = 0;
            }
            $article->save();;
            session()->flash('success', 'وصعیت انتشار با موفقیت بروز رسانی شد.');
            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'خطایی هنگام بروز رسانی رخ داده.');
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {

        try {
            $article = Article::findOrFail($request->id);
            $article->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }
}
