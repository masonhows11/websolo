@extends('dash.include.master_dash')
@section('dash_page_title')
    لیست نمونه کارها
@endsection
@section('dash_main_content')
    <div class="container">
        <div class="row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-1  articles-page">
            @if (isset($samples))
                @if ($samples->count())
                    @foreach ($samples as $sample)
                        <div class="col my-2">
                            <div class="wk-article-card d-flex flex-column h-100">

                                <div class="wk-article-img-card rounded">
                                    <img src="{{ asset('storage/samples/'.$sample->main_image) }}"
                                         class="img-fluid rounded" alt="sample-image"/>
                                </div>

                                <div class="wk-article-card-body mt-2">
                                    <div class="wk-article-card-title  my-1"><h5>{{ $sample->title_persian }}</h5></div>
                                    <div class="wk-article-card-text my-1">
                                        <div class="desc">
                                            {!! $sample->short_description !!}
                                        </div>
                                    </div>
                                    <div class="wk-article-card-footer d-flex justify-content-end my-1">
                                        <a class="btn btn-list-comment" href="{{ route('admin.sampleComments',[$sample]) }}">لیست نظرات</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 d-flex justify-content-center">
                {{ $samples->links() }}
            </div>
        </div>
    </div>
@endsection

