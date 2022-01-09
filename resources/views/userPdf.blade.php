<style type="text/css">  
    table td, table th{  
        border:1px solid black;  
    }  
</style>  
<div class="container">  
    <table>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Image</th>
        </tr>
        <tbody>
            @foreach ($user as $item)
            <tr>
                <td>{{$loop->iteration}}</td>  
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td>
                    @if ($item->image)
                        <img src="{{public_path('storage/avater/'.$item->image)}}" alt="Image" width="50" height="50">
                    @else
                        upload image
                    @endif
                </td>              
            </tr>
            @endforeach
        </tbody>
    </table>
</div>