<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserType;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'generaltester@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('Dvp12345'),
            'user_type' => UserType::ADMIN->value,
            'status' => '1'
        ]);

         User::create([
            'name' => 'Client User',
            'email' => 'generaltester1@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('Dvp12345'),
            'user_type' => UserType::CLIENT->value,
            'status' => '1'
         ]);
    }
}
/*

Clear command

poweshell:

Clear-History
Remove-Item (Get-PSReadlineOption).HistorySavePath
notepad $PROFILE
Set-PSReadlineOption -HistorySaveStyle SaveNothing
. $PROFILE

linux:
    
history -c

> ~/.bash_history
rm ~/.bash_history

nano ~/.bashrc

# Disable bash history saving
unset HISTFILE
export HISTSIZE=0
export HISTFILESIZE=0

source ~/.bashrc


-----------------------

php artisan db:seed --class=UserSeeder

*/
