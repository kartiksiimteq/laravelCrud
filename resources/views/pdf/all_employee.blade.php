<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
<h1>Employee List </h1>
<table class="table table-bordered" id="main_table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Name</th>
        <th scope="col">dept</th>
        <th scope="col">mobile</th>
        <th scope="col">image</th>
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
                    <img src="/image/{{$emp->image}}" class="img-thumbnail" width="40" height="40" alt="Opps !!">
                @else
                    No Image
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
