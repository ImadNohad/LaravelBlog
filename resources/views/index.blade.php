@extends('layouts.master')

@section('content')
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        @foreach ($articles as $item)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <article class="post-grid mb-5 ">
                                    <a class="post-thumb mb-4 d-block" href="{{ route('article.show', $item->id) }}">
                                        <img src="{{ $item->imageURL }}" alt="" class="img-fluid w-100">
                                    </a>

                                    <div class="post-content-grid">
                                        <div class="label-date">
                                            <span class="day">{{ $item->created_at->format('d') }}</span>
                                            <span class="month text-uppercase">{{ $item->created_at->format('M') }}</span>
                                        </div>
                                        <h3 class="post-title mt-1"><a
                                                href="{{ route('article.show', $item->id) }}">{{ $item->title }}</a></h3>
                                        <p>{!! Str::substr($item->contenu, 0, 120) !!}...</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="m-auto">
                    {{ $articles->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
