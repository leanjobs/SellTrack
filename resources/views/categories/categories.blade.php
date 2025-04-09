@extends('layouts.main_layouts')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Categories table</h6>
                        <span class="d-flex align-items-center justify-content-center ms-auto p-1 bg-white rounded-3 shadow">
                            <a href="{{ route('categories.create')}}" class="d-flex align-items-center">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $category->id }}</span>
                                        </td>

                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $category->category_name }}</span>
                                        </td>
                                        <td class="align-middle d-flex ">
                                            <a href="{{ route('categories.update', $category->id) }}">
                                                <button type="button" class="btn btn-success me-2">Update</button>
                                            </a>
                                          <form action="{{ route('categories.destroy', $category->id)}}" method="POST">
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
