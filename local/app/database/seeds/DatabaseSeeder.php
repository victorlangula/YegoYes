<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('PlanTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('RoleTableSeeder');
		$this->call('PermissionTableSeeder');
		$this->call('AssignedRoleTableSeeder');
		$this->call('AppTypeTableSeeder');
	}

}