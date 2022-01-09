@extends('layouts.mylayout')
@section('layout')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="alert alert-block" style="display: none">
                <button class="close" onclick="hideAlert()">x</button>
                <strong id="msg"></strong>
            </div>

            <!--exampleModal Button trigger modal -->
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                +User
            </button>

            <!--userModalBtn Button trigger modal -->
            <button type="button" id="userModalBtn" style="display:none" data-toggle="modal" data-target="#userModal">
                +userModalBtn
            </button>

        
            <!--exampleModal Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form action="" id="form" method="post">
                                            @csrf
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Name</label>
                                            <input type="text" required class="form-control" name="name" id="name" placeholder="Name">
                                            <span id="nameErr" style="color:red"></span>
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Email address</label>
                                          <input type="email" required class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                                          <span id="emailErr" style="color:red"></span>
                                          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" required name="password" class="form-control" id="password" placeholder="Password">
                                            <span id="passwordErr" style="color:red"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="saveBtn" class="btn btn-primary" onclick="save()">Save</button> 
                        </div>
                    </div>
                    </div>
                </div>

                <!--exampleModal Modal -->
                <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form action="" id="formEdit" method="post">
                                            @csrf
                                            <input type="hidden" name="id" id="user_id">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Name</label>
                                            <input required type="text" class="form-control" name="name" id="nameEdit" placeholder="Name">
                                            <span id="nameErrEdit" style="color:red"></span>
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Email address</label>
                                          <input type="email" required class="form-control" name="email" id="emailEdit" aria-describedby="emailHelp" placeholder="Enter email">
                                          <span id="emailErrEdit" style="color:red"></span>
                                          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button id="closeModalEdit" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="update()">Save</button> 
                        </div>
                    </div>
                    </div>
                </div>

            
            <table class="table table-hover table-dark">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    {{-- <th scope="col" colspan="2">Image</th> --}}
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>

                    @forelse ($user as $item)
                    <tr id="row_{{$item->id}}">
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        {{-- <td>
                            @if ($item->image)
                                <img src="{{asset('storage/avater/'.$item->image)}}" alt="Image" width="50" height="50">
                            @else
                                upload image
                            @endif
                        </td> --}}
                        {{-- <td><a href="{{route('user.image',$item->id)}}" class="btn btn-warning">Upload</a></td> --}}
                       <td>
                        <button onclick="editUser({{$item->id}})" class="btn btn-success">Edit</button>
                        </td>
                        <td>
                            <button onclick="deleteuser({{$item->id}})" class="btn btn-danger">Delete</button>
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

@section('scripts')

<script>
    function hideAlert(){
        $(".alert").hide();

    }

    function update(){
        var data = $("#formEdit").serializeArray();

        $.ajax({
            url: "{{route('user.ajaxUpdate')}}",
            type: "POST",
            data:data,
            success: function(data) {
                // console.log(data);
                $("#row_"+data.id+" td:nth-child(1)").html(data.name);
                $("#row_"+data.id+" td:nth-child(2)").html(data.email);
                $('#todo_id').val('');
                $('#edittask').val('');
                // $('#userModal').modal('hide');
                document.getElementById('closeModalEdit').click();

                $(".alert").addClass("alert-success");
    
                document.getElementById('msg').innerHTML = data.msg;
                $(".alert").show();
            },
            error: function(err) {
                
                if(err.responseJSON.errors.name[0] && err.responseJSON.errors){
                    document.getElementById('nameErrEdit').innerHTML = err.responseJSON.errors.name[0];
                }
                if(err.responseJSON.errors.email[0]){
                    document.getElementById('emailErrEdit').innerHTML = err.responseJSON.errors.email[0];
                }
            }
        });
    }
    

    function editUser(id){
        
        var name  = $("#row_"+id+" td:nth-child(1)").html();
        var email  = $("#row_"+id+" td:nth-child(2)").html();
        $("#user_id").val(id);
        $("#nameEdit").val(name);
        $("#emailEdit").val(email);
        document.getElementById('userModalBtn').click();
        // $("#userModal").modal('show');
    }

    function deleteuser(id){
        if(confirm('Do you want to delete this user?'))
        {
            let url = `/ajaxDel/${id}`;
            $.ajax({
                url: url,
                type: 'DELETE',
                data:{
                    _token:'{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#row_"+id).remove();
                    $(".alert").addClass("alert-danger");
    
                    document.getElementById('msg').innerHTML = response.msg;
                    $(".alert").show();

                }
            });
        }

    }
    
    function save() {
        var data = $("#form").serializeArray();
        
        document.getElementById('saveBtn').disabled = true;
        document.getElementById('saveBtn').innerHTML ="proccessing...";
        
        $.ajax({
            url: "{{route('user.save')}}",
            type: "POST",
            data: data,
            success: function(response) {
                console.log( response.msg);    
                if (response.user) {  
                    todo = response.user;
                    
                    $('table tbody tr:first').before(`
                        <tr id="row_${todo.id}">
                            <td>${ todo.name }</td>
                            <td>${todo.email}</td>
                            <td>
                        <button onclick="editUser(${todo.id})" class="btn btn-success">Edit</button>
                        </td>
                        <td>
                            <button onclick="deleteuser(${todo.id})" class="btn btn-danger">Delete</button>
                       </td>
                        </tr>
                    `);

                    $('#name').val('');
                    $('#email').val('');
                    $('#password').val('');

                    
                    document.getElementById('closeModal').click();
                    
                    $(".alert").addClass("alert-success");
                    document.getElementById('saveBtn').disabled = false;
                    document.getElementById('saveBtn').innerHTML ="Save";
                    document.getElementById('msg').innerHTML = response.msg;
                    $(".alert").show();

                }else{
                    $(".alert").addClass("alert-danger")
                    document.getElementById('msg').innerHTML = "something worng!try again";
                    $(".alert").show();
                }
            },
            error: function(err) {
                console.log(err.responseJSON.errors.email[0]);
                if(err.responseJSON.errors.email[0]){
                    document.getElementById('emailErr').innerHTML = err.responseJSON.errors.email[0];
                }
                if(err.responseJSON.errors.name[0]){
                    document.getElementById('nameErr').innerHTML = err.responseJSON.errors.name[0];
                }
                if(err.responseJSON.errors.password[0]){
                    document.getElementById('passwordErr').innerHTML = err.responseJSON.errors.password[0];
                }
            }
        });
    }
</script>
    
@endsection