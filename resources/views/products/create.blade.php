@extends('layouts.main_layouts')
@section('breadcrumb', 'Products')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5 class="text-dark text-capitalize ps-3 ">Create New Product</h5>
            {{-- <form action="{{ route('products.uploadImage')}}" method="POST" enctype="multipart/form-data" id="image-upload" class="dropzone">
            @csrf
            </form> --}}

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="row p-3 "
                id="product-form">
                @csrf

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control border p-2" id="product_name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="categories_id" class="form-select border p-2" aria-label="Default select example"
                            id="categories_id">
                            <option value="" selected disabled>-- Select a category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control border p-2" id="price" required>
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="product_img" class="form-control border p-2" id="product_img" required>
                    </div> --}}
                </div>

                <div class="col-md-6">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="product_img" id="product_img" style="display: none;">
                    <div class="dz-message text-center dropzone" style="border: 2px dashed #ccc; padding: 50px;"
                        id="uploadImg">
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>


    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#uploadImg", {
            url: "#",
            autoProcessQueue: false,
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag & Drop file here or click to upload",
            init: function() {
                let dropzone = this;
                dropzone.on("addedfile", function(file) {
                    if (dropzone.files.length > 1) {
                        dropzone.removeAllFiles(true);
                        dropzone.addFile(file);
                    }
                    let input = document.getElementById("product_img");
                    let dataTransfer = new DataTransfer();

                    dataTransfer.items.add(file);
                    input.files = dataTransfer.files;
                });
            }
        });
    </script>
@endsection
