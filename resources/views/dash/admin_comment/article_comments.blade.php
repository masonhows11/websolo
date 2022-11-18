@extends('dash.include.master_dash')
@section('dash_page_title')
    لیست نظرات
@endsection
@section('dash_main_content')
    <div class="container">
        <div class="row d-flex flex-column list-unapproved-comments">


            <div class="col-md-4 post-card-section">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('/storage/images/' . $article->image) }}" class="img-fluid card-img-top"
                                 alt="article-image">
                            <div class="card-body mt-3 comment-post-title">
                                <h4 class="card-title">{{ $article->user->name }}</h4>
                                <h5 class="card-title">{{ $article->title_persian }}
                                    - {{ $article->title_english }}</h5>
                                <p>{!! substr($article->short_description, 0, 200) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($article->comments->count() != null)
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item mt-5">
                        <div class="accordion-header border border-2" id="headingOne">
                            <bottun class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $article->id }}" aria-expanded="true" aria-controls="collapseOne">
                            </bottun>
                        </div>
                        <div id="collapse-{{ $article->id }}" class="accordion-collapse collapse {{ $article->comments->count() >= 1 ? 'show' : '' }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @foreach ($article->comments as $comment)
                                    <div class="d-flex flex-row p-3 h-auto">
                                        <div class="w-100 border border-1 p-4 rounded-3 bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex flex-row align-items-center"><span
                                                        class="mr-2 comment-user">{{ $comment->user->name }}</span>
                                                </div>
                                            </div>
                                            <p class="text-justify comment-text mt-4 mb-0">
                                                {{ $comment->body }}
                                            </p>
                                            <div class="comment-operation">
                                                <div class="mbt-3 mt-3 p-4 d-flex flex-row">
                                                    <button type="button" data-comment="{{ $comment->id }}"
                                                            class="btn btn-danger btn-sm me-7" id="delete_comment">
                                                        حذف
                                                    </button>
                                                    <button type="button" data-comment="{{ $comment->id }}"
                                                            class="btn {{ $comment->approved === 0 ? 'btn-danger' : 'btn-success' }}  btn-sm"
                                                            id="approved_comment">
                                                        {{ $comment->approved === 0 ? 'تایید نشده' : 'تایید شده' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="alert alert-light mt-5 border border-3">
                        <strong> برای این مقاله دیدگاهی ثبت نشده.</strong>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('custom_scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#approved_comment', function (event) {
                event.preventDefault();
                let comment_id = event.target.getAttribute('data-comment');
                $.ajaxSetup({
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                });
                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.articleApproveComment') }}',
                    data: {id: comment_id},
                }).done(function (data) {
                    if (data['status'] === 404) {
                        swal.fire({icon: 'info', text: data['message'],})
                    }
                    if (data['status'] === 200) {
                        if (data['publish'] === 1) {
                            event.target.innerText = 'تایید شده';
                            event.target.classList.remove('btn-danger');
                            event.target.classList.add('btn-success');
                        }
                        if (data['publish'] === 0) {
                            event.target.innerText = 'تایید نشده';
                            event.target.classList.remove('btn-success');
                            event.target.classList.add('btn-danger');
                        }
                    }
                }).fail(function (data) {
                    swal.fire({icon: 'alert', text: data['message'],})
                })
            });
            // end approve comment
            $(document).on('click', '#delete_comment', function (event) {
                event.preventDefault();
                let comment_id = event.target.getAttribute('data-comment');
                swal.fire({
                    title: 'آیا مطمئن هستید این ایتم حذف شود؟',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله حذف کن!',
                    cancelButtonText: 'خیر',
                }).then((result) => {
                    // confirmed scope start
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        });
                        $.ajax({
                            method: 'GET',
                            url: '{{ route('admin.articleDeleteComment') }}',
                            data: {id: comment_id},
                        }).done(function (data) {
                            if (data['status'] === 404) {
                                swal.fire({icon: 'warning', text: data['message'],})}
                            if (data['status'] === 200) {
                                swal.fire({icon: 'success', text: data['message'],})
                                setTimeout(() => {location.reload()}, 1000);
                            }
                        }).fail(function (data) {
                            if (data['status'] === 500) {
                                swal.fire({icon: 'error', text: data['message'],})
                            }
                        })
                    }
                })
                // end delete comment
            })
        })
    </script>
@endpush
