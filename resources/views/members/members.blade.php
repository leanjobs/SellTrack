@extends('layouts.main_layouts')
@section('breadcrumb', 'Members')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Members table</h6>
                        <span class="d-flex align-items-center justify-content-center ms-auto p-1 bg-white rounded-3 shadow">
                            <a href="{{ route('members.create') }}" class="d-flex align-items-center">
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
                                    <form action="{{ route('members.index') }}" method="GET">
                                        <input type="search" name="search" value="{{ request('search')}}" class="form-control" placeholder="type here...">
                                    </form>
                                    {{-- <span class="d-flex align-items-center justify-content-center ms-1">
                                        <i class="material-symbols-rounded fs-3">tune</i>
                                    </span> --}}
                                </div>
                            </div>
                        </div>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Member Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Phone Number</th>
                                    {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Point</th> --}}
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $member->id }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $member->member_name }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $member->phone_number }}</span>
                                        </td>
                                        {{-- <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $member->point ?? "0" }}</span>
                                        </td> --}}
                                        <td class="align-middle d-flex ">
                                            <a href="{{ route('members.update', $member->id) }}">
                                                <button type="button" class="btn btn-success me-2">Update</button>
                                            </a>
                                          <form action="{{ route('members.destroy', $member->id)}}" method="POST">
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
