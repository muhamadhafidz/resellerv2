<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User_point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PesananController extends Controller
{
    public function index()
    {
        $trans = Auth::user()->transaction()->with('transaction_products')->get();
        return view('user.pages.pesanan.index', [
            'trans' => $trans
        ]);
    }
    
    public function batal($id)
    {
        $tran = Auth::user()->transaction()->with('transaction_products.product')->findOrFail($id);
        foreach ($tran->transaction_products as $transaction_product) {
            $transaction_product->product->terjual -= $transaction_product->qty;
            $transaction_product->product->stok += $transaction_product->qty;
            $transaction_product->product->save();
        }
        $tran->status = "Pesanan dibatalkan";
        $tran->keterangan = "Pesanan dibatalkan reseller";
        $tran->save();

        
        Alert::toast('Pesanan berhasil dibatalkan', 'success');
        return redirect()->route('user.pesanan');
    }

    public function selesai($id)
    {
        $tran = Transaction::with('user.user_points')->findOrFail($id);

        if ($tran->total_point != 0) {
            $totalPoint = $tran->total_point;
            if (!$tran->user->user_points->isEmpty()) {
                $totalPoint = $tran->user->user_points->last()->total_point;
            }
    
    
            User_point::create([
                'user_id' => $tran->user_id,
                'point' => $tran->total_point,
                'total_point' => $totalPoint,
                'status' => 'sukses',
                'keterangan' => 'masuk',
                'invoice' => $tran->invoice
            ]);        
        }

        $tran->status = "pesanan selesai";
        $tran->keterangan = "Reseller telah melakukan konfirmasi pesanan telah selesai";
        $tran->save();
        Alert::toast('Pesanan telah selesai', 'success');
        return redirect()->route('user.pesanan');
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
