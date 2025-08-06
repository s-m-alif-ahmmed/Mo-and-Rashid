@extends('backend.app')

@section('title', 'FAQ Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">FAQ Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('faq.update', ['id' => $data->id]) }}" >
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="question" class="form-label">Question:</label>
                            <input type="text" class="form-control @error('question') is-invalid @enderror"
                                name="question" placeholder="Question" id="question" value="{{ $data->question ?? ' ' }}">
                            @error('question')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="answer" class="form-label">Answer:</label>
                            <textarea class="form-control @error('answer') is-invalid @enderror" id="summernote" name="answer">{!! $data->answer !!}</textarea>
                            @error('answer')
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
