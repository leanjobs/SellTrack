<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sales Bills Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media print {
            table {
                font-size: 10px;
                border-collapse: collapse !important;

            }

            table th,
            table td {
                border: 0.2px solid #dee2e6 !important;
                padding: 4px !important;
            }

            .card-title,
            .card-text {
                font-size: 10px;
            }

            h1 {
                font-size: 18px;
            }

            h2 {
                font-size: 16px;
            }

            h3 {
                font-size: 14px;
            }

            p,
            li {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container my-3" id="printableArea">
        <!-- Heading -->
        <div class="text-center mb-3">
            <h1 class="fw-bold">SALES BILLS REPORT</h1>
            <h3>SellTrack</h3>
            <p> {{  \Carbon\Carbon::parse($startDate)->translatedFormat('l, d F Y') }} - {{  \Carbon\Carbon::parse($endDate)->translatedFormat('l, d F Y') }} </p>
        </div>

        <!-- Info -->
        <div class="mb-4">
            <p class="mb-1"><strong>Print Date : </strong> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y')}} </p>
            <p class="mb-1"><strong>Generated By : </strong> {{ auth()->user()->user_name}}</p>
            <p class="mb-1"><strong>Branch : </strong> {{auth()->user()->user_branch->branch_name}}</p>
        </div>

        <!-- Detail -->
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between"><span>Total Bills</span><strong>{{ $bills->count()}}</strong></li>
            <li class="list-group-item d-flex justify-content-between"><span>Total Sales</span><strong>Rp {{ number_format($bills->sum('grand_total'))}}</strong></li>
        </ul>

        <!-- Recent Bills -->
        <h3 class="mt-5">Recent Bills</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bill ID</th>
                    <th>Payment Method</th>
                    <th>Grand Total</th>
                    <th>Tax</th>
                    <th>Member's Phone</th>
                    <th>Cashier ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $bill )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->payment->payment_type}}</td>
                    <td>Rp {{ number_format($bill->grand_total)}}</td>
                    <td>Rp {{ number_format($bill->tax)}}</td>
                    <td>{{ $bill->member->phone_number ?? "-"}}</td>
                    <td>{{ $bill->users_id}}</td>
                    <td>{{ $bill->payment->status}}</td>
                    <td>{{ $bill->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
        setTimeout(() => {
            window.print();
        }, 500);
    };
    </script>


</body>

</html>
