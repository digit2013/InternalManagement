@extends('layout.main')
@section('title', 'Task List')
@section('content')
@section('selected', 'tasks')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Task List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Task List</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section id="contact" class="contact">
    <div class="container-fluid" data-aos="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12"><a href="{{ url('/task') }}" class="btn btn-info float-left me-5">Add New Task</a></div>
                        </div>
                    </div>
                    {{-- @if(session()->has('message')) --}}
                        {{-- <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div> --}}
                        {{-- @endif --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tbl">
                                <thead>
                                    <tr>
                                    <th class="col-md-1" scope="col">Id</th>
                                    <th class="col-md-2" scope="col">Task</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if (count($task_heads) != 0)
                                @foreach ($task_heads as $task)
                                <tr data-widget="expandable-table" aria-expanded="false">
                                <td class="text-left"> {{$task->id }} </td>
                             
                                <td class="text-left"> {{ $task->name }} </td>

                                    <td class="text-left">
                                        @if ($task->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($task->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if($task->status == 1)
                                        <span class="bg-info p-1">active</span>
                                        @elseif($task->status == 4)
                                        <span class="bg-success  p-1">complete</span>
                                        @elseif($task->status == 2)
                                        <span class="bg-warning  p-1">pending</span>
                                        @elseif($task->status == 3)
                                        <span class="bg-danger  p-1">overdue</span>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger">Action</button>
                                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                              <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a class="dropdown-item" role="button" data-toggle="modal" data-target="#subTask-{{ $task->id }}">Assign Tasks
                                                 
                                                {{-- <a href="" data-toggle="modal" data-target="#subTask-{{ $task->id] }}" class="dropdown-item">Assign Task</a> --}}
                                              <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="dropdown-item">Edit</a>
                                            </div>
                                          </div>
                                    </td>
                                    <div class="modal fade" id="subTask-{{ $task->id }}" >   
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Create Task Detail</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                @if(session()->has('message'))
                                                <div class="alert alert-success">
                                                    <div id="infoText">
                                                    {{ session()->get('message') }}
                                    
                                                    </div>
                                                </div>
                                            
                                                @endif
                                                <form method="POST" action="{{ route('task_detail.create') }}">
                                                    @csrf
                                                    <input type="hidden" name="t_id" id="t_id" value="{{$task->id}}">
                                                    <div class="form-group">
                                                        <label>Users</label>
                                                        <div class="select2-purple">
                                                            <select class="select2" multiple="multiple" data-placeholder="Select Users" data-dropdown-css-class="select2-purple" style="width: 100%;" name="users[]">
                                                            @foreach ($users as $data)
                                                            <option selected value="{{$data->id}}">
                                                                {{$data->name}} ({{$data->hname}} - {{$data->bname}} - {{$data->dname}} )
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
                                                            <label for="inputName" class="form-label">Sub Task Name</label>
                                                            <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $task_head->name ?? '' }}">
                                            
                                                            @error('name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputDescription" class="form-label">Sub Task Description </label>
                                                            <input type="text" class="form-control col-md-12" id="description" name="description" value="{{ $task_head->description ?? '' }}">

                                                            @error('description')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    <div class="text-center mt-3">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-plus-circle"></i>
                                                            <span>Create</span>
                                                        </button>
                                                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                              </div>
                                             
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>
                                        
                                    
                                    </div>
                                </tr>
                                <tr class="expandable-body">
                                    @if(!empty($helper->getTaskDetailList($task->id)))
                                    <td colspan="6">
                                        <div class="p-2">
                                          <table class="table table-hover">
                                            <thead>
                                                <th>Sub Task Name</th>
                                                <th>Description</th>
                                                <th> Assigned To </th>
                                                <th> Assign Start Date </th>
                                                <th> Assign End Date </th>
                                                <th> Status </th>
                                                <th> Action </th>
                                            </thead>
                                    @foreach($helper->getTaskDetailList($task->id) as $taskd)
                                                <tr>
                                                    <td>{{$taskd->name}}</td>
                                                    <td>{{$taskd->description}}</td>
                                                    <td>{{$helper->getUserName($taskd->u_id)->name}}</td>
                                                    <td>{{Carbon\Carbon::parse($taskd->assign_start_date)->format('Y/m/d') }}</td>
                                                    <td>{{Carbon\Carbon::parse($taskd->assign_end_date)->format('Y/m/d') }}</td>
                                                    <td class="text-left">
                                                        @if($taskd->status == 1)
                                                        <span class="bg-info p-1">new</span>
                                                        @elseif($taskd->status == 4)
                                                        <span class="bg-success  p-1">complete</span>
                                                        @elseif($taskd->status == 2)
                                                        <span class="bg-warning  p-1">pending</span>
                                                        @elseif($taskd->status == 3)
                                                        <span class="bg-danger  p-1">overdue</span>
                                                        @endif
                                                    </td>
                                                       <td class="text-left">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-danger">Action</button>
                                                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu" style="">
                                                                <a href="{{ route('task_detail.edit', ['id' => $taskd->id]) }}" class="dropdown-item">Edit Task</a>
                                                                <a href="{{ route('task_detail.delete', ['id' => $task->id]) }}" class="dropdown-item">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>

                                               
                                        @endforeach
                                    </table>
                                </div>
                              </td>
                                    </tr>
                                        @endif
                                           
                                  </tr>
                                @endforeach
                                @else
                                <tr class="bg-warning">
                                    <td colspan="10">There is no data to show!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($task_heads->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $task_heads->lastItem() }} of total {{ $task_heads->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        {{ $task_heads->links() }}
                    </div>
                </div>
                @endif
            </div>


        </div>
</section>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  
    $(document).ready(function() {
        $('#effectDate').daterangepicker()

    $('.select2').select2()
    
    });


</script>
@push('scripts')

@endpush
@endsection