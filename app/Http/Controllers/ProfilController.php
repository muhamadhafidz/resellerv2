<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Image;

class ProfilController extends Controller
{
    public function index()
    {
        return view('user.pages.profil.index');
    }

    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:users,username,'.Auth::user()->id,
            'email' => 'required|unique:users,email,'.Auth::user()->id,
            'alamat' => 'required',
            'no_hp' => 'required|unique:users,no_hp,'.Auth::user()->id,
        ]);
 
        if ($validator->fails()) {
            return redirect()->route('user.profil')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = $request->all();
        Auth::user()->update($user);
        Alert::toast('Profil berhasil diupdate', 'success');
        return redirect()->route('user.profil');
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
        
        return redirect()->route('user.profil');
        

    }

    public function updateFoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img_user' => 'required|mimes:png,jpg,jpeg'
        ]);
 
        if ($validator->fails()) {
            return redirect()->route('user.profil')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = Auth::user();
        // dd($user);

        $file = $request->file('img_user');
        
        $file_name = $file->getFilename().".".strtolower($file->getClientOriginalExtension());
        
        $file_location = "assets/user/img/profil";
        $img = Image::make($file);
        $img->save($file_location.$file_name, 50);

        $data['img_user'] = $file_location.$file_name;

        if ($user->img_user != "-") {
            File::delete($user->img_user);
        }

        $user->update([
            'img_user' => $data['img_user']
        ]);
        Alert::toast('Foto Profil berhasil diupdate', 'success');
        return redirect()->route('user.profil');
    }
}
