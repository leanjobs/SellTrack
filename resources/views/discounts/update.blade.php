@extends('layouts.main_layouts')
@section('breadcrumb', 'Discounts')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Update  Discount</h5>
            <form action="{{ route('discounts.update', $discount->id)}}" method="POST" enctype="multipart/form-data"
                class="row p-3" id="discount-form">
                @csrf
                @method('PUT')

                @if ($discount->type == 'buy_x_get_y')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required value="{{ old('discount_name', $discount->discount_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="hidden" name="type" value="{{ old('type', $discount->type) }}">
                                <input type="text" class="form-control" value="{{ old('type', $discount->type) }}" disabled>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required value="{{ old('start_date',  $discount->start_date) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required value="{{ old('end_date', $discount->end_date)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Buy</label>
                                <select name="products_id" id="products_id"
                                    class="form-select select2 bg-transparent border p-2"
                                    aria-label="Default select example">
                                    <option value="" selected disabled>Select and search</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                            data-code="{{ $product->product_code }}"
                                            data-stocks="{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}"
                                            data-price="{{ $product->price }}" {{ $product->id == ($discount->detail_discounts->products_id ?? '') ? 'selected' : '' }} >{{ $product->product_name }} -
                                            {{ $product->product_code }}</option>
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
                                <label class="form-label">Min Quantity</label>
                                <input type="number" name="min_quantity" class="form-control border p-2" required value="{{ old('min_quantity', $discount->detail_discounts->min_quantity)}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Free Product</label>
                                <select name="free_products_id" id="free_products_id"
                                    class="form-select select2 bg-transparent border p-2"
                                    aria-label="Default select example">
                                    <option value="" selected disabled>Select and search</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                            data-code="{{ $product->product_code }}"
                                            data-stocks="{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}"
                                            data-price="{{ $product->price }}" {{ $product->id == ($discount->detail_discounts->free_products_id ?? '') ? 'selected' : '' }}>{{ $product->product_name }} -
                                            {{ $product->product_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="free_product_detail" style="display: none">
                                <p class="text-md text-bold mb-0">Product Details</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-sm mb-0"><span class="text-bold">Name :</span> <span
                                                id="free_product_name"></span></p>
                                        <p class="text-sm mb-0"><span class="text-bold">Code :</span> <span
                                                id="free_product_code"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-sm  mb-0"><span class="text-bold">Stock :</span> <span
                                                id="free_product_stocks"></span></p>
                                        <p class="text-sm  mb-0"><span class="text-bold">Price :</span> <span
                                                id="free_product_price"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity Free Prodcut</label>
                                <input type="number" name="quantity_free_products" class="form-control border p-2"
                                    required value="{{ old('quantity_free_products', $discount->detail_discounts->quantity_free_products)}}">
                            </div>
                        </div>
                    @elseif ($discount->type == 'percentage_off')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required value="{{ old('discount_name', $discount->discount_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Type</label>
                               <input type="hidden" name="type" value="{{ old('type', $discount->type) }}">
                                <input type="text" class="form-control" value="{{ old('type', $discount->type) }}" disabled>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required value="{{ old('start_date',  $discount->start_date) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required value="{{ old('end_date', $discount->end_date)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="products_id" id="products_id"
                                    class="form-select select2 bg-transparent border p-2"
                                    aria-label="Default select example">
                                    <option value="" selected disabled>Select and search</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                            data-code="{{ $product->product_code }}"
                                            data-stocks="{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}"
                                            data-price="{{ $product->price }}"  {{ $product->id == ($discount->detail_discounts->products_id ?? '') ? 'selected' : '' }} >{{ $product->product_name }} -
                                            {{ $product->product_code }}</option>
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
                                <label class="form-label">Min Quantity</label>
                                <input type="number" name="min_quantity" class="form-control border p-2 "
                                    id="min_quantity" required disabled value="{{ old('min_quantity', $discount->detail_discounts->min_quantity)}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Percentage</label>
                                <input type="number" name="discount_percentage" id="discount_percentage"
                                    class="form-control border p-2" required disabled min="0" max="100" value="{{ old('discount_percentage', $discount->detail_discounts->discount_percentage)}}">
                            </div>
                            <p class="text-sm mb-0 ms-1"><span class="text-bold">Discount Price :</span> <span
                                    id="show_discount_price"></span></p>
                            <input type="number" name="discount_price" class="form-control border p-2" id="discount_price" hidden value="{{ old('discount_price', $discount->detail_discounts->discount_price)}}">
                        </div>
                    @elseif ($discount->type == 'cheap_redemption')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required value="{{ old('discount_name', $discount->discount_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Type</label>
                               <input type="hidden" name="type" value="{{ old('type', $discount->type) }}">
                                <input type="text" class="form-control" value="{{ old('type', $discount->type) }}" disabled>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required value="{{ old('start_date',  $discount->start_date) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required value="{{ old('end_date', $discount->end_date)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Min Total Price</label>
                                <input type="number" name="min_total_price" class="form-control border p-2" required  value="{{ old('min_total_price', $discount->detail_discounts->min_total_price) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Discount</label>
                                <select name="free_products_id" id="free_products_id"
                                    class="form-select select2 bg-transparent border p-2"
                                    aria-label="Default select example">
                                    <option value="" selected disabled>Select and search</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                            data-code="{{ $product->product_code }}"
                                            data-stocks="{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}"
                                            data-price="{{ $product->price }}" {{ $product->id == ($discount->detail_discounts->free_products_id ?? '') ? 'selected' : '' }}>{{ $product->product_name }} -
                                            {{ $product->product_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="free_product_detail" style="display: none">
                                <p class="text-md text-bold mb-0">Product Details</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-sm mb-0"><span class="text-bold">Name :</span> <span
                                                id="free_product_name"></span></p>
                                        <p class="text-sm mb-0"><span class="text-bold">Code :</span> <span
                                                id="free_product_code"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-sm  mb-0"><span class="text-bold">Stock :</span> <span
                                                id="free_product_stocks"></span></p>
                                        <p class="text-sm  mb-0"><span class="text-bold">Price :</span> <span
                                                id="free_product_price"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity Free Prodcut</label>
                                <input type="number" name="quantity_free_products" id="quantity_free_products"
                                    class="form-control border p-2" required disabled value="{{ old('quantity_free_products', $discount->detail_discounts->quantity_free_products)}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Price</label>
                                <input type="number" name="discount_price" id="discount_price"
                                    class="form-control border p-2" required disabled min="0" value="{{ old('discount_price', $discount->detail_discounts->discount_price)}}">
                            </div>
                        </div>
                    @elseif ($discount->type == 'member')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required value="{{ old('discount_name', $discount->discount_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Type</label>
                               <input type="hidden" name="type" value="{{ old('type', $discount->type) }}">
                                <input type="text" class="form-control" value="{{ old('type', $discount->type) }}" disabled>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required value="{{ old('start_date',  $discount->start_date) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required value="{{ old('end_date', $discount->end_date)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="products_id" id="products_id"
                                    class="form-select select2 bg-transparent border p-2"
                                    aria-label="Default select example">
                                    <option value="" selected disabled>Select and search</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                            data-code="{{ $product->product_code }}"
                                            data-stocks="{{ $product->incoming_stocks->sum('current_stocks') ?? 0 }}"
                                            data-price="{{ $product->price }}"  {{ $product->id == ($discount->detail_discounts->products_id ?? '') ? 'selected' : '' }} >{{ $product->product_name }} -
                                            {{ $product->product_code }}</option>
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
                                <label class="form-label">Min Quantity</label>
                                <input type="number" name="min_quantity" class="form-control border p-2 "
                                    id="min_quantity" required disabled value="{{ old('min_quantity', $discount->detail_discounts->min_quantity)}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Percentage</label>
                                <input type="number" name="discount_percentage" id="discount_percentage"
                                    class="form-control border p-2" required disabled min="0" max="100" value="{{ old('discount_percentage', $discount->detail_discounts->discount_percentage)}}">
                            </div>
                            <p class="text-sm mb-0 ms-1"><span class="text-bold">Discount Price :</span> <span
                                    id="show_discount_price"></span></p>
                            <input type="number" name="discount_price" class="form-control border p-2" id="discount_price" hidden value="{{ old('discount_price', $discount->detail_discounts->discount_price)}}">
                        </div>
                    @endif

                <div class="col-12 ps-3">
                    <button type="button" class="btn btn-outline-secondary px-5"
                        onclick="window.history.back()">Back</button>
                        <button type="submit" class="btn bg-gradient-dark ms-2 px-5">Submit</button>
                </div>
            </form>

        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: "-- Search and select --",
                allowClear: true
            });


            function toggleBranchSelection() {
                if ($('#all_branches').is(':checked')) {
                    $('#branches_selection').hide();
                    $('#all_branches').val(1);
                    $('#branches_id').prop('disabled', true).removeAttr('name', 'branches_id');
                } else {
                    $('#branches_selection').show();
                    $('#all_branches').val(0);
                    $('#branches_id').prop('disabled', false).attr('name', 'branches_id');
                }
            }


            $('#all_branches').change(toggleBranchSelection);

            if($('#all_branches').val() == 1){
                $('#all_branches').prop('checked', true);
            }

            toggleBranchSelection();


            function productDetails(selectedId, detailIdPrefix) {
                let selectedProduct = $(selectedId).find('option:selected');
                let productName = selectedProduct.data('name');
                let productCode = selectedProduct.data('code');
                let productPrice = selectedProduct.data('price');
                let productStocks = selectedProduct.data('stocks');

                if (productCode && productName && productPrice && productStocks) {
                    $(`#${detailIdPrefix}_name`).text(productName);
                    $(`#${detailIdPrefix}_code`).text(productCode);
                    $(`#${detailIdPrefix}_price`).text("Rp " + parseInt(productPrice).toLocaleString("id-ID"));
                    $(`#${detailIdPrefix}_stocks`).text(productStocks);

                    $(`#${detailIdPrefix}_detail`).show();
                } else {
                    $(`#${detailIdPrefix}_detail`).hide();
                }


            }

            $('#products_id').change(function() {
                productDetails('#products_id', 'product');
                var selectedOption = $(this).find('option:selected');
                var price = selectedOption.data('price');

                $('#discount_price').attr('max', price);

            });

            if($('#products_id').val()){
                $('#products_id').trigger('change');
            }

            $('#free_products_id').change(function() {
                productDetails('#free_products_id', 'free_product');
            });

            if($('#free_products_id').val()){
                $('#free_products_id').trigger('change');
            }


            function discountPrice(selectedId, discountPercentage, showDiscountPriceId, discountPrice,
            minQuantity) {
                var selectedProduct = $(selectedId).find('option:selected');
                var productPrice = selectedProduct.data('price');

                if (productPrice > 0 && discountPercentage > 0) {
                    var finalPrice = (productPrice * minQuantity) - (productPrice * (discountPercentage / 100));
                    $(showDiscountPriceId).text("Rp " + finalPrice.toLocaleString("id-ID"));
                    $(discountPrice).val(finalPrice.toFixed(2));
                } else {
                    $(discountPrice).val(null);
                    $(showDiscountPriceId).text('-');
                }
            }

            $('input[name="discount_percentage"]').on('input', function() {
                var discountPercentage = $(this).val();
                var minQuantity = $('#min_quantity').val();
                discountPrice('#products_id', discountPercentage, '#show_discount_price',
                    'input[name="discount_price"]', minQuantity);
            });

            if($('#discount_price').val()){
                $('input[name="discount_percentage"]').trigger('input');
            }

            $('input[name="min_quantity"]').on('input', function() {
                var minQuantity = $(this).val();
                var discountPercentage = $('#discount_percentage').val();
                discountPrice('#products_id', discountPercentage, '#show_discount_price',
                    'input[name="discount_price"]', minQuantity);
            });

            function setDependentInput(inputSelector, dependentSelector, showDiscountPriceId = null, discountPrice =
                null) {
                $(inputSelector).on('input', function() {
                    let value = $(this).val();

                    if (value !== "" && value !== null) {
                        $(dependentSelector).prop("disabled", false);
                    } else {
                        if (showDiscountPriceId) $(showDiscountPriceId).text('-');
                        $(dependentSelector).prop("disabled", true).val("");
                        if (discountPrice) $(discountPrice).val(null);
                    }
                });
            }

            setDependentInput('#products_id', '#discount_percentage', '#show_discount_price',
                'input[name="discount_price"]');
            setDependentInput('#products_id', '#discount_price');
            setDependentInput('#products_id', '#min_quantity');
            setDependentInput('#free_products_id', '#quantity_free_products');
            setDependentInput('#free_products_id', '#discount_price');

            if ($('#products_id').val()) {
                $('#products_id').trigger('input').trigger('change');
                $('input[name="discount_percentage"]').trigger('input');
            }


        });
    </script>
@endsection

