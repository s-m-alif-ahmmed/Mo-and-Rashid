@extends('backend.app')

@section('title', 'Category Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Category Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('product.category.update', ['id' => $data->id]) }}" >
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name" class="form-label">Category:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" placeholder="Category Name" id="name" value="{{ $data->name ?? ' ' }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('product.category.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
