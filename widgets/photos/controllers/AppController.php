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
		$images = \Mobile\Controller\WidgetController::getData($page, 'images', '');
		$images = json_decode($images);

        echo \View::make('widget::app.index')->with([
			'app' => $app,
			'page' => $page,
			'images' => $images
		]);
	}
}