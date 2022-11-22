<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
      
    public function postLogin(Request $request)
    {
        $auth = false;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $auth = true; 
        }

        if ($request->ajax()) {
            return response()->json([
                'auth' => $auth,
            ]);
        } else {
            return redirect()->intended(URL::route('login'));
        }
        return redirect(URL::route('login'));
    }

    
    public function home()
    {
        if(Auth::check()){
            return view('home');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function daftarbaru(Request $request){
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
      
        $post = User::create([
            'name'     => $request->name, 
            'email'   => $request->email,
            'photo'   => $namafile,
            'password'   => Hash::make($request->password),
        ]);
        
        
        $path = public_path().'/images/';
        if (!file_exists($path)){
            File::makeDirectory($path, $mode = 0755, true, true);
        }

        $path = public_path().'/images/user/';
        if (!file_exists($path)){
            File::makeDirectory($path, $mode = 0755, true, true);
        }

        if (!empty($file)){
            $file->move($path,$namafile);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post  
        ]);
    }
    
    public function logOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
