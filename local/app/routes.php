<?php
/*
 |--------------------------------------------------------------------------
 | Installation check (database, permissions)
 |--------------------------------------------------------------------------
 */

\App\Controller\InstallationController::check();

/*
 |--------------------------------------------------------------------------
 | CORS
 |--------------------------------------------------------------------------
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");

/*
 |--------------------------------------------------------------------------
 | Language
 |--------------------------------------------------------------------------
 */

$app_language = \App\Controller\AccountController::appLanguage();
App::setLocale($app_language);

/*
 |--------------------------------------------------------------------------
 | Globals
 |--------------------------------------------------------------------------
 */

$url_parts = parse_url(URL::current());

/*
 |--------------------------------------------------------------------------
 | Front end website
 |--------------------------------------------------------------------------
 */

Route::get('/', function() use($url_parts)
{
    // Check for custom user domain
    $domain = str_replace('www.', '', $url_parts['host']);

    $app = \Mobile\Model\App::where('domain', '=', $domain)
        ->orWhere('domain', '=', 'www.' . $domain)
        ->first();

    if (count($app) > 0)
    {
        // App
        return App::make('\Mobile\Controller\MobileController')->showApp($app->local_domain);
    }
	else
	{
		// Public facing website
		if (\Config::get('system.show_homepage')) 
		{
			return App::make('\App\Controller\WebsiteController')->showWebsite($url_parts);
		}
		else
		{
			return \Redirect::to('platform');
		}
	}
});

/*
 |--------------------------------------------------------------------------
 | API
 |--------------------------------------------------------------------------
 */

Route::group(array('prefix' => 'api/v1'), function()
{
    Route::controller('admin',            'App\Controller\AdminController');
    Route::controller('account',          'App\Controller\AccountController');
    Route::controller('log',              'App\Controller\LogController');
    Route::controller('campaign',         'Campaign\Controller\CampaignController');
    Route::controller('app',              'Mobile\Controller\AppController');
    Route::controller('mobile',           'Mobile\Controller\MobileController');
    Route::controller('app-edit',         'Mobile\Controller\AppEditController');
    Route::controller('app-export',       'Mobile\Controller\ExportController');
    Route::controller('app-asset',        'Mobile\Controller\AssetController');
    Route::controller('app-theme',        'Mobile\Controller\ThemeController');
    Route::controller('stats',            'Stats\Controller\StatsController');
    Route::controller('track',            'Stats\Controller\TrackController');
    Route::controller('help',             'App\Core\Help');
    Route::controller('widget',           'Mobile\Controller\WidgetController');
    Route::controller('thumb',            'App\Core\Thumb');
    Route::controller('oauth',            'App\Controller\oAuthController');
    Route::controller('website',          'App\Controller\WebsiteController');
});

/*
 |--------------------------------------------------------------------------
 | App
 |--------------------------------------------------------------------------
 */

//Dashboard
Route::get( '/platform',                             'App\Controller\DashboardController@getMainDashboard');
Route::get( '/app/dashboard',                        'App\Controller\DashboardController@getDashboard');
Route::get( '/app/javascript',                       'App\Controller\DashboardController@getAppJs');

// Mobile
Route::get( '/app/mobile',                           'Mobile\Controller\AppController@getApps');
Route::get( '/app/app',                              'Mobile\Controller\AppController@getApp');
Route::get( '/app/modal/mobile/qr',   		   	     'Mobile\Controller\AppController@getQrModal');
Route::get( '/app/modal/mobile/app-redirect',   	 'Mobile\Controller\AppController@getAppRedirectModal');
Route::get( '/app/modal/mobile/app-settings',        'Mobile\Controller\AppController@getAppSettingsModal');
Route::get( '/app/modal/mobile/app-export',          'Mobile\Controller\AppController@getAppExportModal');

// Campaigns
Route::get( '/app/campaigns',                        'Campaign\Controller\CampaignController@getCampaigns');
Route::get( '/app/campaign',                         'Campaign\Controller\CampaignController@getCampaign');

