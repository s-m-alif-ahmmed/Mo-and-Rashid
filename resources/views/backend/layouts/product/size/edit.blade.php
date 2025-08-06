@extends('backend.app')

@section('title', 'Size Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Size Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Size</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('product.size.update', ['id' => $data->id]) }}" >
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="size" class="form-label">Size:</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror"
                                name="size" placeholder="Size" id="size" value="{{ $data->size ?? ' ' }}">
                            @error('size')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('product.size.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
