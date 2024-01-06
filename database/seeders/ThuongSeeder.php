<?php

namespace Database\Seeders;

use App\Models\Thuong;
use Illuminate\Database\Seeder;

class ThuongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Thuong::create([
            'ma_thuong'=> 'mathuong00',
            'tien_thuong'=> 0,
        ]);
        Thuong::create([
            'ma_thuong'=> 'mathuong01',
            'tien_thuong'=> 500000,
        ]);
        Thuong::create([
            'ma_thuong'=> 'mathuong02',
            'tien_thuong'=> 1000000,
        ]);
        Thuong::create([
            'ma_thuong'=> 'mathuong03',
            'tien_thuong'=> 1500000,
        ]);
    }
}
