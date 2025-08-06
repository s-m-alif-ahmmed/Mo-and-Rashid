@extends('backend.app')

@section('title', 'Contact Detail')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Contact Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Queries</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="" id="first_name" value="{{ $data->first_name ?? ' ' }}" readonly>
                        </div>

                        <div class="col-6">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="" id="last_name" value="{{ $data->last_name ?? ' ' }}" readonly>
                        </div>

                        <div class="col-6">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="" id="email" value="{{ $data->email ?? ' ' }}" readonly>
                        </div>

                        <div class="col-6">
                            <label for="order_number" class="form-label">Order Number:</label>
                            <input type="text" class="form-control @error('order_number') is-invalid @enderror" name="order_number" placeholder="" id="order_number" value="{{ $data->order_number ?? ' ' }}" readonly>
                        </div>

                        <div class="col-12">
                            <label for="subject" class="form-label">Subject:</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" placeholder="" id="subject" value="{{ $data->subject ?? ' ' }}" readonly>
                        </div>

                        <div class="col-12">
                            <label for="name" class="form-label">Message:</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" cols="30" rows="3" readonly>{{ $data->message ?? ' ' }}</textarea>
                        </div>

                        <form method="post" action="{{ route('queries.contact.update', ['id' => $data->id]) }}" >
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="note" class="form-label">Note:</label>
                                <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" cols="30" rows="3">{{ $data->note ?? ' ' }}</textarea>
                                @error('note')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a href="{{ route('queries.contact.index') }}" class="btn btn-danger me-2">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
