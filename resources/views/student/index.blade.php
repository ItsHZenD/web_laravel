@extends('layout.master')
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/sc-2.0.7/sb-1.4.0/sl-1.5.0/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card">
        {{-- @if ($errors->any())
            <div class="card-header">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif --}}
        <div class="card-body">
            <a class="btn btn-primary" href="{{ route('students.create') }}">
                ADD
            </a>
            <div class="form-group">
                <select id="select-course-name" style="width: 244px !important;"></select>
            </div>
            <div class="form-group">
                <select id="select-status" style="width: 244px !important;">
                    <option value="0">Tất cả </option>
                    @foreach ($arrStudentStatus as $option => $value )
                        <option value="{{ $value }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <form class="float-right form-group form-inline">
                Search: <input type="search" name="q" value="{{ $search }}">
            </form> --}}
            <table class="table table-striped" id="table-index">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Avatar</th>
                        <th>Course Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                {{--
                @foreach ($data as $each)
                    <tr>
                        <td>
                            {{ $each->id }}
                        </td>
                        <td>
                            {{ $each->name }}
                        </td>
                        <td>
                            {{ $each->year_created_at }}
                        </td>
                        <td>
                            <a class="btn btn-info" href="{{ route('course.edit', $each) }}">
                                Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('students.destroy', $each) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach --}}
            </table>
            {{-- <nav aria-label="...">
                <ul class="pagination">

                    {{ $data->links() }}
                </ul>
            </nav> --}}


        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/sc-2.0.7/sb-1.4.0/sl-1.5.0/datatables.min.js">
    </script>
    <script script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $("#select-course-name").select2({
                ajax: {
                    url: "{{ route('courses.api.name') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function(data, params) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                },
                placeholder: 'Search for a name',
                allowClear: true
            });
            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#table-index').DataTable({
                dom: 'Bflrtip',
                select: true,
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'copyHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'csvHtml5'
                    }), $.extend(true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    }), $.extend(true, {}, buttonCommon, {
                        extend: 'print'
                    }),
                    'colvis'
                ],
                lengthMenu: [10, 25, 100],
                processing: true,
                serverSide: true,
                ajax: "{!! route('students.api') !!}",
                columnDefs: [{
                    className: "not-export",
                    "targets": [3]
                }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'avatar',
                        target: 5,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if(!data){
                                return '';
                            }
                            return `<img src="{{ asset('storage/${data}') }}">`;
                            // return `<img src="{{ public_path() }}/${data}">`;
                        }
                    },
                    {
                        data: 'course_name',
                        name: 'course_name'
                    },
                    {
                        data: 'edit',
                        target: 7,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<a class="btn btn-info" href="${data}">
                                Edit
                                </a>`;
                        }
                    },
                    {
                        data: 'destroy',
                        target: 8,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<form action="${data}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete btn-danger">Delete</button>
                                    </form>`;
                        }
                    },
                ]
            });
            $('#select-course-name').change(function() {
                table.column(6).search($(this).val()).draw();
            });
            $('#select-status').change(function() {
                // let value = $(this).val();
                // if(value==='0'){
                //     table.column(4).search('').draw();
                // }else{
                //     table.column(4).search(value).draw();
                // }
                table.column(4).search($(this).val()).draw();
            });
            $(document).on('click', '.btn-delete', function() {
                let form = $(this).parents('form');
                let row = $(this).parents('tr');
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: form.serialize(),
                    success: function() {
                        console.log("success");
                        table.draw();
                    },
                    error: function() {
                        console.log("error");
                    }
                });
            });
        })
    </script>
@endpush
