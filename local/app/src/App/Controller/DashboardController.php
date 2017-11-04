<?php
namespace App\Controller;

use View, Config, Cache, App;

/*
|--------------------------------------------------------------------------
| Dashboard controller
|--------------------------------------------------------------------------
|
| Dashboard related logic
|
*/

class DashboardController extends \BaseController {

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'app.layouts.backend';

    /**
     * Instantiate a new instance.
     */
    public function __construct()
    {
		if(\Auth::check())
		{
			$this->parent_user_id = (\Auth::user()->parent_id == NULL) ? \Auth::user()->id : \Auth::user()->parent_id;
		}
		else
		{
			$this->parent_user_id = NULL;
		}
    }

    /**
     * Show main dashboard
     */
    public function getMainDashboard()
    {
		$hashPrefix = (\Config::get('system.seo', true)) ? '!' : '';
        $username = (\Auth::user()->first_name != '' || \Auth::user()->last_name != '') ? \Auth::user()->first_name . ' ' . \Auth::user()->last_name : \Auth::user()->username;

		if($this->parent_user_id != NULL && \Auth::user()->getRoleId() == 4)
		{
			$user_settings = json_decode(\Auth::user()->settings);
			$app_permissions = (isset($user_settings->app_permissions)) ? $user_settings->app_permissions : array();
			$count_apps = count($app_permissions);
		}
		else
		{
			$count_apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->count();
		}

        View::share('username', $username);
        View::share('count_apps', $count_apps);
        View::share('hashPrefix', $hashPrefix);

        $this->layout->content = View::make('app.loader');
    }

    /**
     * Show dashboard partial
     */
    public function getDashboard()
    {
        $username = (\Auth::user()->first_name != '' || \Auth::user()->last_name != '') ? \Auth::user()->first_name . ' ' . \Auth::user()->last_name : \Auth::user()->username;

		if($this->parent_user_id != NULL && \Auth::user()->getRoleId() == 4)
		{
			$user_settings = json_decode(\Auth::user()->settings);
			$app_permissions = (isset($user_settings->app_permissions)) ? $user_settings->app_permissions : array();

			$apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->whereIn('id', $app_permissions)->orderBy('name', 'asc')->get();
		}
		else
		{
			$apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->get();
		}

        return View::make('app.dashboard.dashboard', array(
            'username' => $username,
            'apps' => $apps
        ));
    }

    /**
     * App JavaScript
     */
    public function getAppJs()
    {
        $translation = \Lang::get('javascript');

		$js = '_lang=[];';
		foreach($translation as $key => $val)
		{
			$js .= '_lang["' . $key . '"]="' . $val . '";';
		}

		$response = \Response::make($js);
		$response->header('Content-Type', 'application/javascript');

		return $response;
    }
}
