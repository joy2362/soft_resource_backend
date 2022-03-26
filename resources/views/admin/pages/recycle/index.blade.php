@extends('admin.layout.master')
@section('title')
    <title>Recycle Bin</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="h3 mb-3">Recycle Bin
                <div class="float-end">
                    <a href="{{route('recycle-bin.recover.all')}}" class=" btn btn-sm btn-success g-4" >Recover All</a>
                    <a href="{{route('recycle-bin.delete.all')}}" class=" btn btn-sm btn-danger" >Delete All</a>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Item</h4>
                        </div>
                        <div class="card-body">
                                <form action="{{route('item.multi-recover')}}" method="post" id="recover">
                                    @csrf
                                    <div class="check-out invisible">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="itemAction" id="restoreItem" value="restore" checked required>
                                            <label class="form-check-label" for="restoreItem">
                                                Restore
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="itemAction" id="deleteItem" value="delete"  required>
                                            <label class="form-check-label" for="deleteItem">
                                                Delete
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pt-4 pb-4">
                                        <button type="submit"  form="recover"  class="btn btn-danger check-out invisible" id="checkoutbtn">Save</button>
                                    </div>
                                </form>

                            <div class="table-responsive">
                                <table class="table table-border" id="item">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input " type="checkbox"  id="checkedAll" >
                                            </div>
                                        </th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Delete By</th>
                                        <th>Delete At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item as $row)
                                        <tr>
                                            <td>
                                                <input class="form-check-input checkSingle" type="checkbox" form="recover" name="selectedItem[]" value="{{$row->id}}"></td>
                                            <td> {{$row->id}}</td>
                                            <td> {{$row->item_name}}</td>
                                            <td> {{$row->deletedBy->name}}</td>
                                            <td> {{$row->deleted_at}}</td>
                                            <td>
                                                @if(auth()->user()->hasRole('Super Admin'))
                                                    <a class="m-2 btn btn-sm btn-success" href="{{route('item.recover',$row->id)}}">Restore</a>
                                                @endif

                                                @if(auth()->user()->hasRole('Super Admin'))
                                                    <a class="m-2 btn btn-sm btn-danger " id="delete_button" href="{{route('item.delete.completely',$row->id)}}">Confirm Delete</a>
                                                @endif
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-border" id="subCategory">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Delete By</th>
                                        <th>Delete At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subCategory as $row)
                                        <tr>
                                            <td> {{$row->id}}</td>
                                            <td> {{$row->sub_category_name}}</td>
                                            <td> {{$row->deletedBy->name}}</td>
                                            <td> {{$row->deleted_at}}</td>
                                            <td>
                                                @if(auth()->user()->hasRole('Super Admin'))
                                                    <a class="m-2 btn btn-sm btn-success" href="{{route('subCategory.recover',$row->id)}}">Restore</a>
                                                @endif

                                                @if(auth()->user()->hasRole('Super Admin'))
                                                        <a class="m-2 btn btn-sm btn-danger" id="delete_button" href="{{route('subCategory.delete.completely',$row->id)}}">Confirm Delete</a>
                                                @endif
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Category</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-border" id="category">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Delete By</th>
                                        <th>Delete At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($category as $row)
                                        <tr>
                                            <td> {{$row->id}}</td>
                                            <td> {{$row->category_name}}</td>
                                            <td> {{$row->deletedBy->name}}</td>
                                            <td> {{$row->deleted_at}}</td>
                                            <td>
                                                @if(auth()->user()->hasRole('Super Admin'))
                                                    <a class="m-2 btn btn-sm btn-success" href="{{route('category.recover',$row->id)}}">Restore</a>
                                                @endif

                                                @if(auth()->user()->hasRole('Super Admin'))
                                                        <a class="m-2 btn btn-sm btn-danger " id="delete_button" href="{{route('category.delete.completely',$row->id)}}">Confirm Delete</a>
                                                @endif
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
            $('#category').DataTable({});
            $('#subCategory').DataTable({});
            $('#item').DataTable({
                "order":false
            });

            $(document).on('click','#delete_button',function(e){
                e.preventDefault();
                var link = $(this).attr("href");

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
                        window.location.href = link;
                    }
                })
            });
        });

        $("#checkedAll").change(function() {
            if (this.checked) {
                $(".checkSingle").each(function() {
                    this.checked=true;
                    $(".check-out").removeClass("invisible");
                    $(".check-out").removeClass("invisible");

                });
            } else {
                $(".checkSingle").each(function() {
                    this.checked=false;
                    $(".check-out").addClass("invisible");
                    $(".check-out").addClass("invisible");
                });
            }
        });

        $(".checkSingle").change(function() {
            if (this.checked) {
                $(".check-out").removeClass("invisible");

            }else{
                $(".check-out").addClass("invisible");
            }
        });


    </script>
@endsection
