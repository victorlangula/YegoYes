@extends('../app.layouts.partial')

@section('content')
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">{{ trans('global.you_are_here') }} </div>
		<li><a href="{{ url('/') }}">{{ trans('global.home') }}</a></li>
		<li><a href="#/">{{ trans('global.dashboard') }}</a></li>
		<li><a href="#/campaigns">{{ trans('global.campaigns') }}</a></li>
		<li class="active">{{ trans('global.edit_campaign') }}</li>
	</ul>

	<div class="page-header">
		<h1 style="height:32px"><i class="fa fa-share-alt page-header-icon"></i> {{ trans('global.edit_campaign') }}</h1>
	</div>

<?php
echo Former::open()
	->class('form ajax ajax-validate')
	->action(url('api/v1/campaign/save'))
	->method('POST');

echo Former::hidden()
		->name('sl')
		->forceValue($sl);
?>
		  <div class="panel"> 
		   <div class="panel-body padding-sm">
<?php

echo Former::text()
    ->name('name')
    ->autocomplete('off')
    ->help(trans('global.campaign_info'))
	->dataFvNotempty()
	->dataFvNotemptyMessage(trans('global.please_enter_a_value'))
    ->forceValue($campaign->name)
	->label(trans('global.name'));
	
echo Former::actions(
    Former::submit(trans('global.save'))->class('btn-lg btn-primary btn')->id('btn-submit'),
    Former::link(trans('global.cancel'))->class('btn-lg btn-default btn')->href('#/campaigns')
);
?>
			 </div>
		   </div>
		</div>
<?php
echo Former::close();
?>

<script>
function formSubmittedSuccess(r)
{
    if(r.result == 'error')
    {
        return;
    }
	document.location = '#/campaigns';
}
</script>
@stop