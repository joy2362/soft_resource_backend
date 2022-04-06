@extends('admin.layout.master')
@section('title')
    <title>Setting</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Setting</h1>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">App Logo</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $App_logo }}" alt="{{$App_Name}}" class="img-fluid rounded-circle mb-2" style="width:150px; height:150px;" />
                            <div>
                                @can('edit setting')
                                    <button data-bs-toggle="modal" data-bs-target="#changeImage" class="btn btn-primary btn-sm">Change Image</button>
                                @endcan
                            </div>
                        </div>
                        <hr class="my-0" />
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="changeImage" tabindex="-1" aria-labelledby="changeImageLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="post" action="{{route('setting.logo.change')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeImageLabel">Change Logo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" id="image" name="image" placeholder="Image" accept="image/*">
                                        <label for="image">Logo</label>
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

                            <h5 class="card-title mb-0">Update Application Setting</h5>
                        </div>
                        <div class="card-body h-100">

                            <div class="d-flex align-items-start">
                                <form class="flex-grow-1" method="POST" action="{{ route('setting.update',1) }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group g-2 mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control"  id="name" name="name" required value="{{$App_Name}}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group g-2 mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control"  id="email" name="email" required value="{{$App_Email}}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group g-2 mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control"  id="phone" name="phone" required value="{{$App_Mobile}}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group g-2 mb-3">
                                        <label for="about_us" class="form-label">About Us</label>
                                        <textarea class="form-control" id="about_us" name="about_us" rows="6">{{ $About_Us }}}</textarea>
                                        @error('about_us')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group g-2 mb-3">
                                        <label for="declaimer" class="form-label">Declaimer</label>
                                        <textarea class="form-control" id="declaimer"  name="declaimer" rows="6">{{ $App_Declaimer }}}</textarea>
                                        @error('declaimer')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group g-2 mb-3">
                                        <label for="acknowledge" class="form-label">Acknowledge</label>
                                        <textarea class="form-control" id="acknowledge"  name="acknowledge" rows="6">{!! $Acknowledge !!} </textarea>
                                        @error('acknowledge')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group g-2 mb-3">
                                        <label for="quote">Quote</label>
                                        <input type="text" class="form-control"  id="quote" name="quote" required value="{{$quote}}">
                                        @error('quote')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @can('edit setting')
                                        <button type="submit" class="btn btn-sm btn-success mt-1"> Update</button>
                                    @endcan
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#acknowledge').summernote({
            height: 200,
        });
    });
</script>
@endsection