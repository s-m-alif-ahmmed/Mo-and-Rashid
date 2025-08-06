@extends('backend.app')

@section('title', 'Social Media Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Social Media Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Social Media</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('social.update', ['id' => $data->id]) }}" >
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="instagram" class="form-label">Instagram:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="instagram" placeholder="Instagram Link" id="instagram"  value="{{ $data->instagram ?? ' ' }}"">
                            @error('instagram')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="whatsapp" class="form-label">Whatsapp:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="whatsapp" placeholder="Whatsapp Link" id="whatsapp"  value="{{ $data->whatsapp ?? ' ' }}">
                            @error('whatsapp')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="twitter" class="form-label">Twitter:</label>
                            <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                   name="twitter" placeholder="Twitter Link" id="twitter"  value="{{ $data->twitter ?? ' ' }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tiktok" class="form-label">Tiktok:</label>
                            <input type="text" class="form-control @error('tiktok') is-invalid @enderror"
                                   name="tiktok" placeholder="Tiktok link" id="tiktok"  value="{{ $data->tiktok ?? ' ' }}">
                            @error('tiktok')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('social.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
