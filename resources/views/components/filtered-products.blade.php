@foreach ($products as $product )
<div class="col-md-3 col-sm-4 col-6 py-2">
    <button class="btn border-0  w-100 p-0 product_item" {{ $product->incoming_stocks->sum('current_stocks') < 1 ? 'disabled' : '' }} id="{{ $product->id}}" data-code="{{ $product->product_code}}">
        <div class="card">
            <div class="card-header mt-1 text-center">
                <img src="{{ asset('storage/'.$product->product_img) }}" alt="product img"
                    style="height: 90px; width:90px;  object-fit: cover;" class="rounded product_img">
            </div>
            <div class="card-body pt-0 text-center">
                <h6 class="text-center mb-0 product_name">{{ $product->product_name}}</h6>
                <span class="text-xs">Stock : <span class="product_stock">{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}</span> </span>
                <hr class="horizontal dark my-3">
                <h5 class="mb-0 ">Rp <span class="product_price">{{ number_format($product->price, 0, ',', '.') }}</span></h5>
            </div>
        </div>
    </button>
</div>
@endforeach
