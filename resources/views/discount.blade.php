@extends('layout.main')
@section('title', 'New Discount')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Discount</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Discount</li>
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
                            <div class="col-md-8">{{ isset($discount) ? "Edit Discount" : "Create Discount" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/discounts')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($discount) ? route('discount.update',$discount->id) : route('discount.create') }}">
                            @csrf
                            @isset($discount)
                            @method('PUT')
                            @endisset


                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Offer Name </label>
                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $discount->name ?? '' }}">


                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">From Price</label>
                                <input type="number" class="form-control col-md-12" id="fr_price" name="fr_price" value="{{ $discount->fr_price ?? '' }}">


                                @error('fr_price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">To Price</label>
                                <input type="number" class="form-control col-md-12" id="to_price" name="to_price" value="{{ $discount->to_price ?? '' }}">


                                @error('to_price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group ">
                                <div class="row ">
                                    <div class="col-md-4">
                            <select class="form-control " name="type" id="type">
                                <option value="">-- Select Type --</option>
                                @if((isset($discount->type)) && ($discount->type == 1))
                                <option selected value="1">
                                    Fixed
                                </option>
                                @else
                                <option  value="1">
                                    Fixed
                                </option>
                               
                                @endif 
                                @if((isset($discount->type)) && ($discount->type == 2))
                                <option selected value="2">
                                    Percent
                                </option>
                                @else
                                <option  value="2">
                                    Percent
                                </option>
                               
                                @endif 
                            </select>
                                    </div>
                                    <div class="col-md-4">
                            <input type="number" class="form-control col-md-4" id="amount" name="amount" value="{{ $discount->amount ?? '' }}">
                            @error('amount')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                                    </div>
                        </div>

                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    @isset($discount)
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