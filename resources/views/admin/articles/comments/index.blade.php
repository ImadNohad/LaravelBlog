@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                @isset($article)
                    <h1>{{ $article->title }}'s Comments</h1>
                @endisset
                <div class="mt-5">
                    <a class="btn btn-primary" href="{{ route('articles.index') }}">
                        < Back to articles</a>
                </div>
                <table id="example" class="table table-hover responsive nowrap text-center" style="width:100%">
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
                            <th>Email</th>
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
                                            <p class="font-weight-bold mb-0">{{ $comment->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                @empty($article)
                                    <td><a target="_blank"
                                            href="{{ route('article.show', $comment->article->id) }}">{{ $comment->article->title }}</a>
                                    </td>
                                @endempty
                                <td>{{ $comment->user->email }}</td>
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
                                            ]) type="button" data-toggle="modal"
                                                data-target="#exampleModalCenter" data-bs-id="{{ $comment->id }}"
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
                                                data-toggle="modal" data-target="#exampleModalCenter"
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
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to perform this action ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="show-confirm" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
