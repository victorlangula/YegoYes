<?php
namespace Mobile\Controller;

use Auth, View, Input;

/*
|--------------------------------------------------------------------------
| App controller
|--------------------------------------------------------------------------
|
| CMS App related logic
|
*/

class AppController extends \BaseController {

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
     * New App
     */
    public function newApp()
    {
        return View::make('user.app.new');
    }

    /**
     * Show all apps partial
     */
    public function getApps()
    {
		if($this->parent_user_id != NULL && \Auth::user()->getRoleId() == 4)
		{
			$user_settings = json_decode(\Auth::user()->settings);
			$app_permissions = (isset($user_settings->app_permissions)) ? $user_settings->app_permissions : array();

			$apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->whereIn('id', $app_permissions)->orderBy('name', 'asc')->get();
			$campaigns = \Campaign\Model\Campaign::where('user_id', '=', $this->parent_user_id)->whereIn('id', $apps->lists('campaign_id'))->orderBy('name', 'asc')->get();
		}
		else
		{
			$apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->orderBy('name', 'asc')->get();
			$campaigns = \Campaign\Model\Campaign::where('user_id', '=', $this->parent_user_id)->orderBy('name', 'asc')->get();
		}

		return View::make('app.mobile.apps', array(
			'apps' => $apps,
			'campaigns' => $campaigns
		));
    }

    /**
     * Show QR modal
     */
    public function getQrModal()
    {
        return View::make('app.mobile.modal.qr');
    }

    /**
     * Show app settings modal
     */
    public function getAppSettingsModal()
    {
		$sl = \Request::input('sl', '');
		$qs = \App\Core\Secure::string2array($sl);
   		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

		if (\Auth::user()->parent_id != '')
		{
			$parent_user = \Mobile\Model\App::where('user_id', '=', \Auth::user()->parent_id)->first();
			$plan_settings = $parent_user->plan->settings;
		}
		else
		{
			$plan_settings = \Auth::user()->plan->settings;
		}

		$plan_settings = json_decode($plan_settings);

		$domain = (isset($plan_settings->domain)) ? (boolean) $plan_settings->domain : true;

        return View::make('app.mobile.modal.app-settings', array(
            'app' => $app,
            'sl' => $sl,
            'domain' => $domain
        ));
    }

