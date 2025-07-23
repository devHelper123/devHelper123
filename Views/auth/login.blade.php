<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Laravel Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
        <meta name="title" content="Laravel Project" />
        <meta name="description" content="Laravel Project." />
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </head>
    <body class="login-form-body">
        <form class="log-form-wrp" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="log-form-contents row">
                <div class="col-lg-12 col-md-12 col-sm-12 form-outline mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email"  name="email" class="form-control" />
                    @error('email')
                        <div class="validation-error text-end text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" />
                    @error('password')
                        <div class="validation-error password-validation text-end text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 d-grid gap-2">
                    <button type="submit" class="btn btn-primary" >Login</button>
                </div>
            </div>
        </form>
    </body>
    <style>
        .login-form-body .log-form-wrp {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            min-width: 100vw; 
            background: #e0e4eaff;
        }
        .login-form-body .log-form-wrp .log-form-contents {
            width: 50%;
            padding: 50px;
            border-radius: 15px;
            background: #fff;
        }
        .login-form-body .log-form-wrp .log-form-contents .log-sec img {
            height: 40px;
            width: auto;
        }
        
    </style>
</html>