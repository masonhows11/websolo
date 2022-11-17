@extends('dash.include.master_dash')
@section('dash_page_title')
     زبان جدید سمت سرور
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center tag-section-create">
            <div class="col-lg-4 col-md-5  col-sm-5 col-xs-5  category-create">
                <form action="{{ route('admin.backStore') }}" method="post">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="title_persian" class="form-label">عنوان زبان به فارسی :</label>
                        <input type="text" name="title_persian"
                               class="form-control @error('title_persian') is-invalid @enderror"
                               id="title_persian"
                               value="{{ old('title_persian') }}">
                    </div>
                    @error('title_persian')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3 mt-3">
                        <label for="title_english" class="form-label">عنوان زبان به انگلیسی:</label>
                        <input type="text" name="title_english" dir="ltr"
                               class="form-control @error('title_english') is-invalid @enderror text-left"
                               id="title_english"
                               value="{{ old('title_english') }}">
                    </div>
                    @error('title_english')
                    <div class="alert alert-danger">{{ $message}}</div>
                    @enderror


                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                        <a href="{{ route('admin.backIndex') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