// Media
Route::get( '/app/media',                            'Media\Controller\MediaController@getBrowser');
Route::get( '/app/browser',                          'Media\Controller\MediaController@elFinder');

// Profile, team and subscription
Route::get( '/app/profile',                          'App\Controller\AccountController@getProfile');
Route::post('/app/profile',                          'App\Controller\AccountController@postProfile');
Route::get( '/app/modal/avatar',                     'App\Controller\AccountController@getAvatarModal');
Route::get( '/app/users',                            'App\Controller\AccountController@getUsers');
Route::get( '/app/user',                             'App\Controller\AccountController@getUser');
Route::get( '/app/upgrade',                          'App\Controller\AccountController@getUpgrade');
Route::get( '/app/account',                          'App\Controller\AccountController@getAccount');
Route::get( '/app/order-subscription',               'App\Controller\AccountController@getOrderSubscription');
Route::get( '/app/order-subscription-confirm',       'App\Controller\AccountController@getOrderSubscriptionConfirm');
Route::get( '/app/order-subscription-confirmed',     'App\Controller\AccountController@getOrderSubscriptionConfirmed');
Route::get( '/app/modal/account/invoice',            'App\Controller\AccountController@getInvoiceModal');

// Messages
Route::get( '/app/messages',                         'App\Controller\MessageController@getInbox');
Route::get( '/app/message',                          'App\Controller\MessageController@getMessage');

// Stats
Route::get( '/app/stats',                            'Stats\Controller\StatsController@getOverview');

// Log
Route::get( '/app/log',                              'App\Controller\LogController@getLog');

// Help
Route::get( '/app/help/{item}',                      'App\Core\Help@getHelp');

// Admin
Route::get( '/app/admin/users',                      'App\Controller\AdminController@getUsers');
Route::get( '/app/admin/user',                       'App\Controller\AdminController@getUser');
Route::get( '/app/admin/plans',                      'App\Controller\AdminController@getPlans');
Route::get( '/app/admin/plan',                       'App\Controller\AdminController@getPlan');
Route::get( '/app/admin/website',                    'App\Controller\AdminController@getWebsite');
Route::get( '/app/admin/modal/website-settings',     'App\Controller\AdminController@getWebsiteSettingsModal');
Route::get( '/app/admin/purchases',                  'App\Controller\AdminController@getPurchases');

// Demo
Route::get( '/reset/{key}',                          'App\Controller\InstallationController@reset');

/*
 |--------------------------------------------------------------------------
 | Mobile App
 |--------------------------------------------------------------------------
 */

Route::get( '/mobile',                               'Mobile\Controller\AppController@newApp');
Route::get( '/mobile/{local_domain}',                'Mobile\Controller\MobileController@showApp');
Route::get( '/sitemap.xml',                          'Mobile\Controller\SitemapController@showSitemap');
Route::get( '/mobile/{local_domain}/sitemap.xml',    'Mobile\Controller\SitemapController@showSitemap');

/*
 |--------------------------------------------------------------------------
 | Confide routes / authorization
 |--------------------------------------------------------------------------
 */

if (\Config::get('system.allow_registration')) 
{
	Route::get( 'signup',                                'UsersController@create');
	Route::post('signup',                                'UsersController@store');
	Route::get( 'confirm/{code}',                        'UsersController@confirm');
}
Route::get( 'login',                                 'UsersController@login');
Route::post('login',                                 'UsersController@doLogin');
Route::get( 'forgot_password',                       'UsersController@forgotPassword');
Route::post('forgot_password',                       'UsersController@doForgotPassword');
Route::get( 'reset_password/{token}',                'UsersController@resetPassword');
Route::post('reset_password',                        'UsersController@doResetPassword');
Route::get( 'logout',                                'UsersController@logout');

/*
 |--------------------------------------------------------------------------
 | ElFinder File browser
 |--------------------------------------------------------------------------
 */

