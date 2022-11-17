@extends('dash.include.master_dash')
@section('dash_page_title')
   ویرایش نمونه کار
@endsection
@section('dash_main_content')
    <div class="container-fluid">


        <div class="sample-section-create">


            <form action="{{ route('admin.sampleUpdate') }}" method="post">
                @csrf

                <div class="row d-flex flex-column row-cols-xxl-2 row-cols-xl-2 row-cols-lg-2 row-cols-md-1 row-cols-1">
                    <div class="col">

                        <input type="hidden" value="{{ $sample->id }}" name="id">
                        <div class="my-5">
                            <label for="title_persian" class="form-label">عنوان نمونه کار ( فارسی )</label>
                            <input type="text" class="form-control @error('title_persian') is-invalid @enderror"
                                   id="title_persian" name="title_persian" value="{{ $sample->title_persian}}">
                            @error('title_persian')
                            <div class="alert alert-danger mt-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="my-5">
                            <label for="title_english" class="form-label">عنوان نمونه کار (انگلیسی )</label>
                            <input type="text" class="form-control @error('title_english') is-invalid @enderror"
                                   id="title_english" name="title_english" value="{{ $sample->title_english }}">
                            @error('title_english')
                            <div class="alert alert-danger mt-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="my-5">
                            <label for="back-end" class="form-label">زبان یا فریم ورک سمت سرور
                                (back-end)</label>
                            <select type="text" multiple class="form-control chosen-select" id="back-end"
                                    name="back_ends[]">
                                @foreach($back_ends as $lang)
                                    <option value="{{ $lang->id }}" {{ in_array($lang->id,$sample->backEnds()->pluck('back_end_id')->toArray())? 'selected' :''}}>
                                        {{ $lang->title_persian }}
                                    </option>
                                @endforeach
                            </select>
                            @error('back_ends')
                            <div class="alert alert-danger mt-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="my-5">
                            <label for="front-end" class="form-label">زبان یا فریم ورک سمت کاربر
                                (front-end)</label>
                            <select type="text" multiple class="form-control chosen-select" id="front-end"
                                    name="front_ends[]">

                                @foreach($front_ends as $lang)
                                    <option value="{{ $lang->id }}" {{ in_array($lang->id,$sample->frontEnds()->pluck('front_end_id')->toArray())? 'selected' :''}}>
                                        {{ $lang->title_persian }}
                                    </option>
                                @endforeach
                            </select>
                            @error('front_ends')
                            <div class="alert alert-danger mt-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="row main-image-select">
                    <div class="col-xl-6 mt-5">
                        <label for="button-image" class="form-label">عکس اصلی :</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="button-image-main">انتخاب عکس
                                </button>
                            </div>
                            <input type="text" id="main_image"
                                   class="form-control @error('image') is-invalid @enderror" name="main_image"
                                   aria-label="Image" aria-describedby="button-image" value="{{ $sample->main_image }}">
                        </div>
                        @error('main_image')
                        <div class="alert alert-danger my-5">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row d-flex flex-column sample-image-multi-select">
                    <div class="col-xl-6 col-lg-6 col-md-5 col">
                        <div class="col mt-5">
                            <label for="button-image" class="form-label">عکس نمونه شماره یک:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="button-image1">انتخاب عکس
                                    </button>
                                </div>
                                <input type="text" id="image1"
                                       class="form-control @error('image1') is-invalid @enderror"
                                       name="image1" aria-label="Image1" aria-describedby="button-image" value="{{ $sample->image1 }}">
                            </div>
                            @error('image1')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col mt-5">
                            <label for="button-image" class="form-label">عکس نمونه شماره دو:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="button-image2">انتخاب عکس
                                    </button>
                                </div>
                                <input type="text" id="image2"
                                       class="form-control @error('image2') is-invalid @enderror"
                                       name="image2"
                                       aria-label="Image2"
                                       aria-describedby="button-image"
                                       value="{{ $sample->image2 }}">
                            </div>
                            @error('image2')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col mt-5">
                            <label for="button-image" class="form-label">عکس نمونه شماره سه:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="button-image3">انتخاب عکس
                                    </button>
                                </div>
                                <input type="text" id="image3"
                                       class="form-control @error('image3') is-invalid @enderror"
                                       name="image3"
                                       aria-label="Image3"
                                       value="{{ $sample->image3 }}">
                            </div>
                            @error('image3')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col mt-5">
                            <label for="button-image" class="form-label">عکس نمونه شماره چهار:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="button-image4">انتخاب عکس
                                    </button>
                                </div>
                                <input type="text" id="image4"
                                       class="form-control @error('image4') is-invalid @enderror"
                                       name="image4"
                                       aria-label="Image4"
                                       aria-describedby="button-image"
                                       value="{{ $sample->image4 }}">
                            </div>
                            @error('image4')
                            <div class="alert alert-danger my-5">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        <div class="form-group my-5">
                            <label for="desc-editor-text" class="form-label">خلاصه</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror"
                                      id="desc-editor-text"
                                      name="short_description">{{ $sample->short_description }}</textarea>
                        </div>
                        @error('short_description')
                        <div class="alert alert-danger my-5">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10">
                        <div class="form-group my-5">
                            <label for="editor-text" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="editor-text"
                                      name="description">{{ $sample->description }}</textarea>
                        </div>
                        @error('description')
                        <div class="alert alert-danger my-5">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-8 d-flex justify-content-start">
                        <div class="me-2">
                            <button type="submit" class="btn  btn-success">ذخیره</button>
                        </div>
                        <div>
                            <a href="{{ route('admin.sampleIndex') }}" class="btn  btn-secondary">بازگشت</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="col">
                   <div class="my-5">
                       <label for="main_image" class="form-label">تصویر اصلی</label>
                       <input type="file" id="main_image" class="form-control @error('main_image') is-invalid @enderror" name="main_image" accept="image/x-png,image/gif,image/jpeg">
                       @error('main_image')
                       <div class="alert alert-danger mt-5">
                           {{ $message }}
                       </div>
                       @enderror
                   </div>
               </div>
               <div class="col d-flex justify-content-end main-image-preview">
                   <div class="my-3">
                       <img src="{{ asset('assets/dash/images/no-image-icon-23494.png') }}" id="image_view" class="img-thumbnail" height="220" width="200" alt="image">
                   </div>
               </div>

              <div class="row">
                   <div class="col-lg-10">
                       <div class="row">
                           <div class="my-5">
                               <label for="gallery" class="form-label">گالری</label>
                               <input type="file" class="form-control @error('gallery') is-invalid @enderror" name="gallery" id="gallery_select" accept="image/x-png,image/gif,image/jpeg" multiple>
                               @error('gallery')
                               <div class="alert alert-danger mt-5">
                                   {{ $message }}
                               </div>
                               @enderror
                           </div>
                           <div class="my-3">
                               <div class="col-lg-8" id="result">
                                   <img src="{{ asset('assets/dash/images/no-image-icon-23494.png') }}" id="gallery_view"
                                   class="img-thumbnail" height="220" width="200" alt="image">
                               </div>
                           </div>
                       </div>
                   </div>
               </div>--}}
