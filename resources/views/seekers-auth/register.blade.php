<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Fursa - Register</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('front/Authcssjs/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
 
  <!-- Custom styles for this template-->
  <link href="{{ asset('front/Authcssjs/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body style="background-color: #f5fefd;">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-ƒ10">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img src="{{ asset('front/images/fursa.png') }}" alt="Logo" height="100" class="mb-4">
                    <hr>
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                  </div>
                  <form action="{{ route('seekerRegister.save') }}" method="POST" class="user">
                    @csrf
                    <div class="form-group">
                      <input name="first_name" type="text" class="form-control form-control-user @error('first_name') is-invalid @enderror" id="exampleInputName" placeholder="First Name">
                      @error('first_name')
                          <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input name="last_name" type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror" id="exampleInputName" placeholder="Last Name">
                      @error('last_name')
                          <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input name="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email Address">
                      @error('email')
                          <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input name="phone" type="tell" class="form-control form-control-user @error('phone') is-invalid @enderror" id="exampleInputEmail" placeholder="Phone Number">
                      @error('phone')
                          <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input name="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-sm-6">
                        <input name="password_confirmation" type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" id="exampleRepeatPassword" placeholder="Repeat Password">
                        @error('password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <!-- Company Information -->
                    <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('seekerLogin') }}">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('front/Authcssjs/jquery.min.js') }}"></script>
  <script src="{{ asset('front/Authcssjs/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('front/Authcssjs/jquery.easing.min.js') }}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('front/Authcssjs/sb-admin-2.min.js') }}"></script>
</body>
</html>
