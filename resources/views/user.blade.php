@extends('layouts.mylayout')
@section('layout')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if ($message = Session::get('message'))
            
            <div class="alert alert-{{ Session::get('class')}} alert-block">
                <button class="close" data-dismiss="alert">x</button>
                <strong>{{$message}}</strong>
            </div>
            @endif
            <a href="{{route('user.create')}}" class="btn btn-primary m-2">+User</a>
            <a href="{{route('user.pdfview')}}" class="btn btn-outline-danger m-2">PDF</a>
            <a href="{{route('importExportView')}}" class="btn btn-outline-success m-2">XLS</a>
            
            <table class="table table-hover table-dark">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" colspan="2">Image</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>

                    @forelse ($user as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>
                            @if ($item->image)
                                <img src="{{asset('storage/avater/'.$item->image)}}" alt="Image" width="50" height="50">
                            @else
                                upload image
                            @endif
                        </td>
                        <td><a href="{{route('user.image',$item->id)}}" class="btn btn-warning">Upload</a></td>
                       <td>
                        <a href="{{ route('user.edit',$item->id) }}" class="btn btn-success">Edit</a>
                      
                        </td>
                        <td>
                            <a href="" onclick="if(confirm('Do you want to delete this user?')){ event.preventDefault(); document.getElementById('delete-{{$item->id}}').submit();
                            }else{ event.preventDefault();}" class="btn btn-danger">Delete</a>
                            <form id="delete-{{$item->id}}" method="post" action="{{route('user.destroy',$item->id)}}">
                                @csrf
                                @method('DELETE')
                            </form>
                       </td>
                        
                      </tr>
                    @empty
                        No data found
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
