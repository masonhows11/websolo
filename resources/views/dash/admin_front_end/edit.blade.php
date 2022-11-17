@extends('dash.include.master_dash')
@section('dash_page_title')
    ویرایش زبان سمت کاربر
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center tag-section-create">
            <div class="col-lg-4 col-md-5  col-sm-5 col-xs-5  category-create">
                <form action="{{ route('admin.frontUpdate') }}" method="post">
                    @csrf

                    <input type="hidden" name="id" value="{{ $frontEnd->id }}">
                    <div class="mb-3 mt-3">
                        <label for="title_persian" class="form-label">عنوان تگ به فارسی :</label>
                        <input type="text" name="title_persian" class="form-control @error('title_persian') is-invalid @enderror"
                               id="title_persian" value="{{ $frontEnd->title_persian }}">
                    </div>
                    @error('title_persian')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3 mt-3">
                        <label for="title_english" class="form-label">عنوان تگ به انگلیسی:</label>
                        <input type="text" name="title_english" dir="ltr"
                               class="form-control @error('title_english') is-invalid @enderror text-left"
                               id="title_english" value="{{ $frontEnd->title_english }}">
                    </div>
                    @error('title_english')
                    <div class="alert alert-danger">{{ $message}}</div>
                    @enderror


                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                        <a href="{{ route('admin.frontIndex') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

