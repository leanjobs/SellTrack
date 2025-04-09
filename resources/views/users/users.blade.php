@extends('layouts.main_layouts')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Users table</h6>
                        <span class="d-flex align-items-center justify-content-center ms-auto p-1 bg-white rounded-3 shadow">
                            <a href="{{ route('users.create') }}" class="d-flex align-items-center">
                                <i class="material-symbols-rounded fs-3 text-dark">add</i>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <div class="d-flex  align-items-center px-3">
                            <div class="ms-auto pe-md-3 d-flex align-items-center">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Type here...</label>
                                    <input type="text" class="form-control">
                                    <span class="d-flex align-items-center justify-content-center ms-1">
                                        <i class="material-symbols-rounded fs-3">tune</i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> User Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Email</th>
                                    {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Password</th> --}}
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone Number</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Position</th>
                                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $user->id }}</span>
                                        </td>
                                        <td>
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->user_name }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-sm font-weight-bold">{{ $user->email }}</span>
                                        </td>
                                        {{-- <td class="align-middle text-center">
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->password }}</span>
                                        </td> --}}
                                        <td class="align-middle text-center">
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->phone_number }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->role }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->branches_id ? $user->user_branch->branch_name : "branch not found" }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->position }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                            class="text-secondary text-sm font-weight-bold">{{ $user->status }}</span>
                                        </td>
                                        <td class="align-middle d-flex pb-6">
                                            <a href="{{ route('users.update', $user->id) }}">
                                                <button type="button" class="btn btn-success me-2">Update</button>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
