<!-- Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-weight-bold" id="receiptModalLabel">SALES RECEIPT</h5>
                {{-- <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body" id="printArea">

                <div class="text-center mb-3">
                    {{-- <h6 class="mb-0 branch_name">Mini Market Sejahtera</h6>
                <small class="branch_code">001-1-1-1</small> --}}
                </div>

                <div class="mb-2">
                    {{-- <strong>ID Member:</strong> 1234567890 <br>
                <strong>Cabang:</strong> Jakarta Barat <br>
                <strong>Kasir:</strong> Andi <br>
                <strong>Tanggal:</strong> 14 April 2025, 14:30 --}}
                </div>

                <hr>
                <div>
                    <strong>Item List:</strong>
                    <ul class="list-group list-group-flush">
                        {{-- <li class="list-group-item d-flex justify-content-between">
                    <span>Indomie Goreng x2</span>
                    <span>Rp6.000</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Susu Ultra x1</span>
                    <span>Rp8.000</span>
                  </li>
                  <li class="list-group-item">
                    <div class=" d-flex justify-content-between">
                        <span>Roti Tawar x1</span>
                        <span>Rp12.000</span>
                    </div>
                    <div class=" d-flex justify-content-between">
                        <span>-20%</span>
                        <span>Rp10.000</span>
                    </div>
                  </li> --}}
                    </ul>
                </div>

                <hr>
                <div class="payment-summary">
                    {{-- <div class="d-flex justify-content-between">
                        <span>Total Item:</span>
                    <span class="total_item">4</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax (10%):</span>
                    <span class="tax">Rp2.600</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Grand Total:</span>
                    <span class="grand_total">Rp28.600</span>
                    </div> --}}
                </div>
                <hr>

                <div class="text-center payment-method">
                    {{-- <small class="text-muted">Payment Method: <strong>Tunai</strong></small> --}}
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <div class="close-btn">
                    <button type="button" class="btn bg-gradient-secondary btn-reset-close">Close</button>
                </div>
                <button type="button" class="btn bg-gradient-primary btn-print">Print</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#receiptModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $(".close-btn .btn-reset-close").on("click", function(event) {
            event.preventDefault();
            $('#receiptModal').modal('hide');
            localStorage.clear();
            setTimeout(function() {
                location.reload();
            }, 500);
        });




        function printStruk() {
            const printContents = $('#printArea').html();
            const w = window.open('', '', 'height=600,width=800');

            w.document.write('<html><head><title>SALES RECEIPT</title>');
            w.document.write('<style>body { font-family: Arial, sans-serif; }</style>');

            w.document.write(`
            <html>
            <head>
                <title>SALES RECEIPT</title>
                <style>
                   @media print {
                        body {
                            width: 58mm;
                            font-size: 12px;
                        }
                    }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
            </html>
        `);

            w.document.close();

            w.onload = function() {
                const link = w.document.createElement('link');
                link.rel = 'stylesheet';
                link.href = `${window.location.origin}/assets/css/material-dashboard.css?v=3.2.0`;

                link.onload = function() {
                    setTimeout(() => {
                        w.focus();
                        w.print();
                        w.close();
                    }, 500);
                };

                w.document.head.appendChild(link);
            };
        }


        $(".btn-print").off().on("click", function() {
            console.log("printtt");
            printStruk();
        });
    });
</script>
