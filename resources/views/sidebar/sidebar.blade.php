<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
        target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Creative Tim</span>
    </a>
</div>
<hr class="horizontal dark mt-0 mb-2">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-dark" href="#">
                <i class="material-symbols-rounded opacity-5">table_view</i>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Master Data</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/categories">
                <i class="material-symbols-rounded opacity-5">table_view</i>
                <span class="nav-link-text ms-1">Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/members">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Members</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/users">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/branches">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Branches</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/products">
                <i class="material-symbols-rounded opacity-5">dashboard</i>
                <span class="nav-link-text ms-1">Products</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Sales & Transaction</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pos-system">
                <i class="material-symbols-rounded opacity-5">table_view</i>
                <span class="nav-link-text ms-1">POS System</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/discounts">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Discounts</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Reports & Analysis</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/analysis">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Analysis</span>
            </a>
        </li>

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Inventory Management
            </h6>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="incoming-stocks">
                <i class="material-symbols-rounded opacity-5">table_view</i>
                <span class="nav-link-text ms-1">Incoming Stocks</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/outgoing-stocks">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Outgoing Stocks</span>
            </a>
        </li>
    </ul>
</div>
<div class="sidenav-footer position-absolute w-100 bottom-0 ">
    <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100"
            href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree"
            type="button">Documentation</a>
        <a class="btn bg-gradient-dark w-100"
            href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to
            pro</a>
    </div>
</div>

<script>
    var path = window.location.pathname;

    var links = document.querySelectorAll('.nav-link');

    links.forEach(function(link) {
        if (link.getAttribute('href') === path) {
            link.classList.remove('text-dark');
            link.classList.add('active', 'bg-gradient-dark', 'text-white');
        }
    });
</script>
