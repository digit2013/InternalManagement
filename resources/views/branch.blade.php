@extends('layout.main')
@section('title', 'New Role')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Branch</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Branch</li>
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
                            <div class="col-md-8">{{ isset($branch) ? "Edit Branch" : "Create Branch" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/branchs')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($branch) ? route('branch.update',$branch->id) : route('branch.create') }}">
                            @csrf
                            @isset($branch)
                            @method('PUT')
                            @endisset
                            <div class="form-group mb-3">
                                <select class="form-control" name="headoffice" id="headoffice">
                                    <option value="">-- Select Head Office --</option>
                                    @foreach ($headoffices as $data)
                                    @if((isset($branch->h_id)) && ($branch->h_id == $data->id))
                                    <option selected value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @else
                                    <option value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @endif
                                 
                                    @endforeach
                                </select>
                                @error('headoffice')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Branch Name </label>
                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $branch->name ?? '' }}">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Branch Location </label>
                                <input type="text" class="form-control col-md-12" id="location" name="location" value="{{ $branch->location ?? '' }}">

                                @error('location')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Description</label>
                                <input type="text" class="form-control col-md-12" id="description" name="description" value="{{ $branch->description ?? '' }}">


                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    @isset($branch)
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
<script>
   
</script>
@endpush