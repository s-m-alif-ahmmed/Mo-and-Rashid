@extends('backend.app')

@section('title', 'Product Create')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Product Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form class="row" method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-6 form-group">
                            <label for="name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Product Name" id="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Quantity:</label>
                            <input class="form-control" type="number" name="quantity" placeholder="Product quantity" required>
                            @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Category:</label>
                            <select name="category_id" class="form-control select2 form-select" data-placeholder="Choose one">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="name" class="form-label">Product Brand:</label>
                            <select name="brand_id" class="form-control select2 form-select" data-placeholder="Choose one">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Color:</label>
                            <select name="color_id[]" class="form-control select2 form-select" data-placeholder="Choose one" multiple>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color }}</option>
                                @endforeach
                            </select>
                            @error('color_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Size:</label>
                            <select name="size_id[]" class="form-control select2 form-select" data-placeholder="Choose one" multiple>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                                @endforeach
                            </select>
                            @error('size_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="discount_price" class="form-label">Discount Price:</label>
                            <input type="text" class="form-control @error('discount_price') is-invalid @enderror"
                                   name="discount_price" placeholder="Product discount price" id="discount_price"
                                   pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price (up to two decimal places)">
                            @error('discount_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="selling_price" class="form-label">Selling Price:</label>
                            <input type="text" class="form-control @error('selling_price') is-invalid @enderror"
                                   name="selling_price" placeholder="Product selling price" id="selling_price"
                                   pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price (up to two decimal places)">
                            @error('selling_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 form-group">
                            <label class="form-label">Product Images:</label>
                            <input type="file" class="form-control" name="image[]" placeholder="Product images" id="gallery-photo-add" multiple required>
                            @error('image.*')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="gallery"></div>
                        </div>

                        <div class="col-12 form-group">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="" name="description">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('product.brand.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .image-preview {
        position: relative;
        display: inline-block;
        margin: 5px;
        }

        .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        }

        .image-preview .remove-image {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(255, 0, 0, 0.7);
        border: none;
        color: white;
        cursor: pointer;
        padding: 0 5px;
        }

    </style>
@endpush

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(function() {
            var selectedFiles = [];

            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;

                    for (let i = 0; i < filesAmount; i++) {
                        selectedFiles.push(input.files[i]); // Track the selected files

                        var reader = new FileReader();

                        reader.onload = function(event) {
                            var imageContainer = $(`<div class="image-preview" style="position: relative; display: inline-block; margin: 5px;">
                        <img src="${event.target.result}" style="width: 100px; height: 100px; object-fit: cover;" />
                        <button type="button" class="btn btn-danger remove-image" style="position: absolute; top: 0; right: 0;">&times;</button>
                    </div>`);
                            $(placeToInsertImagePreview).append(imageContainer);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };

            $('#gallery-photo-add').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });

            // Remove image functionality
            $(document).on('click', '.remove-image', function() {
                var index = $(this).parent('.image-preview').index(); // Get the index of the image preview
                $(this).closest('.image-preview').remove(); // Remove the preview

                // Remove the corresponding file from selectedFiles
                selectedFiles.splice(index, 1);

                // Create a new DataTransfer object to update the input files
                var dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                // Update the input element's files
                $('#gallery-photo-add')[0].files = dataTransfer.files;
            });
        });

    </script>
@endpush
