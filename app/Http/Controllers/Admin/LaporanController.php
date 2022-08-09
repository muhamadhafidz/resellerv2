<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->start) && isset($request->finish)){
            
            $data = Transaction::with(['transaction_products', 'user'])->where('status', 'pesanan selesai')->whereBetween('created_at', [$request->start, $request->finish])->orderBy('id', 'DESC')->get();
        }else {
            $data = Transaction::with(['transaction_products', 'user'])->where('status', 'pesanan selesai')->orderBy('id', 'DESC')->get();
        }
        return view('admin.pages.laporan.index', [
            'data' => $data
        ]);
    }
}
