<?php

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $role_admin = Role::create(array(
            'name' => 'Owner'
        ));

        Role::create(array(
            'name' => 'Admin'
        ));

        Role::create(array(
            'name' => 'Manager'
        ));

        Role::create(array(
            'name' => 'User'
        ));
    }
}