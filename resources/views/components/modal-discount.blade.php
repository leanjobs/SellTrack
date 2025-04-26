<div class="modal fade" id="discountModal-{{ $product->id }}" tabindex="-1" aria-labelledby="discountModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountModalLabel{{ $product->id }}">Detail Discount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-start">
                <strong>Discount Type:</strong> {{ $product->discounts[0]->type }} <br>
                <strong>Discount Name:</strong> {{ $product->discounts[0]->discount_name ?? '-' }}<br>
                <strong>Date:</strong> {{ $product->discounts[0] ? 'From ' . \Carbon\Carbon::parse($product->discounts[0]->start_date)->translatedFormat('l, d F Y') . ' To ' . \Carbon\Carbon::parse($product->discounts[0]->end_date)->translatedFormat('l, d F Y') : '-' }}<br>
                <strong>Min Total Price:</strong>Rp {{ number_format($product->discounts[0]->detail_discounts->min_total_price, 0,',', '.') ?? '-' }}<br>
                <strong>Product Name:</strong> {{ $product->discounts[0]->detail_discounts->product->product_name ?? '-' }}<br>
                <strong>Min Quantity:</strong> {{ $product->discounts[0]->detail_discounts->min_quantity ?? '-' }}<br>
                <strong>Free Product:</strong> {{ $product->discounts[0]->detail_discounts->free_product->product_name ?? '-' }}<br>
                <strong>Quantity Free Product:</strong> {{ $product->discounts[0]->detail_discounts->quantity_free_products ?? '-' }}<br>
                <strong>Discount Percentage:</strong> {{ $product->discounts[0]->detail_discount->discount_percentage ?? '-' }}<br>
                <strong>Discount Price:</strong> Rp {{ number_format($product->discounts[0]->detail_discounts->discount_price, 0 ,',', '.') ?? '-' }}<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
