<?php

namespace App\Http\Controllers;

use App\User_point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index()
    {
        $points = Auth::user()->user_points()->orderBy('id', 'desc')->get();
        return view('user.pages.point.index', [
            'points' => $points
        ]);
    }
}
