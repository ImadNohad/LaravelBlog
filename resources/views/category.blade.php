@extends('layouts.master')

@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h2 class="lg-title">{{ $category->nom }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section-padding">
        <div class="container">
            <div class="row">
                @foreach ($articles as $item)
                    <div class="col-lg-4 col-md-4">
                        <article class="post-grid mb-5 ">
                            <div class="post-thumb mb-4">
                                <a href="{{ route('article.show', $item->id) }}">
                                    <img src="{{ asset('storage/images/' . $item->imageURL) }}" alt=""
                                        class="img-fluid w-100">
                                </a>
                            </div>

                            <span class="cat-name text-color font-sm font-extra text-uppercase letter-spacing">
                                {{ $category->nom }}
                            </span>

                            <h3 class="post-title mt-1"><a
                                    href="{{ route('article.show', $item->id) }}">{{ $item->title }}</a></h3>

                            <span class=" text-muted  text-capitalize">
                                {{ $item->created_at->format('F d, Y') }}
                            </span>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="m-auto">
                {{ $articles->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
@endsection
