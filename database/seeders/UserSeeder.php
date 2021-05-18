<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(10)
            ->create();

        $user = User::find(1);
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('123456789');
        $user->save();
    }
}
