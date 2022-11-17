@extends('dash.include.master_dash')
@section('dash_page_title')
    لیست نمونه کارها
@endsection
@section('dash_main_content')
    <div class="container-fluid">


        <div class="row d-flex justify-content-center my-5">
            <div class="col-xl-12 col-lg-12  col-md-12 col-12 d-flex justify-content-start">
                <a href="{{ route('admin.sampleCreate') }}" class="btn btn-primary">ایجاد نمونه کار جدید</a>
            </div>
        </div>
        @if ($samples->count())
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4 g-2 sample-section-index">
                @foreach ($samples as $sample)
                    <div class="col">
                        <div class="card  h-100">
                            <img src="{{ asset('storage/samples/' . $sample->main_image) }}"
                                 class="card-img-top"
                                 alt="sample-image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $sample->title_persian }}</h5>
                                <p class="card-text my-5">{!! $sample->short_description !!}</p>
                                <div class="d-flex flex-column">
                                    <h6>بک اند :</h6>
                                    @foreach($sample->backEnds as $lng)
                                        <ul class="list-group list-group-horizontal">
                                            <li class="list-group-item">{{ $lng->title_persian }}</li>
                                        </ul>

                                    @endforeach
                                </div>
                                <div class="d-flex flex-column my-2">
                                    <h6>فرانت اند :</h6>
                                    @foreach($sample->frontEnds as $lng)
                                      <ul class="list-group list-group-horizontal">
                                          <li class="list-group-item">{{ $lng->title_persian }}</li>
                                      </ul>
                                    @endforeach
                                </div>
                                <div class="col-xl-12 d-flex justify-content-between mt-5 article-footer-card">
                                    <div class="col-xl-2  article-date d-flex align-content-center align-items-center">
                                        <p class="mt-3">
                                            <span>{{ jDate($sample->created_at)->format('Y/m/d') }}</span>
                                        </p>
                                    </div>
                                    <div class="col-xl-10  d-flex justify-content-end  article-op">
                                        <a href="javascript:void(0)" onclick="return false" id="delete_item"
                                           class="btn btn-secondary btn-sm me-3" data-sample="{{ $sample->id }}">حذف</a>
                                        <a href="{{ route('admin.sampleEdit', [$sample]) }}"
                                           class="btn btn-info btn-sm me-3">ویرایش</a>
                                        <a href="{{ route('admin.sampleActivate', [$sample]) }}"
                                           class="btn btn-{{ $sample->approved == 0 ? 'danger' : 'success' }} btn-sm">{{ $sample->approved == 0 ? 'منتشر نشده' : 'منتشر شده' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-xl-8 col-lg-8">
                    <div class="alert d-flex justify-content-center border border-2 border-dark alert-light no-article">
                        <p class="text-center my-auto">نمونه کاری وجود ندارد.</p>
                    </div>
                </div>
            </div>
        @endif


        <div class="row d-flex justify-content-center my-5">
            <div class="col-xl-5 col-lg-5 my-5">
                {{ $samples->links() }}
            </div>
        </div>


    </div>
@endsection
@push('custom_scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#delete_item', function (event) {
                event.preventDefault();
                let id = event.target.getAttribute('data-sample');
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
                            url: '{{ route('admin.sampleDelete') }}',
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
