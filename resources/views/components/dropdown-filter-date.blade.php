<ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4 shadow" aria-labelledby="dropdownFilterDate">
    <li class="dropdown-item border-radius-md">
        <p class="mb-0 text-dark font-weight-bold">Filter Date</p>
    </li>
    <form action="@yield('route-print')" method="GET">
        <li class="mb-2 d-flex">
            <div class="px-3 py-1 border-radius-md">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control border p-2" required>
            </div>
            <div class="px-3 py-1 border-radius-md">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control border p-2" required>
            </div>
        </li>
        <li class="mt-2">
            <a href="{{ route('print.bills') }}" target="_blank" class="dropdown-item border-radius-md text-dark font-weight-bold">
                Print
            </a>
        </li>
    </form>
</ul>
