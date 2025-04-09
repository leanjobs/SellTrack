@extends('layouts.main_layouts')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New Incoming Stock</h5>
            {{-- {{ auth()->user()->branches_id}} --}}
            <form action="{{ route('incoming-stocks.store')}}" method="POST" enctype="multipart/form-data" class="row p-3" id="category-form">
                @csrf
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Product Code</label>
                        <select name="products_id" id="products_id" class="form-select select2 bg-transparent border p-2" aria-label="Default select example">
                            <option value="" selected disabled>-- Select a product code --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id}}">{{$product->product_code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Initial Stock</label>
                        <input type="number" name="initial_stocks" class="form-control border p-2" required value="{{ old('initial_stocks') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expired</label>
                        <input type="date" name="expired" class="form-control border p-2" required>
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
    <script>
        $(document).ready(function() {
            $('#products_id').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: "-- Select a product code --",
                allowClear: true
            });
        });
    </script>

@endsection
