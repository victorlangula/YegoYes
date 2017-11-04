<?php

class AppTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('app_types')->delete();

        \Mobile\Model\AppType::create(array(
            'sort' => 10,
            'name' => 'business',
            'icon' => 'fa-shopping-cart',
			'app_icon' => 'store'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 20,
            'name' => 'music',
            'icon' => 'fa-headphones',
			'app_icon' => 'mixpanel'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 30,
            'name' => 'events',
            'icon' => 'fa-calendar',
			'app_icon' => 'calendar'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 40,
            'name' => 'restaurants',
            'icon' => 'fa-cutlery',
			'app_icon' => 'cutlery'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 50,
            'name' => 'blog',
            'icon' => 'fa-comments',
			'app_icon' => 'pen'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 60,
            'name' => 'education',
            'icon' => 'fa-graduation-cap',
			'app_icon' => 'mortarboard'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 70,
            'name' => 'photography',
            'icon' => 'fa-camera-retro',
			'app_icon' => 'diaphragm'
        ));

        \Mobile\Model\AppType::create(array(
            'sort' => 80,
            'name' => 'other',
            'icon' => 'fa-leaf',
			'app_icon' => 'leaf'
        ));

    }
}