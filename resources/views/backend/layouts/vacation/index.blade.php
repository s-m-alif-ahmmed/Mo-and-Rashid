@extends('backend.app')

@section('title', 'Vacation')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>

    </style>
@endpush

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vacation</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <h3 class="mb-5">
                        Vacation Setting
                    </h3>
                    <form method="post" action="{{ route('vacation.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_date" class="form-label">Start Date Time:</label>
                                    <input class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                        placeholder="Start Date Time" id="start_date" value="{{ $vacation->start_date ?? null }}">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_date" class="form-label">Start Date Time:</label>
                                    <input class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                        placeholder="End Date Time" id="end_date" value="{{ $vacation->end_date ?? null }}">
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#start_date", {
            enableTime: true,
            time_24hr: true
        });

        flatpickr("#end_date", {
            enableTime: true,
            time_24hr: true
        });
    </script>
@endpush
