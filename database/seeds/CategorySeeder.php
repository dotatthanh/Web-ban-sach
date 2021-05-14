<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create([
            'name' => 'Sách Tiếng Việt'
        ]);
        \App\Category::create([
            'name' => 'Sách Tiếng Anh'
        ]);
        \App\Category::create([
            'name' => 'Sách đang khuyến mãi'
        ]);
        \App\Category::create([
            'name' => 'Sách văn học nước ta'
        ]);
    }
}
