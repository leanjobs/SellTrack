@extends('layouts.main_layouts')
@section('breadcrumb', 'Cashier')
@section('content')
    <div class="row">
        <div class="col-xl-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="">
                    <h3 class="mb-0 h4 font-weight-bolder ">Cashier</h3>
                    <p class="mb-0">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <select name="set-select-item" class="form-select border " aria-label="Default select example"
                        id="set-select-item">
                        {{-- <option value="" selected disabled>-- Select a time --</option> --}}
                        <option value="list" selected>-- List --</option>
                        <option value="scan">-- Scan --</option>
                    </select>
                </div>
            </div>
            {{-- scanner --}}
            <div id="scan-section" class="d-none">
                <div id="reader"></div>
                <div id="scan-result" class="d-none">
                    <p id="prodcut-code">hello</p>
                    <input type="hidden" id="scan-product-code" name="scan-product-code">
                    <button id="start-scan" class="btn btn-dark">Start Scan</button>
                </div>
            </div>
            {{-- category section --}}
            <div class="d-flex overflow-x-auto gap-3" id="category-section" style="max-width: 100%; white-space: nowrap;">
                <div class="col-3 pb-3">
                    <button class="btn border-0  w-100 p-0 filter_category" data-category="all">
                        <div class="card bg-dark">
                            <div class="card-header p-2 pb-0 bg-dark">
                                <h6 class="mb-0 text-center text-white">All</h6>
                            </div>
                            {{-- <hr class="dark horizontal my-0 " style="color: white"> --}}
                            <div class="card-footer p-2 pt-0">
                                <p class="mb-0 text-xs text-center text-white">{{ $products->count() }} products in stocks
                                </p>
                            </div>
                        </div>
                    </button>
                </div>

                @foreach ($categories as $category)
                    <div class="col-3 pb-3">
                        <button class="btn border-0 bg-transparent w-100 p-0 filter_category"
                            data-category="{{ $category->id }}">
                            <div class="card">
                                <div class="card-header p-2 pb-0">
                                    <h6 class="mb-0 text-center">{{ $category->category_name }}</h6>
                                </div>
                                {{-- <hr class="dark horizontal my-0"> --}}
                                <div class="card-footer p-2 pt-0 ">
                                    <p class="mb-0 text-xs text-center">{{ $category->products_count }} products in stocks
                                    </p>
                                </div>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>
            {{-- products section --}}
            <div class="row" id="products_list">
                @include('components.filtered-products')
                {{-- @foreach ($products as $product)
                <div class="col-md-3 col-sm-4 col-6 py-2">
                    <div class="card">
                        <div class="card-header mt-1 text-center">
                            <img src="{{ asset('assets/img/meeting.jpg') }}" alt="product img"
                                style="height: 90px; width:90px;  object-fit: cover;" class="rounded">
                        </div>
                        <div class="card-body pt-0 text-center">
                            <h6 class="text-center mb-0">{{ $product->product_name}}</h6>
                            <span class="text-xs">Stok : 1</span>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0">{{ $product->price }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach --}}
            </div>
        </div>
        {{-- invoice section --}}
        <div class="col-xl-5">
            <div class="card p-4" style="max-height: 100%">
                <div class="d-flex justify-content-between">
                <h3>Invoice</h3>
                <button class="btn d-flex align-items-center bg-dark rounded" id="btn-refresh">
                    <i class="material-symbols-rounded fs-5 text-white">refresh</i>
                  </button>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="mb-0 text-dark pe-3">Members</h5>
                        <a href="{{ route('members.create') }}"
                            class="d-flex align-items-center bg-dark rounded-circle">
                            <i class="material-symbols-rounded fs-5 text-white">add</i>
                        </a>
                    </div>
                    <select name="members_id" id="members_id" class="form-select select2 bg-transparent border p-2"
                        aria-label="Default select example">
                        <option value="" selected disabled>-- Search Member's Phone Number --</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" data-phone="{{ $member->phone_number }}"
                                data-name="{{ $member->member_name }}">{{ $member->phone_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2"style="display:none;" id="member_detail">
                    <p class="text-sm mb-1 text-start"><span class="text-bold">Member Name :</span> <span
                            id="member_name"></span></p>
                    <p class="text-sm mb-0 text-start"><span class="text-bold">Phone Number :</span> <span
                            id="member_phone"></span></p>
                </div>
                <div class="" id="bill-section">
                    <div class="overflow-y-auto mb-3" style="max-height: 50vh; overflow-y: auto;" id="cart_items">
                        {{-- <div class="row d-flex align-items-center mb-3">
                            <div class="col-3">
                                <img src="{{ asset('assets/img/meeting.jpg') }}" alt="product img"
                                    style="height: 90px; width:90px;  object-fit: cover;">
                            </div>
                            <div class="col-9">
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark fs-6 fw-bold">Producttt</p>
                                    <i class="material-symbols-rounded fs-5 text-dark">delete</i>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex">
                                        <button class="btn border-0  w-100 p-0">
                                            <i
                                            class="material-symbols-rounded fs-5 text-dark d-flex align-items-center border border-dark rounded-circle p-1 border-2">add</i>
                                        </button>
                                        <p class="text-dark fs-6 fw-bold px-4 mb-0">1</p>
                                        <button class="btn border-0  w-100 p-0">
                                            <i class="material-symbols-rounded fs-5 text-dark d-flex align-items-center border border-dark rounded-circle p-1 border-2">remove</i>
                                        </button>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-dark fs-6 fw-bold mb-0">Rp 20.000</p>
                                        <p class="text-dark fs-6 fw-bold mb-0">Rp 200.000</p>

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div id="selected_cheap_redemptions">
                        {{-- <div class="mb-3 p-3 border border-dark rounded selected_cheap_redemption"  style="min-width: 100%; max-width:100%" >
                            <div class="d-flex justify-content-between">
                            <p class="fs-6 text-dark mb-0 text-m text-bold">Tebus Murah</p>
                            <button type="button" class="btn bg-success mb-2 px-2 py-1 text-white">Add</button>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fs-6 text-dark mb-0 ">Min. Total Price</p>
                                <p class="fs-6 text-dark mb-0 ">Rp 100.000</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fs-6 text-dark mb-0 ">SUSU - 010101010</p>
                                <p class="fs-6 text-dark mb-0 ">x1</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fs-6 text-dark mb-0 "></p>
                                <p class="fs-6 text-dark mb-0 ">Rp 10.000</p>
                            </div>
                        </div> --}}
                    </div>
                    <h5 class="mb-2 text-dark">Cheap Redemptions</h5>
                    <div class="d-flex overflow-x-auto gap-3" style="max-width: 100%; white-space: nowrap;"
                        id="cheap_redemptions_items">
                        @foreach ($discounts as $discount)
                            @if ($discount->type === 'cheap_redemption')
                                <div class="mb-3 p-3 border border-gray-400 rounded cheap_redemption_item"
                                    style="min-width: 100%; max-width:100%" data-id="{{ $discount->id }}"
                                    data-min-price="{{ $discount->detail_discounts->min_total_price }}"
                                    data-discount-price="{{ $discount->detail_discounts->discount_price }}"
                                    data-products-id="{{ $discount->detail_discounts->products_id }}"
                                    data-quantity="{{ $discount->detail_discounts->min_quantity }}">
                                    <div class="d-flex justify-content-between">
                                        <p class="fs-6 text-gray-400 mb-0 text-m text-bold discount_name ">
                                            {{ $discount->discount_name }}</p>
                                        <button type="button" class="btn bg-success mb-2 px-2 py-1 text-white"
                                            disabled>Add</button>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fs-6 text-gray-400 mb-0">Min. Total Price</p>
                                        <p class="fs-6 text-gray-400 mb-0 min_price">Rp
                                            {{ number_format($discount->detail_discounts->min_total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fs-6 text-gray-400 mb-0 detail_product">
                                            {{ $discount->detail_discounts->free_product->product_name }} -
                                            {{ $discount->detail_discounts->free_product->product_code }}</p>
                                        <p class="fs-6 text-gray-400 mb-0 ">
                                            x{{ $discount->detail_discounts->min_quantity }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fs-6 text-gray-400 mb-0 "></p>
                                        <p class="fs-6 text-gray-400 mb-0 discount_price">Rp
                                            {{ number_format($discount->detail_discounts->discount_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <h5 class="mb-0 text-dark">Payement Summary</h5>
                        <div class="d-flex justify-content-between">
                            <p class="fs-6 text-dark mb-0">Total Price</p>
                            <p class="fs-6 text-dark mb-0 total_price">Rp 0</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fs-6 text-dark mb-0">Tax</p>
                            <p class="fs-6 text-dark mb-0 tax">Rp 0</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="fs-5 fw-bold text-dark mb-0">Grand Total</h5>
                            <h5 class="fs-5 fw-bold text-dark mb-0 grand_total">Rp 0</h5>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-3 ">
                    <button class="btn border-0 p-1 mx-3 payment_method active">
                        <i class="material-symbols-rounded fs-2 text-white d-flex align-items-center border border-dark rounded p-1 border-2 p-2  bg-dark "
                            data-method="cash">payments</i>
                    </button>
                    <button class="btn border-0 p-1 mx-3 payment_method">
                        <i class="material-symbols-rounded fs-2 text-dark d-flex align-items-center border border-dark rounded p-1 border-2 p-2 "
                            data-method="qr">qr_code_scanner</i>
                    </button>
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    @include('components.modal-receipt')
                    <button type="button" class="btn bg-gradient-dark w-100 btn_place_order" disabled>Place an
                        Order</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{  env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        $(document).ready(function() {
            function BillSavedToLocalStorage() {
                var billHtml = $('#bill-section').html();
                localStorage.setItem('billHtml', billHtml);
            }

            function ProductSavedToLocalStorage() {
                var productsList = $('#products_list').html();
                localStorage.setItem('productsList', productsList);
            }

            function MemberSavedToLocalStorage() {
                var memberId = $("#members_id").val()
                localStorage.setItem('memberId', memberId);
            }

            var billHtml = localStorage.getItem('billHtml');
            var productsList = localStorage.getItem('productsList');
            var memberId = localStorage.getItem('memberId');
            if (billHtml) {
                $('#bill-section').html(billHtml);
                updateSummary();
            }

            if (productsList) {
                $('#products_list').html(productsList);
            }

            if (memberId) {
                $("#members_id option").each(function() {
                    if ($(this).val() == memberId) {
                        $(this).attr('selected', 'selected');
                    }
                });
            }

            $('#members_id').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: "-- Search Member's Phone Number --",
                allowClear: true
            });

            let html5QRCodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 2,
                    qrbox: 300,
                }
            );

            function onScanSuccess(decodedText, decodedResult) {
                console.log("decode", decodedResult.decodedText);
                $('#prodcut-code').text("Hasil Scan: " + decodedText);
                $('#scan-product-code').val(decodedText);

                let scannedProduct = $(`.product_item[data-code="${decodedText}"]`);
                if (scannedProduct.length > 0) {
                    scannedProduct.trigger('click');
                    html5QRCodeScanner.pause();
                    $('#scan-result').removeClass('d-none');
                    $('#scan-result').addClass('d-flex justify-content-between');

                } else {
                    console.log("Produk tidak ditemukan dari hasil scan:", decodedText);
                }
            }

            html5QRCodeScanner.render(onScanSuccess);

            $('#start-scan').on('click', function() {
                $('#scan-result').addClass('d-none');
                $('#scan-result').removeClass('d-flex justify-content-between');
                html5QRCodeScanner.resume();
            });

            $('#set-select-item').on('change', function() {
                let selected = $(this).val();

                if (selected === 'scan') {
                    $('#category-section').addClass('d-none');
                    $('#products_list').addClass('d-none');
                    $('#scan-section').removeClass('d-none');

                    if ($('#reader').is(':empty')) {
                        console.log("teste")

                        html5QRCodeScanner.render(onScanSuccess);
                    }

                } else if (selected === 'list') {
                    $('#category-section').removeClass('d-none');
                    $('#products_list').removeClass('d-none');
                    $('#scan-result').addClass('d-none');
                    $('#scan-result').removeClass('d-flex justify-content-between');


                    html5QRCodeScanner.clear().then(() => {
                        $('#reader').empty();
                        console.log("Scanner stopped dan UI dibersihkan");
                    }).catch(err => {
                        console.error("Gagal clear scanner:", err);
                    });
                }
            });

            if ($('#set-select-item').val()) {
                $('#set-select-item').trigger('change');
            }


            $("#btn-refresh").on('click', function(){
                localStorage.clear();
                    setTimeout(function() {
                    location.reload();
                }, 500);
            });

            $(".filter_category").on("click", function() {
                let categoryId = $(this).data("category");
                if ($(this).hasClass("active")) return;

                $(".filter_category").removeClass("active").find(".card, .card-header, h6, p")
                    .removeClass("bg-dark text-white");

                $(this).addClass("active").find(".card, .card-header, h6, p")
                    .addClass("bg-dark text-white");


                $("#products_list").html('<p class="text-center pt-3">Loading...</p>');


                $.ajax({
                    url: "{{ route('filter.products') }}",
                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $("#products_list").html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $(".payment_method").on("click", function() {
                if ($(this).hasClass("active")) return;

                $(".payment_method").removeClass("active").find("i").removeClass("bg-dark text-white")
                    .addClass("text-dark");
                $(this).addClass("active").find("i").addClass("bg-dark text-white");
            });

            function updateSummary() {
                let totalPrice = 0;

                $('.cart_item').each(function() {
                    let cartTotalPrice = parseInt($(this).find('.cart_total_price').text().replace("Rp ",
                        "").replace(/\./g, ""));
                    let afterDiscountPrice = parseInt($(this).find('.after_discount_price').text().replace(
                        "Rp ", "").replace(/\./g, ""));

                    if (!isNaN(afterDiscountPrice) && afterDiscountPrice) {
                        totalPrice += afterDiscountPrice;
                    } else {
                        totalPrice += cartTotalPrice;
                    }
                });

                $('.selected_cheap_redemption').each(function() {
                    let discountPrice = parseInt($(this).data('discount-price')) || 0;
                    totalPrice += discountPrice;
                });

                let tax = totalPrice * 0.10;
                let grandTotal = totalPrice + tax;

                if ($(".cart_item").length === 0) {
                    totalPrice = 0;
                    tax = 0;
                    grandTotal = 0;

                    $(".btn_place_order").prop("disabled", true);
                } else {
                    $(".btn_place_order").prop("disabled", false);
                }

                $(".total_price").text("Rp " + totalPrice.toLocaleString("id-ID"));
                $(".tax").text("Rp " + tax.toLocaleString("id-ID"));
                $(".grand_total").text("Rp " + grandTotal.toLocaleString("id-ID"));
                cheapRedemption();
            }

            function membersDetails(selectedId, detailIdPrefix) {
                let selectedMember = $(selectedId).find('option:selected');
                let memberName = selectedMember.data('name');
                let memberId = selectedMember.val();
                let phoneNumber = selectedMember.data('phone');

                if (memberId && memberName && phoneNumber) {
                    $(`#${detailIdPrefix}_name`).text(memberName);
                    $(`#${detailIdPrefix}_phone`).text(phoneNumber);

                    $(`#${detailIdPrefix}_detail`).show();
                } else {
                    $(`#${detailIdPrefix}_detail`).hide();
                }
            }

            $('#members_id').change(function() {
                membersDetails('#members_id', 'member');

                $('.cart_item').each(function() {
                    let productId = $(this).data('id');
                    let productPrice = $(this).data('price');
                    updateDiscountItem(productId, productPrice);
                    updateSummary();
                });
                MemberSavedToLocalStorage();
            });

            function updateCartItem(productId, productChange = 0, quantityChange = 0, remove = false) {
                let cartItem = $(`.cart_item[data-id="${productId}"]`);
                let cartProductQuantity = cartItem.find(".cart_product_quantity");
                let cartTotalPrice = cartItem.find(".cart_total_price");
                let productStock = $(`.product_item[id="${productId}"]`).find(".product_stock");
                let addBtn = cartItem.find(".add-item");

                let quantity = parseInt(cartProductQuantity.text()) + quantityChange;
                let stock = parseInt(productStock.text()) - productChange;
                let price = parseInt(cartItem.data("price"));

                console.log("stock", stock);

                if (remove) {
                    let resetStock = stock + quantity;
                    productStock.text(resetStock);
                    $(`.product_item[id=${productId}]`).prop("disabled", false).removeClass("disabled");
                    updateSummary();
                    cartItem.remove();
                } else {
                    if (quantity <= 0) {
                        cartItem.remove();
                        updateSummary();
                    } else {
                        cartProductQuantity.text(quantity);
                        cartTotalPrice.text("Rp " + (quantity * price).toLocaleString("id-ID"));
                        updateSummary();
                    }

                    productStock.text(stock);
                    if (stock <= 0) {
                        $(`.product_item[id=${productId}]`).prop("disabled", true).addClass("disabled");
                        addBtn.prop("disabled", true).addClass("disabled");
                    } else {
                        $(`.product_item[id=${productId}]`).prop("disabled", false).removeClass("disabled");
                        addBtn.prop("disabled", false).removeClass("disabled");
                    }
                }
            }

            function updateDiscountItem(productId, productPrice, remove = false) {
                let discountItem = $(`.discount_item[data-id="${productId}"]`);
                let discountPrice = parseInt(discountItem.data('price'));
                let discountType = discountItem.data('type');
                let cartItem = $(`.cart_item[data-id="${productId}"]`);
                let cartTotalPrice = parseInt(cartItem.find(".cart_total_price").text().replace("Rp ", "").replace(
                    /\./g, ""));
                let cartProductQuantity = parseInt(cartItem.find(".cart_product_quantity").text());
                let afterDiscountQuantity = discountItem.find(".free_discount_quantity");
                let afterDiscountPrice = discountItem.find(".after_discount_price");
                let productStock = parseInt($(`.product_item[id="${productId}"]`).find(".product_stock").text());
                let discountsData = @json($discounts);
                let selectedMembers = $("#members_id").val();

                discountsData.forEach(discount => {
                    const detail = discount.detail_discounts;
                    let discountInstances = Math.floor(cartProductQuantity / discount.detail_discounts
                        .min_quantity);
                    let discountCard = `
                                <div class="row d-flex align-items-center mb-3 discount_item px-0" data-id="${productId}" data-price="${detail.discount_price}" data-type="${discount.type}" id="${discount.id}">
                                <div class="col-3">
                                </div>
                                <div class="col-9 px-0">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-dark fs-6 fw-bold mb-0  text-start">${discount.discount_name}</p>
                                        <p class="text-dark fs-6 fw-bold  mb-0  text-end">${discount.type}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-dark fs-6 fw-bold mb-0  text-start">Minimal</p>
                                        <p class="text-dark fs-6 fw-bold  mb-0  text-end">x${detail.min_quantity}</p>
                                    </div>
                                <div class="d-flex justify-content-between">
                                        <p class="text-dark fs-6 fw-bold   text-start">${discount.type == "buy_x_get_y" ? detail.free_product.product_name + " - " + detail.free_product.product_code : detail.discount_percentage + "%"}</p>
                                        <p class="text-dark fs-6 fw-bold  after_discount  text-end">${discount.type == "buy_x_get_y" ? `<span class="free_discount_quantity">x${detail.quantity_free_products}</span>` : `<span class="after_discount_price">  Rp ${ (parseInt( detail.discount_price ).toLocaleString("id-ID"))} </span>`  }</p>
                                    </div>
                                </div>
                            </div>
                            `;

                    if (discount.type === "cheap_redemption") return;
                    if (detail.products_id == productId) {
                        if (productStock > 0) {
                            if (cartProductQuantity >= detail.min_quantity) {
                                if (cartProductQuantity > detail.min_quantity) {
                                    if (discountType == "percentage_off") {
                                        // percentage_off
                                        afterDiscountPrice.text("Rp " + (((cartProductQuantity % discount
                                            .detail_discounts.min_quantity) * productPrice) + (
                                            discountInstances * discountPrice)).toLocaleString(
                                            "id-ID"));
                                        updateSummary();
                                        BillSavedToLocalStorage();
                                        ProductSavedToLocalStorage();
                                    } else if (discountType == "buy_x_get_y") {
                                        // buy x get y
                                        let freeDiscountQuantity = discountInstances * discount
                                            .detail_discounts.quantity_free_products;
                                        console.log("remove", remove);
                                        if(remove){
                                            updateCartItem(productId, -detail.quantity_free_products);
                                        }else{
                                            updateCartItem(productId, +(freeDiscountQuantity - parseInt(
                                            afterDiscountQuantity.text().replace("x", "").replace(/\./g,
                                                ""))));
                                        }

                                        afterDiscountQuantity.text("x" +freeDiscountQuantity);
                                        updateSummary();
                                        BillSavedToLocalStorage();
                                        ProductSavedToLocalStorage();

                                    } else if ((discountType == "member" || discount.type == "member") &&
                                        selectedMembers) {
                                        if (discountItem.length === 0) {
                                            cartItem.append(discountCard);
                                        }
                                        afterDiscountPrice = cartItem.find(".after_discount_price");
                                        let test = (((cartProductQuantity % detail.min_quantity) *
                                            productPrice) + (discountInstances * discountPrice));
                                        afterDiscountPrice.text("Rp " + (((cartProductQuantity % discount
                                                .detail_discounts.min_quantity) * productPrice) + (
                                                discountInstances * detail.discount_price))
                                            .toLocaleString("id-ID"));
                                        updateSummary();
                                        BillSavedToLocalStorage();
                                        ProductSavedToLocalStorage();
                                    } else {
                                        cartItem.find(".discount_item").remove();
                                    }
                                } else {

                                    if (discount.type === "buy_x_get_y" && remove == false) {
                                        updateCartItem(productId, +detail.quantity_free_products);
                                    }

                                    if (discount.type === "buy_x_get_y" && remove == true) {
                                        updateCartItem(productId, -detail.quantity_free_products);
                                    }

                                    cartItem.find(".discount_item").remove();

                                    if ((discount.type == "member" && selectedMembers) || discount.type !=
                                        "member") {
                                        console.log("hello");
                                        cartItem.append(discountCard);
                                    }
                                    updateSummary();
                                    BillSavedToLocalStorage();
                                    ProductSavedToLocalStorage();

                                }
                            } else {
                                if (discount.type === "buy_x_get_y" && remove == true) {
                                        updateCartItem(productId, -detail.quantity_free_products);
                                    }

                                cartItem.find(".discount_item").remove();
                            }
                        } else {
                            console.log("outofstc")
                        }

                    }
                });
            }



            $('.product_item').on('click', function() {
                console.log("hasil product di clisk", $(this));
                let productId = $(this).attr("id");
                let productName = $(this).find(".product_name").text();
                let productPrice = $(this).find(".product_price").text().replace("Rp ", "").replace(/\./g,
                    "");
                let productImage = $(this).find(".product_img").attr("src");
                let productStock = $(this).find(".product_stock");

                if (parseInt(productStock.text()) <= 0) return;


                let checkCartItem = $(`.cart_item[data-id="${productId}"]`);


                if (checkCartItem.length > 0) {
                    updateCartItem(productId, +1, +1);
                    updateDiscountItem(productId, productPrice);
                    BillSavedToLocalStorage();
                    ProductSavedToLocalStorage();

                } else {
                    let cartItem = `
                    <div class="row d-flex align-items-center mb-3 cart_item" data-id="${productId}" data-price="${productPrice}">
                            <div class="col-3">
                                <img src="${productImage}" alt="product img"
                                    style="height: 90px; width:90px;  object-fit: cover;">
                            </div>
                            <div class="col-9">
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark fs-6 fw-bold  cart_product_name">${productName}</p>
                                    <button class="btn border-0 p-0 delete-item">
                                         <i class="material-symbols-rounded fs-5 text-dark">delete</i>
                                        </button>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex">
                                    <button class="btn border-0 w-100  p-1 add-item">
                                            <i
                                            class="material-symbols-rounded fs-5 text-dark d-flex align-items-center border border-dark rounded-circle p-1 border-2">add</i>
                                        </button>
                                        <p class="text-dark fs-6 fw-bold px-4 mb-0 cart_product_quantity">0</p>
                                    <button class="btn border-0  w-100 p-1 remove-item">
                                            <i class="material-symbols-rounded fs-5 text-dark d-flex align-items-center border border-dark rounded-circle p-1 border-2">remove</i>
                                            </button>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-dark fs-6 fw-bold mb-0">Rp ${(parseInt(productPrice)).toLocaleString("id-ID")}</p>
                                        <p class="text-dark fs-6 fw-bold mb-0 cart_total_price">Rp ${productPrice.toLocaleString("id-ID")}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                `;

                    $('#cart_items').append(cartItem);
                    updateCartItem(productId, +1, +1);
                    updateDiscountItem(productId);
                    BillSavedToLocalStorage();
                    ProductSavedToLocalStorage();

                }

            });

            $("#cart_items").on("click", ".add-item", function() {
                let productId = $(this).closest(".cart_item").data("id");
                let productPrice = $(this).closest(".cart_item").data("price");
                updateCartItem(productId, +1, +1);
                updateDiscountItem(productId, productPrice);
                cheapRedemption();
                updateSummary();
                BillSavedToLocalStorage();
                ProductSavedToLocalStorage();
            });

            $("#cart_items").on("click", ".remove-item", function() {
                let productId = $(this).closest(".cart_item").data("id");
                let productPrice = $(this).closest(".cart_item").data("price");

                updateCartItem(productId, -1, -1);
                updateDiscountItem(productId, productPrice, true);
                cheapRedemption();
                updateSummary();
                BillSavedToLocalStorage();
                ProductSavedToLocalStorage();

            });

            $("#cart_items").on("click", ".delete-item", function() {
                let productId = $(this).closest(".cart_item").data("id");
                let productPrice = $(this).closest(".cart_item").data("price");

                updateCartItem(productId, 0, 0, true);
                updateSummary();
                updateDiscountItem(productId, productPrice);
                cheapRedemption();
                BillSavedToLocalStorage();
                ProductSavedToLocalStorage();


            });

            function cheapRedemption() {
                try {
                    let hasAdded = $('.cheap_redemption_item.added').length > 0;

                    $('.cheap_redemption_item').each(function() {
                        let minPrice = parseInt($(this).data('min-price'));
                        let discountId = $(this).data('id');
                        let isAdded = $(this).hasClass('added');
                        let btn = $(this).find('button');
                        let allText = $(this).find('p');
                        let totalPrice = parseInt($(".total_price").text().replace("Rp ", "").replace(/\./g, ""));

                        $(this).removeClass('border-dark border-gray-400').removeClass(
                            'added inactive active');
                        btn.removeClass('bg-success bg-danger').prop('disabled', false).text('Add');
                        allText.removeClass('text-dark text-gray-400');

                        if (totalPrice >= minPrice) {
                            if (isAdded) {
                                $(this).addClass('border-dark added');
                                btn.addClass('bg-danger').text('Cancel');
                                allText.addClass('text-dark');
                            } else {
                                $(this).addClass('border-dark active');
                                btn.addClass('bg-success').text('Add');
                                allText.addClass('text-dark');

                                if (hasAdded) {
                                    $(this).addClass('border-gray-400 inactive').removeClass('border-dark');
                                    btn.addClass('bg-success').prop('disabled', true);
                                    allText.addClass('text-gray-400');
                                    allText.removeClass('text-dark');
                                }

                            }
                        } else {
                            $(this).addClass('border-gray-400 inactive');
                            btn.addClass('bg-success').prop('disabled', true);
                            allText.addClass('text-gray-400');
                            allText.removeClass('text-dark');
                            $(`#selected_cheap_redemptions .selected_cheap_redemption[data-id="${discountId}"]`)
                                .remove();

                        }

                        btn.addClass('text-white');
                    });
                } catch (err) {
                    console.log(err);
                }
            }

            $('.cheap_redemption_item button').on('click', function() {
                const card = $(this).closest('.cheap_redemption_item');
                let discountName = card.find('.discount_name').text();
                let minPrice = card.data('min-price');
                let discountId = card.data('id');
                let discountPrice = card.data('discount-price');
                let productsId = card.data('products-id');
                let quantityProducts = card.data('quantity');
                let detailProduct = card.find('.detail_product').text();

                if (card.hasClass('added')) {
                    card.removeClass('added');
                    $(`#selected_cheap_redemptions .selected_cheap_redemption[data-id="${discountId}"]`)
                        .remove();
                    updateCartItem(productsId, -quantityProducts);

                } else {
                    card.addClass('added');
                    let selectedCheapRedemptionItem = (`
                     <div class="mb-3 p-3 border border-dark rounded selected_cheap_redemption"  style="min-width: 100%;"  data-id="${discountId}" data-min-price="${minPrice}" data-discount-price="${discountPrice}" data-products-id="${productsId}" data-quantity="${quantityProducts}">
                        <div class="d-flex justify-content-between">
                        <p class="fs-6 text-dark mb-0 text-m text-bold">${discountName}</p>
                        <button type="button" class="btn bg-danger mb-2 px-2 py-1 text-white">Cancel</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fs-6 text-dark mb-0 ">Min. Total Price</p>
                            <p class="fs-6 text-dark mb-0 ">${ parseInt(minPrice).toLocaleString("id-ID")}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fs-6 text-dark mb-0 ">${detailProduct}</p>
                            <p class="fs-6 text-dark mb-0 ">x${quantityProducts}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fs-6 text-dark mb-0 "></p>
                            <p class="fs-6 text-dark mb-0 ">${ parseInt(discountPrice).toLocaleString("id-ID")}</p>
                        </div>
                    </div>
                `);
                    $('#selected_cheap_redemptions').append(selectedCheapRedemptionItem);
                    console.log("iddd", productsId);
                    updateCartItem(productsId, +quantityProducts);

                }
                cheapRedemption();
                updateSummary();
                BillSavedToLocalStorage();
                ProductSavedToLocalStorage();
            });

            $('#selected_cheap_redemptions').on('click', '.btn.bg-danger', function() {
                const selectedCheapRedemption = $(this).closest('.selected_cheap_redemption');
                const discountId = selectedCheapRedemption.data('id');
                const productsId = selectedCheapRedemption.data('products-id');
                const quantityProducts = selectedCheapRedemption.data('quantity');
                selectedCheapRedemption.remove();

                $(`.cheap_redemption_item[data-id="${discountId}"]`).removeClass('added');

                cheapRedemption();
                updateCartItem(productsId, -quantityProducts);
                updateSummary();
                BillSavedToLocalStorage();
                ProductSavedToLocalStorage();
            });





            $(".btn_place_order").on("click", function() {
                if ($(this).prop("disabled")) return;

                let cartItems = [];
                $(".selected_cheap_redemption").each(function() {
                    let minPrice = $(this).data('min-price');
                    let discountId = $(this).data('id');
                    let discountPrice = $(this).data('discount-price');
                    let productsId = $(this).data('products-id');
                    let quantityProducts = $(this).data('quantity');

                    let item = {
                        product_id: productsId,
                        quantity: quantityProducts,
                        total_price: discountPrice,
                        discounts_id: discountId,
                    }
                    cartItems.push(item);
                });

                $(".cart_item").each(function() {
                    let total_price = parseInt($(this).find(".cart_total_price").text().replace(
                        "Rp ", "").replace(/\./g, ""));
                    let quantity =  parseInt($(this).find(".cart_product_quantity").text());

                    let discountItem = $(this).find(".discount_item");

                    if (discountItem.length > 0) {
                        let afterDiscount = discountItem.find(".after_discount_price").text().replace("Rp ", "").replace(/\./g, "");
                        let afterDiscountQuantity = discountItem.find(".free_discount_quantity").text().replace("x", "").replace(/\./g, "");
                        if (!isNaN(afterDiscount) && afterDiscount !== "") {
                            total_price = parseInt(afterDiscount);
                        }
                        if (!isNaN(afterDiscountQuantity) && afterDiscountQuantity !== "") {
                        console.log(afterDiscountQuantity);
                            quantity += parseInt(afterDiscountQuantity);
                            console.log("qty", quantity)
                        }
                    }

                    let item = {
                        product_id: $(this).data("id"),
                        product_name: $(this).find(".cart_product_name").text(),
                        quantity: quantity,
                        total_price: total_price,
                        discounts_id: discountItem.attr("id") ?? null,
                    };
                    cartItems.push(item);
                });

                let totalPrice = parseInt($(".total_price").text().replace("Rp ", "").replace(/\./g, ""));
                let tax = parseInt($(".tax").text().replace("Rp ", "").replace(/\./g, ""));
                let grandTotal = parseInt($(".grand_total").text().replace("Rp ", "").replace(/\./g, ""));
                let selectedMembers = $("#members_id").val();
                let paymentMethod = $(".payment_method.active").find("i").data("method");

                let bills = {
                    members_id: selectedMembers,
                    total_price: totalPrice,
                    tax: tax,
                    grand_total: grandTotal,
                    items: cartItems,
                    payment_method: paymentMethod
                };

                console.log(bills);

                $.ajax({
                    url: "/bills",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    contentType: "application/json",
                    data: JSON.stringify(bills),
                    success: function(response) {
                        let snapToken = response.data.payment.snap_token;
                        if(response.data.payment.payment_type == "cash"){
                            showBill(response);
                        }else if( response.data.payment.payment_type == "qr"){
                            snap.pay(snapToken, {
                            onSuccess: function(result) {
                            //     $.ajax({
                            //     url: '/api/handle-midtrans',
                            //     method: 'POST',
                            //     data: {
                            //         _token: '{{ csrf_token() }}',
                            //         order_id: result.order_id,
                            //         transaction_status: result.transaction_status,
                            //     },
                            //     success: function(responseHandle) {
                            //         showBill(response);
                            //     },
                            //     error: function(xhr) {
                            //         alert("Gagal update data pembayaran.");
                            //     }
                            // });
                            showBill(response)
                            },
                            onPending: function(result) {
                            },
                            onError: function(result) {
                            }
                        });
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseText, "erorr");
                        console.log("error", xhr.responseText)
                    }
                });
            });

            function showBill(response){
                localStorage.clear();
                const bill = response.data.bill;
                const detail_bill = response.data.detail_bill;
                const date = new Date(bill.created_at);
                const formattedDate = date.toLocaleDateString('en-US');


                console.log(response.data);


                $(".modal-body .mb-3").html(`
                        <h6 class="mb-0 branch_name">${bill.branch.branch_name}</h6>
                        <small class="branch_code">${bill.branch.address}</small>
                `);
                $(".modal-body .mb-2").html(`
                    <strong>ID Bill:</strong> ${bill.id} <br>
                    <strong>ID Member:</strong> ${bill.member? bill.member.member_name : "-"} <br>
                    <strong>Branch Code:</strong> ${bill.branch.branch_code} <br>
                    <strong>Cashier:</strong> ${bill.users.user_name} <br>
                    <strong>Date:</strong> ${formattedDate}
                `);

                const listHtml = detail_bill.map(item => `
                    <li class="list-group-item">
                            <div class=" d-flex justify-content-between">
                            <span>${item.product.product_name}</span>
                            <span>Rp ${(parseInt(item.total_price)).toLocaleString("id-ID")}</span>
                        </div>
                        ${item.discount ? `
                        <div class="d-flex justify-content-between">
                            <span>${item.discount.discount_name}</span>
                            <span>${item.discount.type}</span>
                        </div>` : ''}
                    </li>
                `).join('');
                $(".modal-body .list-group").html(listHtml);

                const summary = `
                <div class="d-flex justify-content-between">
                    <span>Total Item:</span>
                    <span>Rp ${(parseInt(bill.total_price)).toLocaleString("id-ID")}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>PPN (10%):</span>
                    <span>Rp ${(parseInt(bill.tax)).toLocaleString("id-ID")}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Grand Total:</span>
                    <span>Rp ${(parseInt(bill.grand_total)).toLocaleString("id-ID")}</span>
                </div>
                `;
                $(".modal-body .payment-summary").html(summary);


                $("#receiptModal").modal("show");
            }

        });
    </script>
@endsection
