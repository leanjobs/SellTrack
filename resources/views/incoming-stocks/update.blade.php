@extends('layouts.main_layouts')
@section('breadcrumb', 'Incoming Stocks')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Update Incoming Stock</h5>
            <form action="{{ route('incoming-stocks.update', $incomingStock->id)}}" method="POST" enctype="multipart/form-data" class="row p-3" id="category-form">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Product Code</label>
                        <select name="products_id" id="products_id" class="form-select select2 bg-transparent border p-2" aria-label="Default select example" disabled>
                            <option value="" selected disabled>-- Select a product code --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id}}" {{$product->id === $incomingStock->products_id ? "selected" : ""}}>{{$product->product_code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="product_detail" style="display: none">
                        <p class="text-md text-bold mb-0">Product Details</p>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-sm mb-0"><span class="text-bold">Name :</span> <span
                                        id="product_name"></span></p>
                                <p class="text-sm mb-0"><span class="text-bold">Code :</span> <span
                                        id="product_code"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-sm  mb-0"><span class="text-bold">Stock :</span> <span
                                        id="product_stocks"></span></p>
                                <p class="text-sm  mb-0"><span class="text-bold">Price :</span> <span
                                        id="product_price"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Initial Stock</label>
                        <input type="number" name="initial_stocks" class="form-control border p-2" required value="{{ old('initial_stocks', $incomingStock->initial_stocks) }}" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expired</label>
                        <input type="date" name="expired" class="form-control border p-2" value="{{ old('expired', $incomingStock->expired) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                </div>

                <div class="col-12 ps-3">
                    <button type="button" class="btn btn-outline-secondary px-5" onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn bg-gradient-dark ms-2 px-5">Submit</button>
                </div>
            </form>

        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            // $('#products_id').select2({
            //     theme: 'bootstrap-5',
            //     width: '100%',
            //     placeholder: "-- Select a product code --",
            //     allowClear: true
            // });
            function productDetails(selectedId, detailIdPrefix) {
                let selectedProduct = $(selectedId).find('option:selected');
                let productName = selectedProduct.data('name');
                let productCode = selectedProduct.data('code');
                let productPrice = selectedProduct.data('price');
                let productStocks = selectedProduct.data('stocks') ?? 0;

                if(selectedProduct && productName && productCode && productPrice && productStocks){
                    $(`#${detailIdPrefix}_name`).text(productName);
                    $(`#${detailIdPrefix}_code`).text(productCode);
                    $(`#${detailIdPrefix}_price`).text("Rp " + parseInt(productPrice).toLocaleString("id-ID"));
                    $(`#${detailIdPrefix}_stocks`).text(productStocks);
                    $(`#${detailIdPrefix}_detail`).show();
                }else{
                    $(`#${detailIdPrefix}_detail`).hide();
                }

            }

            $('#products_id').change(function() {
                productDetails('#products_id', 'product');

                var selectedOption = $(this).find('option:selected');

            });

            if("#products_id").val(){
                $("#products_id").trigger(change);
            }
        });
    </script>

@endsection
