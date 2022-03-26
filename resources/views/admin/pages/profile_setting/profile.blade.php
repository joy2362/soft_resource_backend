@extends('admin.layout.master')
@section('title')
    <title>Profile</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Profile</h1>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profile Details</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset(Auth::guard('web')->user()->avatar)}}" alt="{{Auth::guard('web')->user()->name}}" class="img-fluid rounded-circle mb-2" style="width:150px; height:150px;" />
                            <h5 class="card-title mb-0">{{Auth::guard('web')->user()->name}}</h5>

                            <div>
                                <button data-bs-toggle="modal" data-bs-target="#changeImage" class="btn btn-primary btn-sm">Change Image</button>
                            </div>
                        </div>
                        <hr class="my-0" />
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="changeImage" tabindex="-1" aria-labelledby="changeImageLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="post" action="{{route('profile-image.update')}}" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeImageLabel">Change Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" id="image" name="image" placeholder="Image" accept="image/*">
                                        <label for="image">Image</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-9">
                    <div class="card">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Update Profile Information</h5>
                        </div>
                        <div class="card-body h-100">

                            <div class="d-flex align-items-start">
                                <form class="flex-grow-1" method="POST" action="{{ route('user-profile-information.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group g-2">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control"  id="name" name="name" required value="{{old('name') ?? auth::guard('web')->user()->name}}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group g-2">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control"  id="email" name="email" required value="{{old('email') ?? auth::guard('web')->user()->email}}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
