@extends('admin.layout.master')
@section('title')
    <title>Edit Item</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Edit Item
                @can("view item")
                    <a href="{{route('item.index')}}" class="float-end btn btn-sm btn-success">View Item</a>
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
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('item.update',$item->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select category</option>
                                        @foreach($category as $row)
                                            @if( $row->id == $item->category_id)
                                                <option value="{{$row->id}}" selected>{{$row->category_name}}</option>
                                            @else
                                                <option value="{{$row->id}}">{{$row->category_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_category" class="form-label">Sub Category</label>
                                    <select class="form-select" id="sub_category" name="sub_category" required>
                                        <option value="">Select sub-category</option>

                                        @foreach($subcategory as $row)
                                            @if( $row->id == $item->sub_category_id)
                                                <option value="{{$row->id}}" selected>{{$row->sub_category_name}}</option>
                                            @else
                                                <option value="{{$row->id}}">{{$row->sub_category_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{$item->item_name}}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="release_date" class="form-label">Release Date</label>
                                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{$item->release_date}}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <input type="text" class="form-control" id="rating" name="rating" value="{{$item->item_rating}}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" class="form-control" name="description" rows="8">{{$item->item_description}}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label ">Current Image</label><br>
                                    <img src="{{$item->image}}" alt="{{$item->item_name}}" height="250" width="250">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*" >
                                </div>

                                <div class="form-group mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="is_requested" name="is_requested" value="true" @if($item->is_requested){{'checked'}}@endif>
                                    <label class="form-check-label" for="is_requested">Requested</label>
                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" id="is_slider" name="is_slider" value="true" @if($item->is_slider){{'checked'}} @endif>
                                    <label class="form-check-label" for="is_slider">Slider</label>
                                </div>
                               </div>
                                <div class="form-group mb-3">
                                    <label  class="form-label mr-2">Status: </label>
                                    <input class="form-check-input" type="radio" name="status" id="status_active" value="active" @if($item->status == \App\Enums\ItemStatus::ACTIVE()){{'checked'}}@endif>
                                    <label class="form-check-label" for="status_active">
                                        Active
                                    </label>
                                    <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" @if($item->status == \App\Enums\ItemStatus::INACTIVE()){{'checked'}}@endif>
                                    <label class="form-check-label" for="status_inactive">
                                        Inactive
                                    </label>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="item-table">
                                        @for($i=0;$i<count($item->download);$i++)
                                            @if($i == 0)
                                            <tr>
                                                <td>
                                                    <label class="form-label" for="type">Type</label>
                                                    <input type="text" name="type[]" id="type" class="form-control" value="{{$item->download[$i]->type}}">
                                                </td>
                                                <td>
                                                    <label class="form-label" for="link_label">Link Label</label>
                                                    <input type="text" name="link_label[]" id="link_label"  class="form-control"  value="{{$item->download[$i]->label}}">
                                                </td>
                                                <td>
                                                    <label class="form-label" for="link">Link</label>
                                                    <input type="text" name="link[]" required id="link" class="form-control"  value="{{$item->download[$i]->link}}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info font-weight-bold" name="add" id="add" data-toggle="tooltip" data-placement="top" title="Add More">+</button>
                                                </td>
                                            </tr>
                                            @else
                                                <tr id="row{{$i}}">
                                                    <td>
                                                        <label class="form-label" for="type">Type</label>
                                                        <input type="text" name="type[]" id="type" class="form-control" value="{{$item->download[$i]->type}}">
                                                    </td>
                                                    <td>
                                                        <label class="form-label" for="link_label">Link Label</label>
                                                        <input type="text" name="link_label[]" id="link_label"  class="form-control"  value="{{$item->download[$i]->label}}">
                                                    </td>
                                                    <td>
                                                        <label class="form-label" for="link">Link</label>
                                                        <input type="text" name="link[]" required id="link" class="form-control"  value="{{$item->download[$i]->link}}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn_remove" name="remove" data-toggle="tooltip" data-placement="top" title="removed" id="{{$i}}">X</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endfor
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
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

            $('#description').summernote({
                height: 200,
            });

            function ajaxsetup(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

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
        });
    </script>
@endsection
