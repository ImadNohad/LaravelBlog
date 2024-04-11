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
                            <div class="meta-cat">
                                @foreach ($article->categories as $cat)
                                    <a class="post-category font-extra text-color
                                              text-uppercase font-sm letter-spacing-1"
                                        href="{{ route('categoryArticles', $cat->id) }}">{{ $cat->nom }}
                                        @if (!$loop->last)
                                            <span>, </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
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
                                <img src="{{ asset('storage/images/' . $article->imageURL) }}" class="img-fluid w-100"
                                    alt="featured-image">
                            </div>
                        </div>

                        <div class="post-body">
                            <div class="entry-content">
                                {!! $article->contenu !!}
                            </div>

                            <div class="post-tags py-4">
                                @foreach ($article->tags as $tag)
                                    <a href="{{ route('tagArticles', $tag->id) }}">#{{ $tag->nom }}</a>
                                @endforeach
                            </div>

                            <div
                                class="tags-share-box center-box d-flex text-center
                                        justify-content-between border-top border-bottom py-3">

                                <span class="single-comment-o"><i
                                        class="fa fa-comment-o"></i>{{ $article->commentaires->count() }}
                                    {{ $article->commentaires->count() > 1 ? 'comments' : 'comment' }}</span>

                                <div class="post-share">
                                    <span id="like-counter" class="count-number-like">
                                        {{ $article->likes->count() }}
                                    </span>
                                    <a class="penci-post-like single-like-button">
                                        @if (auth()->check() && $userLike)
                                            <i id="like" class='bx bxs-heart text-danger'></i>
                                        @else
                                            <i id="like" class='bx bx-heart'></i>
                                        @endif
                                    </a>
                                </div>

                                <div class="list-posts-share">
                                    <a target="_blank" rel="nofollow" href="#"><i class="ti-facebook"></i></a>
                                    <a target="_blank" rel="nofollow" href="#"><i class="ti-twitter"></i></a>
                                    <a target="_blank" rel="nofollow" href="#"><i class="ti-pinterest"></i></a>
                                    <a target="_blank" rel="nofollow" href="#"><i class="ti-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post-author d-flex my-5">
                        <div class="author-img">
                            <img alt="" src="{{ asset('storage/images/' . $article->user->imageURL) }}"
                                class="avatar avatar-100 photo" width="100" height="100">
                        </div>

                        <div class="author-content ps-4">
                            <h4 class="mb-3"><a href="#" title="" rel="author"
                                    class="text-capitalize">{{ $article->user->name }}</a></h4>
                            <p>{{ $article->user->bio }}</p>
                        </div>
                    </div>

                    <div class="comment-area my-5">
                        <h3 class="mb-4 text-center">{{ $article->commentaires->count() }}
                            {{ $article->commentaires->count() > 1 ? 'Comments' : 'Comment' }}</h3>

                        @foreach ($article->commentaires as $comment)
                            <div class="comment-area-box d-flex {{ $loop->first ? 'mt-5' : '' }}">
                                <img height="100" width="100" alt=""
                                    src="{{ asset($comment->user->imageURL) }}" class="mt-2 flex-shrink-0 me-3">

                                <div class="flex-grow-1 ms-4">
                                    <h4 class="mb-0">{{ $comment->user->name }}</h4>
                                    <span class="date-comm font-sm text-capitalize text-color"><i
                                            class="ti-time me-2"></i>{{ $comment->created_at->format('F d, Y') }}</span>

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

                                    <textarea class="form-control mb-3" name="comment" cols="30" rows="5" placeholder="Comment">{{ old('comment') }}</textarea>
                                </div>
                            </div>

                            <input class="btn btn-primary" type="submit" name="submit-contact" id="submit_contact"
                                value="Submit Message">
                        </form>
                    @else
                        <a class="text-color" href="/login">Login to comment</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        $("#like").on("click", function() {
            let method = 'POST'
            if ($(this).hasClass("bxs-heart")) {
                method = 'DELETE'
            }
            $.ajax({
                type: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `/like/{{ $article->id }}`,
                success: function(result) {
                    $("#like-counter").text(result);
                    if ($("#like").hasClass("bxs-heart")) {
                        $("#like").removeClass("bxs-heart text-danger").addClass("bx-heart");
                        return;
                    }
                    $("#like").removeClass("bx-heart").addClass("bxs-heart text-danger");
                }
            });
        })
    </script>
@endsection
