@extends('layout.main')
@section('title', 'Role List')
@section('content')
@section('selected', 'roles')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Role List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Role List</li>
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
                            <div class="col-md-12"><a href="{{ url('/role') }}" class="btn btn-info float-left me-5">Add New Role</a></div>
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
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($roles->total() != 0)
                                @foreach ($roles as $role)
                                <tr>
                                <td> {{$role->id }} </td>

                                    <td class="text-left"> {{ $role->name }} </td>
                                    <td class="text-left"> {{ $role->description }} </td>
                                    <td class="text-left">
                                        @if ($role->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($role->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($role->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($role->status == 4)
                                        <span class="bg-danger  p-1">De-Active</span>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('role.edit', ['id' => $role->id]) }}" class="btn btn-info">Edit</a>
                                    </td>

                                    {{-- <td>
                                    @if($role->status == 1)
                                        <a href="{{ route('role.status', ['id' => $role->id,'status'=>'2']) }}" class="btn btn-info col-sm-12 float-right"  >Suspend</a>
                                    @elseif($role->status == 2) <a href="{{ route('role.status', ['id' => $role->id,'status'=>'1']) }}" class="btn btn-info col-sm-12 float-right"  >Active</a>
                                    @elseif($role->status == 5) <a href="{{ route('role.status', ['id' => $role->id,'status'=>'1']) }}" class="btn btn-info col-sm-12 float-right"  >Active</a>
                                    @else <a href="{{ route('role.status', ['id' => $role->id,'status'=>'1']) }}" class="btn btn-info col-sm-12 float-right"  >Suspend</a>
                                    @endif
                                    </td> --}}
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
                @if ($roles->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $roles->lastItem() }} of total {{ $roles->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        {{ $roles->links() }}
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