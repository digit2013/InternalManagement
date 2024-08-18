@extends('layout.main')
@section('title', 'New Role')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Meeting Minute</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Meeting Minute</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<style>
     a.ui-state-default{
   background-color: red !important;
 } 

 </style>
<section id="contact" class="contact">
    <div class="container-fluid" data-aos="fade-in">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">{{ isset($minute) ? "Edit Meeting Minute" : "Create Meeting Minute" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/meeting-minutes')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($minute) ? route('minute.update',$minute->id) : route('minute.create') }}">
                            @csrf
                            @isset($minute)
                            @method('PUT')
                            @endisset
                            <div class="form-group mb-3">
                                <select class="form-control" name="host" id="host">
                                    <option value="0">-- Host --</option>
                                    @foreach ($users as $data)
                                    @if((isset($minute->host)) && ($minute->host == $data->id))
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
                                <label>Attendees</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder="Select Users" data-dropdown-css-class="select2-purple" style="width: 100%;" name="attendees[]">
                                    @foreach ($users as $data)
                                    <option selected value="{{$data->id}}">
                                        {{$data->name}} ({{$data->hname}} - {{$data->bname}} - {{$data->dname}} )
                                    </option>
                                    @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Meeting Date:</label>
                  
                                    <div class="input-group">
                                     
                                      <input type="date" class="form-control "   id="meeting_date" name="meeting_date" value="{{$minute->meeting_date ?? ''}}">
                                    </div>
                                  </div>
                          
                                <div class="form-group">
                                    <label for="inputInformation" class="form-label">Meeting Minute </label>
                                    <textarea id="description" name="description" text={!! $minute->description ?? ''!!}                                        ></textarea>
    
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script>
             
              $(function () {
                $('input.date').datepicker({
                    beforeShow: function(input, inst)
                    {
                        $.datepicker._pos = $.datepicker._findPos(input); //this is the default position
                        $.datepicker._pos[0] = whatever; //left
                        $.datepicker._pos[1] = whatever; //top
                    }
                });
                $('.select2').select2()
                $(document).ready(function() {
                    $('#description').summernote({
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
        </div>
</section><!-- End Services Section -->
@push('scripts')

@endpush

@endsection
