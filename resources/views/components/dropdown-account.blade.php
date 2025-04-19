  <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
    <li class="mb-2">
      <div class="dropdown-item border-radius-md">
        <div class="d-flex flex-column">
          <h6 class="text-sm font-weight-bold mb-1">
            {{ auth()->user()->user_name }} -  {{ auth()->user()->role }}
          </h6>
          <p class="text-xs text-secondary mb-0">
            {{ auth()->user()->email }}
          </p>
        </div>
      </div>
    </li>

    <li class="mt-2">
      <form method="GET" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dropdown-item border-radius-md text-danger">
          <i class="fas fa-sign-out-alt me-2"></i> Logout
        </button>
      </form>
    </li>
  </ul>
