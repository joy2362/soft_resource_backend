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
                            <h5 class="card-title mb-0">Two Step Verification Recovery Codes</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Please do not Share Those Recovery code with anyone</h5>

                    @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                        <li class="mb-3">{{$code}}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
