@extends('layouts.app')

@section('title')
    Orders
@endsection

@section('orders')

    @if ($errors->any())
        @foreach ($errors->all() as $false)
            {{ $false }}<br>
        @endforeach
    @endif


    @if (session('success'))
        {{ session('success') }}<br>
    @endif


    <body>

        <h4>
            <p class="text-center">Orders on the base: <b>{{ $data->count() }}</b></p>
        </h4>
        <div class="container mt-4">

            <div class="col-md-12 mt-12 mb-2">
                <p class="text-center"><button type="button" id="addNewBook" class="btn btn-success">Add</button></p>
            </div>

            <div class="card">

                <div class="card-header text-center font-weight-bold">
                    <p class="text-center">
                    <h2>Orders</h2>
                    </p>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" width="100%"
                        id="datatable-ajax-crud">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Brand</th>
                                <th>Product</th>
                                <th>Buy</th>
                                <th>Sale</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Profit</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot class="thead-dark" cellspacing="0" width="100%" id="datatable-ajax-crud">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Brand</th>
                                <th>Product</th>
                                <th>Buy</th>
                                <th>Sale</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Profit</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>

            @php($i = 0)

            <!-- boostrap add and edit book model -->
            <div class="modal fade" id="ajax-book-model" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="ajaxBookModel"></h4>
                        </div>
                        <div class="modal-body">
                            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm"
                                class="form-horizontal" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="client" class="col-sm-2 control-label">Client</label>
                                    <div class="col-sm-6 pull-left">
                                        <select name="client_id" class="form-control" id="client_id">
                                            <option value="">Choose the client</option>
                                            @foreach ($cldata as $info)
                                                <option value="{{ $info->id }}">{{ $info->name }} {{ $info->surname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="product" class="col-sm-2 control-label">Product</label>
                                    <div class="col-sm-6 pull-left">
                                        <select name="product_id" class="form-control" id="product_id">
                                            <option value="">Choose the product</option>
                                            @foreach ($prdata as $info)
                                                <option value="{{ $info->id }}">{{ $info->brname }} -
                                                    {{ $info->name }} - [{{ $info->quantity }}]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="quantity" name="q"
                                                placeholder="Enter The Quantity" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save
                                        changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- end bootstrap model -->

            <script type="text/javascript">
                $(document).ready(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#photo').change(function() {

                        let reader = new FileReader();

                        reader.onload = (e) => {

                            $('#preview-image').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(this.files[0]);

                    });


                    let table = $('#datatable-ajax-crud').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ url('orders') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'id',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'fullname',
                                name: 'fullname',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'brname',
                                name: 'brname',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'product',
                                name: 'product',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'buy',
                                name: 'buy',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'sale',
                                name: 'sale',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'stock',
                                name: 'stock',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'quantity',
                                name: 'quantity',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'profit',
                                name: 'profit',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false
                            }
                        ],
                        order: [
                            [9, 'asc']
                        ],
                        dom: 'Bfrltip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5',
                            'print'
                        ]
                    });


                    $('#addNewBook').click(function() {
                        $('#addEditBookForm').trigger("reset");
                        $('#ajaxBookModel').html("Add Order");
                        $('#ajax-book-model').modal('show');
                        $('#id').val('');
                        $('#preview-image').attr('src',
                            'https://www.riobeauty.co.uk/images/product_image_not_found.gif');

                    });

                    $('body').on('click', '.edit', function() {

                        let id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('edit-order') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(res) {
                                $('#ajaxBookModel').html("Edit Book");
                                $('#ajax-book-model').modal('show');
                                $('#id').val(res.id);
                                $('#client_id').val(res.client_id);
                                $('#product_id').val(res.product_id);
                                $('#quantity').val(res.quantity);
                            }
                        });

                    });

                    $('body').on('click', '.delete', function() {

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

                                let id = $(this).data('id');

                                // ajax
                                $.ajax({
                                    type: "POST",
                                    url: "{{ url('delete-order') }}",
                                    data: {
                                        id: id
                                    },
                                    dataType: 'json',
                                    success: function(res) {

                                        var oTable = $('#datatable-ajax-crud').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your order has been deleted.',
                                    'success'
                                )

                            }
                        })



                    });

                    $('#addEditBookForm').submit(function(e) {

                        e.preventDefault();

                        var formData = new FormData(this);

                        $.ajax({
                            type: 'POST',
                            url: "{{ url('add-update-order') }}",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                $("#ajax-book-model").modal('hide');
                                var oTable = $('#datatable-ajax-crud').dataTable();
                                oTable.fnDraw(false);
                                $("#btn-save").html('Save changes');
                                $("#btn-save").attr("disabled", false);
                                Swal.fire(
                                    'Good job!',
                                    'New order added successfully!',
                                    'success'
                                )
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    });

                    $('body').on('click', '.confirm', function() {

                        let crow = $(this).closest('tr');
                        let stock = parseInt(crow.find("td:eq(6)").text());
                        let quantity = parseInt(crow.find("td:eq(7)").text());

                        if (stock >= quantity) {
                            let id = $(this).data('id');

                            // ajax
                            $.ajax({
                                type: "POST",
                                url: "{{ url('confirm-order') }}",
                                data: {
                                    id: id
                                },
                                dataType: 'json',
                                success: function(res) {

                                    Swal.fire(
                                        'Good job!',
                                        'Order sucessfully confirmed!',
                                        'success'
                                    )
                                    var oTable = $('#datatable-ajax-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Stock is not sufficient!',
                            })
                        }


                    });


                    $('body').on('click', '.unconfirm', function() {

                        let id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('unconfirm-order') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(res) {

                                Swal.fire(
                                    'Good job!',
                                    'Successfully unconfirmed!',
                                    'info'
                                )

                                var oTable = $('#datatable-ajax-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        });
                    });



                });
            </script>
        </div>
    </body>

    </html>

@endsection
