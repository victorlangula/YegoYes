<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8" lang="{{ App::getLocale() }}" ng-app="cmsApp" dir="{{ trans('i18n.dir') }}"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8" lang="{{ App::getLocale() }}" ng-app="cmsApp" dir="{{ trans('i18n.dir') }}"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie" lang="{{ App::getLocale() }}" ng-app="cmsApp" dir="{{ trans('i18n.dir') }}"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ trans('global.app_title') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<link rel="stylesheet" href="{{ url('/assets/css/app.css?v=' . Config::get('system.version')) }}" />
	<link rel="stylesheet" href="{{ url('/assets/css/custom/app.general.css?v=' . Config::get('system.version')) }}" />
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />

	<!--[if lt IE 9]>
		<script src="{{ url('/assets/js/ie.min.js') }}"></script>
	<![endif]-->

	<script src="{{ url('/app/javascript?lang=' . \App::getLocale()) }}"></script>
	<script>var init = [];var app_root = '{{ url('/') }}';var hashPrefix = '{{ $hashPrefix }}';</script>
</head>
<body class="theme-white main-menu-animated main-navbar-fixed main-menu-fixed<?php if(\Lang::has('i18n.dir') && trans('i18n.dir') == 'rtl') echo ' right-to-left'; ?>" ng-class="{
	'page-mail': $route.current.active == 'messages' || $route.current.active == 'message', 
	'page-profile': $route.current.active == 'profile' || $route.current.active == 'users' || $route.current.active == 'user-edit', 
	'page-profile-user': $route.current.active == 'user-new', 
	'page-edit-site': $route.current.active_sub == 'edit-site', 
	'page-pricing': $route.current.active == 'account', 
	'page-invoice': $route.current.active_sub == 'invoice'
}" ng-controller="MainNavCtrl">
<div class="modal fade" id="ajax-modal" data-backdrop="static" data-keyboard="true" tabindex="-1"></div>
<div class="modal fade" id="ajax-modal2" data-backdrop="static" data-keyboard="true" tabindex="-1"></div>
<div id="main-wrapper">
	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">{{ trans('global.hide_menu') }}</span></button>
		
		<div class="navbar-inner">
			<div class="navbar-header">
				<a href="#/" class="navbar-brand">
					<div></div>
					{{ trans('global.app_title') }}
				</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
			</div>

			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
				<div>

					<div class="right clearfix">
						<ul class="nav navbar-nav pull-right right-navbar-nav">
							<li id="msg-saved" class="bg-success">
								<a class="no-link text-danger"><i class="fa fa-circle-o-notch fa-spin"></i>&nbsp; Saved</span></a>
							</li>
<?php /*
							<li>
								<a class="no-link"><i class="fa fa-clock-o"></i> <span id="current-time"></span></a>
							</li>
							<li>
								<a class="no-link"><i class="fa fa-calendar-o"></i> <span id="current-date"></span></a>
							</li>

                            <li>
                                <form class="navbar-form pull-left">
                                    <input type="text" class="form-control" placeholder="Search">
                                </form>
                            </li>
*/ ?>
<?php
$languages = \App\Controller\AccountController::getLanguages();

