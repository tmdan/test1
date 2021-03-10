<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('books')->insertOrIgnore([

            ['title' => "Капитанская дочка"],
            ['title' => "Пиковая дама"],
            ['title' => "Медный всадник (поэма)"],

            ['title' => "Война и мир"],
            ['title' => "Анна Каренина"],
            ['title' => "Исповедь"],
        ]);

        Db::table('author_book')->insertOrIgnore([

            ['book_id' => 1, 'author_id' => 1],
            ['book_id' => 2, 'author_id' => 1],
            ['book_id' => 3, 'author_id' => 1],
            ['book_id' => 3, 'author_id' => 2],

            ['book_id' => 4, 'author_id' => 2],
            ['book_id' => 5, 'author_id' => 2],
            ['book_id' => 6, 'author_id' => 2],
            ['book_id' => 6, 'author_id' => 1],
        ]);
    }
}
