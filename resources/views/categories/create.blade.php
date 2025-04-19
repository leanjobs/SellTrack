@extends('layouts.main_layouts')
@section('breadcrumb', 'Categories')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New Category</h5>
            <form action="{{ route('categories.store')}}" method="POST" enctype="multipart/form-data" class="row p-3" id="category-form">
                @csrf

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control border p-2" required>
                    </div>
                </div>

                <div class="col-md-6">
                    {{-- <label class="form-label">Upload Image</label>
                    <form action="{{ url('uploadFiles') }}" method="POST" class="dropzone" id="image-upload">
                        @csrf
                        <div class="dz-message text-center" style="border: 2px dashed #ccc; padding: 50px;">
                            <p>Drag and drop files here or click to upload</p>
                        </div>
                    </form> --}}
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
