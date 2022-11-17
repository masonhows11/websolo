@extends('dash.include.master_dash')
@section('dash_page_title')
   ویرایش دسته بندی
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center category-section-create">
            <div class="col-lg-4 col-md-5  col-sm-5 col-xs-5  category-create">
                <form action="{{ route('admin.categoryUpdate') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">عنوان دسته بندی به فارسی :</label>
                        <input type="text" name="title_persian" class="form-control @error('title_persian') is-invalid @enderror"
                               id="title" value="{{ $category->title_persian }}">
                    </div>
                    @error('title_persian')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">عنوان دسته بندی به انگلیسی:</label>
                        <input type="text" name="title_english" dir="ltr"
                               class="form-control @error('title_english') is-invalid @enderror text-left"
                               id="name" value="{{ $category->title_english }}">
                    </div>
                    @error('title_english')
                    <div class="alert alert-danger">{{ $message}}</div>
                    @enderror

                   {{-- @if($parent === null)
                    @else--}}
                    <div class="mb-3 mt-3">
                        <label for="parent" class="form-label">انتخاب دسته بندی والد:</label>
                        <select class="form-control" name="parent" id="parent">
                            @foreach($categories as $item)
                                @if($parent !== null)
                                    <option value="{{ $item->id }}" {{ $item->id === $parent->id ? 'selected' : '' }}>{{ $item->title_persian }}</option>
                                @else
                                    <option value="{{ $item->id }}" >{{ $item->title_persian }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                   {{-- @endif--}}
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                        <a href="{{ route('admin.categoryIndex') }}" class="btn btn-secondary">انصراف</a>
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
        $('.chosen-select').chosen({rtl: true,width: "100%"})
        // ckeditor
        CKEDITOR.replace('editor-text', {
            language: 'fa',
            removePlugins: 'image',
        });
        CKEDITOR.replace('short_description',{
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
