@extends('layout.main')
@section('title', 'Customer List')
@section('content')
@section('selected', 'customers')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customer List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Customer List</li>
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
                            <div class="col-md-12"><a href="{{ url('/customer') }}" class="btn btn-info float-left me-5">Add New Customer</a></div>
                        </div>
                    </div>
                    @if(session()->has('message')) 
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                        @endif
                    <div class="table-responsive">
                        <table class="table table-hover" id="tbl">
                                <thead>
                                    <tr>
                                    <th class="col-md-1" scope="col">Id</th>

                                    <th class="col-md-1" scope="col">Name</th>
                            <th class="col-md-2" scope="col">Phone</th>
                            <th class="col-md-2" scope="col">Mail</th>
                            <th class="col-md-2" scope="col">Address</th>
                            <th class="col-md-2" scope="col">Created Date</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($customers->total() != 0)
                                @foreach ($customers as $customer)
                                <tr>
                                <td> {{$customer->id }} </td>

                                    <td class="text-left"> {{ $customer->name }} </td>
                                    <td class="text-left"> {{ $customer->phone }} </td>
                                    <td class="text-left"> {{ $customer->mail }} </td>
                                    <td class="text-left"> {{ $customer->address }} </td>
                                    <td class="text-left">
                                        @if ($customer->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($customer->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                 
                                    <td class="text-left">
                                        @if($customer->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($customer->status == 4)
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
                                                <a href="{{ route('customer.edit', ['id' => $customer->id]) }}" class="dropdown-item">Edit</a>
                                                @if($customer->status == 1)
                                                <a href="{{ route('customer.status', ['id' => $customer->id,'status' => 4]) }}" class="dropdown-item">De-Active</a>
                                                  @else
                                                  <a href="{{ route('customer.status', ['id' => $customer->id,'status' => 1]) }}" class="dropdown-item">Active</a>
  
                                                  @endif                                            </div>
                                          </div>

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
                @if ($customers->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $customers->lastItem() }} of total {{ $customers->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        <ul class="pagination pagination-md ">
                          @if ($customers->hasMorePages())
                              <a href="{{ $customers->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($customers->currentPage() > 1)
                              <a href="{{ $customers->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
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