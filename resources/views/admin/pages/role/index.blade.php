@extends('admin.layout.master')
@section('title')
    <title>Role</title>
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Role
                @if(auth()->user()->hasRole('Super Admin'))
                <a href="{{route('role.create')}}" class="float-end btn btn-sm btn-success" >Add Role</a>
                @endif
            </h1>

            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                    @foreach($roles as $row)
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->guard_name}}</td>

                                            <td>
                                                @if($row->name != 'Super Admin')
                                                <form action="{{route('role.destroy',$row->id)}}" method="post">

                                                    @if(auth()->user()->hasRole('Super Admin'))
                                                        <a class="m-2 btn btn-sm btn-success" href="{{route('role.edit',$row->id)}}">Edit</a>
                                                    @endif

                                                    @if(auth()->user()->hasRole('Super Admin'))
                                                        <button class="m-2 btn btn-sm btn-danger delete_button" type="submit" value="{{$row->id}}" >Delete</button>
                                                    @endif

                                                    @method('delete')
                                                    @csrf
                                                </form>
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
            $('#datatable1').DataTable({});
        });
    </script>
@endsection
