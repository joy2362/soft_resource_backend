@extends('admin.layout.master')
@section('title')
    <title>Role</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Role
                @can('create role')
                <a href="#" class="float-end btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#add_Role">Add Role</a>
                @endcan
            </h1>
            <!-- Modal for add  -->
            <div class="modal fade" id="add_Role" tabindex="-1" aria-labelledby="add_role_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_role_Label">Add Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" id="addRoleForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="save_errorList"></ul>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="row">
                                    @foreach($permissions as $row)
                                    <div class="col-md-6 col-lg-4  g-2">
                                        <div class="form-check form-check-inline form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"  id="permissions_{{$row->id}}" name="permissions[]" value="{{$row->id}}">
                                            <label class="form-check-label" for="permissions_{{$row->id}}">{{$row->name}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Modal for add-->

            <!-- Modal for update  -->
            <div class="modal fade" id="edit_role" tabindex="-1" aria-labelledby="edit_role_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_role_Label">Edit Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" id="editRoleForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="edit_errorList"></ul>
                                <div class="form-group mb-3">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                    <input type="hidden" id="edit_id" name="id" >
                                </div>

                                <div class="row">
                                    @foreach($permissions as $row)
                                        <div class="col-md-6 col-lg-4  g-2">
                                            <div class="form-check form-check-inline form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"  id="edit_permissions_{{$row->id}}" name="permissions[]" value="{{$row->id}}">
                                                <label class="form-check-label" for="edit_permissions_{{$row->id}}">{{$row->name}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end Modal for update  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-border" id="datatable1">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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
            function ajaxsetup(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

            fetchBrand();
            function fetchBrand(){
                ajaxsetup();
                $('#datatable1').DataTable({
                    responsive: true,
                    language: {
                        searchPlaceholder: 'Search...',
                        sSearch: '',
                        lengthMenu: '_MENU_ items/page',
                    },

                    processing: true,
                    serverSide:true,
                    ajax:"{{route('role.index')}}",
                    columns:[
                        {data:"id",name:'ID'},
                        {data:"name",name:'Name'},
                        {data:"guard_name",name:'Guard'},
                        {data:"actions",name:'Actions'},
                    ]
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

            $(document).on('click','.delete_button',function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $(this).val();
                        ajaxsetup();
                        $.ajax({
                            type:'DELETE',
                            url:"/role/"+id,
                            dataType:'json',
                            success: function(response){
                                if(response.status == 404){
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    )
                                }
                                else{
                                    $('#datatable1').DataTable().draw();
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    )
                                }
                            }
                        })
                    }
                })
            });
        })

    </script>
@endsection
