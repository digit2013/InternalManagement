@extends('layout.main')
@section('title', 'Department List')
@section('content')
@section('selected', 'depts')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Department List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Department List</li>
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
                            <div class="col-md-12"><a href="{{ url('/dept') }}" class="btn btn-info float-left me-5">Add New Department</a></div>
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
                                    <th class="col-md-2" scope="col">Branch</th>

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
                                @if ($depts->total() != 0)
                                @foreach ($depts as $dept)
                                <tr>
                                <td class="text-left"> {{$dept->id }} </td>
                                <td class="text-left"> {{ $dept->h_name }} </td>
                                <td class="text-left"> {{ $dept->b_name }} </td>
                                    <td class="text-left"> {{ $dept->name }} </td>
                                    <td class="text-left"> {{ $dept->location }} </td>

                                    <td class="text-left"> {{ $dept->description }} </td>
                              

                                    <td class="text-left">
                                        @if ($dept->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($dept->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if($dept->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($dept->status == 4)
                                        <span class="bg-danger  p-1">De-Active</span>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('dept.edit', ['id' => $dept->id]) }}" class="btn btn-info">Edit</a>
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
                @if ($depts->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $depts->lastItem() }} of total {{ $depts->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        {{ $depts->links() }}
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