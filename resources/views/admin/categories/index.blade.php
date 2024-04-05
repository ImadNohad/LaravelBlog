@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Categories List</h1>
                <div class="mt-5">
                    <a class="btn btn-primary" href="{{ route('categories.create') }}">Add categorie</a>
                </div>
                <table id="example" class="table table-hover responsive nowrap text-center" style="width:100%">
                    <thead>
                        <tr>
                            <td colspan="5" class="p-0">
                                {{ $categories->links('vendor.pagination.custom') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Categorie</th>
                            <th>Active</th>
                            <th>Creation Date</th>
                            <th>Update Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <td>{{ $item->nom }}</td>
                                <td><i @class([
                                    'bx bxs-check-circle text-success' => $item->active,
                                ])></i></td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>{{ $item->updated_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/admin/categories/{{ $item->id }}/edit"><i
                                                class="bx bxs-pencil mr-2"></i></a>

                                        <form id="delete{{ $item->id }}"
                                            action="{{ route('categories.destroy', $item) }}" method="POST">
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
                                {{ $categories->links('vendor.pagination.custom') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
                        Do you really want to delete this category ?
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
