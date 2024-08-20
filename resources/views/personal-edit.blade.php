@extends('layout.main')
@section('title', 'New Role')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Personal Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Add Personal Data</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section id="contact" class="contact">
        <div class="container-fluid" data-aos="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">{{ isset($person) ? 'Edit Personal Data' : 'Create Personal Data' }}
                                </div>
                                <div class="col-md-4" align="right"><a href="{{ url('/personal-source') }}">Go Listing</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    <div id="infoText">
                                        {{ session()->get('message') }}

                                    </div>
                                </div>
                            @endif
                            <form id="itemFrom" role="form" method="POST"
                                action="{{ isset($person) ? route('person.update', $person->id) : route('person.create') }}">
                                @csrf
                                @isset($person)
                                    @method('PUT')
                                @endisset


                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Person Name </label>
                                    <input type="text" class="form-control col-md-12" id="name" name="name"
                                        value="{{ $person->name ?? '' }}">

                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Age </label>
                                    <input type="number" class="form-control col-md-12" id="age" name="age"
                                        value="{{ $person->age ?? '' }}">

                                    @error('age')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">

                                    @if (isset($occupations))
                                        <select class="form-control select2" name="occupation" id="occupation">
                                            <option value="">-- Select Occupation --</option>
                                            @foreach ($occupations as $data)
                                                @if (isset($person->occupation) && $person->occupation == $data)
                                                    <option selected value="{{ $data }}">
                                                        {{ $data }}
                                                    </option>
                                                @else
                                                    <option value="{{ $data }}">
                                                        {{ $data }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control" name="occupation" id="occupation">
                                            <option value="">-- Select Occupation --</option>
                                    @endif
                                    </select>
                                    @error('occupation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-3">
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="">-- Gender --</option>
                                            @foreach (config('app.gender') as $title => $value)
                                                @if (isset($person->gender) && $person->gender == $value)
                                                    <option selected value="{{ $value }}">
                                                        {{ $title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $value }}">
                                                        {{ $title }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4 mb-3">
                                        <select class="form-control" name="material" id="material">
                                            <option value="">-- Material --</option>
                                            @foreach (config('app.material') as $title => $value)
                                                @if (isset($person->material) && $person->material == $value)
                                                    <option selected value="{{ $value }}">
                                                        {{ $title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $value }}">
                                                        {{ $title }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('material')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 mb-3">
                                        <select class="form-control select2" name="country" id="country">
                                            <option value="">-- Select Country --</option>
                                            @foreach ($countries as $data)
                                                @if (isset($person->countryCode) && $person->countryCode == $data['isoCode'])
                                                    <option selected value="{{ $data['isoCode'] }}"
                                                        data-id="{{ $data['phonecode'] }}" data-cur="{{$data['currency']}}">
                                                        {{ $data['name'] }}
                                                    </option>
                                                @else
                                                    <option value="{{ $data['isoCode'] }}"
                                                        data-id="{{ $data['phonecode'] }}" data-cur="{{$data['currency']}}">
                                                        {{ $data['name'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4 mb-3">
                                        @if (isset($states))
                                            <select class="form-control select2" name="state" id="state">
                                                <option value="">-- Select State --</option>
                                                @foreach ($states as $data)
                                                    @if (isset($person->stateCode) && $person->stateCode == $data['isoCode'])
                                                        <option selected value="{{ $data['isoCode'] }}">
                                                            {{ $data['name'] }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $data['isoCode'] }}">
                                                            {{ $data['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select class="form-control" name="state" id="state">
                                                <option value="">-- Select State --</option>
                                        @endif
                                        </select>
                                        @error('state')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        @if (isset($cities))
                                            <select class="form-control select2" name="city" id="city">
                                                <option value="">-- Select City --</option>
                                                @foreach ($cities as $data)
                                                    @if (isset($person->cityCode) && $person->cityCode == $data['name'])
                                                        <option selected value="{{ $data['name'] }}">
                                                            {{ $data['name'] }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $data['name'] }}">
                                                            {{ $data['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select class="form-control" name="city" id="city">
                                                <option value="">-- Select City --</option>
                                        @endif
                                        </select>
                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Address </label>
                                    <input type="text" class="form-control col-md-12" id="address" name="address"
                                        value="{{ $person->address ?? '' }}">

                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Phone Number</label>
                                    <div class="row">
                                        <input type="text" class="form-control col-md-2" id="phonecode"
                                            name="phonecode" value="{{ $person->phonecode ?? '' }}" readonly>
                                        <input type="text" class="form-control col-md-10" id="phone"
                                            name="phone" value="{{ $person->phone ?? '' }}">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Mail</label>
                                    <input type="text" class="form-control col-md-12" id="mail" name="mail"
                                        value="{{ $person->mail ?? '' }}">
                                    @error('mail')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="form-label">Average Income (Annual)</label>
                                    <div class="row">
                                    <input type="number" class="form-control col-md-10" id="avgIncome" name="avgIncome"
                                        value="{{ $person->avgIncome ?? '' }}">
                                        <input type="text" class="form-control col-md-2" id="currency" name="currency"
                                        value="{{ $person->currency ?? '' }}" readonly>
                                    </div>
                                    @error('avgIncome')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        @isset($person)
                                            <i class="fas fa-arrow-circle-up"></i>
                                            <span>Update</span>
                                        @else
                                            <i class="fas fa-plus-circle"></i>
                                            <span>Create</span>
                                        @endisset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
    </section><!-- End Services Section -->
    @push('scripts')
    @endpush
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        var country_code;
        var country_name;
        var state_code;
        var state_name;
        function countryChange(){
            $("#state").html('');
                country_code = $('#country').val();
                country_name = $('#country').find("option:selected").text();
                $('#currency').val($('#country').find(':selected').attr('data-cur'));
                $('#phonecode').val($('#country').find(':selected').attr('data-id'));
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        countryCode: country_code,
                        countryName: country_name,

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state').html('<option value="">-- Select State --</option>');
                        $.each(result, function(key, value) {

                            if(<?php echo json_encode(isset($person)); ?>){
                                if(<?php echo json_encode($person->stateCode); ?> == value.isoCode){
                                    $("#state").append('<option value="' + value
                                    .isoCode + '" selected>' + value.name + '</option>');
                                }else{
                                    $("#state").append('<option value="' + value
                                    .isoCode + '">' + value.name + '</option>');
                                }
                            }else{
                                $("#state").append('<option value="' + value
                                .isoCode + '">' + value.name + '</option>');
                            }
                          
                        });
                        stateChange();
                    }
                });
        }
        function stateChange(){
            $("#city").html('');
                state_code =  $('#state').val();
                state_name = $('#state').find("option:selected").text();
                $.ajax({
                    url: "{{ url('api/fetch-cities') }}",
                    type: "POST",
                    data: {
                        countryCode: country_code,
                        countryName: country_name,
                        stateCode: state_code,
                        stateName: state_name,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                    
                        $('#city').html('<option value="">-- Select City --</option>');
                        $.each(result, function(key, value) {

                            if("{{ isset($person) }}"){
                                if(<?php echo json_encode($person->city); ?> == value.name){
                                    $("#city").append('<option value="' + value
                                    .name + '" selected>' + value.name + '</option>');
                                }else{
                                    $("#city").append('<option value="' + value
                                    .name + '">' + value.name + '</option>');
                                }
                            }else{
                                $("#city").append('<option value="' + value
                                .name + '">' + value.name + '</option>');
                            }

                            });
                    }
                });
        }
        $(document).ready(function() {
            $('.select2').select2();
            
            if("{{ isset($person) }}"){
                countryChange();
            }else{
            }

            $('#country').on('change', function() {
                $("#state").html('');
                country_code = this.value;
                country_name = $(this).find("option:selected").text();
                $('#currency').val($(this).find(':selected').attr('data-cur'));
                $('#phonecode').val($(this).find(':selected').attr('data-id'));
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        countryCode: country_code,
                        countryName: country_name,

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state').html('<option value="">-- Select State --</option>');
                        $.each(result, function(key, value) {
                            $("#state").append('<option value="' + value
                                .isoCode + '">' + value.name + '</option>');
                        });
                    }
                });
            });

            $('#state').on('change', function() {
                $("#city").html('');
                state_code = this.value;
                state_name = $(this).find("option:selected").text();
                $.ajax({
                    url: "{{ url('api/fetch-cities') }}",
                    type: "POST",
                    data: {
                        countryCode: country_code,
                        countryName: country_name,
                        stateCode: state_code,
                        stateName: state_name,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city').html('<option value="">-- Select City --</option>');
                        $.each(result, function(key, value) {
                            $("#city").append('<option value="' + value
                                .name + '">' + value.name + '</option>');
                        });
                    }
                });
            });


        });
    </script>
@endsection
