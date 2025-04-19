@extends('layouts.main_layouts')
@section('breadcrumb', 'Products')
@section('content')
<div class="row mb-3">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Total Product</p>
                <h4 class="mb-0">{{ $products->count() }}</h4>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm font-weight-bold">All active products recorded</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Overall product stock</p>
                <h4 class="mb-0">
                    {{
                        collect($products)->flatMap(function ($product) {
                            return $product['incoming_stocks'];
                        })->sum('current_stocks')
                    }}
                </h4>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm font-weight-bold">Represents all product quantities</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Products Close to Expiry</p>
                <h4 class="mb-0">{{ $closeExpired->sum('current_stocks')}}</h4>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <button class="mb-0 text-sm font-weight-bold text-success text-decoration-underline link-offset-5 bg-transparent border-0 p-0" type="button" data-bs-toggle="modal" data-bs-target="#expiryModal">
                more
            </button>
            @include('components.modal-expiry')
        </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Product Running Low</p>
                <h4 class="mb-0">{{$runningLow->count() }}</h4>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <button class="mb-0 text-sm font-weight-bold text-success text-decoration-underline link-offset-5 bg-transparent border-0 p-0" type="button" data-bs-toggle="modal" data-bs-target="#runningLowModal">
                more
            </button>
            @include('components.modal-running-low')
          </div>
        </div>
      </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Products table</h6>
                        <span class="d-flex align-items-center justify-content-center ms-auto p-1 bg-white rounded-3 shadow">
                            <a href="{{ route('products.create') }}" class="d-flex align-items-center">
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
                                    <form action="{{ route('products.index') }}" method="GET">
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
                                        Product Code</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Product Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Product Image</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Category</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stock</th>
                                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    use Picqer\Barcode\BarcodeGeneratorPNG;
                                    $generator = new BarcodeGeneratorPNG();
                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $product->id }}</span>
                                        </td>
                                        <td>
                                            {{-- <p class="text-xs font-weight-bold mb-0">{!! DNS1D::getBarcodeHTML($product->product_code, 'C128') !!}</p> --}}
                                            <img src="data:image/png;base64,{{ base64_encode($generator->getBarcode($product->product_code, $generator::TYPE_CODE_128)) }}" alt="Barcode {{ $product->product_code }}">

                                            <p class="text-xs text-secondary mb-0">{{ $product->product_code }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-sm font-weight-bold">{{ $product->product_name }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($product->product_img)
                                                <img src="{{ asset('storage/' . $product->product_img) }}"
                                                    style="width: 100px; height: 100px; object-fit: cover;"
                                                    alt="{{ $product->product_name }}">
                                            @else
                                                <p>no img</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-sm font-weight-bold">Rp{{ number_format($product->price) }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-secondary text-sm font-weight-bold">{{ $product->categories_id ? $product->product_category->category_name : 'category not found' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-sm font-weight-bold">{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}</span>
                                        </td>
                                        <td class="align-middle d-flex pb-6">
                                            <a href="{{ route('products.update', $product->id) }}">
                                                <button type="button" class="btn btn-success me-2">Update</button>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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
