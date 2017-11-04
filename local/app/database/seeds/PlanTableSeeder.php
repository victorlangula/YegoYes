<?php

class PlanTableSeeder extends Seeder {

    public function run()
    {
        DB::table('plans')->delete();

        \App\Model\Plan::create(array(
            'name' => 'Free',
            'sort' => 10
        ));

		\App\Model\Plan::create(array(
            'name' => 'Standard',
            'sort' => 20
        ));

		\App\Model\Plan::create(array(
            'name' => 'Deluxe',
            'sort' => 30
        ));

		\App\Model\Plan::create(array(
            'name' => 'Professional',
            'sort' => 40
        ));

    }
}