<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Point;
use Illuminate\Http\Request;
use Image;
use File;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Point::get();

        return view('admin.pages.point.index', [
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
        return view('admin.pages.point.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $point = $request->validate([
            'nama' => 'required|max:255|unique:points,nama',
            'detail' => 'required|max:255',
            'req_point' => 'required|integer'
        ]);
        // dd($product);
        $image = $request->validate([
            'img_point' => 'required|image|mimes:jpeg,jpg,png'
        ]);

        
        $image_point = $request->file('img_point');
        if (!isset($image_point)) {
            Alert::toast('gambar point wajib diisi!', 'warning');
            return redirect()->route('admin.point.create');
        }else {
            $file_name = $image_point->getFilename().".".strtolower($image_point->getClientOriginalExtension());
        
            $file_location = "assets/admin/img/points/";
            $img = Image::make($image_point);
            
            $img->save($file_location.$file_name, 60);

            $image['img_point'] = $file_location.$file_name;
        }

        Point::create([
            'nama' => $point['nama'],
            'detail' => $point['detail'],
            'req_point' => $point['req_point'],
            'img_point' => $image['img_point']
        ]);

        return redirect()->route('admin.point.index');
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
        $item = Point::findOrFail($id);
        return view('admin.pages.point.edit', [
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
        $point = $request->validate([
            'nama' => 'required|max:255|unique:points,nama,'.$id,
            'detail' => 'required|max:255',
            'req_point' => 'required|integer'
        ]);
        // dd($product);
        $image = $request->validate([
            'img_point' => 'image|mimes:jpeg,jpg,png'
        ]);

        $dPoint = Point::findOrFail($id);
        $dPoint->update($point);

        $image_point = $request->file('img_point');
        if (isset($image_point)) {
            $file_name = $image_point->getFilename().".".strtolower($image_point->getClientOriginalExtension());
        
            $file_location = "assets/admin/img/points/";
            $img = Image::make($image_point);
            
            $img->save($file_location.$file_name, 60);

            $image['img_point'] = $file_location.$file_name;

            File::delete($dPoint->img_point);
            $dPoint->update($image);
        }

        return redirect()->route('admin.point.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Point::findOrFail($id);

        File::delete($item->img_point);

        $item->delete();
        return redirect()->route('admin.point.index');
    }
}
