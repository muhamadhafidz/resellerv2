<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Product_image;
use App\Product_point;
use Illuminate\Http\Request;
use Image;
use Str;
Use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with(['product_images', 'product_points'])->get();

        return view('admin.pages.produk.index', [
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
        return view('admin.pages.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->validate([
            'nama_barang' => 'required|max:255|unique:products,nama_barang',
            'deskripsi' => 'required|max:65000',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'active' => ''
        ]);
        // dd($product);
        $image = $request->validate([
            'image1' => 'required|image|mimes:jpeg,jpg,png',
            'image2' => 'image|mimes:jpeg,jpg,png',
            'image3' => 'image|mimes:jpeg,jpg,png',
            'image4' => 'image|mimes:jpeg,jpg,png',
        ]);

        $min_beli = $request->validate([
            'min_beli1' => 'required|integer|min:1',
            'min_beli2' => 'integer|nullable|gt:min_beli1',
            'min_beli3' => 'integer|nullable|gt:min_beli2',
        ]);

        $persentase = $request->validate([
            'point_persentase1' => 'required_with:min_beli1|integer|max:100',
            'point_persentase2' => 'required_with:min_beli2|integer|nullable|max:100',
            'point_persentase3' => 'required_with:min_beli3|integer|nullable|max:100',
        ]);
        
        if (!isset($product['active'])) {
            $product['active'] = 'n';
        }
        $img1 = $request->file('image1');
        if (!isset($img1)) {
            Alert::toast('Foto produk 1 wajib diisi!', 'warning');
            return redirect()->route('admin.produk.create');
        }
        $product['terjual'] = 0;
        
        // dd($product);
        $product['slug'] = Str::slug($product['nama_barang'], '-');
        $productId = Product::create($product)->id;
        $image['product_id'] = $productId;
        for ( $i = 1 ; $i <= 4 ; $i++) {
            $file = $request->file('image'.$i);
            if (isset($file)) {
                $file_name = $file->getFilename().".".strtolower($file->getClientOriginalExtension());
        
                $file_location = "assets/admin/img/products/";
                $img = Image::make($file);
                // $img->move('assets/user/img/coba', 'aw.jpg');
                $img->save($file_location.$file_name, 60);
                // dd($aw);
                // $stored_file = $file->move($file_location, $file_name);

                $image['img_product'] = $file_location.$file_name;
                // $file_name =$file->getFilename().".".$file->getClientOriginalExtension();
                // $file_location = "assets/admin/img/products";
                // $stored_file = $file->move($file_location, $file_name);
                // $image['dir_photo'] = $stored_file->getPathname();
                Product_image::create($image);
            }
            
        }

        for ($j=1; $j <= 3; $j++) {

            if ($min_beli['min_beli'.$j]) {
                Product_point::create([
                    'product_id' => $productId,
                    'min_beli' => $min_beli['min_beli'.$j],
                    'point_persentase' => $persentase['point_persentase'.$j]
                ]);
            }
        }
        return redirect()->route('admin.produk.index');
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
        $item = Product::with(['product_images', 'product_points'])->findOrFail($id);
        return view('admin.pages.produk.edit', [
            'item' => $item
        ]);
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
        $product = $request->validate([
            'nama_barang' => 'required|max:255|unique:products,nama_barang,'.$id,
            'deskripsi' => 'required|max:65000',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'active' => ''
        ]);
        $image = $request->validate([
            'image1' => 'image|mimes:jpeg,jpg,png',
            'image2' => 'image|mimes:jpeg,jpg,png',
            'image3' => 'image|mimes:jpeg,jpg,png',
            'image4' => 'image|mimes:jpeg,jpg,png',
        ]);

        $min_beli = $request->validate([
            'min_beli1' => 'required|integer|min:1',
            'min_beli2' => 'integer|nullable|gt:min_beli1',
            'min_beli3' => 'integer|nullable|gt:min_beli2',
        ]);

        $persentase = $request->validate([
            'point_persentase1' => 'required_with:min_beli1|integer|max:100',
            'point_persentase2' => 'required_with:min_beli2|integer|nullable|max:100',
            'point_persentase3' => 'required_with:min_beli3|integer|nullable|max:100',
        ]);

        if (!isset($product['active'])) {
            $product['active'] = 'n';
        }

        $product['slug'] = Str::slug($product['nama_barang'], '-');

        $dataP = Product::findOrFail($id);
        $dataP->update($product);

        for ( $i = 1 ; $i <= 4 ; $i++) {
            $file = $request->file('image'.$i);
            $data = Product::findOrFail($id)->product_images()->get();
            if (isset($file)) {
                $file_name = $file->getFilename().".".strtolower($file->getClientOriginalExtension());
        
                $file_location = "assets/admin/img/products/";
                $img = Image::make($file);

                $img->save($file_location.$file_name, 60);

                $image['img_product'] = $file_location.$file_name;
                if (isset($data[$i-1])) {
                    # code...
                    File::delete($data[$i-1]->img_product);
                    $data[$i-1]->update($image);
                }else {
                    $image['product_id'] = $dataP->id;
                    Product_image::create($image);
                }
            }
            
        }
        // dd($detail);
        $product_points = Product_point::where('product_id', $id)->get();
        for ($j=1; $j <= 3; $j++) { 

            if ($min_beli['min_beli'.$j]) {
                if ($j <= $product_points->count()) {
                    $product_points[$j-1]->min_beli = $min_beli['min_beli'.$j];
                    $product_points[$j-1]->point_persentase = $persentase['point_persentase'.$j];
                    $product_points[$j-1]->save();
                }else {
                    Product_point::create([
                        'product_id' => $id,
                        'min_beli' => $min_beli['min_beli'.$j],
                        'point_persentase' => $persentase['point_persentase'.$j]
                    ]);
                }
            }else {
                if ($j <= $product_points->count()) {
                    $product_points[$j-1]->delete();
                }
            }
        }
        return redirect()->route('admin.produk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::with('product_images')->findOrFail($id);

        for ($i=0; $i < 4; $i++) { 
            if (isset($item->product_images[$i])) {
                File::delete($item->product_images[$i]->img_product);
            }
        }

        $item->delete();
        return redirect()->route('admin.produk.index');
    }

    public function setStatus(Request $request)
    {
        $result = [];
        // $id_asisten = [];
        $details = Product::findOrFail($request->id_product);
        if ($details->active == "y") {
            $status = "n";
            $result[0] = 'tidak aktif';
        }else {
            $status = "y";
            $result[0] = 'aktif';
        }
        $details->update([
            'active' => $status
        ]);
        
        $result[1] = $details->nama_barang;
        return response()->json($result);
    }

    public function hapusGambar(Request $request )
    {
        $data = $request->validate([
            'urut' => 'required',
            'id' => 'required'
        ]);
        
        $item = Product::findOrFail($data['id'])->product_images()->take($data['urut'])->get();

        File::delete($item[$data['urut']-1]->img_product);
        $item[$data['urut']-1]->delete();
        return "success";
    }
}
