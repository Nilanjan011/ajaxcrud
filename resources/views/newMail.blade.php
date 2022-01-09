<!DOCTYPE html>
<html>
<head>
    <title>mail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>
<body>
   
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
           <a href="{{url('/user')}}" class="btn btn-danger mb-3">< Back</a> 
        </div>
        <div class="card-body">
            <form action="{{route('user.newMail')}}" method="POST">
                @csrf
                <input type="text" name="mail">
                <button class="btn btn-success">Send mail</button>         
            </form>
        </div>
    </div>
</div>
</body>
</html>