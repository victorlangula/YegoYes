@extends('../app.layouts.partial')

@section('content')

<h3 class="text-center" style="margin:41px 0 20px;">{{ trans('global.welcome_user', ['name' => $username]) }}</h3>

<hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t" style="margin-bottom:12px;">
<style type="text/css">
#carousel_dashboard .owl-prev,
#carousel_dashboard .owl-next {
    top:62px;
}
#carousel_dashboard .owl-buttons i {
	font-size:92px !important;
}
</style>
        <div class="row text-center">
            <div class="col-xs-4 col-xs-offset-4">
<?php
if(count($apps) > 1)
{
?>
                <wrap-owlcarousel class="owl-carousel" id="carousel_dashboard"  
                    data-options="{
                        navigation: true,
                        navigationText: ['<i class=\'car-btn-prev fa fa-angle-left\'></i>', '<i class=\'car-btn-next fa fa-angle-right\'></i>'],
                        items: 1,
                        autoWidth:true,
                        autoPlay:4000,
                        stopOnHover:true,
                        itemsDesktop: [1199,1],
                        itemsDesktopSmall: [979,1],
                        itemsTablet: [768,1],
                        itemsTabletSmall: false,
                        itemsMobile: [479,1],
                        mouseDrag: false,
                        touchDrag: false,
                        loop: true
                    }" style="margin-top:10px">
<?php
foreach($apps as $app)
{
    $sl = \App\Core\Secure::array2string(array('app_id' => $app['id']));
?>
            <div>
                <h4 class="ellipsis-oneline" style="margin:0 0 19px 0">{{ $app->name }}</h4>
                <a href="#/app/{{ $sl }}"><img src="{{ $app->icon(152) }}"></a>
            </div>
<?php
}
?>
       </wrap-owlcarousel>
<?php
}
if(count($apps) == 1)
{
    foreach($apps as $app)
    {
        $sl = \App\Core\Secure::array2string(array('app_id' => $app['id']));
?>
            <div>
                <h4 class="ellipsis-oneline" style="margin:0 0 19px 0">{{ $app->name }}</h4>
                <a href="#/app/{{ $sl }}"><img src="{{ $app->icon(152) }}"></a>
            </div>
<?php
    }
}
if(count($apps) == 0)
{
    if(\Auth::user()->parent_id != NULL && \Auth::user()->getRoleId() == 4)
    {
        
    }
    else
    {
?>
            <div>
                <a href="#/app" tooltip="{{ trans('global.create_first_app') }}" tooltip-placement="top"><img src="{{ url('/static/app-icons/globe/152.png') }}"></a>
            </div>
<?php
    }
}
?>
        </div>
    </div>

    <br>
    <br>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">

                <div class="row button-grid">
                    <div class="col-xs-12 col-sm-6 grid-gutter-margin-b">
                        <a href="#/apps" class="btn btn-lg btn-primary btn-flat btn-block text-center"><i class="fa fa-2x fa-th"></i><br>{{ trans('global.apps') }}</a>
                    </div>
 
                    <div class="col-xs-12 col-sm-6 grid-gutter-margin-b">
                        <a href="#/stats" class="btn btn-primary btn-lg btn-flat btn-block text-center"><i class="fa fa-2x fa-line-chart text-center"></i><br>{{ trans('global.data_and_statistics') }}</a>
                    </div>
 
                    <div class="col-xs-12 col-sm-6 grid-gutter-margin-b">
                        <a href="#/media" class="btn btn-primary btn-lg btn-flat btn-block text-center"><i class="fa fa-2x fa-cloud-upload text-center"></i><br>{{ trans('global.media') }}</a>
                    </div>
    
                    <div class="col-xs-12 col-sm-6 grid-gutter-margin-b">
                        <a href="#/account" class="btn btn-primary btn-lg btn-flat btn-block text-center"><i class="fa fa-2x fa-credit-card text-center"></i><br>{{ trans('global.my_account') }}</a>
                    </div>
                </div>

            </div>
        </div>
@stop