@extends('layout.main')
@section('title', 'Role List')
@section('content')
@section('selected', 'roles')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Annoucement List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Annoucement List</li>
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
                            <div class="col-md-12"><a href="{{ url('/annoucement') }}" class="btn btn-info float-left me-5">Add New Annoucement</a></div>
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
                                    <th class="col-md-2" scope="col">Heading</th>
                                    <th class="col-md-1" scope="col">Effective Date</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if (count($announces) != 0)
                                @foreach ($announces as $announce)
                                <tr data-widget="expandable-table" aria-expanded="false">
                                <td class="text-left"> {{$announce->id }} </td>
                                {{-- <td class="text-left"> 
                                    @foreach ($announce->deptArr as $d)
                                    <span class="bg-success p-1">{{$d}}</span>
                                    @endforeach
                                </td> --}}
                                <td class="text-left"> {{ $announce->heading }} </td>
                                <td class="text-left">                                         
                                    {{ Carbon\Carbon::parse($announce->startDate)->format('Y/m/d') }}
                                    
                                    {{ Carbon\Carbon::parse($announce->endDate)->format('Y/m/d') }}

                                </td>

                                    <td class="text-left">
                                        @if ($announce->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($announce->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if($announce->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($announce->status == 4)
                                        <span class="bg-danger  p-1">De-Active</span>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('annoucement.edit', ['id' => $announce->id]) }}" class="btn btn-info">Edit</a>
                                    </td>
                                </tr>
                                <tr class="expandable-body">
                                    <td colspan="6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                            @foreach ($announce->deptArr as $d)
                                            <td class="text-center">
                                            <span class="badge bg-success p-3">{{$d}}</span>
                                            </td class="text-center">
                                            @endforeach
                                        </tr>
                                            </tbody>
                                        </table>
                                    </td>
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
                {{-- @if ($announces->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $announces->lastItem() }} of total {{ $announces->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        {{ $announces->links() }}
                    </div>
                </div>
                @endif --}}
            </div>


        </div>
</section>

@push('scripts')
<script>
  
   
</script>
@endpush
@endsection