<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama = 'Tempred glass android '.Str::random(3);

        $productId = DB::table('products')->insertGetId([
            'nama_barang' => $nama,
            'slug' => Str::slug($nama),
            'active' => 'y',
            'deskripsi' => Str::random(20),
            'harga' => rand(1000, 100000),
            'stok' => rand(1, 100),
            'terjual' => rand(1, 100)
        ]);
        

        for ($i=1; $i <= 4 ; $i++) { 
            DB::table('product_images')->insert([
                'product_id' => $productId,
                'img_product' => 'assets/img/'.$i.'.png'
            ]);
        }
    }
}
