@extends('layouts.app')

@section('title')
    Clients
@endsection

@section('clients')

    @if ($errors->any())
        @foreach ($errors->all() as $false)
            {{ $false }}<br>
        @endforeach
    @endif


    @if (session('success'))
        {{ session('success') }}<br>
    @endif


    @isset($editdata)
        <h1>Clients</h1>

        <div class="alert alert-secondary" role="alert">
            <form method="post" enctype="multipart/form-data" action="{{ route('updatecl') }}">
                @csrf
                <h1>Clients</h1>
                <div class="alert alert-secondary" role="alert">
                    <form method="post">
                        Edit name:<br>
                        <input type="text" name="a" class="form-control" autocomplete="off"
                            value="{{ $editdata->name }}"><br>
                        Edit surname:<br>
                        <input type="text" name="b" class="form-control" autocomplete="off"
                            value="{{ $editdata->surname }}"><br>
                        Edit tel:<br>
                        <input type="text" name="c" class="form-control" autocomplete="off"
                            value="{{ $editdata->tel }}"><br>
                        Edit company:<br>
                        <input type="text" name="d" class="form-control" autocomplete="off"
                            value="{{ $editdata->company }}"><br>
                        Photo:<br>
                        <img style="width:100px; height:auto" src="{{ $editdata->photo }}"><br>
                        <input type="file" name="p" value="{{ $editdata->photo }}"><br><br>
                        <input type="hidden" name="id" value="{{ $editdata->id }}">
                        <button type="submit" name="u" class="btn btn-success btn-sm">Update</button>
                        <a href="{{ route('clients') }}"><button type="button">Cancel</button></a><br><br>
                    </form>
                </div>
            @endisset



            @isset($deletedata)
                Are you sure to delete <b>{{ $deletedata->name }} {{ $deletedata->surname }}</b> from the base?<br><br>
                <a href="{{ route('cdeletecl', $deletedata->id) }}"><button type="button">Delete</button></a>
                <a href="{{ route('clients') }}"><button type="button">Cancel</button></a>
            @endisset



            @empty($editdata)
                <h1>
                    <p class="text-center">Clients</p>
                </h1>
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="post" enctype="multipart/form-data" action="{{ route('addcl') }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <p style="color:black">Name</p>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Name" name="a"><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <p style="color:black">Surname</p>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Surname" name="b"><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <p style="color:black">Tel</p>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Tel" name="c"><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <p style="color:black">Company</p>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Company" name="d"><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <p style="color:black">Photo</p>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" placeholder="Photo" name="p"><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endempty

            <h4>
                <p class="text-center">Clients on the base: <b>{{ $data->count() }}</b></p>
            </h4>

            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Surame</th>
                        <th>Tel</th>
                        <th>Company</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $info)
                        <tr>
                            <td>
                                <p style="color:black">#{{ $i += 1 }}</p>
                            </td>
                            <td>
                                <div class="round-img">
                                    <img style="width:100px; height:auto" src="{{ $info->photo }}" alt=""></a>
                                </div>
                            </td>
                            <td>
                                <p style="color:black">{{ $info->name }}</p>
                            </td>
                            <td>
                                <p style="color:black">{{ $info->surname }}</p>
                            </td>
                            <td>
                                <p style="color:black">{{ $info->tel }}</p>
                            </td>
                            <td>
                                <p style="color:black">{{ $info->company }}</p>
                            </td>
                            <td>
                                <a href="{{ route('qdeletecl', $info->id) }}"><button
                                        class="btn btn-danger">Delete</button></a>
                                <a href="{{ route('editcl', $info->id) }}"><button
                                        class="btn btn-warning">Edit</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endsection
