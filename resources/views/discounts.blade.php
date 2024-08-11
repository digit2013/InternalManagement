@extends('layout.main')
@section('title', 'Discount List')
@section('content')
@section('selected', 'discounts')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Discount List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Discount List</li>
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
                            <div class="col-md-12"><a href="{{ url('/discount') }}" class="btn btn-info float-left me-5">Add New Discount</a></div>
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

                                    <th class="col-md-1" scope="col"> Offer Name</th>
                            <th class="col-md-2" scope="col">Price Range</th>
                            <th class="col-md-2" scope="col">Type</th>
                            <th class="col-md-2" scope="col">Amount</th>
                            <th class="col-md-1" scope="col"> Status</th>
                            <th class="col-md-4" scope="col" colspan="4" class="text-center">Action
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($discounts->total() != 0)
                                @foreach ($discounts as $discount)
                                <tr>
                                <td> {{$discount->id }} </td>

                                    <td class="text-left"> {{ $discount->name }} </td>
                                    <td class="text-left"> {{ $discount->fr_price }} - {{$discount->to_price}} </td>
                                    <td class="text-left">
                                        @if($discount->type == 1)
                                        Fixed
                                        @else
                                        Percent
                                        @endif
                                     </td>
                                     <td class="text-left"> {{ $discount->amount }} </td>
                                    <td class="text-left">
                                        @if ($discount->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($discount->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                 
                                    <td class="text-left">
                                        @if($discount->status == 1)
                                        <span class="bg-success p-1">Active</span>
                                        @elseif($discount->status == 4)
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
                                                <a href="{{ route('discount.edit', ['id' => $discount->id]) }}" class="dropdown-item">Edit</a>
                                                @if($discount->status == 1)
                                                <a href="{{ route('discount.status', ['id' => $discount->id,'status' => 4]) }}" class="dropdown-item">De-Active</a>
                                                  @else
                                                  <a href="{{ route('discount.status', ['id' => $discount->id,'status' => 1]) }}" class="dropdown-item">Active</a>
  
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
                @if ($discounts->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $discounts->lastItem() }} of total {{ $discounts->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        <ul class="pagination pagination-md ">
                          @if ($discounts->hasMorePages())
                              <a href="{{ $discounts->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($discounts->currentPage() > 1)
                              <a href="{{ $discounts->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
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