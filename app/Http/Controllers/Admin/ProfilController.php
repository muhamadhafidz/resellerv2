<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Image;
use File;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.profil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.pages.profil.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username,'.Auth::user()->id,
            'email' => 'required|unique:users,email,'.Auth::user()->id,
            'alamat' => 'required',
            'no_hp' => 'required|unique:users,no_hp,'.Auth::user()->id,
        ]);

        Auth::user()->update($user);

        return redirect()->route('admin.profil.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatePassword(Request $request)
    {
        $item = $request->validate([
            'password_old' => 'required|min:8|max:16',
            'password_new' => 'required|min:8|max:16',
            'password_confirm' => 'required',
        ]);

        $activeUser = Auth::user();
        if ($item['password_new'] == $item['password_confirm']) {
            if (Hash::check($item['password_old'],$activeUser->password)) {
                $activeUser->update([
                    'password' => Hash::make($item['password_new']),
                ]);
                Alert::success('Password berhasil diubah', '');
            }else {
                Alert::error('Gagal merubah password', 'password lama yang anda masukan salah');
            }
        }else {
            Alert::error('Gagal merubah password', 'konfirmasi password tidak cocok');
        }
        
        return redirect()->route('admin.profil.index');
        

    }

    public function ubahFoto(Request $request)
    {
        $data = $request->validate([
            'foto' => 'required|mimes:png,jpg,jpeg'
        ]);

        $user = Auth::user();
        // dd($user);

        $file = $request->file('foto');
        $file_name = $file->getFilename().".".strtolower($file->getClientOriginalExtension());
        
        $file_location = "assets/user/img/profil/";
        $img = Image::make($file);
        // $img->move('assets/user/img/coba', 'aw.jpg');
        $img->save($file_location.$file_name, 50);
        // dd($aw);
        // $stored_file = $file->move($file_location, $file_name);

        $data['img_user'] = $file_location.$file_name;
        // $file_name = $file->getFilename().".".$file->getClientOriginalExtension();
        // $file_location = "assets/user/img/profil";
        // $stored_file = $file->move($file_location, $file_name);
        
        if ($user->img_user != "-") {
            File::delete($user->img_user);
        }

        $user->update([
            'img_user' => $data['img_user']
        ]);

        // dd($test);

        return redirect()->route('admin.profil.index');        
    }
}