if(isset($url_parts['path']) && strpos($url_parts['path'], '/elfinder') !== false)
{
    Route::group(array('before' => 'auth'), function()
    {
        if(Auth::check())
        {
            // Set Root dir
            if(Auth::user()->parent_id == NULL)
            {
                $root_dir = \App\Core\Secure::staticHash(Auth::user()->id);
            }
            else
            {
                // Check if user has admin access to media
                if(\Auth::user()->can('user_management'))
                {
                    $root_dir = \App\Core\Secure::staticHash(Auth::user()->parent_id);
                }
                else
                {
                    $Punycode = new Punycode();
                    $user_dir = $Punycode->encode(Auth::user()->username);
                    $root_dir = \App\Core\Secure::staticHash(Auth::user()->parent_id) . '/' . $user_dir;
                }
            }
    
            $root_dir_full = public_path() . '/uploads/user/' . $root_dir;
    
            if(! File::isDirectory($root_dir_full))
            {
                File::makeDirectory($root_dir_full, 0775, true);
            }

			$root = substr(url('/'), strpos(url('/'), \Request::server('HTTP_HOST')));
			$abs_path_prefix = str_replace(\Request::server('HTTP_HOST'), '', $root);

            $roots = array(
                array(
                    'driver'        => 'LocalFileSystem',
                    'path'          => public_path() . '/uploads/user/' . $root_dir,
                    'URL'           => $abs_path_prefix . '/uploads/user/' . $root_dir,
                    'alias'         => trans('global.my_files'),
                    'tmbSize'       => '100',
                    'tmbCrop'       => false,
                    'uploadMaxSize' => '4M',
                    'icon'          => url('packages/barryvdh/laravel-elfinder/img/volume_icon_local.png'),
					'accessControl' => 'access',
					'uploadDeny'    => array('text/x-php'),
                    'attributes' => array(
                        array(
                          'pattern' => '/.tmb/',
                           'read' => false,
                           'write' => false,
                           'hidden' => true,
                           'locked' => false
                        ),
                        array(
                          'pattern' => '/.quarantine/',
                           'read' => false,
                           'write' => false,
                           'hidden' => true,
                           'locked' => false
                        ),
						array( // hide readmes
							'pattern' => '/\.(txt|html|php|py|pl|sh|xml)$/i',
							'read'   => false,
							'write'  => false,
							'locked' => true,
							'hidden' => true
						)
                    )
                /*,
                array(
                    'driver'        => 'LocalFileSystem',
                    'path'          => public_path() . '/stock',
                    'URL'           => '/stock',
                    'defaults'       => array('read' => false, 'write' => false),
                    'alias'         => trans('global.photo_library'),
                    'icon'          => '/packages/barryvdh/laravel-elfinder/img/volume_icon_image.png',
                    'attributes' => array(
                        array(
                            'pattern' => '!^.!',
                            'hidden'  => false,
                            'read'    => true,
                            'write'   => false,
                            'locked'  => true
                        ),
                        array(
                          'pattern' => '/.tmb/',
                           'read' => false,
                           'write' => false,
                           'hidden' => true,
                           'locked' => false
                        ),
                        array(
                          'pattern' => '/.quarantine/',
                           'read' => false,
                           'write' => false,
                           'hidden' => true,
                           'locked' => false
                        )
                    )
                )*/
                )
            );
    
            \Config::set('laravel-elfinder::roots', $roots);

            \Route::get('elfinder/ckeditor4', '\Media\Controller\MediaController@ckEditor');
            \Route::get('elfinder/standalonepopup/{input_id}/{callback?}', '\Media\Controller\MediaController@popUp');
            \Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
        }
    });
}

/*
 |--------------------------------------------------------------------------
 | 404
 |--------------------------------------------------------------------------
 */

App::missing(function($exception) use($url_parts)
{

	/*
	 |--------------------------------------------------------------------------
	 | Public facing website, 404's are managed at the template controller
	 |--------------------------------------------------------------------------
	 */

	return App::make('\App\Controller\WebsiteController')->showWebsite($url_parts);
});