<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\User_point;
use Illuminate\Http\Request;

class PointresellerController extends Controller
{
    public function index()
    {
        $users = User::where('roles', 'reseller')->with('user_points')->get();

        return view('admin.pages.point-reseller.index', [
            'users' => $users
        ]);
    }

    public function riwayat()
    {
        $points = User_point::with('user')->get();
        return view('admin.pages.point-reseller.riwayat', [
            'points' => $points
        ]);
    }
}
