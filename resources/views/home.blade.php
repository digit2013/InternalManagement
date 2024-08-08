@extends('layout.main')
@section('title', 'User Management')
@section('content')
@section('Home', 'active')
<section id="contact" class="contact">
  <div class="container-fluid mt-3" data-aos="fade-in">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Users</span>
            <span class="info-box-number">{{($helper->getTopWidget()[0]['userCount'])}}</span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tag"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Products</span>
            <span class="info-box-number">
              {{($helper->getTopWidget()[0]['productCount'])}}
            </span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="far fa-calendar-alt"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Overdue Task</span>
            <span class="info-box-number">{{($helper->getTopWidget()[0]['overdueTaskCount'])}}</span>
          </div>
        </div>
      </div>

      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Sales</span>
            <span class="info-box-number">76,000</span>
          </div>
        </div>
      </div>
      
    </div>

    <div class="row">

      <div class="col-md-6">
        
        <div class="card">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="ion ion-clipboard mr-1"></i>
              My Task
            </h3>
            <div class="card-tools">
            {{-- @if (count($helper->getTaskDetailList()) != 0)
            <ul class="pagination pagination-sm">
              @if ($helper->getTaskDetailList()->hasMorePages())
                  <a href="{{ $helper->getTaskDetailList()->nextPageUrl() }}" class="p-1"><small
                          class="badge badge-info">Next</small></a>
              @endif
              @if($helper->getTaskDetailList()->currentPage() > 1)
                  <a href="{{ $helper->getTaskDetailList()->previousPageUrl() }}" class="p-1"><small
                          class="badge badge-info">Prev</small></a>
              @endif
            </ul>
            @endif --}}
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            </div>
          </div>
          <div class="card-body">
            @if (count($helper->getTaskDetailList()) != 0)
            <ul class="todo-list" data-widget="todo-list">
              @foreach($helper->getTaskDetailList() as $taskd)
              <li>
                <span class="handle">
                  <i class="fas fa-ellipsis-v"></i>
                  <i class="fas fa-ellipsis-v"></i>
                </span>
                <span class="text">{{$taskd->description}}</span>
                @if($taskd->status == 1)
                <small class="badge badge-info"><i class="far fa-clock"></i>{{$taskd->assign_end_date}}</small>
                @elseif($taskd->status == 2)
                <small class="badge badge-warning"><i class="far fa-clock"></i>{{$taskd->assign_end_date}}</small>
                @elseif($taskd->status == 3)
                <small class="badge badge-danger"><i class="far fa-clock"></i>{{$taskd->assign_end_date}}</small>
                @elseif($taskd->status == 4)
                <small class="badge badge-success"><i class="far fa-clock"></i>{{$taskd->finish_end_date .' complete'}}</small>
                @endif
                <div class="tools">
                  <i class="fas fa-edit" data-toggle="modal" data-target="#taskDetail-{{ $taskd->id }}"></i>
                  <i class="fas fa-upload" data-toggle="modal" data-target="#taskAttach-{{ $taskd->id }}"></i>
                </div>
              </li>
              <div class="modal fade" id="taskDetail-{{ $taskd->id }}" >   
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Task Detail</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="itemFrom" role="form" method="POST" action="{{url('/task-detail/'.$taskd->id.'/status') }}">
                              @csrf
                              <input type="hidden" class="form-control col-md-12" id="id" name="id" value="{{$taskd->id}}" >
                              <div class="form-group">
                                  <label for="inputHeading" class="form-label">Assigned By</label>
                                  <input type="text" class="form-control col-md-12"  value="{{$helper->getUser($helper->getAssignedBy($taskd->t_id)->created_by)->name }}" disabled>
            
                              </div>
                              <div class="form-group">
                                  <label>Effective Date:</label>
                
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    
                                    <input type="text" class="form-control float-right" value= {{ Carbon\Carbon::parse($taskd->assign_start_date)->format('Y/m/d') .' to '. Carbon\Carbon::parse($taskd->assign_end_date)->format('Y/m/d')}}  disabled>
                                  </div>
                                  <!-- /.input group -->
                              </div>
                              <div class="form-group">
                                  <label for="inputHeading" class="form-label">Task Name</label>
                                  <input type="text" class="form-control col-md-12" value="{{ $taskd->name ?? '' }}" disabled>
            
                                 
                              </div>
                              <div class="form-group">
                                  <label for="inputHeading" class="form-label">Task Description </label>
                                  <input type="text" class="form-control col-md-12" value="{{ $taskd->description ?? '' }}" disabled>
                              </div>
                              <div class="form-group">
                                  <label>Select Progress</label>
                                  <select class="form-control" name="status" id="status" {{($taskd->status == 4 ? 'disabled':'')}}>
                                      <option value="">-- Select Progress --</option>
                                      
                                      <option {{($taskd->status == 2 ? 'selected':'')}} value="2">
                                          Pending
                                      </option>
                                      <option {{($taskd->status == 4 ? 'selected':'')}} value="4">
                                          Complete
                                      </option>
                                  </select>
                              </div>
                              <div class="text-center mt-3">
                                  <button type="submit" class="btn btn-primary">
                                      @isset($taskd)
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
              <div class="modal fade" id="taskAttach-{{ $taskd->id }}" >   
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Task Detail</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="itemFrom" role="form" method="POST" action="{{ url('task/'.$taskd->id.'/upload') }}" enctype="multipart/form-data">
                              @csrf
                                <div class="mb-3">
                                  <label>Upload Images (Max:10 files only)</label>
                                  <input type="file" name="taskAttach[]" multiple class="form-control" />
                              </div>
                              <div class="text-center mt-3">
                                  <button type="submit" class="btn btn-primary">
                                      <i class="fas fa-plus-circle"></i>
                                      Upload                                </button>
                              </div>
                          </form>
                        </div>
                        <div class="col-md-6">
                          <ul class="list-unstyled">
                          @foreach($helper->getFileList($taskd->id) as $tfile)
                            <li>
                              <a href="{{ route('download',$tfile->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i>{{basename($tfile->file_url)}}</a>
                              <a href="{{ url('/task-file/'.$tfile->id.'/delete') }}" >Delete</a>
                            </li>
                        </ul>
                          @endforeach
                      </div>
                    </div>
                  </div>
              </div>
             @endforeach
            </ul>
            @else
               There is no tasks!
            @endif 
          </div>
         
        </div>
        
      </div>
      <div class="col-md-6">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">My Task Chart</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="taskChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 466px;" width="466" height="250" class="chartjs-render-monitor"></canvas>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
     
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-info">
            <h3 class="card-title">Pending Tasks</h3>
            <div class="card-tools">
             
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Task</th>
                  <th>Members</th>
                  <th>Deadline</th>
                </tr>
              </thead>
              <tbody>
                @if (count($helper->getAssignedByUser( Session::get('user')->id,2)) != 0)
                @foreach($helper->getAssignedByUser( Session::get('user')->id,2) as $taskd)
                <tr>
                  <td>{{$taskd->name}}</td>
                  <td>{{$taskd->assigned_member}}</td>
                  <td>
                     <span  class="badge badge-warning">{{$taskd->assign_end_date}}</span>
                  </td>
                </tr>
              @endforeach
              @else
              <tr class="bg-warning">
                  <td colspan="3">There is no pending tasks!</td>
              </tr>
              @endif              
            </tbody>
            </table>
            <hr/>
            <div class="row">
              <div class="col-md-8">

              {{-- @if (count($helper->getAssignedByUser( Session::get('user')->id,2)) != 0)
              <ul class="pagination pagination-sm">
                @if ($helper->getAssignedByUser( Session::get('user')->id,2)->hasMorePages())
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,2)->nextPageUrl() }}" class="p-1"><small
                            class="badge badge-info">Next</small></a>
                @endif
                @if($helper->getAssignedByUser( Session::get('user')->id,2)->currentPage() > 1)
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,2)->previousPageUrl() }}" class="p-1"><small
                            class="badge badge-info">Prev</small></a>
                @endif
              </ul>
              @endif --}}
              </div>
              <div class="col-md-4">
              <small> total {{$helper->getAssignedByUser( Session::get('user')->id,2)->total()}} tasks </small>
              </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-danger">
            <h3 class="card-title">Overdue Tasks</h3>
            <div class="card-tools">
             
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Task</th>
                  <th>Members</th>
                  <th>Deadline</th>
                </tr>
              </thead>
              <tbody>
                @if (count($helper->getAssignedByUser( Session::get('user')->id,3)) != 0)
                @foreach($helper->getAssignedByUser( Session::get('user')->id,3) as $taskd)
                <tr>
                  <td>{{$taskd->name}}</td>
                  <td>{{$taskd->assigned_member}}</td>
                  <td>
                    <span  class="badge badge-danger">{{$taskd->assign_end_date}}</span>
                  </td>
                </tr>
              @endforeach
              @else
              <tr class="bg-warning">
                  <td colspan="3">There is no overdue tasks!</td>
              </tr>
              @endif              
            </tbody>
            </table>
            <hr/>
            <div class="row">
              <div class="col-md-8">

              {{-- @if (count($helper->getAssignedByUser( Session::get('user')->id,3)) != 0)
              <ul class="pagination pagination-sm">
                @if ($helper->getAssignedByUser( Session::get('user')->id,3)->hasMorePages())
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,3)->nextPageUrl() }}" class="p-1"><small
                            class="badge badge-info">Next</small></a>
                @endif
                @if($helper->getAssignedByUser( Session::get('user')->id,3)->currentPage() > 1)
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,3)->previousPageUrl() }}" class="p-1"><small
                            class="badge badge-info">Prev</small></a>
                @endif
              </ul>
              @endif --}}
              </div>
              <div class="col-md-4">
              <small> total {{$helper->getAssignedByUser( Session::get('user')->id,3)->total()}} tasks </small>
              </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-success">
            <h3 class="card-title">Complete Tasks</h3>
            <div class="card-tools">
             
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Task</th>
                  <th>Members</th>
                  <th>Finish Date</th>
                </tr>
              </thead>
              <tbody>
                @if (count($helper->getAssignedByUser( Session::get('user')->id,4)) != 0)
                @foreach($helper->getAssignedByUser( Session::get('user')->id,4) as $taskd)
                <tr>
                  <td>{{$taskd->name}}</td>
                  <td>{{$taskd->assigned_member}}</td>
                  <td>
                      {{$taskd->finish_end_date}}
                  </td>
                </tr>
              @endforeach
              @else
              <tr class="bg-warning">
                  <td colspan="3">There is no complete tasks!</td>
              </tr>
              @endif              
            </tbody>
            </table>
            <hr/>
            <div class="row">
              <div class="col-md-8">

              {{-- @if (count($helper->getAssignedByUser( Session::get('user')->id,4)) != 0)
              <ul class="pagination pagination-sm">
                @if ($helper->getAssignedByUser( Session::get('user')->id,4)->hasMorePages())
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,4)->nextPageUrl() }}" class="p-1"><small
                            class="badge badge-info">Next</small></a>
                @endif
                @if($helper->getAssignedByUser( Session::get('user')->id,4)->currentPage() > 1)
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,4)->previousPageUrl() }}" class="p-1"><small
                            class="badge badge-info">Prev</small></a>
                @endif
              </ul>
              @endif --}}
              </div>
              <div class="col-md-4">
              <small> total {{$helper->getAssignedByUser( Session::get('user')->id,4)->total()}} tasks </small>
              </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
 var pieChartCanvas = $('#taskChart').get(0).getContext('2d')
 var data = {
        labels: ['new','pending', 'complete', 'overdue'],
        datasets: [{
            data: [ @json($newTaskCount),  @json($pendingTaskCount),   @json($completeTaskCount),  @json($overdueTaskCount)],
            backgroundColor: [  '#00c0ef','#f39c12', '#00a65a','#f56954']
        }]
    };
    var pieData        = data;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

</script>
</section>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection

