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
		$api_key = \Config::get('widget::api.api_key');
		$channel_url = \Mobile\Controller\WidgetController::getData($page, 'channel_url', trans('widget::global.default_channel'));
		$playlist_url = \Mobile\Controller\WidgetController::getData($page, 'playlist_url', trans('widget::global.default_playlist'));
		$tab = \Mobile\Controller\WidgetController::getData($page, 'tab', 'uploads');
		$columns = \Mobile\Controller\WidgetController::getData($page, 'columns', '1');
		$max_results = \Mobile\Controller\WidgetController::getData($page, 'max_results', '15');

        echo \View::make('widget::app.index')->with([
			'app' => $app,
			'page' => $page,
			'api_key' => $api_key,
			'channel_url' => $channel_url,
			'playlist_url' => $playlist_url,
			'tab' => $tab,
			'columns' => $columns,
			'max_results' => $max_results
		]);
	}
}