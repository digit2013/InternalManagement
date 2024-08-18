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
                            <th class="" scope="col">Parent Role</th>
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
                                    <td class="text-left"> 
                                        @if($role->parent >0 )
                                        <?php $i = 0; $parent_roles = $helper->getAllRolesById($role->parent)[0]->parent_role; ?> 
                                        @if(!empty($parent_roles))
                                        @foreach(explode(',',$parent_roles) as $r)
                                            {{$helper->getRole($r)->name;}} 
                                            @if($i < count(explode(',',$parent_roles))-1)
                                            >
                                            @endif
                                            <?php $i++; ?>
                                        @endforeach
                                        @endif
                                        @else
                                        -
                                        @endif

                             </td>
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
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger">Action</button>
                                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                              <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a class="dropdown-item" role="button" data-toggle="modal" data-target="#jd-{{ $role->id }}">Job Description</a>
                                                    <a href="{{ route('role.edit', ['id' => $role->id]) }}" class="dropdown-item">Edit</a>
                                            </div>
                                          </div>

                                    </td>
                                    <div class="modal fade" id="jd-{{ $role->id }}" >   
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Job Description</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="card-body">
                                                {!!$role->description!!}
                                              </div>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>
                                        
                                    
                                    </div>
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
                        <ul class="pagination pagination-md ">
                          @if ($roles->hasMorePages())
                              <a href="{{ $roles->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($roles->currentPage() > 1)
                              <a href="{{ $roles->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
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