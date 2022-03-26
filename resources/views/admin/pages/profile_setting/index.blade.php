@extends('admin.layout.master')
@section('title')
    <title>Profile Setting</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Profile</h1>
            </div>
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Two Step Verification</h5>
                        </div>

                        <div class="card-body text-center">
                            @if(!Auth::guard('web')->user()->two_factor_secret)
                                <h5 class="card-title mb-0">Currently Turn Off</h5>
                                <form action="{{route('two-factor.enable')}}" method="post">
                                    @csrf
                                    <button class="btn btn-primary btn-sm">Turn on</button>
                                </form>
                            @else
                                <h5 class="card-title mb-3 ">Use Any TOTP compatible mobile authentication application such as<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&gl=US" target="_blank"> Google Authenticator</a></h5>
                                {!! Auth::user()->twoFactorQrCodeSvg()  !!}
                                <div class="mt-3">

                                    <form action="{{route('two-factor.disable')}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-primary btn-sm " href="{{url('profile/setting/recovery-codes')}}">View Recovery Code</a>
                                        <button class="btn btn-danger btn-sm" type="submit">Turn Off</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <hr class="my-0" />
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Password</h5>
                        </div>
                        <div class="card-body h-100">

                            <div class="d-flex align-items-start">
                                <form class="flex-grow-1" method="POST" action="{{ route('user-password.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group g-2">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control"  id="current_password" name="current_password" required>
                                        @error('current_password','updatePassword')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group g-2">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control"  id="password" name="password" required >
                                        @error('password','updatePassword')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group g-2">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" required >
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-danger mt-1"> Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
