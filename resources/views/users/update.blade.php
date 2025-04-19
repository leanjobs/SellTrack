@extends('layouts.main_layouts')
@section('breadcrumb', 'Users')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New User</h5>
            <form action="{{ route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data" class="row p-3" id="user-form">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" name="user_name" value="{{ old('user_name', $user->user_name) }}" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"  value="{{ old('email', $user->email) }}" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        {{-- <input type="hidden" id="oldPassword" value="{{ old('password', $user->password) }}"> --}}
                        <input type="password" name="password" pattern="\d{8,}"
                        placeholder="Enter New Password - min 8 characters" class="form-control border p-2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" pattern="\d{10,}"  value="{{ old('phone_number', $user->phone_number) }}" name="phone_number" class="form-control border p-2" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select border p-2"  aria-label="Default select example"
                        id="role">
                        <option value="" selected disabled>-- Select a role --</option>
                            <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branches_id" class="form-select border p-2" aria-label="Default select example"
                        id="categories_id" id="">
                        <option value="" selected disabled>-- Select a branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $branch->id == $user->branches_id ? 'selected' : "" }}>
                                    {{ $branch->branch_name }} - {{$branch->branch_code}}
                                </option>
                            @endforeach
                    </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" name="position"  value="{{ old('position', $user->position) }}" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select border p-2" aria-label="Default select example"
                        id="status">
                        <option value="" selected disabled>-- Select a status --</option>
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 ps-3">
                    <button type="button" class="btn btn-outline-secondary px-5" onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn bg-gradient-dark ms-2 px-5">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script>
        // document.getElementById("user-form").addEventListener("submit", function(event) {
        // let passwordInput = document.getElementById("password");
        // let oldPassword = document.getElementById("oldPassword").value;

        // if (passwordInput.value.trim() === "") {
        //     passwordInput.value = oldPassword; // Pakai password lama jika input kosong
        // }
    });
    </script>
@endsection
