<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('authors')->insertOrIgnore([
            ['name' => "Пушкин Александр"],
            ['name' => "Толстой Лев"],
        ]);
    }
}
