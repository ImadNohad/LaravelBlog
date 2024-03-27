@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Users</h1>
                <table id="example" class="table table-hover responsive nowrap text-center" style="width:100%">
                    <thead>
                        <tr>
                            <td colspan="5" class="p-0">
                                {{ $users->links('vendor.pagination.custom') }}
                            </td>
                        </tr>
                        <tr>
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
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="font-weight-bold mb-0">{{ $user->firstname }} {{ $user->lastname }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                @if ($user_count > 1 && auth()->user()->id != $user->id)
                                    <td>
                                        <div>
                                            <form id="delete{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button class="text-danger border-0 bg-transparent" type="button"
                                                    data-toggle="modal" data-target="#exampleModalCenter"
                                                    data-bs-id="{{ $user->id }}">
                                                    <i class="bx bxs-trash mr-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to delete this user ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="show-confirm" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
