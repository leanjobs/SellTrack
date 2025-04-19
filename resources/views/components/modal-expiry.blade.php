<div class="modal fade" id="expiryModal" tabindex="-1" role="dialog" aria-labelledby="expiryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-weight-bold" id="expiryModalLabel">Product Close to Expiry</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    No</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Product Code</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Product Name</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Current Stocks</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Expired</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Add Discount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($closeExpired as $index => $product )
                            <tr>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">{{$index + 1 }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">{{$product->product_detail->product_code }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">{{$product->product_detail->product_name }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold link-offset-2">
                                        {{$product->current_stocks }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold link-offset-2">
                                        {{$product->expired }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{-- <button type="button" class="btn btn-outline-secondary">Add</button> --}}
                                    <a href="{{ route('discounts.create', ['product_id' => $product->product_detail->id]) }}" class="btn btn-outline-secondary">Add</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn bg-gradient-primary btn-print">Print</button> --}}
            </div>
        </div>
    </div>
</div>
