@extends('layouts.main_layouts')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New Member</h5>
            <form action="{{ route('members.store')}}" method="POST" enctype="multipart/form-data" class="row p-3" id="category-form">
                @csrf

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Member Name</label>
                        <input type="text" name="member_name" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel"  pattern="\d{10,}" name="phone_number" class="form-control border p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Point</label>
                        <input type="integer" name="point" class="form-control border p-2">
                    </div>
                </div>

                <div class="col-md-6">
                </div>

                <div class="col-12 ps-3">
                    <button type="button" class="btn btn-outline-secondary px-5">Cancel</button>
                    <button type="submit" class="btn bg-gradient-dark ms-2 px-5">Submit</button>
                </div>
            </form>

        </div>
    </div>
    </div>
@endsection
