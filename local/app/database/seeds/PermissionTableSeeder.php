<?php

class PermissionTableSeeder extends Seeder {

    public function run()
    {
        DB::table('permissions')->delete();

		// Permissions
        $system_management = Permission::create(array(
            'name' => 'system_management',
            'display_name' => 'System Management'
        ));

        $user_management = Permission::create(array(
            'name' => 'user_management',
            'display_name' => 'User Management'
        ));

        $general_management = Permission::create(array(
            'name' => 'general_management',
            'display_name' => 'General Management'
        ));

		// Attach to role
		$owner = Role::find(1);
		$owner->perms()->sync(array(
            $system_management->id, 
            $user_management->id,
            $general_management->id
        ));

		$admin = Role::find(2);
		$admin->perms()->sync(array(
            $user_management->id,
            $general_management->id
        ));

		$manager = Role::find(3);
		$manager->perms()->sync(array(
            $general_management->id
        ));
    }
}