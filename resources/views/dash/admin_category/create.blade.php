@extends('dash.include.master_dash')
@section('dash_page_title')
    دسته بندی جدید
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center category-section-create">
            <div class="col-lg-4 col-md-5  col-sm-5 col-xs-5  category-create">
                <form action="{{ route('admin.categoryStore') }}" method="post">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">عنوان دسته بندی به فارسی :</label>
                        <input type="text" name="title_persian" class="form-control @error('title_persian') is-invalid @enderror"
                               id="title">
                    </div>
                    @error('title_persian')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">عنوان دسته بندی به انگلیسی:</label>
                        <input type="text" name="title_english" dir="ltr"
                               class="form-control @error('title_english') is-invalid @enderror text-left" id="name">
                    </div>
                    @error('title_english')
                    <div class="alert alert-danger">{{ $message}}</div>
                    @enderror
                    <div class="mb-3 mt-3">
                        <label for="parent" class="form-label">انتخاب دسته بندی والد:</label>
                        <select class="form-control" name="parent" id="parent">
                            <option></option>
                            @foreach($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->title_persian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                        <a href="{{ route('admin.categoryIndex') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
