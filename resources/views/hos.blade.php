@extends('layout.main')
@section('title', 'Role List')
@section('content')
@section('selected', 'roles')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Head Office List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Head Office List</li>
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
                            <div class="col-md-12"><a href="{{ url('/ho') }}" class="btn btn-info float-left me-5">Add New Head Office</a></div>
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
                            <th class="col-md-2" scope="col">Location</th>
                            <th class="col-md-2" scope="col">Description</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($hos->total() != 0)
                                @foreach ($hos as $ho)
                                <tr>
                                <td> {{$ho->id }} </td>

                                    <td class="text-left"> {{ $ho->name }} </td>
                                    <td class="text-left"> {{ $ho->location }} </td>
                                    <td class="text-left"> {{ $ho->description }} </td>
                                    <td class="text-left">
                                        @if ($ho->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($ho->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                 
                                    <td class="text-left">
                                        @if($ho->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($ho->status == 4)
                                        <span class="bg-danger  p-1">De-Active</span>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('ho.edit', ['id' => $ho->id]) }}" class="btn btn-info">Edit</a>
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
                @if ($hos->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $hos->lastItem() }} of total {{ $hos->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        {{ $hos->links() }}
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