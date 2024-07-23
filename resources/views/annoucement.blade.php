@extends('layout.main')
@section('title', 'New Role')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Annoucement</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Annoucement</li>
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
                            <div class="col-md-8">{{ isset($announce) ? "Edit Annoucement" : "Create Annoucement" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/annoucements')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($announce) ? route('annoucement.update',$announce->id) : route('annoucement.create') }}">
                            @csrf
                            @isset($announce)
                            @method('PUT')
                            @endisset
                            <div class="form-group">
                                <label>Destination Departments</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder="Select Destinations" data-dropdown-css-class="select2-purple" style="width: 100%;" name="destination[]">
                                    @foreach ($depts as $data)
                                    <option selected value="{{$data->id}}">
                                        {{$data->hname}} > {{$data->bname}} > {{$data->dname}}
                                    </option>
                                    @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Effective Date:</label>
                  
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                        </span>
                                      </div>
                                      <input type="text" class="form-control float-right" id="effectDate" name="effectDate">
                                    </div>
                                    <!-- /.input group -->
                                  </div>
                                <div class="form-group">
                                    <label for="inputHeading" class="form-label">Announcement Heading</label>
                                    <input type="text" class="form-control col-md-12" id="heading" name="heading" value="{{ $announce->heading ?? '' }}">
    
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputInformation" class="form-label">Department Name </label>
                                    <textarea id="information" name="information" text={!! $announce->information ?? ''!!}                                        ></textarea>
    
                                    @error('information')
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
@push('scripts')

@endpush
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(function () {
    $('#effectDate').daterangepicker()

    $('.select2').select2()
    $(document).ready(function() {
        $('#information').summernote({
            height: 300,
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
