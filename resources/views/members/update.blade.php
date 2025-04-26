@extends('layouts.main_layouts')
@section('breadcrumb', 'Members')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Detail Member</h5>
            <form action="{{ route('members.update', $member->id)}}" method="POST" enctype="multipart/form-data" class="row p-3" id="category-form">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Member Name</label>
                        <input type="text" name="member_name" class="form-control border p-2" required value="{{ old('member_name', $member->member_name)}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel"  pattern="\d{10,}" name="phone_number" class="form-control border p-2" required value="{{ old('phone_number', $member->phone_number)}}">
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label">Point</label>
                        <input type="integer" name="point" class="form-control border p-2" value="{{ old('point', $member->point ?? "0")}}">
                    </div> --}}
                </div>

                <div class="col-md-6">
                    <div class="mb-5">
                        <label class="form-label">Created at</label>
                        <input type="date"  name="created_at" class="form-control border p-2" required value="{{ old('created_at', $member->created_at->format('Y-m-d'))}}" readonly disabled>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary px-5" onclick="window.history.back()">Back</button>
                        <button type="submit" class="btn bg-gradient-dark ms-2 px-5">Update</button>
                    </div>
                </div>


            </form>

        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12  mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Bill</h6>
                            <p class="text-sm mb-0">
                                <span class=""> Total Bill : </span> {{ $total_bills }}
                            </p>
                        </div>

                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No</th>
                                    <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Bill ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Payment method</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Branch</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Grand Total</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        More</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $index => $bill )
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$index + 1 }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$bill->id }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$bill->payment->payment_type }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$bill->payment->status }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$bill->branch->branch_name }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">Rp {{number_format($bill->grand_total) }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$bill->created_at}}</span>
                                    </td>
                                    <td class="align-middle">
                                        <button type="submit" class="btn btn-outline-dark btn-receipt"
                                        data-id="{{ $bill->id }}">
                                        Receipt
                                    </button>
                                    @include('components.modal-receipt')
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
    <script>
        $(document).ready(function() {
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
