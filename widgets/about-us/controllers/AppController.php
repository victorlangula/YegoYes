<?php
namespace Widget\Controller;

/*
|--------------------------------------------------------------------------
| Widget app controller
|--------------------------------------------------------------------------
|
| App related logic
|
*/

class AppController extends \BaseController {

    /**
	 * Construct
     */
    public function __construct()
    {
    }

    /**
     * Main view
     */
    public function getIndex($app, $page)
    {
		$image = \Mobile\Controller\WidgetController::getData($page, 'image');
		$list = \Mobile\Controller\WidgetController::getData($page, 'list', trans('widget::global.list_default'));
		$list = json_decode($list);
		$social_share = (boolean) \Mobile\Controller\WidgetController::getData($page, 'social_share', 0);

        echo \View::make('widget::app.index')->with([
			'app' => $app,
			'page' => $page,
			'image' => $image,
			'page' => $page,
			'list' => $list,
			'social_share' => $social_share
		]);
	}
}