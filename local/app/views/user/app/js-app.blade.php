<!-- skipmin --><script>

var locale = '{{ \App::getLocale() }}';
var url = '{{ url() }}';

var ngApp = angular.module('ngApp', ['ionic', 'ngResource', 'ngApp.controllers', 'ngApp.services'])

.run(function($ionicPlatform, $rootScope, $ionicLoading) {
    $rootScope.$on('loading:show', function() {
        $ionicLoading.show({
            noBackdrop: false
        });
    });

    $rootScope.$on('loading:hide', function() {
        $ionicLoading.hide();
    });

	$ionicPlatform.ready(function() {
		/* Ready */
	});
})

.config(function($stateProvider, $locationProvider, $urlRouterProvider, $ionicConfigProvider, $httpProvider) {

<?php
if (\Config::get('system.seo', true))
{
?>
	$locationProvider.hashPrefix('!');
		/*.html5Mode(true)*/
<?php
}
?>

	$ionicConfigProvider.backButton.previousTitleText(false).text('');

    $httpProvider.interceptors.push(function($rootScope) {
        return {
            /* http request show loading */
            request: function(config) {
               $rootScope.$broadcast('loading:show');
               return config
            },
            /* Hide loading in case any occurred */
            requestError: function(response) {
               $rootScope.$broadcast('loading:hide');
               return response
            },
            /* Hide loading once got response */
            response: function(response) {
               $rootScope.$broadcast('loading:hide');
               return response
            },
            /* Hide loading if got any response error  */
            responseError: function(response) {
              $rootScope.$broadcast('loading:hide');
              return response
            }
        }
    });

<?php
if($app->layout == 'tabs-bottom')
{
	echo '	$ionicConfigProvider.tabs.position("bottom");';
}
elseif($app->layout == 'tabs-top')
{
	echo '	$ionicConfigProvider.tabs.position("top");';
}
?>

	$stateProvider

	.state('nav', {
		url: '/nav',
		abstract: true,
		templateUrl: '<?php echo url('/api/v1/mobile/view/' . $app->local_domain) ?>',
      	controller: 'NavCtrl'
	})

	.state('nav.widget1', {
	  url: '/widget/:widget/:func/:sl/:id',
	  views: {
		'mainContent': {
		  templateUrl: function(params) { return '<?php echo url('/api/v1/widget/route') ?>/' + params.widget + '/' + params.func + '/' + params.sl + '/' + params.id; }
		}
	  }
	})

	.state('nav.widget2', {
	  url: '/widget/:widget/:func/:sl/:id/:extra',
	  views: {
		'mainContent': {
		  templateUrl: function(params) { return '<?php echo url('/api/v1/widget/route') ?>/' + params.widget + '/' + params.func + '/' + params.sl + '/' + params.id + '/' + params.extra; }
		}
	  }
	})

<?php
$first_slug = '';

foreach($app->appPages as $page)
{
	if($first_slug == '') $first_slug = $page->slug;
	$class = camel_case('c-' . $page->slug);
?>
	.state('nav.<?php echo $page->slug ?>', {
		  url: '/<?php echo $page->slug ?>',
		  class: '<?php echo $class ?>',
		  cache: false,
		  views: {
			'mainContent': {
			  templateUrl: '<?php echo url('/api/v1/mobile/view/' . $app->local_domain . '?_escaped_fragment_=' . $page->slug) ?>',
			  controller: '<?php echo $class ?>Ctrl'
			}
		  }
		})
<?php
}
?>;

	$urlRouterProvider.otherwise('/nav/<?php echo $first_slug ?>');

});

</script>{{--skipmin--}}