@extends('layout.main')
@section('title', 'Head Office List')
@section('content')
@section('selected', 'hos')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Meeting Minutes List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Meeting Minutes List</li>
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
                            @if(session('isAdmin') == 1)
                            <div class="col-md-12"><a href="{{ url('/meeting-minute') }}" class="btn btn-info float-left me-5">Add New Meeting Minutes</a></div>
                            @endif
                        </div>
                    </div>
                    {{-- @if(session()->has('message')) --}}
                        {{-- <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div> --}}
                        {{-- @endif --}}
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl">
                                <thead>
                                    <tr>
                                    <th class="col-md-1" scope="col">Id</th>
                            <th class="col-md-2" scope="col">Meeting Date</th>
                            <th class="col-md-2" scope="col">Host</th>
                            <th class="col-md-2" scope="col">Attendees</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            @if(session('isAdmin') == 1)

                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            @endif
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($minutes->total() != 0)
                                @foreach ($minutes as $minute)
                                <tr>
                                <td> {{$minute->id }} </td>
                                <td class="text-left">{{ Carbon\Carbon::parse($minute->meeting_date)->format('Y/m/d') }} </td>

                                    <td class="text-left"> {{ $helper->getUserName($minute->host)->name }} </td>
                                    <td class="text-left">
                                        <?php $i=0; $attendees = explode(',',$minute->attendees);?>
                                        @if(!empty($attendees))
                                        @foreach($attendees as $a)
                                            {{$helper->getUserName($a)->name;}} 
                                            @if($i < count($attendees)-1)
                                            ,
                                            @endif
                                            <?php $i++; ?>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if ($minute->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($minute->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                    @if(session('isAdmin') == 1)
                                    <td class="text-left">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger">Action</button>
                                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                              <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a class="dropdown-item" role="button" data-toggle="modal" data-target="#minute-{{ $minute->id }}">View Detail
                                                <a href="{{ route('minute.edit', ['id' => $minute->id]) }}" class="dropdown-item" >Edit</a>
                                            </div>
                                          </div>
                                    </td>
                                    <div class="modal fade" id="minute-{{ $minute->id }}" >   
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Meeting Minute -  {{ Carbon\Carbon::parse($minute->created_at)->format('Y/m/d') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                {!!$minute->description!!}
                                              </div>
                                             
                                            </div>
                                          </div>
                                    </div>
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
                @if ($minutes->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $minutes->lastItem() }} of total {{ $minutes->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        <ul class="pagination pagination-md ">
                          @if ($minutes->hasMorePages())
                              <a href="{{ $minutes->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($minutes->currentPage() > 1)
                              <a href="{{ $minutes->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
                          @endif
                        </ul>
                    </div>
                </div>
                @endif
            </div>


        </div>
</section>

@push('scripts')
<script>
  
   
</script>
@endpush
@endsection