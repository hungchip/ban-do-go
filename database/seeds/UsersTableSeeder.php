<?php

use App\Admin;
use App\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate();
        $adminRoles = Roles::where('name','admin')->first();
        $authorRoles = Roles::where('name','author')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
            'admin_name' => 'admin',
            'admin_email' => 'admin@gmail.com',
            'admin_phone' => '0335562246',
            'admin_password' => md5('123456'),
        ]);

        $author = Admin::create([
            'admin_name' => 'author',
            'admin_email' => 'author@gmail.com',
            'admin_phone' => '0335562246',
            'admin_password' => md5('123456'),
        ]);

        $user = Admin::create([
            'admin_name' => 'user',
            'admin_email' => 'user@gmail.com',
            'admin_phone' => '0335562246',
            'admin_password' => md5('123456'),
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        factory(App\Admin::class,20)->create();
    }
}
