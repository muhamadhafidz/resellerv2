<?php

namespace App\Http\Controllers;

use App\Point;
use App\User_point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TukarpointController extends Controller
{
    public function index()
    {
        $points = Point::get();
        return view('user.pages.tukar-point.index', [
            'points' => $points
        ]);
    }

    public function ambil($id)
    {
        $point = Point::findOrFail($id);

        User_point::create([
            'user_id' => Auth::user()->id,
            'point' => $point->req_point,
            'total_point' => Auth::user()->user_points()->get()->last()->total_point - $point->req_point,
            'keterangan' => 'keluar',
            'status' => 'sukses',
            'invoice' => 'Tukar point dengan '.$point->nama
        ]);

        return redirect()->route('user.point');
    }
}
