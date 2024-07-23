@extends('layout.main')
@section('title', 'New Role')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">New User</li>
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
                            <div class="col-md-8">{{ isset($dept) ? "Edit User" : "Create User" }}</div>
                            <div class="col-md-4" align="right"><a href="{{url('/users')}}">Go Listing</a></div>
                        </div>
                    </div>
                    <div class="card-body ">
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            <div id="infoText">
                            {{ session()->get('message') }}

                            </div>
                        </div>
                    
                        @endif
                        <form id="itemFrom" role="form" method="POST" action="{{ isset($user) ? route('user.update',$user->id) : route('user.create') }}">
                            @csrf
                            @isset($user)
                            @method('PUT')
                            @endisset
                            <div class="form-group mb-3">
                                <select class="form-control" name="roles" id="roles">
                                    <option value="">-- Select Role --</option>
                                    @foreach ($roles as $data)
                                    @if((isset($user->r_id)) && ($user->r_id == $data->id))
                                    <option selected value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @else
                                    <option value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @endif
                                 
                                    @endforeach
                                </select>
                                @error('headoffice')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <select class="form-control" name="headoffice" id="headoffice">
                                    <option value="">-- Select Head Office --</option>
                                    @foreach ($headoffices as $data)
                                    @if((isset($user->h_id)) && ($user->h_id == $data->id))
                                    <option selected value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @else
                                    <option value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @endif
                                 
                                    @endforeach
                                </select>
                                @error('headoffice')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                @if ((isset($branchs))&&(isset($user)))
                                <select class="form-control" name="branchs" id="branchs">
                                    <option value="">-- Select Branch --</option>
                                    @foreach ($branchs as $data)
                                    @if((isset($user->b_id)) && ($user->b_id == $data->id))
                                    <option selected value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @else
                                    <option value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @endif 
                                 
                                   @endforeach
                                </select>
                                @else
                                <select class="form-control" name="branchs" id="branchs">
                                    <option value="">-- Select Branch --</option>
                                 @endif
                                </select>
                                @error('branchs')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                @if ((isset($depts))&&(isset($user)))
                                <select class="form-control" name="depts" id="depts">
                                    <option value="">-- Select Department --</option>
                                    @foreach ($depts as $data)
                                    @if((isset($user->d_id)) && ($user->d_id == $data->id))
                                    <option selected value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @else
                                    <option value="{{$data->id}}">
                                        {{$data->name}}
                                    </option>
                                    @endif 
                                 
                                   @endforeach
                                </select>
                                @else
                                <select class="form-control" name="depts" id="depts">
                                    <option value="">-- Select Department --</option>
                                 @endif
                                </select>
                                @error('depts')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputUserName" class="form-label">User Name </label>
                                <input type="text" class="form-control col-md-12" id="name" name="name" value="{{ $user->name ?? '' }}">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPhone" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ $user->phone ?? '' }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="{{ $user->password ?? '' }}">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confrim_password" name="confrim_password" value="{{ $user->password ?? '' }}">
                                @error('confrim_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input type="address" class="form-control" id="address" name="address" value="{{ $user->address ?? '' }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    @isset($branch)
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
    $(document).ready(function () {
  var hid;
  $('#headoffice').on('change', function () {
      var h_id = this.value;
      hid = this.value;
      $("#branchs").html('');
      $.ajax({
          url: "{{url('api/fetch-branchs')}}",
          type: "POST",
          data: {
            h_id: h_id,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (result) {
              $('#branchs').html('<option value="">-- Select Branch --</option>');
              $.each(result.branchs, function (key, value) {
                  $("#branchs").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
  });

  $('#branchs').on('change', function () {
      var b_id = this.value;
      $("#depts").html('');
      $.ajax({
          url: "{{url('api/fetch-depts')}}",
          type: "POST",
          data: {
            h_id: hid,
            b_id: b_id,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (result) {
              $('#depts').html('<option value="">-- Select Department --</option>');
              $.each(result.depts, function (key, value) {
                  $("#depts").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
  });

});
</script>
@endsection