if(count($languages) > 1)
{
?>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag"></i> {{ trans('i18n.language_title') }} <span class="caret"></span></a>
								<ul class="dropdown-menu">
<?php
foreach($languages as $language)
{
    $active = ($language['active']) ? ' class="active"' : '';
    echo '<li' . $active . '><a onclick="switchLanguage(\'' . $language['code'] . '\');" href="javascript:void(0);">' . $language['title'] . '</a></li>';
}
?>
								</ul>
							</li>
<?php } ?>
							<li class="dropdown">
								<a class="dropdown-toggle user-menu" data-toggle="dropdown">
									<img src="{{ App\Controller\AccountController::getAvatar(32) }}" class="avatar-32">
									<span>{{ $username }}</span>
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
<?php
if(\Auth::user()->parent_id == NULL)
{
?>
									<li><a href="#/account"><i class="dropdown-icon fa fa-trophy"></i> {{ \Auth::user()->plan->name }}</a></li>
<?php } ?>
									<li><a href="#/profile"><i class="dropdown-icon fa fa-user"></i> {{ trans('global.my_profile') }}</a></li>
									<li class="divider"></li>
									<li><a href="{{ url('/logout') }}"><i class="dropdown-icon fa fa-power-off"></i> {{ trans('global.logout') }}</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="main-menu" role="navigation">
		<div id="main-menu-inner">
			<div class="menu-content top" id="menu-content-demo">
				<div>
					<div class="text-bg"><span class="text-semibold">{{ $username }}</span></div>
					<a href="#/profile"><img src="{{ App\Controller\AccountController::getAvatar(128) }}" height="54" width="54" class="avatar-32"></a>
					<div class="btn-group">
						<a href="#/profile" class="btn btn-xs btn-primary btn-outline dark" title="{{ trans('global.my_profile') }}"><i class="fa fa-user"></i></a>
						<a href="{{ url('/logout') }}" class="btn btn-xs btn-danger btn-outline dark" title="{{ trans('global.logout') }}"><i class="fa fa-power-off"></i></a>
					</div>
				</div>
			</div>
			<ul class="navigation">
				<li ng-class="{'active': $route.current.active == 'dashboard'}">
					<a href="#/"><i class="menu-icon fa fa-dashboard" style="top:1px"></i><span class="mm-text">{{ trans('global.dashboard') }}</span></a>
				</li>

                <li ng-class="{'active': $route.current.active == 'apps'}">
                    <a href="#/apps"><i class="menu-icon fa fa-th"></i><span class="mm-text">{{ trans('global.apps') }}</span><span class="label label-primary" id="count_apps">{{ $count_apps }}</span></a>
                </li>

                <li ng-class="{'active': $route.current.active == 'stats'}">
                    <a href="#/stats"><i class="menu-icon fa fa-line-chart"></i><span class="mm-text">{{ trans('global.data_and_statistics') }}</span></a>
                </li>

				<li ng-class="{'active': $route.current.active == 'media'}">
					<a href="#/media"><i class="menu-icon fa fa-cloud-upload"></i><span class="mm-text">{{ trans('global.media') }}</span></a>
				</li>

				<li class="mm-dropdown" ng-class="{'open': $route.current.active == 'profile' || $route.current.active == 'campaigns' || $route.current.active == 'account' || $route.current.active == 'subscription' || $route.current.active == 'log' || $route.current.active == 'users' || $route.current.active == 'user-new' || $route.current.active == 'user-edit'}">
					<a href="javascript:void(0);"><i class="menu-icon fa fa-sliders"></i><span class="mm-text">{{ trans('global.settings') }}</span></a>
					<ul>

						<li ng-class="{'active': $route.current.active == 'profile'}">
							<a href="#/profile"><i class="menu-icon fa fa-user"></i><span class="mm-text">{{ trans('global.profile') }}</span></a>
						</li>
<?php
if(\Auth::user()->can('user_management'))
{
?>
						<li ng-class="{'active': $route.current.active == 'users' || $route.current.active == 'user-new' || $route.current.active == 'user-edit'}">
							<a href="#/users"><i class="menu-icon fa fa-users"></i><span class="mm-text">{{ trans('global.team') }}</span></a>
						</li>
<?php
if(\Auth::user()->parent_id == NULL)
{
?>
						<li ng-class="{'active': $route.current.active == 'subscription' || $route.current.active == 'account'}">
							<a href="#/account"><i class="menu-icon fa fa-credit-card"></i><span class="mm-text">{{ trans('global.account') }}</span></a>
						</li>
<?php
}
?>
						<li ng-class="{'active': $route.current.active == 'log'}">
							<a href="#/log"><i class="menu-icon fa fa-history"></i><span class="mm-text">{{ trans('global.log') }}</span></a>
						</li>
<?php
}
?>
<?php
if(\Auth::user()->getRoleId() != 4)
{
?>
						<li ng-class="{'active': $route.current.active == 'campaigns'}">
							<a href="#/campaigns"><i class="menu-icon fa fa-share-alt"></i><span class="mm-text">{{ trans('global.campaigns') }}</span></a>
						</li>
<?php
}
?>
					</ul>
				</li>