    /**
     * Show main app
     */
    public function getApp()
    {
		$sl = \Request::input('sl', '');

		if($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);
       		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();
       		$app_pages = $app->appPages->toHierarchy();
       		$campaigns = \Campaign\Model\Campaign::where('user_id', '=', $this->parent_user_id)->orderBy('name', 'asc')->get();
			$widgets = \Mobile\Controller\WidgetController::loadAllWidgetConfig();

			if (\Auth::user()->parent_id != '')
			{
				$parent_user = \Mobile\Model\App::where('user_id', '=', \Auth::user()->parent_id)->first();
				$plan_settings = $parent_user->plan->settings;
			}
			else
			{
				$plan_settings = \Auth::user()->plan->settings;
			}

			$plan_settings = json_decode($plan_settings);
			$plan_widgets = (isset($plan_settings->widgets)) ? $plan_settings->widgets : array();
			if (! isset(\Auth::user()->plan->settings) || \Auth::user()->plan->settings == '') $plan_widgets = false;

			// App limit
			$plan_max_apps = (isset($plan_settings->max_apps)) ? $plan_settings->max_apps : 0;
       		$apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->count();

			$app_limit = ($plan_max_apps != 0 && $apps >= (int) $plan_max_apps) ? true : false;

			$download = (isset($plan_settings->download)) ? (boolean) $plan_settings->download : true;

			return View::make('app.mobile.app-edit', array(
				'sl' => $sl,
				'app' => $app,
				'app_pages' => $app_pages,
				'widgets' => $widgets,
				'campaigns' => $campaigns,
				'plan_widgets' => $plan_widgets,
				'app_limit' => $app_limit,
				'download' => $download
			));
		}
		else
		{
			if(\Auth::user()->parent_id != NULL && \Auth::user()->getRoleId() == 4)
			{
				return View::make('app.auth.no-access');
			}

			// Max apps
			if (\Auth::user()->parent_id != '')
			{
				$parent_user = \Mobile\Model\App::where('user_id', '=', \Auth::user()->parent_id)->first();
				$plan_settings = $parent_user->plan->settings;
			}
			else
			{
				$plan_settings = \Auth::user()->plan->settings;
			}

			$plan_settings = json_decode($plan_settings);
			$plan_max_apps = (isset($plan_settings->max_apps)) ? $plan_settings->max_apps : 0;

			// Current apps
       		$apps = \Mobile\Model\App::where('user_id', '=', $this->parent_user_id)->count();

			if($plan_max_apps != 0 && $apps >= (int) $plan_max_apps)
			{
				return View::make('app.auth.upgrade');
			}

			// App types
			$app_types = \Mobile\Model\AppType::orderBy('sort', 'asc')->remember(\Config::get('cache.ttl'), 'global_app_types')->get();
       		$campaigns = \Campaign\Model\Campaign::where('user_id', '=', $this->parent_user_id)->orderBy('name', 'asc')->get();

			return View::make('app.mobile.app-new', array(
				'app_types' => $app_types,
				'campaigns' => $campaigns
			));
		}
    }

    /**
     * Delete app
     */
    public function getDelete()
    {
		$sl = \Request::input('data', '');
		$qs = \App\Core\Secure::string2array($sl);
   		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

		if(! is_null($app))
		{
			$app->forceDelete();

			// Delete SQLite file(s) from userdata dir
			$userdata = storage_path() . '/userdata/app_' . $app->id . '_*';
			array_map('unlink', glob($userdata));
		}

		return \Response::json(array('result' => 'success'));
    }

    /**
     * Save new App
     */
    public function postNew()
    {
        $name = \Request::get('name');
        $campaign = \Request::get('campaign', NULL);
        $timezone = \Request::get('timezone', 'UTC');
        $language = \Request::get('language', 'en');
        $app_type_id = \Request::get('app_type_id');
        $app_theme = \Request::get('app_theme');

        $app = new \Mobile\Model\App;
        $app->user_id = $this->parent_user_id;
        $app->app_type_id = $app_type_id;
        $app->theme = $app_theme;
        $app->layout = 'tabs-bottom';
        $app->name = $name;
        $app->timezone = $timezone;
        $app->language = $language;

		// Generate App key
		$keyauth = new \App\Core\KeyAuth;
		$keyauth->key_unique = TRUE;
		$keyauth->key_store = TRUE;
		$keyauth->key_chunk = 4;
		$keyauth->key_part = 4;
		$keyauth->key_pre = "";

		$key = $keyauth->generate_key();

        $app->local_domain = $key;

        if($campaign != NULL)
        {
            $campaign = json_decode($campaign);
            if($campaign->id > 0)
            {
                // Campaign already exists, just set campaign_id
                $app->campaign_id = $campaign->id;
            }
            else
            {
                // Campaign doesn't exist yet, add it first
                $new_campaign = new \Campaign\Model\Campaign;
                $new_campaign->user_id = $this->parent_user_id;
                $new_campaign->name = $campaign->text;
                if($new_campaign->save())
                {
                    $app->campaign_id = $new_campaign->id;
                }
            }
        }

        if($app->save())
        {
			$sl = \App\Core\Secure::array2string(array('app_id' => $app->id));

            $response = array(
                'result' => 'success',
                'sl' => $sl
            );
        }
        else
        {
            $response = array(
                'result' => 'error', 
                'result_msg' => $app->errors()->first()
            );
        }

		return \Response::json($response);
    }

    /**
     * Duplicate App
     */
    public function postDuplicate()
    {
		$sl = \Request::input('sl', '');
		$name = \Request::input('name', '');

		if($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);
			$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

			$new_app = $app->replicate();

			// Generate App key
			$keyauth = new \App\Core\KeyAuth;
			$keyauth->key_unique = TRUE;
			$keyauth->key_store = TRUE;
			$keyauth->key_chunk = 4;
			$keyauth->key_part = 4;
			$keyauth->key_pre = "";

			$key = $keyauth->generate_key();

	        $new_app->local_domain = $key;
			$new_app->name = $name;

			$new_app->settings = \App\Core\Settings::json(array(
				'pg_id' => ''
			), $new_app->settings);

			$new_app->save();

			// Replicate pages
			$appPages = \Mobile\Model\AppPage::where('app_id', '=', $qs['app_id'])->orderBy('lft', 'asc')->get();

			foreach ($appPages as $appPage)
			{
				$newPage = $appPage->replicate();
				$newPage->app_id = $new_app->id;
				$newPage->save();

				// Replicate page data
				$widgetData = \Mobile\Model\AppWidgetData::where('app_page_id', '=', $appPage->id)->get();

				foreach ($widgetData as $data)
				{
					$newData = $data->replicate();
					$newData->app_page_id = $newPage->id;
					$newData->save();
				}
			}

			$sl = \App\Core\Secure::array2string(array('app_id' => $new_app->id));
		}

		return \Response::json(array(
                'result' => 'success',
                'sl' => $sl
        ));
	}

    /**
     * Save app settings modal
     */
    public function postAppSettings()
    {
		$sl = \Request::input('sl', '');
		$qs = \App\Core\Secure::string2array($sl);
   		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

        if(count($app) > 0)
        {
            $name = \Request::get('name');
            $domain = \Request::get('domain', NULL);
            $timezone = \Request::get('timezone', 'UTC');
            $language = \Request::get('language', 'en');

			// Social
            $social = \Request::get('social', []);
            $social_size = \Request::get('social_size', 14);
            $social_icons_only = \Request::get('social_icons_only', 0);
            $social_show_count = \Request::get('social_show_count', 0);

            $head_tag = \Request::get('head_tag', '');
            $end_of_body_tag = \Request::get('end_of_body_tag', '');
            $css = \Request::get('css', '');
            $js = \Request::get('js', '');

			// Prevent same domain update
			$url_parts = parse_url(\URL::current());
			if($domain != $url_parts['host']) $app->domain = $domain;

            $app->name = $name;
            $app->timezone = $timezone;
            $app->language = $language;

			// Settings
            $app->settings = \App\Core\Settings::json(array(
            	'social' => $social,
            	'social_size' => $social_size,
            	'social_icons_only' => $social_icons_only,
            	'social_show_count' => $social_show_count,
            	'head_tag' => $head_tag,
            	'end_of_body_tag' => $end_of_body_tag,
            	'css' => $css,
            	'js' => $js
			), $app->settings);

            $app->save();
        }

        return \Response::json(array('result' => 'success'));
    }

    /**
     * Redirect mobile visitors modal
     */
    public function getAppRedirectModal()
    {
		$sl = \Request::input('sl', '');
		$qs = \App\Core\Secure::string2array($sl);
   		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

        return View::make('app.mobile.modal.app-redirect', array(
            'app' => $app,
            'sl' => $sl
        ));
    }

    /**
     * Export app modal
     */
    public function getAppExportModal()
    {
		$sl = \Request::input('sl', '');
		$qs = \App\Core\Secure::string2array($sl);
   		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

		$punycode = new \Punycode();
		$slugify = new \Slugify();

		$punycode_name = $punycode->encode($app->name);
		$filename = $slugify->slugify(urlencode($punycode_name));
		$filename = $filename . '-' . date('Y-m-d');

        return View::make('app.mobile.modal.app-export', array(
            'app' => $app,
            'sl' => $sl,
            'filename' => $filename
        ));
    }
}