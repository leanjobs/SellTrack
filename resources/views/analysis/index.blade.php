@extends('layouts.main_layouts')
@section('breadcrumb', 'Dashboard')
@section('content')
    <div class="row mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="ms-3">
                <h3 class="mb-0 h4 font-weight-bolder ">Dashboard</h3>
                <p class="mb-0">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div>
                <select name="set-time" class="form-select border " aria-label="Default select example" id="set-time">
                    {{-- <option value="" selected disabled>-- Select a time --</option> --}}
                    <option value="daily" selected>-- Daily --</option>
                    <option value="weekly">-- Weekly --</option>
                    <option value="monthly">-- Monthly --</option>
                </select>
            </div>
        </div>

        {{-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize" id="label-cash">Today's Cash Payment</p>
                            <h4 class="mb-0" id="total-cash">Rp 0</h4>
                        </div>
                        <div
                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg ">
                            <i class="material-symbols-rounded opacity-10 fs-4">payments</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2 ps-3">
                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than last month</p>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize" id="label-qr">Today's QR Payment</p>
                            <h4 class="mb-0" id="total-qr">Rp 0</h4>
                        </div>
                        <div
                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10 fs-4">qr_code_scanner</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2 ps-3">
                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than last month</p>
                </div>
            </div>
        </div> --}}
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-2 ps-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize" id="label-time">Today's Money</p>
                            <h4 class="mb-0" id="grand-total">Rp 0</h4>
                        </div>
                        <div
                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10 fs-4">paid</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2 ps-3">
                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than last month</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 ">Income</h6>
                    <p class="text-sm ">This Week’s Earnings</p>
                    <div class="pe-2">
                        <div class="chart">
                            <canvas id="mixed-income" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                        <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 ">Payment</h6>
                    <p class="text-sm ">Cash vs QR Payment</p>
                    <div class="pe-2">
                        <div class="chart d-flex align-items-center justify-content-center"
                            style="max-height: 300px; height: 300px;">
                            <canvas id="pie-payment" class="chart-canvas" style="height: 100%; width: 100%;"></canvas>
                        </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                        <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 ">Product</h6>
                    <p class="text-sm ">Top 5 Selling Products</p>
                    <div class="pe-2">
                        <div class="chart d-flex align-items-center justify-content-center"
                            style="max-height: 300px; height: 300px;">
                            <canvas id="pie-product" class="chart-canvas" style="height: 100%; width: 100%;"></canvas>
                        </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                        <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Product</h6>
                            <p class="text-sm mb-0">
                                Top-selling products
                            </p>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a>
                                    </li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else
                                            here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
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
                                        Total Selling</th>
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        More</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product )
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$index + 1 }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$product->product_code }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">{{$product->product_name }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold link-offset-2">
                                            @php
                                            $totalOutgoing = 0;
                                            if ($product->incoming_stocks) {
                                                foreach ($product->incoming_stocks as $incoming) {
                                                    $totalOutgoing += $incoming->outgoing_stocks->sum('quantity');
                                                }
                                            }
                                            echo $totalOutgoing;
                                        @endphp
                                        </span>
                                    </td>
                                    {{-- <td class="align-middle text-center text-sm">
                                        <a href="#" class=" fw-bold text-xs text-decoration-underline link-offset-5"
                                            style="color: #737373;"> $14,000 </a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let bills = @json($bills);
            let products = @json($products);
            var mixedIncome = $("#mixed-income")[0].getContext("2d");


            const chart = new Chart(mixedIncome, {
                type: "line",
                data: {
                    labels: [],
                    datasets: [{
                        type: 'bar',
                        label: 'Bar Dataset',
                        data: [],
                        backgroundColor: '#393F6B',
                        // borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                        categoryPercentage: 0.2,
                    }, {
                        type: 'line',
                        label: 'Line Dataset',
                        data: [],
                        borderColor: '#D9306A',
                        backgroundColor: '#D9306A',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: '#e5e5e5'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    lineHeight: 2
                                },
                                color: "#737373"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#737373',
                                padding: 10,
                                font: {
                                    size: 14,
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var pieProduct = $("#pie-product")[0].getContext("2d");


            const pieChartProduct = new Chart(pieProduct, {
                type: "pie",
                data: {
                    labels: [],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [0],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)'
                        ],
                        hoverOffset: 4
                    }]
                },

            });



            function getToday() {
                return new Date().toISOString().split('T')[0];
            }

            function getWeekStartDate() {
                const date = new Date();
                const day = date.getDay();
                const diff = date.getDate() - day + (day === 0 ? -6 : 1);
                const monday = new Date(date.setDate(diff));
                return monday.toISOString().split('T')[0];
            }

            function getWeekEndDate() {
                const date = new Date();
                const day = date.getDay();
                const diff = date.getDate() - day + (day === 0 ? 0 : 7);
                const sunday = new Date(date.setDate(diff));
                return sunday.toISOString().split('T')[0];
            }

            function getMonth() {
                const date = new Date();
                return date.toISOString().slice(0, 7);
            }

            function filterBills(type) {
                const today = getToday();
                const weekStart = getWeekStartDate();
                const weekEnd = getWeekEndDate();
                const currentMonth = getMonth();
                return bills.filter(bill => {
                    const billDate = new Date(bill.created_at);
                    const billDay = billDate.toISOString().split('T')[0];
                    const billMonth = billDate.toISOString().slice(0, 7);

                    if (type === 'daily') return billDay === today;
                    if (type === 'weekly') return billDay >= weekStart && billDay <= weekEnd;
                    if (type === 'monthly') return billMonth === currentMonth;
                    return false;
                });

            }



            function updatePieChartProduct() {
                const filtered = products.map(product => {
                    let totalQuantity = 0;

                    product.incoming_stocks.forEach(incoming => {
                        incoming.outgoing_stocks.forEach(outgoing => {
                            const outgoingStockDate = new Date(outgoing.created_at);
                            totalQuantity += outgoing.quantity;
                        });
                    });

                    return {
                        ...product,
                        total_quantity: totalQuantity
                    };
                });

                const top5 = filtered.sort((a, b) => b.total_quantity - a.total_quantity).slice(0, 5);

                const labels = top5.map(product => product.product_name);
                const data = top5.map(product => product.total_quantity);

                pieChartProduct.data.labels = labels;
                pieChartProduct.data.datasets[0].data = data;

                pieChartProduct.update();
            }




            function processDaily(bills) {
                const labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const data = Array(7).fill(0);
                const createDate = Array(7).fill(0);
                bills.forEach(bill => {
                    const date = new Date(bill.created_at);
                    const dayIndex = date.getUTCDay();
                    createDate[dayIndex] = bill.created_at;
                    data[dayIndex] += parseFloat(bill.grand_total);

                });

                console.log("data", createDate)

                return {
                    labels,
                    data
                };
            }

            function processWeekly(bills) {
                const labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                const data = Array(4).fill(0);

                bills.forEach(bill => {
                    const date = new Date(bill.created_at);
                    const week = Math.floor((date.getDate() - 1) / 7);
                    data[week] += parseFloat(bill.grand_total);
                });

                return {
                    labels,
                    data
                };
            }

            function processMonthly(bills) {
                const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const data = Array(12).fill(0);

                bills.forEach(bill => {
                    const date = new Date(bill.created_at);
                    const month = date.getMonth();
                    data[month] += parseFloat(bill.grand_total);
                });

                return {
                    labels,
                    data
                };
            }

            function updateChart(chart, {
                labels,
                data
            }) {
                chart.data.labels = labels;
                chart.data.datasets[0].data = data;
                chart.data.datasets[1].data = data;
                chart.update();
            }

            function updateGrandTotal(filteredBills, type) {
                let totalAll = 0;
                let totalCash = 0;
                let totalQR = 0;

                filteredBills.forEach(bill => {
                    const amount = parseFloat(bill.grand_total);
                    const paymentType = bill.payment?.payment_type;

                    totalAll += amount;
                    if (paymentType === 'cash') totalCash += amount;
                    if (paymentType === 'QR') totalQR += amount;
                });

                $('#grand-total').text("Rp " + parseFloat(totalAll).toLocaleString("id-ID"));
                $('#total-cash').text("Rp " + parseFloat(totalCash).toLocaleString("id-ID"));
                $('#total-qr').text("Rp " + parseFloat(totalQR).toLocaleString("id-ID"));

                $('#label-time').text(
                    type === 'daily' ? "Today's Money" :
                    type === 'weekly' ? "This Week's Money" :
                    type === 'monthly' ? "This Month's Money" : ""
                );

                $('#label-cash').text(
                    type === 'daily' ? "Today's cash Payment" :
                    type === 'weekly' ? "This Week's cash Payment" :
                    type === 'monthly' ? "This Month's  cash Payment" : ""
                );

                $('#label-qr').text(
                    type === 'daily' ? "Today's qr Payment" :
                    type === 'weekly' ? "This Week's qr Payment" :
                    type === 'monthly' ? "This Month's qr Payment" : ""
                );
            }

            $('#set-time').on('change', function() {
                let type = $(this).val();
                updatePieChartProduct();

                let totalBills = [];
                let chartBills = [];
                let result;

                const currentYear = new Date().getFullYear();

                if (type === 'daily') {
                    totalBills = filterBills('daily');
                    chartBills = filterBills('weekly');
                    result = processDaily(chartBills);
                } else if (type === 'weekly') {
                    totalBills = filterBills('weekly');
                    chartBills = filterBills('monthly');
                    result = processWeekly(chartBills);
                } else if (type === 'monthly') {
                    totalBills = filterBills('monthly');
                    chartBills = bills.filter(bill => new Date(bill.created_at).getFullYear() ===
                        currentYear);
                    result = processMonthly(chartBills);
                }


                updateChart(chart, result);
                updateGrandTotal(totalBills, type);

            });

            if ($('#set-time').val()) {
                $('#set-time').trigger('change');
            }

        });
    </script>
@endsection
