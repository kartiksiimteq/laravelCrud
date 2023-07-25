@extends('layout.main')
@section('main')
    <div class="container-fluid ">
        <div class="d-flex justify-content-between">
            <h1 class="display-6">Employee</h1>
            <div class="display-6">
                <button id="activeBtn" class="btn btn-success btn-sm">Active</button>
                <button id="inActiveBtn" class="btn btn-danger btn-sm">InActive</button>
            </div>
        </div>
        <table class="table table-bordered" id="main_table">
            <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" name="checkBoxGloble" data-isOn="false" id="checkBoxGloble"
                            onclick="checkBoxGlobleClick()">
                    </th>
                    {{-- <th scope="col">Sr</th> --}}
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">dept</th>
                    <th scope="col">mobile</th>
                    <th scope="col">image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/update" enctype="multipart/form-data" id="updateForm">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputname1" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    aria-describedby="nameHelp">
                                <input type="hidden" name="id" class="form-control" id="id">


                            </div>
                            <div class="mb-3">
                                <label for="exampleInputmobile1" class="form-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control" id="mobile">

                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select onclick="test()" name="department" id="department" class="form-select" required>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $dp)
                                        <option value={{ $dp->id }}>{{ Str::upper($dp->name) }}</option>
                                    @endforeach
                                    <option value="addNew"> + Add Department</option>
                                    </a>
                                </select>
                                <div id="new_department" class="d-none">
                                    <label for="newDepartmentName" class="form-label">New Department Name</label>
                                    <input type="text" name="newDepartmentName" class="form-control" id="mobile">

                                    <label for="newDepartmentAddress" class="form-label">New Department Address</label>
                                    <input type="text" name="newDepartmentAddress" class="form-control" id="mobile">

                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Image</label>
                                <input name="image" multiple class="form-control  form-control-sm" id="formFileSm"
                                    type="file">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#main_table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, "asc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                ajax: "{{ url('ajaxfetch') }}",
                columns: [{
                        data: null,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<input type="checkbox" name="innerChckbox[]" value='+data.id+'>';
                        }
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'department_id'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'image',
                        searchable: false,
                        render: function(data, type, row) {
                            if (data) {
                                return '<img src="/image/' + data +
                                    '" class="img-thumbnail" width="40" height="40" alt="">';
                            }
                            return '<img src="/image/comun.png" class="img-thumbnail" width="40" height="40" alt="">';
                        }
                    },
                    {
                        data: null,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                    <button type="button" onclick="fetchData(${data.id})" 
                        class="btn btn-sm btn-info" data-bs-toggle="modal" 
                        data-bs-target="#exampleModal" id="editBtn">Edit</button>
                    <a href="/delete/${data.id}">
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>
                    </a>
                `;
                        }
                    },
                ],
                rowCallback: function(row, data, index) {
                    // Add a 'data-id' attribute to the row with the ID from the 'id' column
                    $(row).attr('data-id', data.id);
                }
            });

        });
        // $('#editBtn').on('click', fetchData());
        function fetchData(emp_id) {
            let url = '/employee/' + emp_id;
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'JSON',
                success: function(res) {
                    console.log(res.employee);
                    $('#id').val(res.employee.id);
                    $('#name').val(res.employee.name);
                    $('#mobile').val(res.employee.mobile);
                    $('#department').val(res.employee.department_id);

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                }
            })
        }

        function test() {
            if ($('#department').val() == "addNew") {
                // console.log("dddd");
                $("#new_department").removeClass('d-none');
            } else {

                $("#new_department").addClass('d-none');
                console.log("nooo");
            }
        }

        function checkBoxGlobleClick() {
            let btn_is_on = ($("#checkBoxGloble").attr("data-isOn"));
            if (btn_is_on == "false") {
                $("#main_table  [name='checkBox[]']").prop('checked', true);
                $("#checkBoxGloble").attr("data-isOn", 'true')
            } else {
                $("#main_table  [name='checkBox[]']").prop('checked', false);
                $("#checkBoxGloble").attr("data-isOn", 'false')
            }
        }

        let count = 0;

        function innerCheckboxChange() {
            count = 0;
            $("#main_table  [name='checkBox[]']").each(function(i) {
                $("#main_table  [name='checkBox[]']")[i].checked ? count++ : count;
            })
            // console.log(count);
        }
        // });
    </script>
@endsection
