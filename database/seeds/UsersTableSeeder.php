<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table('users')->delete();
        DB::table('roles')->delete();

        DB::statement("ALTER table roles  AUTO_INCREMENT =  1");

        DB::statement("ALTER table users  AUTO_INCREMENT =  1");

        DB::statement("ALTER table roles_user  AUTO_INCREMENT =  1");

        DB::statement("ALTER table permissions_role  AUTO_INCREMENT =  1");

        $user_id = DB::table('users')->insertGetId([
            'name'=>'Admin',
            'email'=>'chuminhhiep0211@gmail.com',
            'password'=>Hash::make('123456'),
            'is_active'=>1
        ]);
        $role_id = DB::table('roles')->insert([
            'name'=>'Admin',
            'display_name'=>'Quản lý'
        ]);
        DB::table('roles_user')->insert([
            'user_id' => $user_id,
            'role_id'=> $role_id
        ]);
        DB::table('permissions_role')->insert([
            [   'role_id' => $role_id,
                'permission_id'=> '42'
            ],
            [   'role_id' => $role_id,
                'permission_id'=> '43'
            ],
            [   'role_id' => $role_id,
                'permission_id'=> '44'
            ]
        ]
        );
    }
}
