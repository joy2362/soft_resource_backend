@extends('admin.layout.master')
@section('title')
    <title>Items</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Item
                @can('create item')
                <a href="#" class="float-end btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#add_Item">Add Item</a>
                @endcan
            </h1>
            <!-- Modal for add  -->
            <div class="modal fade" id="add_Item" tabindex="-1" aria-labelledby="add_Item_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_Item_Label">Add Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" id="addItemForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="save_errorList"></ul>

                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        @foreach($category as $row)
                                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_category" class="form-label">Sub Category</label>
                                    <select class="form-select" id="sub_category" name="sub_category" required>

                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="release_date" class="form-label">Release Date</label>
                                    <input type="date" class="form-control" id="release_date" name="release_date" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <input type="text" class="form-control" id="rating" name="rating" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" class="form-control" name="description" rows="8"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="is_requested" name="is_requested" value="true">
                                    <label class="form-check-label" for="is_requested">Requested</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="is_slider" name="is_slider" value="true">
                                    <label class="form-check-label" for="is_slider">Slider</label>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="item-table">
                                        <tr>
                                            <td>
                                                <label class="form-label" for="type">Type</label>
                                                <input type="text" name="type[]" id="type" class="form-control">
                                            </td>

                                            <td>
                                                <label class="form-label" for="link_label">Link Label</label>
                                                <input type="text" name="link_label[]" id="link_label"  class="form-control">
                                            </td>
                                            <td>
                                                <label class="form-label" for="link">Link</label>
                                                <input type="text" name="link[]" required id="link" class="form-control"></td>
                                            <td><button type="button" class="btn btn-info font-weight-bold" name="add" id="add" data-toggle="tooltip" data-placement="top" title="Add More">+</button></td>
                                        </tr>
                                    </table>
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
            <div class="modal fade" id="edit_item" tabindex="-1" aria-labelledby="edit_item_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_item_Label">Edit Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" id="editItemForm">
                            <div class="modal-body">
                                <ul class="alert alert-danger d-none" id="edit_errorList"></ul>

                                <div class="form-group mb-3">
                                    <label for="edit_category" class="form-label">Category</label>
                                    <select class="form-select" id="edit_category" name="category" required>
                                        @foreach($category as $row)
                                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="edit_sub_category" class="form-label">Sub Category</label>
                                    <select class="form-select" id="edit_sub_category" name="sub_category" required>

                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                    <input type="hidden" id="edit_id" name="id" >
                                    <input type="hidden" id="edit_count" name="count" >
                                </div>

                                <div class="form-group mb-3">
                                    <label for="edit_release_date" class="form-label">Release Date</label>
                                    <input type="date" class="form-control" id="edit_release_date" name="release_date" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="edit_rating" class="form-label">Rating</label>
                                    <input type="text" class="form-control" id="edit_rating" name="rating" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="edit_description" class="form-label">Description</label>
                                    <textarea id="edit_description" class="form-control" name="description"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <img class="img-thumbnail" src="" width="100px" height="100px" alt="image" id="current_logo">
                                    <input class="form-control" type="file" id="edit_image" name="image" accept="image/*" >
                                </div>


                                <div class="form-check form-check-inline mb-3">
                                    <input class="form-check-input" type="checkbox" id="edit_is_requested" name="is_requested"  value="true">
                                    <label class="form-check-label" for="edit_is_requested">Requested</label>
                                </div>

                                <div class="form-check form-check-inline mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_slider" name="edit_is_slider" value="true">
                                    <label class="form-check-label" for="edit_is_slider">Slider</label>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="edit_item-table">
                                        <tr>
                                            <td>
                                                <label class="form-label" for="edit_type">Type</label>
                                                <input type="text" name="type[]" id="edit_type" class="form-control">
                                            </td>

                                            <td>
                                                <label class="form-label" for="edit_link_label">Link Label</label>
                                                <input type="text" name="link_label[]" id="edit_link_label"  class="form-control">
                                            </td>
                                            <td>
                                                <label class="form-label" for="edit_link">Link</label>
                                                <input type="text" name="link[]" required id="edit_link" class="form-control"></td>
                                            <td><button type="button" class="btn btn-info font-weight-bold" name="edit_add" id="edit_add" data-toggle="tooltip" data-placement="top" title="Add More">+</button></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group mb-3">
                                    <label  class="form-label mr-2">Status: </label>
                                    <input class="form-check-input" type="radio" name="status" id="edit_status_active" value="active" >
                                    <label class="form-check-label" for="edit_status_active">
                                        Active
                                    </label>
                                    <input class="form-check-input" type="radio" name="status" id="edit_status_inactive" value="inactive">
                                    <label class="form-check-label" for="edit_status_inactive">
                                        Inactive
                                    </label>
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
                                        <th>Category Name</th>
                                        <th>Added By</th>
                                        <th>Status</th>
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
            let i = 1;
            $('#add').click(function(){
                i++;
                $('#item-table').append('<tr id="row'+i+'"> <td>  <label class="form-label" for="type">Type</label>' +
                    '<input type="text" name="type[]" id="type" class="form-control"></td>' +
                    '<td><label class="form-label" for="link_label">Link Label</label> <input type="text" name="link_label[]" id="link_label"  class="form-control"></td>' +
                    '<td>  <label class="form-label" for="link">Link</label> <input type="text" name="link[]" id="link" required class="form-control"></td></td><td><button type="button" class="btn btn-danger btn_remove" name="remove" data-toggle="tooltip" data-placement="top" title="removed" id="'+i+'">X</button></td></tr>');
            });
            $(document).on('click','.btn_remove',function(){
                var btn=$(this).attr("id");
                $('#row'+btn+'').remove();
            });

        })

        $(document).ready(function(){
            let i = $('#edit_count').val();
            $('#edit_add').click(function(){
                i++;
                $('#edit_item-table').append('<tr id="row'+i+'"> <td>  <label class="form-label" for="type">Type</label>' +
                    '<input type="text" name="type[]" id="type" class="form-control"></td>' +
                    '<td><label class="form-label" for="link_label">Link Label</label> <input type="text" name="link_label[]" id="link_label"  class="form-control"></td>' +
                    '<td>  <label class="form-label" for="link">Link</label> <input type="text" name="link[]" id="link" required class="form-control"></td></td><td><button type="button" class="btn btn-danger btn_remove" name="remove" data-toggle="tooltip" data-placement="top" title="removed" id="'+i+'">X</button></td></tr>');
            });
            $(document).on('click','.edit_btn_remove',function(){
                const btn = $(this).attr("id");
                $('#row'+btn+'').remove();
            });

        })

        $(document).ready(function(){

            $(document).ready(function() {
                $('#description').summernote({
                    height: 200,
                });

            });
            function ajaxsetup(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

            fetchItems();
            function fetchItems(){
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
                    ajax:"{{route('item.index')}}",
                    columns:[
                        {data:"id",name:'ID'},
                        {data:"item_name",name:'Name'},
                        {data:"category.category_name",name:'Category Name'},
                        {data:"created_by.name",name:'Added By'},
                        {data:"status",name:'status'},
                        {data:"actions",name:'Actions'},
                    ]
                });
            }

            $(document).on('click','.edit_button',function(e){
                e.preventDefault();
                let id = $(this).val();

                ajaxsetup();
                $.ajax({
                    type:'get',
                    url:"/item/"+id+"/edit",
                    dataType:'json',
                    success: function(response){
                        if(response.status === 200){

                            $('#edit_id').val(response.item.id);
                            $('#edit_count').val(response.item.download.length);
                            $('#edit_category').val(response.item.category_id);
                            $('#edit_name').val(response.item.item_name);

                            let sub_category =  $('#edit_sub_category').empty();
                            $.each(response.subcategory,function(key,val){
                                sub_category.append('<option value ="'+val.id+'">'+val.sub_category_name +'</option>');
                            });

                            $('#edit_sub_category').val(response.item.sub_category_id);
                            $('#edit_release_date').val(response.item.release_date);
                            $('#edit_rating').val(response.item.item_rating);
                            $('#edit_description').summernote("code", response.item.item_description);

                            if(response.item.is_requested){
                                $("#edit_is_requested").prop("checked", true);
                            }
                            if(response.item.is_slider){
                                $("#edit_is_slider").prop("checked", true);
                            }

                            if(response.item.status === 'active'){
                                $("#edit_status_active").prop("checked", true);
                            }else{
                                $("#edit_status_inactive").prop("checked", true);
                            }
                            $('#current_logo').attr("src", response.item.image);

                            $('#edit_link').val(response.item.download[0].link);
                            $('#edit_type').val(response.item.download[0].type);
                            $('#edit_link_label').val(response.item.download[0].label);

                            let i = 1;
                            for(let j =1;j<response.item.download.length;j++){

                                i++;

                                $('#edit_item-table').append('<tr id="row'+i+'"> ' +
                                    '<td> ' +
                                    ' <label class="form-label" for="type">Type</label>' +
                                    '<input type="text" name="type[]" id="edit_type" class="form-control" value="'+response.item.download[j].type+'"></td>' +
                                    '<td> <label class="form-label" for="link_label">Link Label</label> ' +
                                    '<input type="text" name="link_label[]" id="edit_link_label"  class="form-control" value="'+response.item.download[j].label+'"></td>' +
                                    '<td>  <label class="form-label" for="link">Link</label> ' +
                                    '<input type="text" name="link[]" id="edit_link" required class="form-control" value='+response.item.download[j].link+'>' +
                                    '</td></td>' +
                                    '<td>' +
                                    '<button type="button" class="btn btn-danger edit_btn_remove" name="remove" data-toggle="tooltip" data-placement="top" title="removed" id="'+i+'">X</button>' +
                                    '</td></tr>');
                            }
                            $('#edit_item').modal('show');
                        }
                    }
                })
            });

            $(document).on('submit','#addItemForm',function(e){
                e.preventDefault();

                let formData = new FormData($('#addItemForm')[0]);

                ajaxsetup();
                $.ajax({
                    type:'post',
                    enctype: 'multipart/form-data',
                    url:"{{route('item.store')}}",
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

                            $('#addItemForm').trigger('reset');

                            $('#add_Item').modal('hide');

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

            $(document).on('submit','#editItemForm',function(e){
                e.preventDefault();
                let  id = $('#edit_id').val();

                let editFormData = new FormData($('#editItemForm')[0]);
                editFormData.append('_method', 'PUT');
                ajaxsetup();

                $.ajax({
                    type:'post',
                    enctype: 'multipart/form-data',
                    url:"/item/"+id,
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

                            $('#editItemForm').trigger('reset');
                            $('#edit_item').modal('hide');

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
                            url:"/item/"+id,
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

            $(document).on('change','#category',function(e){
                let id = e.target.value;
                ajaxsetup();
                $.ajax({
                    type:'get',
                    url:"/sub-category/fetch/"+id,
                    dataType:'json',
                    success: function(response){
                        let sub_category =  $('#sub_category').empty();
                        $.each(response.sub_category,function(key,val){
                            sub_category.append('<option value ="'+val.id+'">'+val.sub_category_name +'</option>');
                        });
                    }
                })
            })

            $(document).on('change','#edit_category',function(e){
                let id = e.target.value;
                ajaxsetup();
                $.ajax({
                    type:'get',
                    url:"/sub-category/fetch/"+id,
                    dataType:'json',
                    success: function(response){
                        let sub_category =  $('#edit_sub_category').empty();
                        $.each(response.sub_category,function(key,val){
                            sub_category.append('<option value ="'+val.id+'">'+val.sub_category_name +'</option>');
                        });
                    }
                })
            })
        });
    </script>
@endsection
