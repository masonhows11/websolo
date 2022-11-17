@extends('dash.include.master_dash')
@section('dash_page_title')
    کاربران
@endsection
@section('dash_main_content')
    <div class="container">

        <div class="row admin-list-users d-flex justify-content-center align-content-center align-items-center">
            <div class="col-xl-7 col-lg-7 col-md-7 list-content bg-white rounded-3">
                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th>شناسه</th>
                        <th>نام کاربری</th>
                        <th>ایمیل</th>
                        <th>موبایل</th>
                        <th>حذف</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @isset($users)
                        @foreach($users as $user)
                            <tr class="text-center">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td><a href=""><i id="delete_item" data-user="{{ $user->id }}" class="fa  fa-trash"></i></a>
                                </td>
                                <td class="mb-3"><a href="{{ route('admin.adminUserStatus',[$user]) }}" class="btn {{ $user->banned == 0 ? 'btn-success' : 'btn-danger' }} btn-sm mb-3">{{ $user->banned == 0 ? 'فعال' : 'غیر فعال' }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>

            <div class="col-xl-7 col-lg-7 col-md-7 mt-2">
                {{ $users->links() }}
            </div>

        </div>

    </div>
@endsection
@push('custom_scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#delete_item', function (event) {
                event.preventDefault();
                let id = event.target.getAttribute('data-user');
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
                            url: '{{ route('admin.adminUserDestroy') }}',
                            data: {id: id}
                        }).done(function (data) {
                            if (data['status'] === 404) {
                                Swal.fire({
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
