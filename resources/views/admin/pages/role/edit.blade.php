@extends('admin.layout.master')
@section('title')
    <title>Edit Role</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Edit Role
                @if(auth()->user()->hasRole('Super Admin'))
                    <a href="{{route('role.index')}}" class="float-end btn btn-sm btn-success">View Role</a>
                @endif
            </h1>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{route('role.update',$role->id)}}">
                                @csrf
                                @method('put')
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{$role->name}}">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    @foreach($permissions as $row)
                                        <div class="col-md-6 col-lg-4 g-2">
                                            <div class="form-check form-check-inline form-switch">
                                                <input class="form-control form-control-lg form-check-input" type="checkbox" role="switch" @if( $role->permissions->contains($row) ) {{'checked'}}  @endif  id="permissions_{{$row->id}}" name="permissions[]" value="{{$row->id}}">
                                                <label class="fs-4 form-control-lg form-check-label" for="permissions_{{$row->id}}">{{$row->name}}</label>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
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
            $('#datatable1').DataTable({});

            function ajaxsetup(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }


            $(document).on('click','.edit_button',function(e){
                e.preventDefault();
                let id = $(this).val();

                $('#edit_role').modal('show');
                ajaxsetup();
                $.ajax({
                    type:'get',
                    url:"/role/"+id+"/edit",
                    dataType:'json',
                    success: function(response){
                        if(response.status === 200){
                            $('#edit_id').val(response.role.id);
                            $('#edit_name').val(response.role.name);

                            response.permissions.forEach(element =>{
                                $("#edit_permissions_"+element.id).prop("checked", true);
                            });
                        }
                    }
                })



            });

            $(document).on('submit','#addRoleForm',function(e){
                e.preventDefault();

                let formData = new FormData($('#addRoleForm')[0]);

                ajaxsetup();
                $.ajax({
                    type:'POST',
                    enctype: 'multipart/form-data',
                    url:"{{route('role.store')}}",
                    data:formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response.status === 400){
                            $('#save_errorList').html("");
                            $('#save_errorList').removeClass("d-none");
                            $.each(response.errors,function(key,err_value){
                                $('#save_errorList').append('<li>'+ err_value+'</li>');
                            });
                        }
                        else if(response.status === 200){
                            $('#save_errorList').html("");
                            $('#save_errorList').addClass("d-none");
                            location.reload();
                            $('#add_Role').modal('hide');

                            $('#datatable1').DataTable().draw();
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            )

                        }
                    }

                })
            });

            $(document).on('submit','#editRoleForm',function(e){
                e.preventDefault();
                let  id = $('#edit_id').val();

                let editFormData = new FormData($('#editRoleForm')[0]);
                editFormData.append('_method', 'PUT');
                ajaxsetup();

                $.ajax({
                    type:'post',
                    enctype: 'multipart/form-data',
                    url:"/role/"+id,
                    data: editFormData,
                    contentType:false,
                    processData:false,
                    success: function(response){
                        if(response.status === 400){
                            $('#edit_errorList').html("");
                            $('#edit_errorList').removeClass("d-none");
                            $.each(response.errors,function(key,err_value){
                                $('#edit_errorList').append('<li>'+ err_value+'</li>');
                            });
                        }
                        else if(response.status === 200){
                            $('#edit_errorList').html("");
                            $('#edit_errorList').addClass("d-none");

                            location.reload();
                            $('#edit_role').modal('hide');

                            $('#datatable1').DataTable().draw();
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            )

                        }
                    }

                })

            });

        })

    </script>
@endsection
