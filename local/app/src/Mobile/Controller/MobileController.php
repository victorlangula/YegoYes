<?php
namespace Mobile\Controller;

use Auth, View, Input;

/*
|--------------------------------------------------------------------------
| MobileApp controller
|--------------------------------------------------------------------------
|
| Mobile App related logic
|
*/

class MobileController extends \BaseController {

    /**
	 * Construct
     */
    public function __construct()
    {
		if(Auth::check())
		{
			$this->parent_user_id = (Auth::user()->parent_id == NULL) ? Auth::user()->id : Auth::user()->parent_id;
		}
		else
		{
			$this->parent_user_id = NULL;
		}
    }

    /**
     * Render App
     */
    public function showApp($local_domain)
    {
		// Get app
		$app = \Mobile\Model\App::where('local_domain', '=', $local_domain)->first();

		if(empty($app))
		{
			return \Redirect::to('/');
		}

		// Check expiration
		if (isset(\Auth::user()->expires) && \Auth::user()->expires->format("Y-m-d") < \Carbon::now()->format("Y-m-d"))
		{
			return View::make('user.app.message', array(
				'app_title' => trans('admin.account_expired'),
				'app_message' => trans('admin.account_is_expired')
			));
		}

		// Get page
		$page = $app->appPages->first();

        // Obfuscated Link
		$app_hash = \App\Core\Secure::staticHash($app->id);

		// Edit or view
		$edit = false;
		$user = false;

		if(\Auth::check())
		{
			$user = \Auth::user();
			if(\Auth::user()->id == $app->user_id || \Auth::user()->parent_id == $app->user_id)
			{
				$edit = true;
			}
		}

        $app_language = \App\Controller\AccountController::siteLanguage($app);
        \App::setLocale($app_language);

        return View::make('user.app.main', array(
            'app_hash' => $app_hash,
            'edit' => $edit,
            'user' => $user,
            'app' => $app,
            'page' => $page,
            'local_domain' => $local_domain
        ));
    }

    /**
     * Show app view partial
     */
    public function getView($local_domain, $slug = '')
    {
		$hashPrefix = (\Config::get('system.seo', true)) ? '!' : '';
		if ($slug == '') $slug = \Request::get('_escaped_fragment_', '');

		if($local_domain != '' && $slug != '')
		{
       		$app = \Mobile\Model\App::where('local_domain', $local_domain)->first();
       		$page = \Mobile\Model\AppPage::where('app_id', $app->id)->where('slug', $slug)->first();

			// Set app classes based on layout
			if($app->layout == 'tabs-bottom')
			{
				$app->content_classes = 'has-footer';
			}
			elseif($app->layout == 'tabs-top')
			{
				$app->content_classes = 'has-tabs-top';
			}
			else
			{
				$app->content_classes = '';
			}

			// Load widget, namespace views, translation and config
			$widget_dir = public_path() . '/widgets/' . $page->widget;
			\View::addLocation($widget_dir . '/views');
			\View::addNamespace('widget', $widget_dir . '/views');
			\Lang::addNamespace('widget', $widget_dir . '/lang');
			\Config::addNamespace('widget', $widget_dir . '/config');

			require public_path() . '/widgets/' . $page->widget . '/controllers/AppController.php';

            $bg_page = ($page->background_smarthpones_file_name != '') ? ' url("' . $page->background_smarthpones->url() . '")' : 'none';

			return \App::make('\Widget\Controller\AppController')->getIndex($app, $page);
		}

		// Show nav (i.e. tab) when there's no $slug
		if($local_domain != '' && $slug == '')
		{
       		$app = \Mobile\Model\App::where('local_domain', '=', $local_domain)->first();

			return View::make('user.app.nav-' . $app->layout, array(
				'app' => $app,
				'hashPrefix' => $hashPrefix
			));
		}
    }

    /**
     * Get global app CSS
     */
	public function getGlobalCss($hash)
	{
		if($hash != '')
		{
			$app_id = \App\Core\Secure::staticHashDecode($hash);
			$app = \Mobile\Model\App::where('id', $app_id)->first();

			if($app)
			{
				$settings = json_decode($app->settings);
				$css = (isset($settings->css)) ? $settings->css : '';
				$response = \Response::make($css, 200);
				$response->header('Content-Type', 'text/css');
				return $response;
			}
		}
	}

    /**
     * Get global app JavaScript
     */
	public function getGlobalJs($hash)
	{
		if($hash != '')
		{
			$return = '';
			$app_id = \App\Core\Secure::staticHashDecode($hash);
			$app = \Mobile\Model\App::where('id', $app_id)->first();

			if($app)
			{
				$settings = json_decode($app->settings);
				$return .= (isset($settings->js)) ? $settings->js : '';
				$response = \Response::make($return, 200);
				$response->header('Content-Type', 'text/javascript');
				return $response;
			}
		}
	}
}