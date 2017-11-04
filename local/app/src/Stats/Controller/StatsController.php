<?php
namespace Stats\Controller;

use View, Auth, Input, Cache;

/*
|--------------------------------------------------------------------------
| Statistics controller
|--------------------------------------------------------------------------
|
| Stats related logic
|
*/

class StatsController extends \BaseController {

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
     * Show stats
     */
    public function getOverview()
    {
        // Security link
		$sl = Input::get('sl', '');

        // Range
		$date_start = Input::get('start', date('Y-m-d', strtotime(' - 30 day')));
		$date_end = Input::get('end', date('Y-m-d'));

        // All apps, joined with campaigns
		if($this->parent_user_id != NULL && \Auth::user()->getRoleId() == 4)
		{
			$user_settings = json_decode(\Auth::user()->settings);
			$app_permissions = (isset($user_settings->app_permissions)) ? $user_settings->app_permissions : array();

			$apps = \Mobile\Model\App::where('apps.user_id', '=', $this->parent_user_id)
				->leftJoin('campaigns as c', 'apps.campaign_id', '=', 'c.id')
				->select(array('apps.*', 'c.name as campaign_name'))
				->whereIn('apps.id', $app_permissions)
				->orderBy('campaign_name', 'asc')
				->orderBy('apps.name', 'asc')
				->get();
		}
		else
		{
			$apps = \Mobile\Model\App::where('apps.user_id', '=', $this->parent_user_id)
				->leftJoin('campaigns as c', 'apps.campaign_id', '=', 'c.id')
				->select(array('apps.*', 'c.name as campaign_name'))
				->orderBy('campaign_name', 'asc')
				->orderBy('apps.name', 'asc')
				->get();
		}

		$apps_array = array();
		$apps_array_ids = array();
		$app_pages_array = array();
		foreach($apps as $app)
		{
			$apps_array[] = $app;
			$apps_array_ids[] = $app->id;
			$app_pages_array = array_merge($app_pages_array, $app->appPages->toArray());
		}

		$first_created = false;
		$campaigns = array();

		if(count($apps) > 0)
		{
			foreach($apps as $app)
			{
				$campaigns[$app->campaign_name][$app->name] = $app;
				$app_created = $app->created_at->timezone(Auth::user()->timezone)->format("Y-m-d");
				if($app_created < $first_created || $first_created == false) $first_created = $app_created;
			}
		}

		// Selected app
		$app_created = false;
		$campaign = false;
		$campaign_apps = false;
		$app = false;

        if($sl != '')
        {
			$first_created = false;
			$apps_array = array();
			$apps_array_ids = array();
			$app_pages_array = array();

            $qs = \App\Core\Secure::string2array($sl);

			if(isset($qs['campaign_id']))
			{
				$campaign = \Campaign\Model\Campaign::where('id', '=', $qs['campaign_id'])
					->where('user_id', '=', $this->parent_user_id)
					->first();

				if($this->parent_user_id != NULL && \Auth::user()->getRoleId() == 4)
				{
					$campaign_apps = \Mobile\Model\App::where('campaign_id', '=', $qs['campaign_id'])
						->where('user_id', '=', $this->parent_user_id)
						->whereIn('id', $app_permissions)
						->get();
				}
				else
				{
					$campaign_apps = \Mobile\Model\App::where('campaign_id', '=', $qs['campaign_id'])
						->where('user_id', '=', $this->parent_user_id)
						->get();
				}

				foreach($campaign_apps as $campaign_app)
				{
					$campaign_app_created = $campaign_app->created_at->timezone(Auth::user()->timezone)->format("Y-m-d");
					if($campaign_app_created < $first_created || $first_created == false) $first_created = $campaign_app_created;
					$apps_array[] = $campaign_app;
					$apps_array_ids[] = $campaign_app->id;
					$app_pages_array = array_merge($app_pages_array, $campaign_app->appPages->toArray());
				}
			}
			elseif($qs['app_id'])
			{
				$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();
				$app_created = $app->created_at->timezone(Auth::user()->timezone)->format("Y-m-d");
				if($app_created < $first_created || $first_created == false) $first_created = $app_created;

				$campaign = \Campaign\Model\Campaign::where('id', '=', $app->campaign_id)
					->where('user_id', '=', $this->parent_user_id)
					->first();

				$apps_array[] = $app;
				$apps_array_ids[] = $app->id;
				$app_pages_array = array_merge($app_pages_array, $app->appPages->toArray());
			}
        }

        // Load widgets to check permissions
        $plan_id = (\Auth::user()->parent_id == NULL) ? \Auth::user()->plan_id : \User::find(\Auth::user()->parent_id)->plan_id;

        $widget = \Mobile\Controller\WidgetController::loadWidgetConfig('forms');
        $widget_allow['forms'] = ($widget['active'] && in_array($plan_id, $widget['plans'])) ? true : false;

        $widget = \Mobile\Controller\WidgetController::loadWidgetConfig('coupons');
        $widget_allow['coupons'] = ($widget['active'] && in_array($plan_id, $widget['plans'])) ? true : false;

		// Get app stats for given period
		$app_stats = \Stats\Controller\TrackController::getVisits($apps_array, $date_start, $date_end);

		//$stats_found = (count($widgets_overview) == 0) ? false : true;
		$stats_found = true;

        return View::make('app.stats.overview', array(
			'sl' => $sl,
			'date_start' => $date_start,
			'date_end' => $date_end,
			'apps' => $apps,
			'apps_array' => $apps_array,
			'apps_array_ids' => $apps_array_ids,
			'campaigns' => $campaigns,
			'campaign' => $campaign,
			'campaign_apps' => $campaign_apps,
			'app' => $app,
			'first_created' => $first_created,
			'stats_found' => $stats_found,
			'widget_allow' => $widget_allow,
			'app_stats' => $app_stats
		));
    }

    /**
     * Get visits for specific app
     */
    public static function getVisits()
    {
        // Security link        
		$sl = Input::get('sl', '');

        if($sl != '')
        {
			// Range
			$date_start = Input::get('start', date('Y-m-d', strtotime(' - 30 day')));
			$date_end = Input::get('end', date('Y-m-d'));

            $qs = \App\Core\Secure::string2array($sl);

			$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->first();
			$date_start = $app->created_at->timezone(\Auth::user()->timezone)->format("Y-m-d");

			$app_stats = \Stats\Controller\TrackController::getVisitsOnly([$app], $date_start, $date_end);

			$visits = (isset($app_stats['apps'][0]['total'])) ? $app_stats['apps'][0]['total'] : 0;
			$visits = number_format($visits, 0, trans('i18n.dec_point'), trans('i18n.thousands_sep'));

			return \Response::json(array('visits' => $visits));
		}
	}

    /**
     * Get date range
	 * \Stats\Controller\StatsController::getRange($date_start, $date_end);
     */
    public static function getRange($strDateFrom, $strDateTo)
    {
		$aryRange=array();

		$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
		$iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
	
		if ($iDateTo >= $iDateFrom)
		{
			array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
			while ($iDateFrom < $iDateTo)
			{
				$iDateFrom +=86400; // add 24 hours
				array_push($aryRange, date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}
}