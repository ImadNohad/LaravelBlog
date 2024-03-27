@extends('layouts.master')

@section('content')
    <section class="section-padding pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <article class="post-list mb-5 pb-4 border-bottom">
                    </article>

                    @foreach ($articles as $item)
                        <div class="mb-4 post-list border-bottom pb-4">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <a class="post-thumb" href="{{ route('article.show', $item->id) }}">
                                        <img src="{{ $item->image }}" alt="" class="img-fluid w-100" />
                                    </a>
                                </div>

                                <div class="col-md-7">
                                    <div class="post-article mt-sm-3">
                                        <h3 class="post-title mt-2">
                                            <a href="{{ route('article.show', $item->id) }}">{{ $item->title }}</a>
                                        </h3>

                                        <div class="post-content">
                                            <p>
                                                {{ Str::substr($item->content, 0, 120) }}...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pagination mt-5 pt-4">
                        {{ $articles->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
