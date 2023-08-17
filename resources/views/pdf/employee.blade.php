<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img.img-thumbnail {
            max-width: 40px;
            max-height: 40px;
        }

        .table-bordered {
            border: 1px solid #dddddd;
        }
    </style>
</head>
<body>
<h1>Employee List</h1>
<table class="table table-bordered" id="main_table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Department</th>
        <th scope="col">Mobile</th>
        <th scope="col">Image</th>
    </tr>
    </thead>
    <tbody>
    @foreach($employee as $emp)
        <tr>
            <td>
                {{$emp->id}}
            </td>
            <td>
                {{$emp->name}}
            </td>
            <td>
                {{$emp->department_id}}
            </td>
            <td>
                {{$emp->mobile}}
            </td>
            <td>
                @if($emp->image)
                    <img src="./image/{{$emp->image}}" class="img-thumbnail" alt="Opps !!">
                @else
                    <img src="./image/comun.png" class="img-thumbnail" alt="Opps !!">
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
