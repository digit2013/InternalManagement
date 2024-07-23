<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KANAIYA | Log in </title>
  <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
</head>
<body class="hold-transition login-page">
    <div class="container d-flex flex-column justify-content-between vh-100">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="card">
                    <div class="card-header" >
                        <div class="app-brand ">
                            <div class="row justify-content-center">
                            <img src="{{url('/images/logo.png')}}" alt="" class="img-fluid" style="width:150px;height:150px;">
                            </div>
                        </div>
                    </div>


                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-body p-5">
                        <h4 class="text-dark mb-5">Sign In our System</h4>
                        <form method="post" action="{{ route('user.login') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12 mb-4">
                                    <input type="text" name="email" id="email" class="form-control input-lg"
                                     placeholder="email">
                                </div>
                                <div class="form-group col-md-12 ">
                                    <input type="password" class="form-control input-lg" name="password"
                                        placeholder="Password">
                                </div>
                                <div class="col-md-12">
                                  
                                    <button type="submit" class="btn btn-lg  btn-info  btn-block mb-4">Sign In</button>
                                
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright pl-0">
            <p class="text-center">Copyright &copy; 2024-2025 KANAIYA.
                <a class="text-primary" href="#" target="_blank"></a>.
            </p>
        </div>
    </div>
<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('dist/js/adminlte.min.js')}}"></script>

</body>
</html>
