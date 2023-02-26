@extends('layouts.app')

@section('title')
    Products
@endsection

@section('products')

    @if ($errors->any())
        @foreach ($errors->all() as $false)
            {{ $false }}<br>
        @endforeach
    @endif


    @if (session('success'))
        {{ session('success') }}<br>
    @endif


    @isset($editdata)
        <h1>Products</h1>

        <div class="alert alert-secondary" role="alert">
            <form method="post" enctype="multipart/form-data" action="{{ route('updatepr') }}">
                @csrf
                Edit brand:<br>
                <select name="brand_id">
                    <option value="">Choose the brand</option>
                    @foreach ($brdata as $info)
                        @if ($editdata->brand_id == $info->id)
                            <option selected value="{{ $info->id }}">{{ $info->name }}</option>
                        @else
                            <option value="{{ $info->id }}">{{ $info->name }}</option>
                        @endif
                    @endforeach
                </select><br>
                Edit name:<br>
                <input type="text" name="a" class="form-control" autocomplete="off" value="{{ $editdata->name }}"><br>
                Edit buy:<br>
                <input type="text" name="b" class="form-control" autocomplete="off" value="{{ $editdata->buy }}"><br>
                Edit sale:<br>
                <input type="text" name="c" class="form-control" autocomplete="off" value="{{ $editdata->sale }}"><br>
                Edit quantity:<br>
                <input type="text" name="d" class="form-control" autocomplete="off"
                    value="{{ $editdata->quantity }}"><br>
                Photo:<br>
                <img style="width:100px; height:auto" src="{{ $editdata->photo }}"><br>
                <input type="file" name="p" value="{{ $editdata->photo }}"><br><br>
                <input type="hidden" name="id" value="{{ $editdata->id }}">
                <button type="submit" name="u" class="btn btn-success btn-sm">Update</button>
                <a href="{{ route('products') }}"><button type="button">Cancel</button></a><br><br>
            </form>
        </div>
    @endisset



    @isset($deletedata)
        Are you sure to delete <b>{{ $deletedata->name }}</b> from the base?<br><br>
        <a href="{{ route('cdeletepr', $deletedata->id) }}"><button type="button">Delete</button></a>
        <a href="{{ route('products') }}"><button type="button">Cancel</button></a>
    @endisset



    @empty($editdata)
        <h1>
            <p class="text-center">Products</p>
        </h1>
        <div class="card">
            <div class="card-body">
                <div class="basic-form">
                    <form method="post" enctype="multipart/form-data" action="{{ route('addpr') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <p style="color:black">Brand</p>
                            </label><br>
                            <div class="col-sm-10">
                                <select name="brand_id">
                                    <option value="">Choose the brand</option>
                                    @foreach ($brdata as $info)
                                        <option value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                                <p style="color:black">Buy</p>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Buy" name="b"><br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <p style="color:black">Sale</p>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Sale" name="c"><br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <p style="color:black">Quantity</p>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Quantity" name="d"><br>
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
        <p class="text-center">Products on the base: <b>{{ $data->count() }}</b></p>
    </h4>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Brand</th>
                <th>Name</th>
                <th>Buy</th>
                <th>Sale</th>
                <th>Quantity</th>
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
                        <p style="color:black">{{ $info->brand }}</p>
                    </td>
                    <td>
                        <p style="color:black">{{ $info->product }}</p>
                    </td>
                    <td>
                        <p style="color:black">{{ $info->buy }}</p>
                    </td>
                    <td>
                        <p style="color:black">{{ $info->sale }}</p>
                    </td>
                    <td>
                        <p style="color:black">{{ $info->quantity }}</p>
                    </td>
                    <td>
                        <a href="{{ route('qdeletepr', $info->id) }}"><button class="btn btn-danger">Delete</button></a>
                        <a href="{{ route('editpr', $info->id) }}"><button class="btn btn-warning">Edit</button></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



@endsection
