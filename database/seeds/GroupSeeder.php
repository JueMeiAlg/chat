<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insert();
    }

    public function insert()
    {
        \App\Models\Chat\Group::query()->create([
            'name'=>'系统默认交流群',
            'max_person'=>5000,
            'photo'=>'https://lorempixel.com/200/200/cats/?88184'
        ]);
    }
}
