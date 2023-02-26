@extends('layouts.app')

@section('title')
    Brands
@endsection

@section('brands')

    @if ($errors->any())
        @foreach ($errors->all() as $false)
            {{ $false }}<br>
        @endforeach
    @endif


    @if (session('success'))
        {{ session('success') }}<br>
    @endif




    <h4>
        <p class="text-center">Brands on the base: <b>{{ $data->count() }}</b></p>
    </h4>
    <div class="container mt-4">

        <div class="col-md-12 mt-1 mb-2">
            <p class="text-center"><button type="button" id="addNewBook" class="btn btn-success">Add</button></p>
        </div>

        <div class="card">

            <div class="card-header">
                <p class="text-center font-weight-bold">
                <h2>Brands</h2>
                </p>
            </div>

            <div class="card-body">

                <table class="table table-bordered" id="datatable-ajax-crud">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>

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
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Brand Name" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Photo</label>
                                <div class="col-sm-6 pull-left">
                                    <input type="file" class="form-control" id="photo" name="photo" required="">
                                </div>
                                <div class="col-sm-6 pull-right">
                                    <img id="preview-image"
                                        src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                        alt="preview image" style="max-height: 250px;">
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


                $('#datatable-ajax-crud').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ url('brands') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id',
                            searchable: false,
                            orderable: true
                        },
                        {
                            data: 'photo',
                            orderable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            searchable: true,
                            orderable: true
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            searchable: true,
                            orderable: true
                        },
                        {
                            data: 'action',
                            orderable: false
                        },
                    ],
                    order: [
                        [0, 'asc']
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
                    $('#ajaxBookModel').html("Add Book");
                    $('#ajax-book-model').modal('show');
                    $("#photo").attr("required", "true");
                    $('#id').val('');
                    $('#preview-image').attr('src',
                        'https://www.riobeauty.co.uk/images/product_image_not_found.gif');


                });

                $('body').on('click', '.edit', function() {

                    let id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('edit-book') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            $('#ajaxBookModel').html("Edit Book");
                            $('#ajax-book-model').modal('show');
                            $('#id').val(res.id);
                            $('#name').val(res.name);
                            $('#photo').val(res.photo);
                            $('#photo').removeAttr('required');

                        }
                    });

                });

                $('body').on('click', '.delete', function() {

                    if (confirm("Delete Record?") == true) {
                        let id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('delete-book') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(res) {

                                var oTable = $('#datatable-ajax-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        });
                    }

                });

                $('#addEditBookForm').submit(function(e) {

                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: "{{ url('add-update-book') }}",
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
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });
            });
        </script>
    </div>


@endsection
