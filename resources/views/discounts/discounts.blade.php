@extends('layouts.main_layouts')
@section('breadcrumb', 'Discounts')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Discounts table</h6>
                        <span class="d-flex align-items-center justify-content-center ms-auto p-1 bg-white rounded-3 shadow">
                            <a href="{{ route('discounts.create') }}" class="d-flex align-items-center">
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
                                    <form action="{{ route('discounts.index') }}" method="GET">
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
                                        Discount Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Discount Type</th>
                                    @if (auth()->user()->role == "super_admin")
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Branch</th>
                                    @endif
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Product</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Start Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        End Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discounts as $discount)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->id }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->discount_name }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->type }}</span>
                                        </td>
                                        @if (auth()->user()->role == "super_admin")
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->all_branches == 1 ? "all branch" : $discount->branches->branch_name}}</span>
                                        </td>
                                        @endif
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->detail_discounts->product->product_name }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->start_date }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $discount->end_date }}</span>
                                        </td>
                                        <td class="align-middle d-flex ">
                                            <a href="{{ route('discounts.update', $discount->id) }}">
                                                <button type="button" class="btn btn-success me-2">Update</button>
                                            </a>
                                          <form action="{{ route('discounts.destroy', $discount->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                          </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $discounts->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
