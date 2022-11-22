<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use File;

class UserController extends Controller
{    

   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(Auth::user()->name)){
            return redirect(URL::route('login'));
        }  

        $perpage = isset($_GET['perpage'])?$_GET['perpage']:10;
        $user = User::orderBy('created_at', 'desc')->simplePaginate($perpage);
       
        return view('user.index', compact('user','perpage'));
    }

    public function cari()
    {
        $q = isset($_GET['q'])?strtolower($_GET['q']):'';
        $perpage = 5;
        $pertanyaan = Pertanyaan::where('judul','like', '%'.$q.'%')
                        ->orWhere('isi','like', '%'.$q.'%')
                        ->paginate($perpage);
       // $get = Pertanyaan::status();
        return view('pertanyaan.timeline', compact('pertanyaan','perpage'));
    }

    public function form()
    {
        $users = null;
        if (isset($_GET['id'])){
            $users = User::find($_GET['id']);
        }
        return View::make('user.form',['users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cekEmail = User::where('email',$request->email)->first(); 
        if (!empty($cekEmail->id)){
            if ($cekEmail->id != $request->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar',
                    'attr' => 'email'
                ]);
            }
        }

        $file = $request->file('photo');
        $tujuan_upload = 'user'; 
		$namafile = '';
        if (!empty($file)){
            $namafile = date('ymdHis').$file->getClientOriginalName();
        }
      
        $is_created = 1;
        if (empty($request->id)){
            $post = User::create([
                'name'     => $request->name, 
                'email'   => $request->email,
                'photo'   => $namafile,
                'password'   => Hash::make($request->password),
            ]);
        }else{        
            $is_created = 2; 
            $post = User::find($request->id);
            $post->name = $request->name;
            $post->email = $request->email;
            if (!empty($namafile)){
                $post->photo = $namafile;
            }
            $post->update();                        
        }
        
        $path = public_path().'/images/';
        if (!file_exists($path)){
            File::makeDirectory($path, $mode = 0755, true, true);
        }

        $path = public_path().'/images/user/';
        if (!file_exists($path)){
            File::makeDirectory($path, $mode = 0755, true, true);
        }

        if (!empty($file)){
            if (($post->photo != $request->tempFile)){
                if (file_exists($path.$namafile)){
                    unlink($path.$namafile);
                }
            }
            $file->move($path,$namafile);
        }

        return response()->json([
            'success' => true,
            'message' => ($is_created == 1)?'Data Berhasil Disimpan!':'Dtaa Berhasil Diubah!',
            'data'    => $post  
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.info',compact('user'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deleted = User::find($id);

        $path = public_path().'/images/user/';
        if (file_exists($path.$deleted->photo) && !empty($deleted->photo)){
            unlink($path.$deleted->photo);
        }

        $deleted->delete();
           
            
        return response()->json([
            'success' => true,
        ]);
    }

    public function upvote($id, Request $request)
    {
        $model = Pertanyaan::store_upvote($id, $request);
        
        return response()->json( $model, 200);
    }

    public function downvote($id, Request $request){
        $model = Pertanyaan::store_downvote($id, $request);

        return response()->json( $model, 200);
    }
}
