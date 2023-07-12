@extends('layout.main')
@section('main')
    <div class="container-fluid">
        <h1 class="display-6">Employee</h1>
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ $message }} </strong>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Sr</th>
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">mobile</th>
                    <th scope="col">image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->mobile }}</td>
                        <td> <img src="/image/{{ $employee->image }}" class="img-thumbnail" width="40" height="40"
                                alt="">
                        </td>
                        <td>
                            <button type="button" onclick="fetchData({{ $employee->id }})" class="btn btn-sm btn-info"
                                data-bs-toggle="modal" data-bs-target="#exampleModal" id="editBtn">
                                Edit </button>
                            <a href="/delete/{{ $employee->id }}">
                                <button type="button" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $employees->links() }}

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
        // $(document).ready(function() {
        // $('#editBtn').on('click', fetchData());
        function fetchData(emp_id) {
            let url = '/employee/' + emp_id;
            console.log(emp_id);
            console.log(url);
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'JSON',
                success: function(res) {
                    console.log(res.employee);
                    $('#id').val(res.employee.id);
                    $('#name').val(res.employee.name);
                    $('#mobile').val(res.employee.mobile);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                }
            })
        }
        // });
    </script>
@endsection
