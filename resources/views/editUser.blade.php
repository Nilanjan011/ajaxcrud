@extends('layouts.mylayout')
@section('layout')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{route("user.update",$user->id)}}" method="post" class="form-horizontal">
                @if ($message = Session::get('message'))
                    <div class="alert alert-danger alert-block">
                        <button class="close" data-dismiss="alert">x</button>
                        <strong>{{$message}}</strong>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li> {{$err}} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @method('put')
                    @csrf
                <div class="form-group">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" value="{{$user->name}}" class="form-control" name="name" id="exampleInputPassword1" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" value="{{$user->email}}" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection