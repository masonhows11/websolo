@extends('front.include.master_front')
@section('page_title')
    خانه
@endsection
@section('main_content')
    <!-- articles -->
    <div class="article-wrapper">
        <div class="container articles">
            <div class="section-title">
                <h5 class="section-title-content text-center">مقالات</h5>
            </div>
            <div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 py-4 px-4 article-content">
                @if(isset($articles))
                    @if($articles->count())
                        @foreach($articles as $article)
                            <div class="col my-2">
                                <div class="wk-article-card d-flex flex-column h-100">
                                    <div class="wk-article-img-card">
                                        <img src="{{ asset('storage/images/' . $article->image) }}"
                                             class="img-fluid rounded" alt="article-image"/>
                                    </div>
                                    <div class="wk-article-card-body">
                                        <div class="wk-article-card-title pt-3"><h5>{{ $article->title_persian }}</h5></div>
                                        <div class="wk-article-card-text my-1">
                                            <div class="desc">
                                                {!! $article->short_description !!}
                                            </div>
                                        </div>
                                        <div class="wk-article-card-footer d-flex justify-content-between my-1">
                                            <div class="py-2 px-2 wk-article-date"><i class="fa-regular fa-clock"></i>{{ jDate($article->created_at)->ago()  }}</div>
                                            <div><a class="btn wk-article-continue" href="{{ route('article', [$article]) }}">ادامه....</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
    <!-- sample-project  -->
    <div class="sample-wrapper">

        <div class="container sample-project">

            <div class="section-title">
                <h5 class="section-title-content text-center">
                    نمونه کارها
                </h5>
            </div>

            <div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 py-4 px-4  sample-content">
                @if(isset($samples))
                    @if($samples->count())
                        @foreach($samples as $sample)
                            <div class="col my-2">
                                <div class="wk-article-card d-flex flex-column h-100">
                                    <div class="wk-article-img-card">
                                        <img src="{{ asset('storage/samples/'. $sample->main_image) }}"
                                             class="img-fluid rounded" alt="sample-image"/>
                                    </div>
                                    <div class="wk-article-card-body">
                                        <div class="wk-article-card-title pt-3"><h5>{{ $sample->title_persian }}</h5></div>
                                        <div class="wk-article-card-text my-1">
                                            <div class="desc">
                                                {!! $sample->short_description !!}
                                            </div>
                                        </div>
                                        <div class="wk-article-card-footer d-flex justify-content-between my-1">
                                            <div class="py-2 px-2 wk-article-date"><i class="fa-regular fa-clock"></i>{{ jDate($sample->created_at)->ago()  }}</div>
                                            <a class="btn wk-article-continue" href="{{ route('sample', [$sample]) }}">ادامه....</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endisset
            </div>
        </div>
    </div>


    <!--  project-done  -->
    <div class="project-wrapper">
        <div class="container project-done">
            <div class="section-title">
                <h5 class="section-title-content text-center">
                    پروژه ها
                </h5>
            </div>
            <div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 py-4 px-4 project-content">
                <div class="main-content col my-2">
                    <div class="card">
                        <img
                            src="images/image-article-test.jpg"
                            class="card-img-top"
                            alt="project-image"
                        />
                        <div class="card-body">
                            <div class="card-text text-muted">
                                <p class="desc">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم.
                                </p>
                                <p class="continue">
                                    <a class="btn btn-light" href="#">ادامه....</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content col my-2">
                    <div class="card">
                        <img
                            src="images/image-article-test.jpg"
                            class="card-img-top"
                            alt=""
                        />
                        <div class="card-body">
                            <div class="card-text text-muted">
                                <p class="desc">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم.
                                </p>
                                <p class="continue">
                                    <a class="btn btn-light" href="#">ادامه....</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content my-2">
                    <div class="card">
                        <img
                            src="images/image-article-test.jpg"
                            class="card-img-top"
                            alt=""
                        />
                        <div class="card-body">
                            <div class="card-text text-muted">
                                <p class="desc">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم.
                                </p>
                                <p class="continue">
                                    <a class="btn btn-light" href="#">ادامه....</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content col my-2">
                    <div class="card">
                        <img
                            src="images/image-article-test.jpg"
                            class="card-img-top"
                            alt=""
                        />
                        <div class="card-body">
                            <div class="card-text text-muted">
                                <p class="desc">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم.
                                </p>
                                <p class="continue">
                                    <a class="btn btn-light" href="#">ادامه....</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
