@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Articles List</h1>

                <div class="mt-4">
                    <a class="btn btn-primary" href="{{ route('articles.create') }}">Add article</a>
                </div>

                <form id="form" action="{{ route('articles.index') }}" class="mt-4">
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
                                <h3 class="form-label" for="drpCategory">Category</h3>
                                <select value="{{ request()->query('category') }}" name="category" id="drpCategory"
                                    class="form-control">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $cat)
                                        @if (request()->query('category') == $cat->id)
                                            <option value="{{ $cat->id }}" selected>{{ $cat->nom }}</option>
                                        @else
                                            <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (auth()->user()->type === 'admin')
                            <div class="col-6">
                                <div class="form-outline mb-4">
                                    <h3 class="form-label" for="drpAuthor">Author</h3>
                                    <select name="author" id="drpAuthor" class="form-control">
                                        <option value="">Select author</option>
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
                        @endif
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

                @if ($articles->count() > 0)
                    <table class="table table-striped responsive nowrap text-center" style="width:100%">
                        <thead>
                            <tr>
                                <td colspan="5" class="p-0">
                                    {{ $articles->links('vendor.pagination.custom') }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Article Title</th>
                                <th>Categories</th>
                                <th>Date of Publication</th>
                                <th>Author</th>
                                <th>Comments</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $item)
                                <tr>
                                    <td>
                                        <div class="avatar avatar-blue mr-3">
                                            <img src="{{ asset('storage/images/' . $item->imageURL) }}" alt=""
                                                width="40" />
                                        </div>
                                    </td>
                                    <td>
                                        <a class="fw-bold mb-0" href="{{ route('article.show', $item->id) }}"
                                            target="_blank">
                                            {{ $item->title }}
                                        </a>
                                    </td>
                                    <td>{!! $item->categories()->where('active', true)->implode('nom', ', ') !!}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        <a class="" href="{{ route('articleComments', $item) }}">
                                            <i class="bx bx-message-rounded mr-2"></i>
                                            {{ $item->commentaires->count() }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="/admin/articles/{{ $item->id }}/edit"><i
                                                    class="bx bxs-pencil mr-2"></i></a>

                                            <form id="delete{{ $item->id }}"
                                                action="{{ route('articles.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button class="text-danger border-0 bg-transparent" type="button"
                                                    data-toggle="modal" data-target="#exampleModalCenter"
                                                    data-bs-id="{{ $item->id }}">
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
                                    {{ $articles->links('vendor.pagination.custom') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <p class="mt-4">No articles to show.</p>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you really want to delete this article ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="show-confirm" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
