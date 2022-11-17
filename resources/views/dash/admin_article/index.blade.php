@extends('dash.include.master_dash')
@section('dash_page_title')
    مقالات
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center my-5">
            <div class="col-xl-12 col-lg-12  col-md-12 col-12 d-flex justify-content-end">
                <a href="{{ route('admin.articleCreate') }}" class="btn btn-primary">ایجاد مقاله جدید</a>
            </div>
        </div>
        <div class="row my-5">
            @if($last_article != null)
                <div class="col-xl-8 col-lg-8 col-md-8 last-article">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('storage/images/'.$last_article->image) }}" class="card-img-top"
                                 alt="image-article">
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $last_article->title_persian }}</h5>
                                <p class="card-text">{!! $last_article->short_description !!}</p>
                                <p class="card-text"><small
                                        class="article-date">{{ JDate($last_article->created_at)->format('Y/m/d') }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-xl-8 col-lg-8">
                        <div
                            class="alert d-flex justify-content-center border border-2 border-dark alert-light no-article">
                            <p class="text-center my-auto">مقاله ای وجود ندارد.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-4 article-section-index">
            @if($articles->count())
                @foreach($articles as $article)
                    <div class="col">
                        <div class="card w-100 h-100">
                            <img src="{{ asset('storage/images/'.$article->image) }}" class="card-img-top"
                                 alt="article-image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title_persian }}</h5>
                                <p class="card-text my-5">{!! $article->short_description !!}</p>

                                <div class="d-flex flex-column">
                                    @php
                                        $article_categories = array();
                                        foreach ($article->categories as $cat){
                                        array_push($article_categories,$cat->title_persian) ;
                                        }
                                    @endphp
                                    <h6>دسته بندی ها:</h6>
                                    <span
                                        class="mx-2 article-category">دسته {{ implode(' - ',$article_categories)}}</span>
                                </div>
                                <div class="d-flex flex-column my-2">
                                    @php
                                        $article_tags = array();
                                        foreach ($article->tags as $tag){
                                        array_push($article_tags,$tag->title_persian) ;
                                        }
                                    @endphp
                                    <h6>تگ ها :</h6>
                                    <span class="mx-2 article-tag">{{ implode(' - ',$article_tags)}}</span>
                                </div>
                                <div class="col-xl-12 d-flex justify-content-between mt-5 article-footer-card">
                                    <div class="col-xl-2  article-date d-flex align-content-center align-items-center">
                                        <p class="mt-3">
                                            <span>{{ JDate($last_article->created_at)->format('Y/m/d')}}</span>
                                        </p>
                                    </div>
                                    <div class="col-xl-10  d-flex justify-content-end  article-op">
                                        <a href="javascript:void(0)" onclick="return false" id="delete_item"
                                           class="btn btn-secondary btn-sm me-3"
                                           data-article="{{ $article->id }}">حذف</a>
                                        <a href="{{ route('admin.articleEdit',[$article]) }}"
                                           class="btn btn-info btn-sm me-3">ویرایش</a>
                                        <a href="{{ route('admin.articleActivate',[$article]) }}"
                                           class="btn btn-{{  $article->approved == 0 ? 'danger' : 'success' }} btn-sm">{{ $article->approved == 0 ? 'منتشر نشده' : 'منتشر شده' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="row d-flex justify-content-center my-5">
            <div class="col-xl-5 col-lg-5 my-5">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
@push('custom_scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#delete_item', function (event) {
                event.preventDefault();
                let id = event.target.getAttribute('data-article');
                Swal.fire({
                    title: 'آیا مطمئن هستید این ایتم حذف شود؟',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله حذف کن!',
                    cancelButtonText: 'خیر',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: 'GET',
                            url: '{{ route('admin.articleDelete') }}',
                            data: {id: id}
                        }).done(function (data) {
                            if (data['status'] === 404) {
                                Swal.fire({
                                    icon: 'warning',
                                    text: data['message'],
                                })
                            }
                            if (data['status'] === 202) {
                                swal.fire({
                                    icon: 'warning',
                                    text: data['message'],
                                })
                            }
                            if (data['status'] === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    text: data['message'],
                                })
                                setTimeout(function () {
                                    location.reload();
                                }, 1000)
                            }
                        }).fail(function (data) {
                            console.log(data);
                        })
                    }
                });
            });
        })
        @if(session()->has('success'))
        Toastify({
            text: '{{ session('success') }}',
            duration: 3000,
            gravity: "top",
            position: "center",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
        @php
            Session::forget('success');
        @endphp
        @elseif(session()->has('error'))
        Toastify({
            text: '{{ session('error') }}',
            duration: 3000,
            gravity: "top",
            position: "center",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
        @php
            Session::forget('error');
        @endphp
        @endif
    </script>
@endpush
