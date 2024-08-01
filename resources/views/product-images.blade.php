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
                            <div class="col-md-4" align="right"><a href="{{url('/productlist')}}">Go Product Listing</a></div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <label for="inputAddress" class="form-label">Category </label>

                                <input type="text" class="form-control col-md-12" id="category" name="category" value="{{ $product->c_name ?? '' }}" disabled>

                             
                            </div>
                            <div class="col-md-12">
                                <label for="inputAddress" class="form-label">Product Name </label>

                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $product->name ?? '' }}" disabled>

                              
                            </div>
                            <div class="col-md-12">
                                <label for="inputAddress" class="form-label">Unit Measure </label>
                                <input type="text" class="form-control col-md-12" id="unit" name="unit" value="{{ $product->u_name ?? '' }}" disabled>

                              
                            </div>
                            <div class="col-md-12">
                                <label for="inputAddress" class="form-label">Selling Price </label>
                                <input type="number" class="form-control col-md-12" id="price" name="price" value="{{ $product->price ?? '' }}" disabled>

                              
                            </div>
                        </div>
                        
                        <form id="itemFrom" role="form" method="POST" action="{{ url('products/'.$product->id.'/upload') }}" enctype="multipart/form-data">
                            @csrf
                            
                            @csrf

                            <div class="mb-3">
                                <label>Upload Images (Max:10 images only)</label>
                                <input type="file" name="images[]" multiple class="form-control" />
                            </div>
                            
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>
                                    Upload                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           <div class="col-md-6">
                @foreach ($productImages as $prodImg)
                    <img src="{{ asset($prodImg->image_url) }}" class="border p-2 m-3" style="width: 150px; height: 150px;" alt="Img" />
                    <a href="{{ url('product-image/'.$prodImg->id.'/delete') }}" >Delete</a>
                @endforeach
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