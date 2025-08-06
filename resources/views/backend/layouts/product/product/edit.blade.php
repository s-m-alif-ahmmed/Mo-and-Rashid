@extends('backend.app')

@section('title', 'Product Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Product Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form class="row" method="post" action="{{ route('products.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="col-6 form-group">
                            <label for="name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" placeholder="Product Name" id="name" value="{{ old('name', $data->name) }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="quantity" class="form-label">Product Quantity:</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                   name="quantity" placeholder="Product Quantity" id="quantity" value="{{ old('quantity', $data->quantity) }}">
                            @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Category:</label>
                            <select name="category_id" class="form-control select2 form-select" data-placeholder="Choose one">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $data->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Brand:</label>
                            <select name="brand_id" class="form-control select2 form-select" data-placeholder="Choose one">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $brand->id == $data->brand_id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Color:</label>
                            <select name="color_id[]" class="form-control select2 form-select" data-placeholder="Choose one" multiple>
                                <option value="">Select Product Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" {{ $data->productColors->pluck('color_id')->contains($color->id) ? 'selected' : '' }}>{{ $color->color }}</option>
                                @endforeach
                            </select>
                            @error('color_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Product Size:</label>
                            <select name="size_id[]" class="form-control select2 form-select" data-placeholder="Choose one" multiple>
                                <option value="">Select Product Size</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}" {{ $data->productSizes->pluck('size_id')->contains($size->id) ? 'selected' : '' }}>{{ $size->size }}</option>
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
                                   value="{{ old('discount_price', $data->discount_price) }}"
                                   pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price (up to two decimal places)">
                            @error('discount_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="selling_price" class="form-label">Selling Price:</label>
                            <input type="text" class="form-control @error('selling_price') is-invalid @enderror"
                                   name="selling_price" placeholder="Product selling price" id="selling_price"
                                   value="{{ old('selling_price', $data->selling_price) }}"
                                   pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price (up to two decimal places)">
                            @error('selling_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-12 form-group">
                            <label class="form-label">Product Images:</label>
                            <input type="file" class="form-control" name="image[]" id="gallery-photo-add" multiple>
                            @error('image.*')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="gallery">
                                @foreach($data->images as $image)
                                    <div class="image-preview" style="display: inline-block; margin: 5px; position: relative;">
                                        <img src="{{ asset($image->image) }}" style="width: 100px; height: 100px; object-fit: cover;" />
                                        <div class="form-check" style="margin-top: 5px;">
                                            <input type="checkbox" class="form-check-input" name="remove_images[]" value="{{ $image->id }}" id="remove-{{ $image->id }}">
                                            <label class="form-check-label" for="remove-{{ $image->id }}">Remove</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 form-group">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="" name="description">{{ old('description', $data->description) }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
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
            let selectedImages = []; // Array to hold selected images

            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    $(placeToInsertImagePreview).empty(); // Clear previous previews
                    selectedImages = []; // Reset selected images

                    for (let i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            var imageContainer = $(`<div class="image-preview">
                            <img src="${event.target.result}" />
                            <button type="button" class="btn btn-danger remove-image">&times;</button>
                        </div>`);
                            $(placeToInsertImagePreview).append(imageContainer);
                            selectedImages.push(input.files[i]); // Store the selected image
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
                const imageIndex = $(this).closest('.image-preview').index();
                $(this).parent('.image-preview').remove();

                // Remove the corresponding image from the selected images array
                selectedImages.splice(imageIndex, 1);
                updateFileInput();
            });

            // Function to update file input
            function updateFileInput() {
                const dataTransfer = new DataTransfer(); // Create a new DataTransfer object
                selectedImages.forEach(file => {
                    dataTransfer.items.add(file); // Add each selected file
                });
                $('#gallery-photo-add')[0].files = dataTransfer.files; // Update the input file's files
            }


        });


    </script>
@endpush
