@extends('layouts.master')

@section('content')
    <section class="single-block-wrapper section-padding">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="single-post">
                        <div class="post-header mb-5 text-center">
                            <h2 class="post-title mt-2">
                                {{ $article->title }}
                            </h2>

                            <div class="post-meta">
                                <span class="text-uppercase font-sm letter-spacing-1 mr-3">by
                                    {{ $article->user->name }}</span>
                                <span
                                    class="text-uppercase font-sm letter-spacing-1">{{ $article->created_at->format('F d,Y') }}</span>
                            </div>

                            <div class="post-featured-image mt-5">
                                <img src="{{ $article->imageURL }}" class="img-fluid w-100" alt="featured-image">
                            </div>
                        </div>

                        <div class="post-body">
                            <div class="entry-content">
                                {!! $article->contenu !!}
                            </div>

                            <div
                                class="tags-share-box center-box d-flex text-center justify-content-between border-top border-bottom py-3">
                                <span class="single-comment-o"><i
                                        class="fa fa-comment-o"></i>{{ $article->commentaires->count() }}
                                    {{ $article->commentaires->count() > 1 ? 'comments' : 'comment' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="post-author d-flex my-5">
                        <div class="author-img">
                            <img alt="" src="{{ asset('images/' . $article->user->imageURL) }}"
                                class="avatar avatar-100 photo" width="100" height="100">
                        </div>

                        <div class="author-content pl-4">
                            <h4 class="mb-3"><a href="#" title="" rel="author"
                                    class="text-capitalize">{{ $article->user->name }}</a></h4>
                            <p>{{ $article->user->bio }}</p>
                        </div>
                    </div>

                    <div class="comment-area my-5">
                        <h3 class="mb-4 text-center">{{ $article->commentaires->count() }}
                            {{ $article->commentaires->count() > 1 ? 'Comments' : 'Comment' }}</h3>

                        @foreach ($article->commentaires as $comment)
                            <div class="comment-area-box media {{ $loop->first ? 'mt-5' : '' }}">
                                <img alt="" src="{{ asset('images/blog-user-' . rand(2, 3) . '.jpg') }}"
                                    class="mt-2 img-fluid float-left mr-3">

                                <div class="media-body ml-4">
                                    <h4 class="mb-0">{{ $comment->user->name }}</h4>
                                    <span class="date-comm font-sm text-capitalize text-color"><i
                                            class="ti-time mr-2"></i>{{ $comment->created_at->format('F d, Y') }}</span>

                                    <div class="comment-content mt-3">
                                        <p>{{ $comment->contenu }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (Auth::check())
                        <p><b>Commenting as : </b>{{ auth()->user()->name }}</p>
                        <form action="{{ route('addComment', $article) }}" method="POST"
                            class="comment-form mb-5 gray-bg p-5" id="comment-form">
                            @csrf
                            <h3 class="mb-4 text-center">Leave a comment</h3>
                            <div class="row">
                                <div class="col-lg-12">
                                    @error('comment')
                                        {{ $message }}
                                    @enderror

                                    <textarea class="form-control mb-3" name="comment" id="comment" cols="30" rows="5" placeholder="Comment">{{ old('comment') }}</textarea>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                        <input class="form-control" type="text" name="name" id="name"
                                            value="{{ old('name') }}" placeholder="Name:">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                        <input class="form-control" type="text" name="email" id="mail"
                                            value="{{ old('email') }}" placeholder="Email:">
                                    </div>
                                </div> --}}
                            </div>

                            <input class="btn btn-primary" type="submit" name="submit-contact" id="submit_contact"
                                value="Submit Message">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
