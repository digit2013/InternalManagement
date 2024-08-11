@extends('layout.main')
@section('title', 'New Customer')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Customer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Customer</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section id="contact" class="contact">
    <div class="container-fluid" data-aos="fade-in">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">{{ isset($unit) ? "Edit Customer" : "Create Customer" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/customers')}}">Go Listing</a></div>
                        </div>
                    </div>
                    <div class="card-body ">
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            <div id="infoText">
                            {{ session()->get('message') }}
                            </div>
                        </div>
                        @endif
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($customer) ? route('customer.update',$customer->id) : route('customer.create') }}">
                            @csrf
                            @isset($customer)
                            @method('PUT')
                            @endisset
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">customer Name </label>
                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $customer->name ?? '' }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Phone Number</label>
                                <input type="text" class="form-control col-md-12" id="phone" name="phone" value="{{ $customer->phone ?? '' }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Mail</label>
                                <input type="text" class="form-control col-md-12" id="mail" name="mail" value="{{ $customer->mail ?? '' }}">
                                @error('mail')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input type="text" class="form-control col-md-12" id="address" name="address" value="{{ $customer->address ?? '' }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    @isset($unit)
                                    <i class="fas fa-arrow-circle-up"></i>
                                    <span>Update</span>
                                    @else
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Create</span>
                                    @endisset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
</section><!-- End Services Section -->

@endsection
@push('scripts')

@endpush