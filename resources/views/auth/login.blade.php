<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('admin/img/icons/icon-48x48.png')}}" />

    <title>Sign In</title>

    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-6 col-lg-4 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                        <h1 class="h2">Welcome back</h1>
                        <p class="lead">
                            Sign in to your account to continue
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email"  class="form-label">Email</label>
                                        <input class="form-control form-control-lg @error('email') is-invalid @enderror " id="email" type="text" name="email" placeholder="Enter your Email"  value="{{ old('email') }}"  autofocus />

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password"  type="password" name="password" placeholder="Enter your password" />
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small>
                                            <a href="{{ route('password.request') }}">Forgot password?</a>
                                        </small>
                                    </div>
                                    <div>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me">
                                            <span class="form-check-label">
                                                    Remember me
                                                </span>
                                        </label>
                                    </div>
                                    <div class="text-center mt-3">
                                         <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{asset('js/app.js')}}"></script>

</body>

</html>