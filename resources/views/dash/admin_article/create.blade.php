@extends('dash.include.master_dash')
@section('dash_page_title')
    مقاله جدید
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row article-section-create">

            <div class="col-xl-10 col-lg-10 col-md-10">

                <form action="{{ route('admin.articleStore') }}" method="post">
                    @csrf

                    <div class="row">

                        <div class="col-xl-5 col-lg-5">
                            <div class="my-5">
                                <label for="title_persian" class="form-label">عنوان مقاله به فارسی :</label>
                                <input type="text" name="title_persian"
                                       class="form-control @error('title_persian') is-invalid @enderror"
                                       id="title_persian"
                                       value="{{ old('title_persian') }}">
                                @error('title_persian')
                                <div class="alert alert-danger my-5">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-5 col-lg-5">
                            <div class="my-5">
                                <label for="title_english" class="form-label">نام مقاله به انگلیسی :</label>
                                <input type="text" name="title_english"
                                       class="form-control text-left @error('title_english') is-invalid @enderror"
                                       id="title_english"
                                       value="{{ old('title_english') }}">
                                @error('title_english')
                                <div class="alert alert-danger my-5">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-5 col-lg-5 mt-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="button-image">انتخاب عکس
                                    </button>
                                </div>
                                <input type="text" id="image_label"
                                       class="form-control @error('image') is-invalid @enderror" name="image"
                                       aria-label="Image" aria-describedby="button-image">
                            </div>
                            @error('image')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="row d-flex flex-column my-5">

                        <div class="col-lg-5  d-flex flex-column my-5">
                            <label for="tag-select" class="form-label">انتخاب تگ :</label>
                            <select class="chosen-select form-select" multiple data-placeholder="انتخاب تگ...."
                                    id="tag-select" name="tag[]">
                                <option value="0"></option>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->title_persian }}</option>
                                @endforeach
                            </select>
                            @error('tag')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-lg-5  d-flex flex-column my-5">
                            <label for="category-select" class="form-label">انتخاب دسته بندی :</label>
                            <select class="chosen-select form-select"
                                    multiple data-placeholder="انتخاب دسته بندی...."
                                    id="category-select"
                                    name="category[]">
                                <option value="0"></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title_persian }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>


                    <div class="form-group my-5">
                        <label for="short_description" class="form-label">خلاصه:</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                  id="short_description"
                                  name="short_description">{{ old('short_description') }}</textarea>
                    </div>
                    @error('short_description')
                    <div class="alert alert-danger my-5">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group my-5">
                        <label for="editor-text" class="form-label">توضیحات:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="editor-text"
                                  name="description">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                    <div class="alert alert-danger my-5">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-group my-5">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                        <a href="{{ route('admin.articleIndex') }}" class="btn btn-secondary">انصراف</a>
                    </div>


                </form>

            </div>
        </div>

    </div>
@endsection
@push('custom_scripts')
    <script type="text/javascript" src="{{ asset('assets/dash/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script>
        // chosen
        $('.chosen-select').chosen({rtl: true, width: "100%"})
        // ckeditor
        CKEDITOR.replace('editor-text', {
            language: 'fa',
            removePlugins: 'image',
        });
        CKEDITOR.replace('short_description', {
            language: 'fa',
            removePlugins: 'image',
        })
        // file manager
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('button-image').addEventListener('click', (event) => {
                event.preventDefault();
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
        });

        // set file link
        function fmSetLink($url) {
            document.getElementById('image_label').value = $url;
        }
    </script>
@endpush
