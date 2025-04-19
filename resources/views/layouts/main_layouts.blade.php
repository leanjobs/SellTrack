<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="../assets/img/icon-selltrack.svg">
    <title>
      SellTrack
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    {{-- custom css select form cdn --}}
    <style>
        /* Ubah background Select2 jadi transparan */
        .select2-container .select2-selection--single {
            background-color: transparent !important;
            font-size: 14px !important;
            color: black !important;
        }

        /* Ubah warna teks di dalam dropdown */
        .select2-container--default .select2-results__option {
            color: black !important;
        }

        /* Ubah warna teks yang dipilih */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: red !important;
        }

        /* Ubah warna highlight saat opsi di-hover */
        .select2-container--default .select2-results__option--highlighted {
            background-color: rgba(255, 0, 0, 0.2) !important;
            color: red !important;
        }
        #sidenav-main {
            z-index: 1030 !important; /* sidebar tetap di bawah modal dan backdrop */
        }

        .modal-backdrop {
            z-index: 1040 !important; /* backdrop di atas sidebar */
        }

        .modal {
            z-index: 1050 !important; /* modal tetap paling atas */
        }
    </style>

    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/html5-qrcode/html5-qrcode.min.js') }}"></script>


</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
        id="sidenav-main">
        @include('sidebar.sidebar')
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                  <li class="breadcrumb-item text-sm text-dark active breadcrumb-position" aria-current="page">@yield('breadcrumb')</li>
                </ol>
              </nav>
              <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                  <div class="input-group input-group-outline">
                    <span><strong class="text-dark"> {{ auth()->user()->user_branch->branch_name}}   </strong>{{ auth()->user()->user_branch->branch_code}}</span>
                  </div>
                </div>
                <ul class="navbar-nav d-flex align-items-center justify-content-end">
                  <li class="nav-item d-xl-none ps-3 pe-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                      <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                      </div>
                    </a>
                  </li>
                  {{-- <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                      <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
                    </a>
                  </li> --}}
                  <li class="nav-item dropdown d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 d-flex align-items-center" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="material-symbols-rounded" style="font-size: 30px">account_circle</i>
                    </a>
                    @include('components.dropdown-account')
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        <!-- End Navbar -->
        <div class="position-fixed bottom-1 end-1 z-index-2 p-3" style="z-index: 9999">
            @if (session('success'))
                <div id="successToast" class="toast hide p-2 bg-white" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header border-0">
                        <i class="material-symbols-rounded text-success me-2">check</i>
                        <span class="me-auto font-weight-bold">Success</span>
                        <small class="text-body">Just now</small>
                        <button type="button" class="border-0 bg-transparent align-items-center d-flex"
                            data-bs-dismiss="toast" aria-label="Close">
                            <i class="material-symbols-rounded opacity-5">close</i>
                        </button>
                    </div>
                    <hr class="horizontal dark m-0">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            @elseif (session('error'))
                <div class="toast fade hide p-2 mt-2 bg-white" role="alert" aria-live="assertive" id="dangerToast"
                    aria-atomic="true">
                    <div class="toast-header border-0">
                        <i class="material-symbols-rounded text-danger me-2">
                            campaign
                        </i>
                        <span class="me-auto text-gradient text-danger font-weight-bold">Failed</span>
                        <small class="text-body">Just now</small>
                        <button type="button" class="border-0 bg-transparent align-items-center d-flex"
                            data-bs-dismiss="toast" aria-label="Close">
                            <i class="material-symbols-rounded opacity-5">close</i>
                        </button>
                    </div>
                    <hr class="horizontal dark m-0">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>
        <div class="position-fixed bottom-1 end-1 z-index-2 p-3" style="z-index: 9999">
            <div class="toast fade hide p-2 mt-2 bg-white" role="alert" aria-live="assertive" id="validationError"
            aria-atomic="true">
            <div class="toast-header border-0">
                <i class="material-symbols-rounded text-danger me-2">
                    campaign
                </i>
                <span class="me-auto text-gradient text-danger font-weight-bold">Failed</span>
                <small class="text-body">Just now</small>
                <button type="button" class="border-0 bg-transparent align-items-center d-flex"
                    data-bs-dismiss="toast" aria-label="Close">
                    <i class="material-symbols-rounded opacity-5">close</i>
                </button>
            </div>
            <hr class="horizontal dark m-0">
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
        </div>
        <div class="container-fluid py-2">
            @yield('content')
        </div>
    </main>



    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    {{-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> --}}


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successToast = document.getElementById("successToast");
            if (successToast) {
                var toastBootstrap = new bootstrap.Toast(successToast);
                toastBootstrap.show();
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var successToast = document.getElementById("dangerToast");
            if (successToast) {
                var toastBootstrap = new bootstrap.Toast(successToast);
                toastBootstrap.show();
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            $("form").submit(function(e) {
                let isValid = true;

                $("select").each(function() {
                    if (!$(this).prop('disabled') && ($(this).val() === "" || $(this).val() === null)) {
                        isValid = false;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    $("#validationError .toast-body").text("All required fields must be filled");
                    var toast = new bootstrap.Toast(document.getElementById('validationError'));
                    toast.show();
                }
            });

            $("select").change(function() {
                if ($(this).val() !== "" && $(this).val() !== null) {
                    $(this).removeClass("is-invalid");
                }
            });


        });

    </script>
    <script>
        // var ctx = document.getElementById("chart-bars").getContext("2d");

        // new Chart(ctx, {
        //     type: "bar",
        //     data: {
        //         labels: ["M", "T", "W", "T", "F", "S", "S"],
        //         datasets: [{
        //             label: "Views",
        //             tension: 0.4,
        //             borderWidth: 0,
        //             borderRadius: 4,
        //             borderSkipped: false,
        //             backgroundColor: "#43A047",
        //             data: [50, 45, 22, 28, 50, 60, 76],
        //             barThickness: 'flex'
        //         }, ],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: 'index',
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [5, 5],
        //                     color: '#e5e5e5'
        //                 },
        //                 ticks: {
        //                     suggestedMin: 0,
        //                     suggestedMax: 500,
        //                     beginAtZero: true,
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         lineHeight: 2
        //                     },
        //                     color: "#737373"
        //                 },
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: false,
        //                     drawOnChartArea: false,
        //                     drawTicks: false,
        //                     borderDash: [5, 5]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#737373',
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //         },
        //     },
        // });


        // var ctx2 = document.getElementById("chart-line").getContext("2d");

        // new Chart(ctx2, {
        //     type: "line",
        //     data: {
        //         labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        //         datasets: [{
        //             label: "Sales",
        //             tension: 0,
        //             borderWidth: 2,
        //             pointRadius: 3,
        //             pointBackgroundColor: "#43A047",
        //             pointBorderColor: "transparent",
        //             borderColor: "#43A047",
        //             backgroundColor: "transparent",
        //             fill: true,
        //             data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
        //             maxBarThickness: 6

        //         }],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false,
        //             },
        //             tooltip: {
        //                 callbacks: {
        //                     title: function(context) {
        //                         const fullMonths = ["January", "February", "March", "April", "May", "June",
        //                             "July", "August", "September", "October", "November", "December"
        //                         ];
        //                         return fullMonths[context[0].dataIndex];
        //                     }
        //                 }
        //             }
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: 'index',
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [4, 4],
        //                     color: '#e5e5e5'
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#737373',
        //                     padding: 10,
        //                     font: {
        //                         size: 12,
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: false,
        //                     drawOnChartArea: false,
        //                     drawTicks: false,
        //                     borderDash: [5, 5]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#737373',
        //                     padding: 10,
        //                     font: {
        //                         size: 12,
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //         },
        //     },
        // });

        // var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        // new Chart(ctx3, {
        //     type: "line",
        //     data: {
        //         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //         datasets: [{
        //             label: "Tasks",
        //             tension: 0,
        //             borderWidth: 2,
        //             pointRadius: 3,
        //             pointBackgroundColor: "#43A047",
        //             pointBorderColor: "transparent",
        //             borderColor: "#43A047",
        //             backgroundColor: "transparent",
        //             fill: true,
        //             data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        //             maxBarThickness: 6

        //         }],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: 'index',
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [4, 4],
        //                     color: '#e5e5e5'
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     padding: 10,
        //                     color: '#737373',
        //                     font: {
        //                         size: 14,
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: false,
        //                     drawOnChartArea: false,
        //                     drawTicks: false,
        //                     borderDash: [4, 4]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#737373',
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //         },
        //     },
        // });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

</body>

</html>
