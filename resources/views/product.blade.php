@extends('layout.main')
@section('title', 'New Role')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Product</li>
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
                            <div class="col-md-8">{{ isset($product) ? "Edit Product" : "Create Product" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/productlist')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($product) ? route('product.update',$product->id) : route('product.create') }}">
                            @csrf
                            @isset($product)
                            @method('PUT')
                            @endisset
                            <div class="form-group mb-3">
                                <select class="form-control" name="category" id="category">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $data)
                                    @if((isset($product->c_id)) && ($product->c_id == $data->id))
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
                                @error('category')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <select class="form-control" name="unit" id="unit">
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($units as $data)
                                    @if((isset($product->u_id)) && ($product->u_id == $data->id))
                                    <option selected value="{{$data->id}}">
                                        {{$data->description}}
                                    </option>
                                    @else
                                    <option value="{{$data->id}}">
                                        {{$data->description}}
                                    </option>
                                    @endif
                                 
                                    @endforeach
                                </select>
                                @error('unit')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Product Name </label>
                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $product->name ?? '' }}">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Selling Price </label>
                                <input type="number" class="form-control col-md-12" id="price" name="price" value="{{ $product->price ?? '' }}">

                                @error('price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputInformation" class="form-label">Description </label>
                                <textarea id="description" name="description" text={!! $product->description ?? ''!!}                                        ></textarea>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(function () {
    
    $(document).ready(function() {
        $('#description').summernote({
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
    });

})

</script>
@endsection
@push('scripts')
<script>
   
</script>
@endpush