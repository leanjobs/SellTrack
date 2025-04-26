<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="#"
        target="_blank">
        <div style="width: 8vw; aspect-ratio: 2 / 1; overflow: hidden;" class="d-flex align-items-center">
            <img src="../assets/img/SellTrack.svg" style="width: 100%; height: 100%; object-fit: cover;" />
          </div>
    </a>
</div>
<hr class="horizontal dark mt-0 mb-2">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-dark" href="/dashboard" data-position="dashboard">
                <i class="material-symbols-rounded opacity-5">dashboard</i>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Master Data</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/members" data-position="members">
                <i class="material-symbols-rounded opacity-5">loyalty</i>
                <span class="nav-link-text ms-1">Members</span>
            </a>
        </li>
        @if (auth()->user()->role == "super_admin")
        <li class="nav-item">
            <a class="nav-link text-dark" href="/categories" data-position="categories">
                <i class="material-symbols-rounded opacity-5">category</i>
                <span class="nav-link-text ms-1">Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/users" data-position="users">
                <i class="material-symbols-rounded opacity-5">person</i>
                <span class="nav-link-text ms-1">Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/branches" data-position="branches">
                <i class="material-symbols-rounded opacity-5">storefront</i>
                <span class="nav-link-text ms-1">Branches</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/products" data-position="products">
                <i class="material-symbols-rounded opacity-5">menu_book</i>
                <span class="nav-link-text ms-1">Products</span>
            </a>
        </li>
        @endif
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Sales & Transaction</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pos-system" data-position="cashier">
                <i class="material-symbols-rounded opacity-5">point_of_sale</i>
                <span class="nav-link-text ms-1">POS System</span>
            </a>
        </li>
        @if (auth()->user()->role == "super_admin" || auth()->user()->role == "admin" )
        <li class="nav-item">
            <a class="nav-link text-dark" href="/discounts" data-position="discounts">
                <i class="material-symbols-rounded opacity-5">percent</i>
                <span class="nav-link-text ms-1">Discounts</span>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link text-dark" href="/bills" data-position="bills">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Bills</span>
            </a>
        </li>
        {{-- <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Reports & Analysis</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/analysis">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Analysis</span>
            </a>
        </li> --}}

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Inventory Management
            </h6>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="/incoming-stocks" data-position="incoming-stocks">
                <i class="material-symbols-rounded opacity-5">call_received</i>
                <span class="nav-link-text ms-1">Incoming Stocks</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/outgoing-stocks" data-position="outgoing-stocks">
                <i class="material-symbols-rounded opacity-5">north_west</i>
                <span class="nav-link-text ms-1">Outgoing Stocks</span>
            </a>
        </li>
    </ul>
</div>
{{-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
    <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100"
            href="{{ route('logout')}}"
            type="button">Logout</a>
        <a class="btn bg-gradient-dark w-100"
            href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to
            pro</a>
    </div>
</div> --}}

<script>
    $(document).ready(function () {
        var breadcrumbText = $('.breadcrumb-position').text().trim().toLowerCase().replace(/\s+/g, '-');

        $('.nav-link').each(function () {
            var position = $(this).data('position')
            if (position === breadcrumbText) {
                $(this).removeClass('text-dark')
                       .addClass('active bg-gradient-dark text-white');
            }
        });
    });
</script>
