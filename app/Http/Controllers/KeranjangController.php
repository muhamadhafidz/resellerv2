<?php

namespace App\Http\Controllers;

use App\Keranjang;
use App\Transaction;
use App\Transaction_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KeranjangController extends Controller
{
    public function index()
    {
        $carts = Auth::user()->keranjang()->with(['product.product_images','product.product_points'])->get();
        return view('user.pages.keranjang.index', [
            'carts' => $carts
        ]);
    }

    public function updateQty(Request $request, $id)
    {
        $cart = Auth::user()->keranjang()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'qty'.$id => 'required|integer|min:1'
        ]);
 
        if ($validator->fails()) {
            return redirect()->route('user.keranjang')
                        ->withErrors($validator)
                        ->withInput();
        }

        $cart->qty = $request['qty'.$id];
        $cart->save();
        Alert::toast('Keranjang berhasil diupdate', 'success');
        return redirect()->route('user.keranjang');
    }

    public function deleteCart($id)
    {
        $cart = Auth::user()->keranjang()->findOrFail($id);

        $cart->delete();
        Alert::toast('Keranjang berhasil diupdate', 'success');
        return redirect()->route('user.keranjang');
    }

    public function checkout()
    {
        $carts = Auth::user()->keranjang()->firstOrFail();

        $invoice = 'INV-'.date('Ymd').$carts->id.rand(100, 999);

        $totalBayar = 0;
        foreach (Auth::user()->keranjang()->with('product')->get() as $cart) {
            $totalBayar += $cart->qty * $cart->product->harga;
        }

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'invoice' => $invoice,
            'ongkir' => '0',
            'total_point' => '0',
            'total_bayar' => $totalBayar,
            'status' => 'menunggu konfirmasi',
            'keterangan' => 'menunggu konfirmasi oleh admin'
        ]);
        $totalPoint = 0;
        foreach (Auth::user()->keranjang()->with('product.product_points')->get() as $cart) {
            $point = 0;
            foreach ($cart->product->product_points as $product_point) {
                if ($cart->qty >= $product_point->min_beli) {
                    $point = ($cart->product->harga * $cart->qty) * ( $product_point->point_persentase / 100 );
                }
            }
            $totalPoint += $point;
            Transaction_product::create([
                'product_id' => $cart->product->id,
                'transaction_id' => $transaction->id,
                'qty' => $cart->qty,
                'point' => $point,
                'nama_barang' => $cart->product->nama_barang,
                'harga' => $cart->product->harga,
                'total_harga' => $cart->qty * $cart->product->harga
            ]);
            $cart->product->terjual += $cart->qty;
            $cart->product->stok -= $cart->qty;
            $cart->product->save();
            
        }
        $transaction->total_point = $totalPoint;
        $transaction->save();

        Auth::user()->keranjang()->delete();
        Alert::toast('Keranjang berhasil di Checkou', 'success');
        return redirect()->route('user.pesanan');
    }
}
