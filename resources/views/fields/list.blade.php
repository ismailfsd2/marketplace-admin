@extends('layout')
@section('head')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@stop
@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Fields</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('field_groups.fields.add',$field_group_id) }}" class="btn btn-success" id="field-add"><i class="ri-add-line align-bottom me-1"></i> Add New Field</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="init-datatables" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lable</th>
                                <th>Machine Name</th>
                                <th>Placeholder</th>
                                <th>Required</th>
                                <th>Options</th>
                                <th>Create By</th>
                                <th>Create At</th>
                                <th>Update At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('bottom')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="{{ asset('') }}assets/js/datatable-init.js"></script>
    <script>
        $datatable = $.tableInit('#init-datatables', '{{ route("field_groups.fields.list",$field_group_id) }}', {
            "columns": [
                { data: 'id' },
                { data: 'label' },
                { data: 'machine_name' },
                { data: 'placeholder' },
                { data: 'required' },
                { data: 'options' },
                { data: 'created_by' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'actions' }
            ]
        });
        $.modalInit('#field-add');
        $.modalInit('.field-edit');
        $.deleteRecord('.field-delete');
    </script>
@stop
