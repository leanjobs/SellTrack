
@foreach ($productsFilter as $product)
    <div class="col-md-3 col-sm-4 col-6 py-2">
        <div class="border-0 w-100 p-0 product_item"
            {{ $product->incoming_stocks->sum('current_stocks') < 1 ? 'disabled' : '' }} id="{{ $product->id }}"
            data-code="{{ $product->product_code }}">
            <div class="card">
                <div class="card-header mt-1 text-center position-relative">
                    @if ($product->discounts->isNotEmpty())
                        @if ($product->discounts[0]->type == 'member')
                        <button type="button" class="border-0 btn p-2 mb-0 position-absolute  bg-success  rounded-circle" data-bs-toggle="modal"   data-bs-target="#discountModal-{{ $product->id }}">
                            <span class="btn-inner--icon">
                                <i class="material-symbols-rounded text-white">loyalty</i>
                            </span>
                        </button>
                        @elseif($product->discounts[0]->type == 'percentage_off')
                            <button type="button" class="border-0 btn p-2 mb-0 position-absolute  bg-primary  rounded-circle" data-bs-toggle="modal"   data-bs-target="#discountModal-{{ $product->id }}">
                                <span class="btn-inner--icon">
                                    <i class="material-symbols-rounded text-white">percent</i>
                                </span>
                            </button>
                        @elseif($product->discounts[0]->type == 'buy_x_get_y')
                        <button type="button" class="border-0 btn p-2 mb-0 position-absolute  bg-warning  rounded-circle" data-bs-toggle="modal"   data-bs-target="#discountModal-{{ $product->id }}">
                            <span class="btn-inner--icon">
                                <i class="material-symbols-rounded text-white">redeem</i>
                            </span>
                        </button>
                        @endif
                    @include('components.modal-discount')

                    @endif

                    <img src="{{ asset('storage/' . $product->product_img) }}" alt="product img"
                        style="height: 90px; width:90px;  object-fit: cover;" class="rounded product_img">
                </div>
                <div class="card-body pt-0 text-center">
                    <h6 class="text-center mb-0 product_name">{{ $product->product_name }}</h6>
                    <span class="text-xs">Stock : <span
                            class="product_stock">{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}</span>
                    </span>
                    <hr class="horizontal dark my-3">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <p class="mb-0 text-sm font-weight-bold text-dark">Rp <span class="product_price">{{ number_format($product->price, 0, ',', '.') }}</span></p>
                        <button class="btn btn-icon btn-2 bg-gradient-dark p-1 mb-0 btn-add-item" {{$product->incoming_stocks->sum('current_stocks') < 1 ? 'disabled' : '' }} }} type="button" data-code="{{ $product->product_code }}" id="{{ $product->id }}">
                            <span class="btn-inner--icon">
                                <i class="material-symbols-rounded">add</i>
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
                // console.log(@json($productsFilter));

    </script>
@endforeach
