@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                @isset($article)
                    <h1>{{ $article->title }}'s Comments</h1>
                    <div class="mt-5">
                        <a class="btn btn-primary" href="{{ route('articles.index') }}">
                            < Back to articles</a>
                    </div>
                @else
                    <h1>Comments List</h1>
                @endisset

                <form id="form" action="{{ route('comments') }}" class="mt-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <h3 class="form-label" for="txtKeyword">Keyword</h3>
                                <input type="text" value="{{ request()->query('keyword') }}" name="keyword"
                                    id="txtKeyword" class="form-control" />
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <h3 class="form-label" for="drpArticle">Article</h3>
                                <select value="{{ request()->query('article') }}" name="article" id="drpArticle"
                                    class="form-control">
                                    <option value="">Select article</option>
                                    @foreach ($articles as $art)
                                        @if (request()->article == $art->id)
                                            <option value="{{ $art->id }}" selected>{{ $art->title }}</option>
                                        @else
                                            <option value="{{ $art->id }}">{{ $art->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <h3 class="form-label" for="drpAuthor">Comment Author</h3>
                                <select name="author" id="drpAuthor" class="form-control form-select">
                                    <option value="">Select comment author</option>
                                    @foreach ($authors as $author)
                                        @if (request()->query('author') == $author->id)
                                            <option value="{{ $author->id }}" selected>{{ $author->name }}</option>
                                        @else
                                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-outline mb-4 col">
                                    <h3 class="form-label" for="drpAuthor">Date from</h3>
                                    <input value="{{ request()->query('dateFrom') }}" name="dateFrom" id="drpAuthor"
                                        type='date' class="form-control" placeholder="from" />
                                </div>

                                <div class="form-outline mb-4 col">
                                    <h3 class="form-label" for="drpAuthor">Date to</h3>
                                    <input value="{{ request()->query('dateTo') }}" name="dateTo" id="drpAuthor"
                                        type='date' class="form-control" placeholder="to" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary" type="submit" value="Search" />
                        </div>
                    </div>
                </form>

                @if ($comments->count() > 0)
                    <table class="table table-striped responsive nowrap text-center" style="width:100%">
                        <thead>
                            <tr>
                                <td colspan="5" class="p-0">
                                    {{ $comments->links('vendor.pagination.custom') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Name</th>
                            @empty($article)
                                <th>Article</th>
                            @endempty
                            <th>Comment</th>
                            <th>Date of Publication</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <div class="fw-bold">{{ $comment->user->name }}</div>
                                            <div class="small">{{ $comment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                @empty($article)
                                    <td><a class="fw-bold mb-0" target="_blank"
                                            href="{{ route('article.show', $comment->article->id) }}">
                                            {{ $comment->article->title }}
                                        </a>
                                    </td>
                                @endempty
                                <td>{{ $comment->contenu }}</td>
                                <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span
                                        @class([
                                            'badge',
                                            'bg-success' => $comment->active,
                                            'bg-warning' => !$comment->active,
                                        ])>{{ $comment->active ? 'Approved' : 'Pending' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <form id="accept{{ $comment->id }}"
                                            action="{{ route('acceptComment', $comment) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button @class([
                                                'border-0 bg-transparent',
                                                'text-success' => !$comment->active,
                                                'text-warning' => $comment->active,
                                            ]) type="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter" data-bs-id="{{ $comment->id }}"
                                                data-bs-action="accept">
                                                <i @class([
                                                    'bx mr-2',
                                                    'bxs-check-circle' => !$comment->active,
                                                    'bxs-x-circle' => $comment->active,
                                                ])></i>
                                            </button>
                                        </form>
                                        <form id="delete{{ $comment->id }}"
                                            action="{{ route('deleteComment', $comment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-danger border-0 bg-transparent" type="button"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                                data-bs-id="{{ $comment->id }}" data-bs-action="delete">
                                                <i class="bx bxs-trash mr-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="p-0">
                                {{ $comments->links('vendor.pagination.custom') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <p class="mt-4">No comments to show.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Do you really want to perform this action ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="show-confirm" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
