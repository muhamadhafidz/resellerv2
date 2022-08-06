<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class TransaksiController extends Controller
{
    public function index()
    {
        $trans = Auth::user()->transaction()->with('transaction_products')->get();
        return view('user.pages.transaksi.index', [
            'trans' => $trans
        ]);
    }
    
    public function batal($id)
    {
        $tran = Auth::user()->transaction()->findOrFail($id);

        $tran->status = "Pesanan dibatalkan";
        $tran->keterangan = "Pesanan dibatalkan reseller";
        $tran->save();
        Alert::toast('Pesanan berhasil dibatalkan', 'success');
        return redirect()->route('user.transaksi');
    }

    public function selesai($id)
    {
        $tran = Transaction::findOrFail($id);

        $tran->status = "pesanan selesai";
        $tran->keterangan = "Reseller telah melakukan konfirmasi pesanan telah selesai";
        $tran->save();
        Alert::toast('Pesanan telah selesai', 'success');
        return redirect()->route('user.transaksi');
    }
    public function cetakInvoice($id)
    {
        // dd($id);
        $data = Transaction::with(['user', 'transaction_products'])->findOrFail($id);
        
        $pdf = PDF::loadView('pdf/invoice', [
            'data' => $data 
            ])->setPaper('A4','potrait');
  
        return $pdf->download('Navil Store - '.$data->invoice.'.pdf');

        // return redirect()->back();
    }
}
