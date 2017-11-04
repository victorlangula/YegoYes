<ion-view title="{{ $page->name }}">
    <ion-content padding="true" class="{{ $app->content_classes }}" ng-controller="FlickrCtrl" ng-init="{{ $ngInit }}">

		<div id="photos" class="clearfix">
			<div ng-repeat="photo in photos.items">
				<div class="row" >
					<div class="col col-33">
						<a ng-href="@{{ photos.items[$index+0].link }}" target="_blank"><img ng-src="@{{ photos.items[$index+0].media.m }}" class="photo"></a>
					</div>
					<div class="col col-33">
						<a ng-href="@{{ photos.items[$index+1].link }}" target="_blank"><img ng-src="@{{ photos.items[$index+1].media.m }}" class="photo"></a>
					</div>
					<div class="col col-33">
						<a ng-href="@{{ photos.items[$index+2].link }}" target="_blank"><img ng-src="@{{ photos.items[$index+2].media.m }}" class="photo"></a>
					</div>
				</div>
			</div>
		</div>

	</ion-content>
</ion-view>