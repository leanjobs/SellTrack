@extends('layouts.main_layouts')
@section('breadcrumb', 'Branches')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New Branch</h5>
            <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data" class="row p-3 "
                id="branch-form">
                @csrf
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Branch Name</label>
                        <input type="text" name="branch_name" class="form-control border p-2" id="branch_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Province</label>
                        <select name="province" class="form-select border p-2" aria-label="Default select example"
                            id="province">
                            <option value="" selected disabled>-- Select a Provice --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <select name="city" class="form-select border p-2" aria-label="Default select example"
                            id="city">
                            <option value="" selected disabled>-- Select a City --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sub Distict</label>
                        <select name="sub_district" class="form-select border p-2" aria-label="Default select example"
                            id="sub_district">
                            <option value="" selected disabled>-- Select a Sub District --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Postal Code</label>
                        <select name="postal_code" class="form-select border p-2" aria-label="Default select example"
                            id="postal_code">
                            <option value="" selected disabled>-- Select a Postal Code --</option>
                        </select>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control border p-2" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="number" name="phone_number" pattern="\d{10,}" class="form-control border p-2"
                            id="phone_number" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label">Branch Head</label>
                        <select name="users_id" class="form-select border p-2" aria-label="Default select example"
                            id="users_id">
                            <option value="" selected disabled>-- Select a User --</option>
                           @foreach ($users as $user)
                                <option value="{{ $user->id}}">{{$user->user_name}}</option>
                           @endforeach
                        </select>
                    </div> --}}
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
        $(document).ready(function() {
            $.get('/get-provinces', function(data) {
                $.each(data, function(index, province) {
                    $('#province').append(
                        `<option value="${province.id}_${province.text}">${province.text}</option>`
                        );
                });
            });

            $('#province').change(function() {
                let province_id = $(this).val();
                console.log(province_id);

                $('#city').prop('disabled', true).html(
                    '<option value="">-- Select a City --</option>');
                $('#sub_district').prop('disabled', true).html(
                    '<option value="">-- Select a Sub District --</option>');
                $('#postal_code').prop('disabled', true).html(
                    '<option value="">-- Select a Postal Code --</option>');

                if (province_id) {
                    $.get(`/get-cities/${province_id}`, function(data) {
                        $.each(data, function(index, city) {
                            $('#city').append(
                                `<option value="${city.id}_${city.text}">${city.text}</option>`
                                );
                        });
                        $('#city').prop('disabled', false);
                    });
                }
            });

            $('#city').change(function() {
                let city_id = $(this).val();
                $('#sub_district').prop('disabled', true).html(
                    '<option value="">-- Select a Sub District --</option>');
                $('#postal_code').prop('disabled', true).html(
                    '<option value="">-- Select a Postal Code --</option>');

                if (city_id) {
                    $.get(`/get-sub-districts/${city_id}`, function(data) {
                        $.each(data, function(index, sub_district) {
                            $('#sub_district').append(
                                `<option value="${sub_district.id}_${sub_district.text}">${sub_district.text}</option>`
                            );
                        });
                        $('#sub_district').prop('disabled', false);
                        $('#postal_code').prop('disabled', false);

                    });
                }
            });

            $('#sub_district').change(function() {
                let sub_district_id = $(this).val();
                let city_id = $('#city').val();
                $('#postal_code').val('');

                if (sub_district_id) {
                    $.get(`/get-postal-code/${city_id}/${sub_district_id}`, function(data) {
                        $.each(data, function(index, postal_code) {
                            $('#postal_code').append(
                                `<option value="${postal_code.id}_${postal_code.text}">${postal_code.text}</option>`
                            );
                        });
                    });
                }
            });
        });
    </script>
@endsection
