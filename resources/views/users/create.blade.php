@extends('layouts.main_layouts')
@section('breadcrumb', 'Users')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New User</h5>
            <form action="{{ route('users.store')}}" method="POST" enctype="multipart/form-data" class="row p-3" id="category-form">
                @csrf
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" name="user_name" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"  pattern="\d{8,}"
                        placeholder="min 8 characters" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" pattern="\d{10,}" name="phone_number" class="form-control border p-2" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select border p-2" aria-label="Default select example"
                        id="role">
                        <option value="" selected disabled>-- Select a role --</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branches_id" class="form-select select2 border p-2" aria-label="Default select example"
                        id="categories_id" id="">
                        <option value="" selected disabled>-- Select a branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">
                                    {{ $branch->branch_name }} - {{$branch->branch_code}}
                                </option>
                            @endforeach
                    </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" name="position" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select border p-2" aria-label="Default select example"
                        id="status">
                        <option value="" selected disabled>-- Select a status --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
@endsection