<?php
if(\Auth::user()->can('system_management'))
{
?>
                <li class="mm-dropdown" ng-class="{'open': $route.current.active == 'admin-users' || $route.current.active == 'admin-plans' || $route.current.active == 'admin-purchases' || $route.current.active == 'admin-website'}">
                    <a href="javascript:void(0);"><i class="menu-icon fa fa-wrench"></i><span class="mm-text">{{ trans('admin.system_administration') }}</span></a>
                    <ul>
                        <li ng-class="{'active': $route.current.active == 'admin-users'}">
                            <a href="#/admin/users"><i class="menu-icon fa fa-database"></i><span class="mm-text">{{ trans('admin.user_administration') }}</span></a>
                        </li>
                        <li ng-class="{'active': $route.current.active == 'admin-purchases'}">
                            <a href="#/admin/purchases"><i class="menu-icon fa fa-money"></i><span class="mm-text">{{ trans('admin.purchases') }}</span></a>
                        </li>
                        <li ng-class="{'active': $route.current.active == 'admin-plans'}">
                            <a href="#/admin/plans"><i class="menu-icon fa fa-trophy"></i><span class="mm-text">{{ trans('admin.user_plans') }}</span></a>
                        </li>
                        <li ng-class="{'active': $route.current.active == 'admin-website'}">
                            <a href="#/admin/website"><i class="menu-icon fa fa-globe"></i><span class="mm-text">{{ trans('admin.website') }}</span></a>
                        </li>
<?php
if(Auth::user()->can('system_management') && Auth::user()->id == 1 && ! \Config::get('app.demo'))
{
?>
                        <li>
                            <a href="javascript:void(0);" id="btn-reset-system"><i class="menu-icon fa fa-exclamation-triangle text-danger"></i><span class="mm-text text-danger">System Reset</span></a>
                        </li>


<script type="text/javascript">

init.push(function () {

$('#btn-reset-system').on('click', function() {

    if(confirm('This feature is only available for the root user. This will delete all cache, database data and user uploaded files and return a clean installation. Are you sure you want to reset the complete system?'))
    {
        if(confirm('[WARNING] Are you really sure you want to DELETE ALL DATA? NEVER DO THIS ON A PRODUCTION SYSTEM!'))
        {
            if(confirm('Please confirm one last time you are sure you want to reset the complete system and all its data.'))
            {
                blockUI();

                var request = $.ajax({
                  url: "{{ url('/api/v1/account/reset-system') }}",
                  type: 'POST',
                  data: {},
                  dataType: 'json'
                });

                request.done(function(json) {
                    document.location = '/';
                });

                request.fail(function(jqXHR, textStatus) {
                    alert('Request failed, please try again (' + textStatus + ')');
                    unblockUI();
                });
            }
        }
    }

});

});
</script>
<?php
}
?>
                    </ul>
                </li>
<?php
}
?>
				<li>
					<a href="{{ url('/logout') }}"><i class="menu-icon fa fa-power-off"></i><span class="mm-text">{{ trans('global.logout') }}</span></a>
				</li>
			</ul>

		</div>
	</div>

	<div id="content-wrapper" ng-view>
		@yield('content')
	</div>
	<div id="main-menu-bg"></div>
</div>

<script src="{{ url('/assets/js/app.js?v=' . Config::get('system.version')) }}"></script>
<script src="{{ url('/api/v1/app-edit/icon-js?v=' . Config::get('system.version')) }}"></script>
<script src="{{ url('/assets/js/custom/app.angular.js?v=' . Config::get('system.version')) }}"></script>
<script src="{{ url('/assets/js/custom/app.general.js?v=' . Config::get('system.version')) }}"></script>
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

<script type="text/javascript">
<?php /*
init.push(function () {
	var monthNames = ['<?php echo trans('global.january') ?>', '<?php echo trans('global.february') ?>', '<?php echo trans('global.march') ?>', '<?php echo trans('global.april') ?>', '<?php echo trans('global.may') ?>', '<?php echo trans('global.june') ?>', '<?php echo trans('global.july') ?>', '<?php echo trans('global.august') ?>', '<?php echo trans('global.september') ?>', '<?php echo trans('global.october') ?>', '<?php echo trans('global.november') ?>', '<?php echo trans('global.december') ?>'];
	var monthNamesAbbr = ['<?php echo trans('global.january_abbr') ?>', '<?php echo trans('global.february_abbr') ?>', '<?php echo trans('global.march_abbr') ?>', '<?php echo trans('global.april_abbr') ?>', '<?php echo trans('global.may_abbr') ?>', '<?php echo trans('global.june_abbr') ?>', '<?php echo trans('global.july_abbr') ?>', '<?php echo trans('global.august_abbr') ?>', '<?php echo trans('global.september_abbr') ?>', '<?php echo trans('global.october_abbr') ?>', '<?php echo trans('global.november_abbr') ?>', '<?php echo trans('global.december_abbr') ?>'];

	var dayNamesAbbr = ['<?php echo trans('global.su') ?>', '<?php echo trans('global.mo') ?>', '<?php echo trans('global.tu') ?>', '<?php echo trans('global.we') ?>', '<?php echo trans('global.th') ?>', '<?php echo trans('global.fr') ?>', '<?php echo trans('global.sa') ?>'];
	var dayNames = ['<?php echo trans('global.sunday') ?>', '<?php echo trans('global.monday') ?>', '<?php echo trans('global.tuesday') ?>', '<?php echo trans('global.wednesday') ?>', '<?php echo trans('global.thursday') ?>', '<?php echo trans('global.friday') ?>', '<?php echo trans('global.saturday') ?>'];

	var newDate = new Date();
	newDate.setDate(newDate.getDate());

	appSetTime();

	setInterval(appSetTime, 1000);

	function appSetTime()
	{
		$('#current-time').html(new Date().toLocaleTimeString(navigator.language, {hour: '2-digit', minute:'2-digit'}));
		$('#current-date').html(monthNames[newDate.getMonth()] + ' ' + newDate.getDate() + ', ' + newDate.getFullYear());
	}
});
*/ ?>
window.CmsAdmin.start(init);
</script>

@yield('page_bottom')
</body>
</html>