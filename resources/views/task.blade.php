@extends('layout.main')
@section('title', 'New Task')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Task</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New Task</li>
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
                            <div class="col-md-8">{{ isset($task_head) ? "Edit Task" : "Create Task" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/tasks')}}">Go Listing</a></div>
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
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($task_head) ? route('task.update',$task_head->id) : route('task.create') }}">
                            @csrf
                            @isset($task_head)
                            @method('PUT')
                            @endisset
                            {{-- <div class="form-group">
                                <label>Users</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder="Select Users" data-dropdown-css-class="select2-purple" style="width: 100%;" name="users[]">
                                    @foreach ($users as $data)
                                    <option selected value="{{$data->id}}">
                                        {{$data->hname}} > {{$data->bname}} > {{$data->dname}} > {{$data->name}}
                                    </option>
                                    @endforeach
                                    </select>
                                </div>
                                </div> --}}
                                {{-- <div class="form-group">
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
                                  </div> --}}
                                <div class="form-group">
                                    <label for="inputHeading" class="form-label">Task Name</label>
                                    <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $task_head->name ?? '' }}">
    
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputInformation" class="form-label">Task Description </label>
                                    <textarea id="description" name="description" text={!! $task_head->description ?? ''!!}                                        ></textarea>
    
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  
    $(document).ready(function() {
    //     $('#effectDate').daterangepicker()

    // $('.select2').select2()
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


</script>
</section><!-- End Services Section -->
@push('scripts')

@endpush

@endsection
