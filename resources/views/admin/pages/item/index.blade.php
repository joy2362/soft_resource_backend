@extends('admin.layout.master')
@section('title')
    <title>Item</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Item
                @can('create item')
                <a href="{{route('item.create')}}" class="float-end btn btn-sm btn-success">Add new</a>
                @endcan
            </h1>


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
                                        @foreach($items as $row)
                                            <tr>
                                                <td>{{$row->id}}</td>
                                                <td>{{$row->item_name}}</td>
                                                <td>{{$row->category->category_name}}</td>
                                                <td>{{$row->createdBy->name}}</td>
                                                <td>
                                                    @if($row->status == \App\Enums\ItemStatus::ACTIVE())
                                                        <span class="badge bg-success">{{$row->status}}</span>
                                                    @else
                                                        <span class="badge bg-warning">{{$row->status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{route('item.destroy',$row->id)}}" method="post">

                                                        @if(auth()->user()->hasPermissionTo('edit item') || auth()->user()->hasRole('Super Admin'))
                                                        <a class="m-2 btn btn-sm btn-success" href="{{route('item.edit',$row->id)}}">Edit</a>
                                                        @endif

                                                        @if(auth()->user()->hasPermissionTo('delete item') || auth()->user()->hasRole('Super Admin'))
                                                        <button class="m-2 btn btn-sm btn-danger delete_button" type="submit" value="{{$row->id}}" >Delete</button>
                                                        @endif

                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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

            $('#datatable1').DataTable({"order": [[ 0, "desc" ]]});

            $(document).on('click','.delete_button',function(e){
                e.preventDefault();
                var form =  $(this).closest("form");
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
                        form.submit();
                    }
                })
            });

        });
    </script>
@endsection
