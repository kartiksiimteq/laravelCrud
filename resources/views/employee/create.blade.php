@extends('layout.main')
@section('main')
    <div class="container-fluid">
        <h1 class="display-6">Employee</h1>
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ $message }} </strong>
            </div>
        @endif
        <div class="container">
            <form method="POST" action="/create/store" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputname1" class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                        id="exampleInputname1" aria-describedby="nameHelp">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="exampleInputmobile1" class="form-label">Mobile</label>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control"
                        id="exampleInputmobile1">
                    @if ($errors->has('mobile'))
                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" class="form-select" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $dp)
                            <option value={{ $dp->id }}>{{ Str::upper($dp->name ) }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Image</label>
                    <input name="image" multiple value="{{ old('image') }}" class="form-control form-control-sm"
                        id="formFileSm" type="file">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>



    </div>
@endsection
