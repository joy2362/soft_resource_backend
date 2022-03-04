@extends('admin.layout.master')
@section('title')
    <title>New Item</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Add new item
                @can("view item")
                    <a href="{{route('item.index')}}" class="float-end btn btn-sm btn-success">View Item</a>
                @endcan
            </h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('item.store')}}">
                               @csrf
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select category</option>
                                        @foreach($category as $row)
                                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_category" class="form-label">Sub Category</label>
                                    <select class="form-select" id="sub_category" name="sub_category" required>
                                        <option value="">Select sub-category</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="release_date" class="form-label">Release Date</label>
                                    <input type="date" class="form-control" id="release_date" name="release_date" >
                                </div>

                                <div class="form-group mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <input type="text" class="form-control" id="rating" name="rating">
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

                                <button type="submit" class="btn btn-success">Save</button>

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
