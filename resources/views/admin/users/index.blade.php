@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Users List</h1>
                <div class="mt-4">
                    <a class="btn btn-primary" href="{{ route('users.create') }}">Add User</a>
                </div>

                <table class="table table-striped responsive nowrap text-center" style="width:100%">
                    <thead>
                        <tr>
                            <td colspan="5" class="p-0">
                                {{ $users->links('vendor.pagination.custom') }}
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date of Publication</th>
                            @if ($user_count > 1)
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="avatar avatar-blue mr-3">
                                        <img src="{{ asset('storage/images/' . $user->imageURL) }}" width="40"
                                            alt="" />
                                    </div>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/admin/users/{{ $user->id }}/edit"><i
                                                class="bx bxs-pencil mr-2"></i></a>

                                        <form id="delete{{ $user->id }}"
                                            action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-danger border-0 bg-transparent" type="button"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                                data-bs-id="{{ $user->id }}">
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
                                {{ $users->links('vendor.pagination.custom') }}
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to delete this user ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="show-confirm" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
