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
            'name' => 'Sách kĩ năng sống'
        ]);
        \App\Type::create([
            'name' => 'Sách quản trị- kinh doanh'
        ]);
        \App\Type::create([
            'name' => 'Sách thể thao'
        ]);
        \App\Type::create([
            'name' => 'Sách bình luận văn học'
        ]);
    }
}
