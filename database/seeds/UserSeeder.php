<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insert('13686840083', '123456');
        $this->insert('13686840082', '123456');
    }

    public function insert(string $phone, string $password)
    {
        app(\App\Repository\User\UserRepository::class)->addUser([
            'name'=>randomEnSTR(mt_rand(10,18)),
            'phone' => $phone,
            'password' => $password,
            'avatar' => 'https://lorempixel.com/200/200/cats/?74058',
            'signature' => '我就是我,不一样的烟火'
        ]);
    }
}
