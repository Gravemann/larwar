<!DOCTYPE html>
<html>

<head>
    <title>Laravel 8 DataTable Ajax Books CRUD Example</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

</head>

@if (session('success'))
    {{ session('success') }}<br>
@endif

<body>

    <div class="container mt-4">

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

        <div class="card">

            <div class="card-header text-center font-weight-bold">
                <h2>Laravel 8 Ajax Book CRUD with DataTable Example Tutorial</h2>
            </div>

            <div class="card-body">

                <table class="table table-bordered" id="datatable-ajax-crud">
                    <thead>
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
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="x"
                                        placeholder="Enter Brand Name" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Photo</label>
                                <div class="col-sm-6 pull-left">
                                    <input type="file" class="form-control" id="photo" name="p"
                                        required="">
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
                    ajax: "{{ url('ajax-datatable-crud') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': true,
                            orderable: true
                        },
                        {
                            data: 'photo',
                            name: 'p',
                            orderable: false
                        },
                        {
                            data: 'name',
                            name: 'x',
                            orderable: true
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'action',
                            orderable: false
                        },
                    ],
                    order: [
                        [0, 'desc']
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
</body>

</html>
