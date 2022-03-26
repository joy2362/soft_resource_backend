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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <form action="{{route('item.multi-delete')}}" method="post" id="checkout">
                                @csrf
                                <div class="col-md-12 pt-4 pb-4">
                                    <button type="submit"  form="checkout" class="btn btn-danger check-out invisible" id="checkoutbtn">Delete Selected</button>
                                </div>
                            </form>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-border" id="datatable1">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"  id="checkedAll">
                                            </div>
                                        </th>
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
                                                <td>
                                                    <input class="form-check-input checkSingle" type="checkbox" form="checkout" name="selectedItem[]" value="{{$row->id}}">
                                                </td>
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

            $('#datatable1').DataTable(
                {
                    "order":false
                }
            );

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

        $("#checkedAll").change(function() {
            if (this.checked) {
                $(".checkSingle").each(function() {
                    this.checked=true;
                    $("#checkoutbtn").removeClass("invisible");

                });
            } else {
                $(".checkSingle").each(function() {
                    this.checked=false;
                    $("#checkoutbtn").addClass("invisible");
                });
            }
        });

        $(".checkSingle").change(function() {
            if (this.checked) {
                $("#checkoutbtn").removeClass("invisible");
            }else{
                $("#checkoutbtn").addClass("invisible");
            }
        });
    </script>
@endsection
