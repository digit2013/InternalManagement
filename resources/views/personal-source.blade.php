@extends('layout.main')
@section('title', 'Person List')
@section('content')
@section('selected', 'pds')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Person List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Person Data Source</li>
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
                            <div class="col-md-12"><a href="{{ url('/person-info') }}" class="btn btn-info float-left me-5">Add New Person Info</a></div>
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
                                    <th class="" scope="col">Id</th>

                                    <th class="" scope="col">Name</th>
                                    <th class="" scope="col">Gender</th>
                                    <th class="" scope="col">Material Status</th>

                            <th class="" scope="col">Country</th>
                            <th class="" scope="col">State</th>
                            <th class="" scope="col">City</th>
                            <th class="" scope="col">Address</th>
                            <th class="" scope="col">Occupation</th>
                            <th class="" scope="col">Age</th>
                            <th class="" scope="col">phone</th>
                            <th class="" scope="col">Mail</th>
                            <th class="" scope="col">Avgerage Income</th>

                            <th class="" scope="col">Created Date</th>
                            @if(session('isAdmin') == 1)

                            <th class="" scope="col" colspan="4" class="text-center">Action
                            </th>
                            @endif
                            </tr>
                            </thead>
                            <tbody>
                                <!-- @php($i = 1) -->
                                @if ($persons->total() != 0)
                                @foreach ($persons as $person)
                                <tr>
                                <td> {{$person->id }} </td>
                                    <?php           if(!empty($person->countryCode)){$country = $helper->getCountry($person->countryCode);$countryName = $country['name'];}
                                    else{
                                        $countryName = '-';
                                    }
                                                    if(!empty($person->stateCode)){$state = $helper->getState($country['name'],$country['isoCode'],$person->stateCode);$stateName = $state['name'];}
                                    else{
                                        $stateName = '-';
                                    }
                                                    if(!empty($person->city)){$city = $helper->getCities($country['name'],$country['isoCode'],$state['name'], $state['isoCode'],$person->city );$cityName = $city['name'];}
                                    else{
                                        $cityName = '-';
                                    }

                                                    ?>
                                    <td class="text-left"> {{ $person->name }} </td>
                                    <td class="text-left">
                                        @foreach(config('app.gender') as $title => $value)
                                        @if($value == $person->gender)
                                        <small style="font-weight: bold;">{{$title}}</small>
                                        @endif
                                        @endforeach

                                    </td>
                                    <td class="text-left">
                                        @foreach(config('app.material') as $title => $value)
                                        @if($value == $person->material)
                                        {{$title}}
                                        @endif
                                        @endforeach

                                    </td>
                                    <td class="text-left"> {{ $countryName  }} </td>
                                    <td class="text-left"> {{  $stateName}} </td>
                                    <td class="text-left"> {{ $cityName}} </td>
                                    <td class="text-left text-warp"> {{ $person->address}} </td>
                                    <td class="text-left text-wrap"> {{ $person->occupation}} </td>
                                    <td class="text-right"> {{ $person->age}} </td>
                                    <td class="text-left"> + {{ $person->phonecode}}   {{ $person->phone}} </td>
                                    <td class="text-left"> {{ $person->mail}} </td>
                                    <td class="text-right">{{$person->avgIncome}} <small class="badge badge-info">({{ $person->currency}})</small>  </td>

                                    <td class="text-left">
                                        @if ($person->created_at == null)
                                        <span class="text-danger"> No Date Set</span>
                                        @else
                                        {{ Carbon\Carbon::parse($person->created_at)->format('Y/m/d') }}
                                        @endif
                                    </td>
                                 
                                   
                                    @if(session('isAdmin') == 1)
                                    <td class="text-left" >
                                        <a href="{{ URL('/person-edit/'.$person->id) }}" class="btn btn-info" >Edit</a>
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
                @if ($persons->total() != 0)
                <div class="row dflex">
                    <div class="col-md-4 float-right">
                        {{ $persons->lastItem() }} of total {{ $persons->total() }}
                    </div>
                    <div class="col-md-6 float-left">
                        <ul class="pagination pagination-md ">
                          @if ($persons->hasMorePages())
                              <a href="{{ $persons->nextPageUrl() }}" class="btn btn-default m-1 p-2">Next</a>
                          @endif
                          @if($persons->currentPage() > 1)
                              <a href="{{ $persons->previousPageUrl() }}" class="btn btn-default m-1 p-2">Prev</a>
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