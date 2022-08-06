<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\User_point;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::with(['transaction_products', 'user'])->get();
        return view('admin.pages.pesanan.index', [
            'data' => $data
        ]);
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
        //
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
        //
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


    public function batal($id)
    {
        $tran = Transaction::with('transaction_products.product')->findOrFail($id);
        foreach ($tran->transaction_products as $transaction_product) {
            $transaction_product->product->terjual -= $transaction_product->qty;
            $transaction_product->product->stok += $transaction_product->qty;
            $transaction_product->product->save();
        }
        $tran->status = "Pesanan dibatalkan";
        $tran->keterangan = "Pesanan dibatalkan admin";
        $tran->save();
        Alert::toast('Pesanan berhasil dibatalkan', 'success');
        return redirect()->route('admin.pesanan.index');
    }

    public function konfirmasi($id)
    {
        $tran = Transaction::findOrFail($id);

        $tran->status = "menunggu input ongkir";
        $tran->keterangan = "Pesanan telah dikonfirmasi oleh admin <br>saat ini sedang menunggu input perhitungan ongkos kirim";
        $tran->save();
        Alert::toast('Pesanan berhasil dikonfirmasi', 'success');
        return redirect()->route('admin.pesanan.index');
    }

    public function bayar($id)
    {
        $tran = Transaction::findOrFail($id);

        $tran->status = "pesanan diproses";
        $tran->keterangan = "Pembayaran telah dikonfirmasi<br>pesanan sedang diproses";
        $tran->save();
        Alert::toast('Pembayaran berhasil dikonfirmasi', 'success');
        return redirect()->route('admin.pesanan.index');
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
        $tran->keterangan = "Admin telah melakukan konfirmasi pesanan telah selesai";
        $tran->save();
        Alert::toast('Pesanan telah selesai', 'success');
        return redirect()->route('admin.pesanan.index');
    }

    public function addongkir(Request $request, $id)
    {
        $item = $request->validate([
            'ongkir' => 'required|integer'
        ]);

        $tran = Transaction::findOrFail($id);
        $tran->ongkir = $item['ongkir'];
        $tran->status = 'menunggu pembayaran';
        $tran->keterangan = 'ongkir telah diinput, silahkan lakukan pembayaran pesanan';

        $tran->save();

        return response()->json('success');
    }

    public function kirim(Request $request, $id)
    {
        $item = $request->validate([
            'kurir' => 'required',
            'resi' => 'required'
        ]);

        $tran = Transaction::findOrFail($id);
        $tran->kurir = $item['kurir'];
        $tran->resi = $item['resi'];
        $tran->status = 'pesanan dikirim';
        $tran->keterangan = 'pesanan telah dikirim oleh Navil Store';

        $tran->save();

        return response()->json('success');
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
