<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Default credentials
        \App\Models\Barang::insert([
            [
                'nama' => 'barang1',
                'jumlah' => '10',
                'harga' => '5000',
            ],
            [
                'nama' => 'barang2',
                'jumlah' => '15',
                'harga' => '3000',
            ],
            [
                'nama' => 'barang3',
                'jumlah' => '17',
                'harga' => '8000',
            ],


        ]);
    }
}
