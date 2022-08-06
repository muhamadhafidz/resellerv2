<?php

namespace App\Http\Controllers;

use App\Keranjang;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
  
        if(isset($request->cari)){
            $products = Product::with(['product_images', 'product_points'])->where('nama_barang', 'like','%'.$request->cari.'%')->paginate(2);
        }else {
            $products = Product::with(['product_images', 'product_points'])->paginate(2);
        }
        return view('user.pages.produk.index', [
            'products' => $products
        ]);
    }

    public function detail($slug)
    {
        $product = Product::with(['product_images', 'product_points'])->where('slug', $slug)->firstorfail();
        return view('user.pages.produk.detail', [
            'product' => $product
        ]);
    }

    public function addKeranjang(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'qty' => 'required|integer|min:1'
        ]);
 
        if ($validator->fails()) {
            return redirect()->route('user.produk.detail', $product->slug)
                        ->withErrors($validator)
                        ->withInput();
        }

        $qty = $request->qty;
        $productCart = Auth::user()->keranjang()->where('product_id', $id)->first();
        if ($productCart) {
            $qty = $request->qty + $productCart->qty;
            $productCart->qty = $qty;
            $productCart->save();
        }else {
            Keranjang::create([
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
                'qty' => $qty
            ]);
        }
        Alert::toast('Berhasil memasukan produk kedalam keranjang', 'success');
        return redirect()->route('user.produk.detail', $product->slug);
    }
}
