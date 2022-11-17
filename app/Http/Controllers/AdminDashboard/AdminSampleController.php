<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Sample;
use Illuminate\Http\Request;
use App\Services\GetImageName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminSampleController extends Controller
{

    public function index()
    {
        $samples = Sample::paginate(10);
        return view('dash.admin_sample.index')
            ->with('samples', $samples);
    }

    public function create()
    {
        $back_ends = DB::table('back_ends')
            ->select(['id', 'title_persian'])
            ->get();
        $front_ends = DB::table('front_ends')
            ->select(['id', 'title_persian'])
            ->get();
        return view('dash.admin_sample.create')
            ->with(['back_ends' => $back_ends, 'front_ends' => $front_ends]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title_persian' => ['required', 'min:3', 'max:50'],
            'title_english' => ['required', 'min:3', 'max:50'],
            'back_ends' => ['required'],
            'front_ends' => ['required'],
            'description' => ['required', 'min:3', 'max:5000'],
            'short_description' => ['required', 'min:3', 'max:500'],
            'main_image' => ['required'],
            'image1' => ['required'],
            'image2' => ['required'],
            'image3' => ['required'],
            'image4' => ['required']
        ], $messages = [
            'title_persian.required' => 'عنوان مقاله الزامی است.',
            'title_persian.min' => 'حداقل ۳ کاراکتر.',
            'title_persian.max' => 'حداکثر ۵۰ کاراکتر.',

            'title_english.required' => 'عنوان مقاله الزامی است.',
            'title_english.min' => 'حداقل ۳ کاراکتر.',
            'title_english.max' => 'حداکثر ۵۰ کاراکتر.',

            'back_ends.required' => 'زبان یا فریم ورک سمت سرور الرامی است.',
            'front_ends.required' => 'زبان یا فریم ورک سمت کاربر الرامی است.',

            'description.required' => 'توضیحات الزامی است.',
            'description.min' => 'حداقل ۱۰ کاراکتر',
            'description.max' => 'حداکثر تعداد کاراکتر.',

            'short_description.required' => 'توضیحات الزامی است.',
            'short_description.min' => 'حداقل ۱۰ کاراکتر',
            'short_description.max' => 'حداکثر ۵۰۰ کاراکتر.',

            'main_image.required' => 'تصویر اصلی الزامی است.',

            'image1.required' => 'تصویر نمونه شماره یک الزامی است.',
            'image2.required' => 'تصویر نمونه شماره دو الزامی است.',
            'image3.required' => 'تصویر نمونه شماره سه الزامی است.',
            'image4.required' => 'تصویر نمونه شماره چهار الزامی است.',

        ]);
        try {
            $image_samples = GetImageName::samplesMultiImage($request);
            $main_image = GetImageName::sampleMainImage($request->main_image);

            DB::transaction(function () use ($image_samples, $main_image, $request) {
              $sample =  Sample::create([
                    'title_persian' => $request->title_persian,
                    'title_english' => $request->title_english,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'user_id' => Auth::guard('admin')->user()->id,
                    'main_image' => $main_image,
                    'image1' => $image_samples[0],
                    'image2' => $image_samples[1],
                    'image3' => $image_samples[2],
                    'image4' => $image_samples[3],
                ]);

                $sample->backEnds()->sync($request->back_ends);
                $sample->frontEnds()->sync($request->front_ends);
            });


            session()->flash('success', 'نمونه کار جدید با موفقیت ایجاد شد.');
            return redirect()->route('admin.sampleIndex');
        } catch (\Exception $ex) {
//             return  $ex->getMessage();
            return view('errors_custom.model_store_error');
        }

    }

    public function edit(Sample $sample)
    {

        $back_ends = DB::table('back_ends')
            ->select(['id', 'title_persian'])
            ->get();
        $front_ends = DB::table('front_ends')
            ->select(['id', 'title_persian'])
            ->get();
        return view('dash.admin_sample.edit')
            ->with(['sample' => $sample, 'back_ends' => $back_ends, 'front_ends' => $front_ends]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_persian' =>
                ['required',Rule::unique('samples')->ignore($request->id), 'min:3', 'max:50'],
            'title_english' =>
                ['required',Rule::unique('samples')->ignore($request->id), 'min:3', 'max:50'],
            'back_ends' => ['required'],
            'front_ends' => ['required'],
            'description' => ['required', 'min:3', 'max:5000'],
            'short_description' => ['required', 'min:3', 'max:500'],
            'main_image' => ['required'],
            'image1' => ['required'],
            'image2' => ['required'],
            'image3' => ['required'],
            'image4' => ['required']
        ], $messages = [
            'title_persian.required' => 'عنوان مقاله الزامی است.',
            'title_persian.min' => 'حداقل ۳ کاراکتر.',
            'title_persian.max' => 'حداکثر ۵۰ کاراکتر.',

            'title_english.required' => 'عنوان مقاله الزامی است.',
            'title_english.min' => 'حداقل ۳ کاراکتر.',
            'title_english.max' => 'حداکثر ۵۰ کاراکتر.',

            'back_ends.required' => 'زبان یا فریم ورک سمت سرور الرامی است.',
            'front_ends.required' => 'زبان یا فریم ورک سمت کاربر الرامی است.',

            'description.required' => 'توضیحات الزامی است.',
            'description.min' => 'حداقل ۱۰ کاراکتر',
            'description.max' => 'حداکثر تعداد کاراکتر.',

            'short_description.required' => 'توضیحات الزامی است.',
            'short_description.min' => 'حداقل ۱۰ کاراکتر',
            'short_description.max' => 'حداکثر ۵۰۰ کاراکتر.',

            'main_image.required' => 'تصویر اصلی الزامی است.',

            'image1.required' => 'تصویر نمونه شماره یک الزامی است.',
            'image2.required' => 'تصویر نمونه شماره دو الزامی است.',
            'image3.required' => 'تصویر نمونه شماره سه الزامی است.',
            'image4.required' => 'تصویر نمونه شماره چهار الزامی است.',

        ]);

        try {

            $image_samples = GetImageName::samplesMultiImage($request);
            $main_image = GetImageName::sampleMainImage($request->main_image);

            DB::transaction(function () use ($request,$main_image,$image_samples) {

                $sample = Sample::findOrFail($request->id);
                $sample->title_persian = $request->title_persian;
                $sample->title_english = $request->title_english;
                $sample->short_description = $request->short_description;
                $sample->description = $request->description;
                $sample->user_id = Auth::guard('admin')->user()->id;
                $sample->main_image = $main_image;
                $sample->image1 = $image_samples[0];
                $sample->image2 = $image_samples[1];
                $sample->image3 = $image_samples[2];
                $sample->image4 = $image_samples[3];
                $sample->save();

                $sample->backEnds()->sync($request->back_ends);
                $sample->frontEnds()->sync($request->front_ends);

            });
            session()->flash('success', 'نمونه کار با موفقیت بروز رسانی شد.');
            return redirect()->route('admin.sampleIndex');
        } catch (\Exception $ex) {
            // return  $ex->getMessage();
            return view('errors_custom.model_store_error');
        }
    }

    public function activate(Sample $sample)
    {
        try {
            if ($sample->approved == 0) {
                $sample->approved = 1;
            } elseif ($sample->approved == 1) {
                $sample->approved = 0;
            }
            $sample->save();;
            session()->flash('success', 'وصعیت انتشار با موفقیت بروز رسانی شد.');
            return redirect()->back();
        } catch (\Exception $ex) {
            ;
            session()->flash('error', 'خطایی هنگام بروز رسانی رخ داده.');
            return redirect()->back();
        }
    }


    public function destroy(Request $request)
    {
        //
        try {
            $article = Sample::findOrFail($request->id);
            $article->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }


}
