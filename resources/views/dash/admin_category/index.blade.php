@extends('dash.include.master_dash')
@section('dash_page_title')
    دسته بندی ها
@endsection
@section('dash_main_content')
    <div class="container-fluid">

        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-lg-8  col-md-2 col-sm-2">
                <a href="{{ route('admin.categoryCreate') }}" class="btn btn-primary">ایجاد دسته بندی جدید</a>
            </div>
        </div>

        <div class="row d-flex justify-content-center  mt-5 category-section-index">
            <div class="col-xl-8 col-lg-8 col-sm-6 col-xs-10">
                @if($categories->isEmpty())
                    <div class="alert d-flex justify-content-center border border-2 border-dark alert-light no-categories">
                        <p class="text-center my-auto">دسته بندی وجود ندارد.</p>
                    </div>
                @else
                    <div class="category-content">
                        @foreach($categories as $item)
                            <div id="accordion">
                                <div class="card mt-4">
                                    <div class="card-header item-category bg-secondary">
                                        <div class="item-category-title">
                                            <a class="btn my-3 text-black" href="#collapse{{ $item->id }}"
                                               data-bs-toggle="collapse"><h6>{{ $item->title_persian }}</h6></a>

                                        </div>

                                        <div class="item-category-actions  my-5">
                                            <a href="{{ route('admin.categoryActivate',[$item]) }}"
                                               class="mx-5 btn {{ $item->is_active == 1 ? 'btn-success' : 'btn-danger' }} btn-sm" >{{ $item->is_active == 1 ? 'فعال' : 'غیر فعال' }}</a>
                                            @if($item->parent_id == null)
                                                <a href="{{ route('admin.categoryEdit',[$item]) }}" class="mx-4"><i class="fas fa-edit"></i></a>
                                            @else
                                                <a href="{{ route('admin.categoryEdit',[$item]) }}"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('admin.categoryDetach',[$item]) }}" class="mx-4"><i class="fa fa-unlink"></i></a>
                                                <a href="#"><i class="fas fa-trash" id="delete_item" data-cat="{{ $item->id }}"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse show" id="collapse{{$item->id}}">
                                    @if(!$item->chlidren)
                                        @include('dash.admin_category.child_category',['child'=>$item->children])
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                @endif
            </div>
        </div>

    </div>
@endsection
@push('custom_scripts')
    <script>
        $(document).ready(function () {

            $(document).on('click', '#delete_item', function (event) {
                event.preventDefault();
                let id = event.target.getAttribute('data-cat');
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
                            url: '{{ route('admin.categoryDelete') }}',
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
