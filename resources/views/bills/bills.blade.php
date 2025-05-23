@extends('layouts.main_layouts')
@section('breadcrumb', 'Bills')
@section('route-print', route('print.bills'))
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between px-3">
                        <h6 class="text-white text-capitalize ">Bills table</h6>
                        @if (auth()->user()->role != "staff")
                            <a href="javascript:;" class="nav-link text-body p-0 d-flex align-items-center ms-auto p-1 bg-white rounded-3 shadow" id="dropdownFilterDate" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded text-dark" style="font-size: 30px">picture_as_pdf</i>
                            </a>
                            @include('components.dropdown-filter-date')
                        @endif
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <div class="d-flex  align-items-center px-3">
                            <div class="ms-auto pe-md-3 d-flex align-items-center">
                                <div class="input-group input-group-outline">
                                    {{-- <label class="form-label">Type here...</label>
                                    <input type="text" class="form-control">
                                    <span class="d-flex align-items-center justify-content-center ms-1">
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
                                        Total Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tax
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Grand Total</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Member's Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Cashier</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Payment</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td class="align-middle px-4 py-3">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $bill->id }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">Rp
                                                {{ number_format($bill->total_price) }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">Rp
                                                {{ number_format($bill->tax) }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span class="text-secondary text-xs font-weight-bold">Rp
                                                {{ number_format($bill->grand_total) }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $bill->member ? $bill->member->phone_number : '-' }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $bill->users->user_name }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $bill->payment->payment_type }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $bill->payment->status }}</span>
                                        </td>
                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $bill->created_at }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if ($bill->payment->status == "waiting")
                                                <button type="button" class="btn bg-gradient-dark pay-now"
                                                data-snap="{{ $bill->payment->snap_token }}">
                                                bayar
                                                </button>
                                            @else
                                                <button type="submit" class="btn bg-gradient-dark btn-receipt"
                                                    data-id="{{ $bill->id }}">
                                                    Receipt
                                                </button>
                                                @include('components.modal-receipt')
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $bills->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

    <script>
        $(document).ready(function() {
            $('.pay-now').on('click', function() {
                const snapToken = $(this).data("snap");
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        $.ajax({
                            url: '/api/handle-midtrans',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                order_id: result.order_id,
                                transaction_status: result.transaction_status,
                            },
                            success: function(responseHandle) {
                                // Refresh data atau tampilkan struk
                            },
                            error: function(xhr) {
                                alert("Gagal update data pembayaran.");
                            }
                        });
                    },
                    onPending: function(result) {
                        console.log("pending", result);
                    },
                    onError: function(result) {
                        alert("payment failed");
                    }
                });
            });

            $('.btn-receipt').on('click', function() {
                let billId = $(this).data('id');

                $.ajax({
                    url: "/bills/" + billId,
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    contentType: "application/json",
                    success: function(response) {
                        const bill = response.data.bill;
                        const payment = response.data.bill.payment;
                        const detail_bill = response.data.detail_bill;
                        const date = new Date(bill.created_at);
                        const formattedDate = date.toLocaleDateString('en-US');

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

                        $(".modal-footer .close-btn").html(`
                         <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    `);
                    $(".modal-body .payment-method").html(`
                            <small class="text-muted">Payment Method: <strong>${payment.payment_type}</strong></small>
                        `);


                        $("#receiptModal").modal("show");
                    },
                    error: function(xhr) {
                        alert(xhr.responeText);
                        console.log(xhr);
                    }
                });
            });

        });
    </script>
@endsection
