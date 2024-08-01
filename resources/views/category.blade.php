@extends('layout.main')
@section('title', 'New Role')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Category</li>
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
                            <div class="col-md-8">{{ isset($category) ? "Edit Category" : "Create Category" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/categories')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($category) ? route('category.update',$category->id) : route('category.create') }}">
                            @csrf
                            @isset($category)
                            @method('PUT')
                            @endisset


                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Category Name </label>
                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $category->name ?? '' }}">


                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Description</label>
                                <input type="text" class="form-control col-md-12" id="description" name="description" value="{{ $category->description ?? '' }}">


                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    @isset($category)
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