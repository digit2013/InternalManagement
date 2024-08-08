@extends('layout.main')
@section('title', 'Branch List')
@section('content')
@section('selected', 'branchs')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Branch List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Branch List</li>
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

                            <div class="col-md-12"><a href="{{ url('/branch') }}" class="btn btn-info float-left me-5">Add New Branch</a></div>
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
                                    <th class="col-md-2" scope="col">Head Office</th>
                                    <th class="col-md-1" scope="col">Name</th>
                            <th class="col-md-2" scope="col">Location</th>
                            <th class="col-md-2" scope="col">Description</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            @if(session('isAdmin') == 1)

                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            @endif
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($branchs->total() != 0)
                                @foreach ($branchs as $branch)
                                <tr>
                                <td class="text-left"> {{$branch->id }} </td>
                                <td class="text-left"> {{ $branch->h_name }} </td>
                                    <td class="text-left"> {{ $branch->name }} </td>
                                    <td class="text-left"> {{ $branch->location }} </td>

                                    <td class="text-left"> {{ $branch->description }} </td>
                              

                                    <td class="text-left">
                                        @if ($branch->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($branch->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if($branch->status == 1)
                                        <span class="badge badge-success">Active</span>
                                        @elseif($branch->status == 4)
                                        <span class="badge badge-danger">De-Active</span>
                                        @endif
                                    </td>
                                    @if(session('isAdmin') == 1)

                                    <td class="text-left">
                                        <a href="{{ route('branch.edit', ['id' => $branch->id]) }}" class="btn btn-info">Edit</a>
                                    </td>
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
                @if ($branchs->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $branchs->lastItem() }} of total {{ $branchs->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        <ul class="pagination pagination-md ">
                          @if ($branchs->hasMorePages())
                              <a href="{{ $branchs->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($branchs->currentPage() > 1)
                              <a href="{{ $branchs->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
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