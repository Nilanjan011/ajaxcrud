<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Mail;
class UserController extends Controller
{
    //================ mail start =================================================================
    public function newMail(Request $request)
    {
        $files = array();
        $files[]= public_path()."/storage/avater/1637922747-left2.jpg.jpg";
        // dd($files);
        $user["to"]=$request->mail;
        Mail::send("mail",["name"=>"nilanjan"],function($message) use ($user,$files) {
            $message->from('nilanjan@gmail.com', '3ps');
            $message->cc('info@fhgtfu.com')
            ->replyTo('reply@example.com', 'Reply Guy')
            ->to($user["to"]);
            $message->subject("something");

            foreach ($files as $file){
                $message->attach($file);
            }
        });
    }
    //================ mail end ====================================================================
    //============== ajax crud =====================================================================
    public function ajax()
    {
        $user = User::toBase()->orderBy('id','DESC')->get(['id','name','email','image']);
        return view('ajaxCrud',compact('user'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'email'=> 'required|email|string|min:3|max:50|unique:users',
            "name" =>"required|string|min:3|max:50",
            "password" =>"required|min:3|max:50"
        ]);

        $user=new User([
            "name"=>$request->post("name"),
            "email"=>$request->post("email"),
            "password"=>bcrypt($request->post("password")),
        ]);

        if ($user->save())
        {
           return response()->json(["msg"=> "inserted data","user"=>$user],200);
        }
    }

    public function ajaxDel(User $user)
    {
        // Storage::delete("./public/avater/$user->image");  
        $user->delete();
        return response()->json(["msg"=> "Delete successful",],200);
    }

    public function ajaxUpdate(Request $request)
    {
        $request->validate([
            'email'=> 'required|email|string|min:3|max:50',
            "name" =>"required|string|min:3|max:50",
        ]);

        $user= User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        
        return response()->json(["msg"=>"Update user successfully","id"=>$request->id,"name"=>$request->name,"email"=>$request->email],200);
    
    }
//======================= ajax crud ==============================================================
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $user = User::toBase()->orderBy('id','DESC')->get(['id','name','email','image']);
        return view('user',compact('user'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('userform');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $request->validate([
            'email'=> 'required|string|min:3|max:50|unique:users',
            "name" =>"required|string|min:3|max:50",
            "password" =>"required|min:3|max:50"
        ]);

        $user=new User([
            "name"=>$request->post("name"),
            "email"=>$request->post("email"),
            "password"=>bcrypt($request->post("password")),
        ]);

        if ($user->save())
        {
           return redirect('user')->with(['message'=>'Successfully inserted','class'=>'success']);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\user  $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
        // dd($user);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\user  $user
    * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
        return view('editUser',compact("user"));
    }
    
    public function update(Request $request, User $user)
    {
        
        $request->validate([
            'email'=> 'required|string|min:3|max:50',
            "name" =>"required|string|min:3|max:50",
        ]);

        $user->update([
            "name"=>$request->post('name'),
            "email"=>$request->post('email')
        ]);
        return redirect('user')->with(['message'=>'Successfully Update','class'=>'success']);
    }

    public function image(User $user)
    {
        return view('userimage',compact("user"));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\user  $user
    * @return \Illuminate\Http\Response
    */
    public function upload(Request $request, User $user)
    {
        $request->validate([
            'image'=> 'required|file|image|mimes:jpeg,jpg,png,webp',
        ]);
        
        if ($user->image) {
            Storage::delete("./public/avater/$user->image");
        }

        $image = $request->file('image');
		$file = time()."-".$image->getClientOriginalName().'.'.$image->extension();
        $image->storeAs('avater',$file,'public');

        $user->image = $file;
        $user->save();

        return redirect('user')->with(['message'=>'Successfully Update','class'=>'success']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\user  $user
    * @return \Illuminate\Http\Response
    */
    public function destroy(User $user)
    {
        Storage::delete("./public/avater/$user->image");  
        $user->delete();
        return redirect('user')->with(['message'=>'Delete Successfully','class'=>'danger']);
    }

    public function pdfview()
    {
        $user = User::toBase()->orderBy('id','DESC')->get(['id','name','email','image']);
        view()->share('user',$user);
   
        $pdf = PDF::loadView('userPdf');
        return $pdf->download('user.pdf');
    }
    
    public function importExportView()
    {
       return view('import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        $request->validate([
            "file"=>"required"
        ]);
        
        Excel::import(new UsersImport,request()->file('file'));
             
        return back();
    }

}
