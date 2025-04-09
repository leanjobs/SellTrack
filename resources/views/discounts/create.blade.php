@extends('layouts.main_layouts')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New Discount</h5>
            <form action="{{ request('type') ? route('discounts.store') : '' }}" method="POST" enctype="multipart/form-data"
                class="row p-3" id="discount-form">
                @csrf

                @if (request('type'))
                    @if (request('type') == 'buy_x_get_y')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required>
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
                                            data-price="{{ $product->price }}">{{ $product->product_name }} -
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
                                <input type="number" name="min_quantity" class="form-control border p-2" required>
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
                                            data-price="{{ $product->price }}">{{ $product->product_name }} -
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
                                    required>
                            </div>
                        </div>
                    @elseif (request('type') == 'percentage_off')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required>
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
                                            data-price="{{ $product->price }}">{{ $product->product_name }} -
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
                                    id="min_quantity" required disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Percentage</label>
                                <input type="number" name="discount_percentage" id="discount_percentage"
                                    class="form-control border p-2" required disabled min="0" max="100">
                            </div>
                            <p class="text-sm mb-0 ms-1"><span class="text-bold">Discount Price :</span> <span
                                    id="show_discount_price"></span></p>
                            <input type="number" name="discount_price" class="form-control border p-2" hidden>
                        </div>
                    @elseif (request('type') == 'cheap_redemption')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Min Total Price</label>
                                <input type="number" name="min_total_price" class="form-control border p-2" required>
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
                                            data-price="{{ $product->price }}">{{ $product->product_name }} -
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
                                    class="form-control border p-2" required disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Price</label>
                                <input type="number" name="discount_price" id="discount_price"
                                    class="form-control border p-2" required disabled min="0">
                            </div>
                        </div>
                    @elseif (request('type') == 'member')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount Name</label>
                                <input type="text" name="discount_name" class="form-control border p-2" required>
                            </div>
                            @if (auth()->user()->role === 'super_admin')
                                @include('components.form-discount-super-admin')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control border p-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control border p-2" required>
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
                                            data-price="{{ $product->price }}">{{ $product->product_name }} -
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
                                    id="min_quantity" required disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Percentage</label>
                                <input type="number" name="discount_percentage" id="discount_percentage"
                                    class="form-control border p-2" required disabled min="0" max="100">
                            </div>
                            <p class="text-sm mb-0 ms-1"><span class="text-bold">Discount Price :</span> <span
                                    id="show_discount_price"></span></p>
                            <input type="number" name="discount_price" class="form-control border p-2" hidden>
                        </div>
                    @endif
                @else
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Discount Type</label>
                            <select name="type" id="type" class="form-select select2 bg-transparent border p-2"
                                aria-label="Default select example">
                                <option value="" selected disabled>Select and search</option>
                                @if (auth()->user()->role === 'super_admin')
                                    <option value="member">Member</option>
                                @endif
                                <option value="cheap_redemption">Cheap Redemption</option>
                                <option value="percentage_off">Percentage Off</option>
                                <option value="buy_x_get_y">Buy X get Y</option>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-12 ps-3">
                    <button type="button" class="btn btn-outline-secondary px-5"
                        onclick="window.history.back()">Back</button>
                    @if (!request('type'))
                        <button type="button" id="next-btn" class="btn bg-gradient-dark ms-2 px-5">Next</button>
                    @else
                        <button type="submit" class="btn bg-gradient-dark ms-2 px-5">Submit</button>
                    @endif
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

            $('#type').change(function() {
                var selectedType = $(this).val();

                if (selectedType && selectedType !== "") {
                    localStorage.setItem('discount_type', selectedType);
                    $('#next-btn').prop('disabled', false);
                } else {
                    $('#next-btn').prop('disabled', true);
                }
            });

            var storedDiscountType = localStorage.getItem('discount_type');
            if (storedDiscountType) {
                $('#hidden_discount_type').val(storedDiscountType);
                $('#type').val(storedDiscountType).trigger('change');
                $('#next-btn').prop('disabled', false);
            } else {
                $('#type').val(null).trigger('change');
                $('#next-btn').prop('disabled', true);
            }

            $('#next-btn').click(function() {
                var selectedType = $('#type').val();
                if (selectedType) {
                    console.log(selectedType);
                    window.location.href = `{{ route('discounts.create') }}?type=${selectedType}`;
                }
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


            $('#free_products_id').change(function() {
                productDetails('#free_products_id', 'free_product');
            });

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


        });
    </script>
@endsection
