<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Import Export Excel to database Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>
<body>
   
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
           <a href="{{url('/user')}}" class="btn btn-danger mb-3">< Back</a> 
           <p>Import Export Excel to database</p>
        </div>
        <div class="card-body">
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                @error('file') <strong class="text-danger">{{$message}}</strong> @enderror
                <br>
                <button class="btn btn-success">Import User Data</button>
                <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>