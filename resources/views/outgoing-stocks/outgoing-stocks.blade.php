@extends('layouts.main_layouts')
@section('breadcrumb', 'Outgoing Stocks')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Outgoing Stocks table</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <div class="d-flex  align-items-center px-3">
                            <div class="ms-auto pe-md-3 d-flex align-items-center">
                                <div class="input-group input-group-outline">
                                    <form action="{{ route('outgoing-stocks.index') }}" method="GET">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bills Id</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outgoingStocks as $outgoingStock)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->id }}</span>
                                        </td>

                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->incoming_stock->product_detail->product_name }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->incoming_stock->product_detail->product_code }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->quantity }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->detail_bill->bills_id }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->detail_bill->bill->payment->status }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $outgoingStock->created_at }}</span>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $queryOutgoingStocks->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