@endsection
@push('custom_scripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dash/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        // ckeditor
        CKEDITOR.replace('editor-text', {
            language: 'fa',
            removePlugins: 'image',
        });
        CKEDITOR.replace('desc-editor-text', {
            language: 'fa',
            removePlugins: 'image',
        });
        // chosen
        $('.chosen-select').chosen({rtl: true, width: "100%"})
    </script>
    {{--   <script>
          $(document).ready(function () {

               const input = document.getElementById("main_image");
               const previewImage = document.getElementById("image_view");
               input.addEventListener("change", function () {
                   const file = this.files[0];
                   if (file) {
                       const reader = new FileReader();
                       reader.addEventListener("load", function () {
                           previewImage.setAttribute("src", this.result);
                       });
                       reader.readAsDataURL(file);
                   }
               });
           })
       </script>
       <script>
           document.querySelector("#gallery_select").addEventListener("change", (e) => {
               if (window.File && window.FileReader && window.FileList && window.Blob) {
                   const files = e.target.files;
                   const output = document.querySelector("#result");
                   output.innerHTML = "";
                   for (let i = 0; i < files.length; i++) {
                       if (!files[i].type.match("image")) continue;
                       const picReader = new FileReader();
                       picReader.addEventListener("load", function (event) {
                           const picFile = event.target;
                           const div = document.createElement("div");
                           div.innerHTML = `<img class="img-thumbnail" height="220" width="200" src="${picFile.result}" title="${picFile.name}"/>`;
                           output.appendChild(div);
                       });
                       picReader.readAsDataURL(files[i]);
                   }
               } else {
                   alert("Your browser does not support File API");
               }
           });
       </script>--}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            document.getElementById('button-image-main').addEventListener('click', (event) => {
                event.preventDefault();
                inputId = 'main_image';
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });

            document.getElementById('button-image1').addEventListener('click', (event) => {
                event.preventDefault();
                inputId = 'image1';
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
            // second button
            document.getElementById('button-image2').addEventListener('click', (event) => {
                event.preventDefault();
                inputId = 'image2';
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
            // third button
            document.getElementById('button-image3').addEventListener('click', (event) => {
                event.preventDefault();
                inputId = 'image3';
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
            // forth button
            document.getElementById('button-image4').addEventListener('click', (event) => {
                event.preventDefault();
                inputId = 'image4';
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
        });

        // input
        let inputId = '';

        // set file link
        function fmSetLink($url) {
            document.getElementById(inputId).value = $url;
        }

        // file manager
        /*  document.addEventListener("DOMContentLoaded", function () {
              document.getElementById('button-image').addEventListener('click', (event) => {
                  event.preventDefault();
                  window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
              });
          });

          // set file link
          function fmSetLink($url) {
              document.getElementById('image_label').value = $url;
          }*/
    </script>

@endpush

