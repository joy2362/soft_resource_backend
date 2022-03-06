@extends('admin.layout.master')
@section('title')
    <title>Recycle Bin</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Recycle Bin</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Item</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-border" id="item">
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
                                    @foreach($item as $row)
                                        <tr>
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
            $('#item').DataTable({});

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


    </script>
@endsection
