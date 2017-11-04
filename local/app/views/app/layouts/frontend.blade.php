<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8" lang="{{ App::getLocale() }}" ng-app="mainApp" dir="{{ trans('i18n.dir') }}"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8" lang="{{ App::getLocale() }}" ng-app="mainApp" dir="{{ trans('i18n.dir') }}"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie" lang="{{ App::getLocale() }}" ng-app="mainApp" dir="{{ trans('i18n.dir') }}"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ trans('global.app_title') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ url('/assets/css/frontend.css?v=' . Config::get('system.version')) }}" />
	<link rel="stylesheet" href="{{ url('/assets/css/custom/frontend.general.css?v=' . Config::get('system.version')) }}" />

	<!--[if lt IE 9]>
		<script src="{{ url('/assets/js/ie.min.js') }}"></script>
	<![endif]-->
	<script>var init = [];</script>
</head>
<body class="theme-default @yield('body_class')<?php if(\Lang::has('i18n.dir') && trans('i18n.dir') == 'rtl') echo ' right-to-left'; ?>">

@yield('content')

<script src="{{ url('/assets/js/frontend.js?v=' . Config::get('system.version')) }}"></script>
<script type="text/javascript">
init.push(function () {

});
window.CmsAdmin.start(init);
</script>
@yield('page_bottom')
</body>
</html>