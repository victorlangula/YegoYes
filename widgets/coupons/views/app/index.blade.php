<ion-view title="{{ $page->name }}">
    <ion-content padding="true" class="{{ $app->content_classes }}" ng-controller="CouponsCtrl" ng-init="sl = '{{ $sl }}'">

		<ion-refresher on-refresh="doRefresh()"></ion-refresher>
		<div ng-show="coupons.length == 0" class="transparent">{{ trans('widget::global.loading_coupons') }}</div>
 		<div ng-show="coupons.found == 0" class="transparent">{{ trans('widget::global.no_coupons') }}</div>

		<div ng-if="coupons.length > 0">
			<div ng-repeat="entry in coupons track by $index" class="list card">
				<div class="item item-divider">
					<strong>@{{ entry.title }}</strong>
					<p>{{ trans('widget::global.valid') }} @{{correctTimestring(entry.valid_start) | date:'mediumDate'}}<span ng-if="entry.valid_end != ''"> - @{{correctTimestring(entry.valid_end) | date:'mediumDate'}}</span></p>
				</div>

				<div class="item item-body">
					<a href="#{{ $hashPrefix }}/nav/widget/coupons/getCoupon/{{ $sl }}/@{{ entry.id }}">
						<span ng-show="entry.redeemed == 0 && (entry.type != 3)" class="button button-small icon-left ion-star button-positive" style="position:absolute; margin:10px">@{{ entry.deal }}</span>
						<span ng-show="entry.redeemed == 1" class="button button-small icon-left ion-android-done button-assertive" style="position:absolute; margin:10px">{{ trans('widget::global.redeemed') }}</span>
						<img ng-src="@{{ entry.image || url + '/widgets/coupons/assets/img/coupon.png' }}" class="full-image"/>
					</a>
				</div>

				<div class="item item-body">
					<p ng-bind-html="entry.brief_description" style="margin-top:0"></p>
				</div>
			</div>
		</div>

    </ion-content>
</ion-view>