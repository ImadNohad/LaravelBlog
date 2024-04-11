@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Tags List</h1>
                <div class="mt-4">
                    <a class="btn btn-primary" href="{{ route('tags.create') }}">Add tag</a>
                </div>

                <form id="form" action="{{ route('tags.index') }}" class="mt-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <h3 class="form-label" for="txtKeyword">Keyword</h3>
                                <input type="text" value="{{ request()->query('keyword') }}" name="keyword"
                                    id="txtKeyword" class="form-control" />
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="row">
                                <div class="form-outline mb-4 col">
                                    <h3 class="form-label" for="dateFrom">Date from</h3>
                                    <input value="{{ request()->query('dateFrom') }}" name="dateFrom" id="dateFrom"
                                        type='date' class="form-control" placeholder="from" />
                                </div>

                                <div class="form-outline mb-4 col">
                                    <h3 class="form-label" for="dateTo">Date to</h3>
                                    <input value="{{ request()->query('dateTo') }}" name="dateTo" id="dateTo"
                                        type='date' class="form-control" placeholder="to" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <h3 class="form-label" for="drpAuthor">Active</h3>
                                <input type="checkbox" name="active" id="cbActive"
                                    {{ request()->query('active') == 'on' ? 'checked' : '' }} />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary" type="submit" value="Search" />
                        </div>
                    </div>
                </form>

                @if ($tags->count() > 0)
                    <table class="table table-striped responsive nowrap text-center" style="width:100%">
                        <thead>
                            <tr>
                                <td colspan="5" class="p-0">
                                    {{ $tags->links('vendor.pagination.custom') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tag</th>
                                <th>Active</th>
                                <th>Creation Date</th>
                                <th>Update Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $item)
                                <tr>
                                    <td>{{ $item->nom }}</td>
                                    <td><i @class([
                                        'bx bxs-check-circle text-success' => $item->active,
                                    ])></i></td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $item->updated_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="/admin/tags/{{ $item->id }}/edit"><i
                                                    class="bx bxs-pencil mr-2"></i></a>

                                            <form id="delete{{ $item->id }}"
                                                action="{{ route('tags.destroy', $item) }}" method="POST">
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
                                    {{ $tags->links('vendor.pagination.custom') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <p class="mt-4">No tags to show.</p>
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
                        Do you really want to delete this tag ?
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
