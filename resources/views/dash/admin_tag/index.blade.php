@extends('dash.include.master_dash')
@section('dash_page_title')
    لیست  تگ ها
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-lg-8  col-md-2 col">
                <a href="{{ route('admin.tagCreate') }}" class="btn btn-primary">ایجاد تگ جدید</a>
            </div>
        </div>

        @if($tags->isEmpty())
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-xl-8 col-lg-8 col-sm-6 col-xs-10">
                    <div class="alert d-flex justify-content-center border border-2 border-dark alert-light no-tag">
                        <p class="text-center my-auto">تگی وجود ندارد.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="row d-flex justify-content-center  mt-5 tag-section-index">
                <div class="col-xl-8 col-lg-8 col-md-8 list-content bg-white rounded-3">
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th>شناسه</th>
                            <th>نام تگ (فارسی)</th>
                            <th>نام  تگ (انگلیسی)</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                            <tr class="text-center">
                                <td>{{ $tag->id }}</td>
                                <td>{{ $tag->title_persian }}</td>
                                <td>{{ $tag->title_english }}</td>
                                <td><a href="{{ route('admin.tagEdit',[$tag]) }}"><i class="fas fa-edit"></i></a></td>
                                <td><a href=""><i id="delete_item" data-tag="{{ $tag->id }}" class="fa  fa-trash"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 mt-2">
                    {{ $tags->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
@push('custom_scripts')
    <script>
        $(document).ready(function () {

            $(document).on('click', '#delete_item', function (event) {
                event.preventDefault();
                let id = event.target.getAttribute('data-tag');
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
                            url: '{{ route('admin.tagDelete') }}',
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
        @endif
    </script>

@endpush
