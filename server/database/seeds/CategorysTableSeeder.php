<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(Category::class, 1)->create();
    }
}
