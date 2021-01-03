<?php

use Illuminate\Database\Seeder;
use App\Section;
class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create(['name' => 'Thời trang nam']);
        Section::create(['name' => 'Thời trang nữ']);
        Section::create(['name' => 'Thời trang em bé']);
    }
}
