@extends('layout.main')
@section('title', 'Unit List')
@section('content')
@section('selected', 'units')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Unit List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Unit List</li>
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
                            <div class="col-md-12"><a href="{{ url('/unit') }}" class="btn btn-info float-left me-5">Add New Unit</a></div>
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

                                    <th class="col-md-1" scope="col">Name</th>
                            <th class="col-md-2" scope="col">Description</th>
                            <th class="col-md-2" scope="col">Actual Count</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($units->total() != 0)
                                @foreach ($units as $unit)
                                <tr>
                                <td> {{$unit->id }} </td>

                                    <td class="text-left"> {{ $unit->name }} </td>
                                    <td class="text-left"> {{ $unit->description }} </td>
                                    <td class="text-left"> {{ $unit->actual }} </td>
                                    <td class="text-left">
                                        @if ($unit->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($unit->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                 
                                    <td class="text-left">
                                        @if($unit->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($unit->status == 4)
                                        <span class="bg-danger  p-1">De-Active</span>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('unit.edit', ['id' => $unit->id]) }}" class="btn btn-info">Edit</a>
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
                @if ($units->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $units->lastItem() }} of total {{ $units->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        <ul class="pagination pagination-md ">
                          @if ($units->hasMorePages())
                              <a href="{{ $units->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($units->currentPage() > 1)
                              <a href="{{ $units->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
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