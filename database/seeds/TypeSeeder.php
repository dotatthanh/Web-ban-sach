<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Type::create([
            'name' => 'Sách kĩ năng sống',
            'code' => 'TL1'
        ]);
        \App\Type::create([
            'name' => 'Sách quản trị- kinh doanh',
            'code' => 'TL2'
        ]);
        \App\Type::create([
            'name' => 'Sách thể thao',
            'code' => 'TL3'
        ]);
        \App\Type::create([
            'name' => 'Sách bình luận văn học',
            'code' => 'TL4'
        ]);
    }
}
