<ion-view title="{{ $page->name }}">
    <ion-content padding="true" class="{{ $app->content_classes }}" ng-controller="PhotosCtrl">
<?php
$i = 0;
$slides = '';
if($images != NULL)
{
	foreach($images->image as $row)
	{
		$image = $images->image[$i];
		if($image != '')
		{
			// row responsive-md -> responsive
			$slides .= '<ion-slide><img src="' . $image . '" class="fullscreen-image"></ion-slide>';
			if($i % 3 == 0) echo '<div class="row">';
			$thumb = url('/api/v1/thumb/nail?w=150&h=150&img=' . $image);

			echo '<div class="col col-33">';
			echo '<a href="javascript:void(0)" ng-click="openModal(\'' . $i . '\')"><img src="' . $thumb . '" class="photo"></a>';
			echo '</div>';

			$i++;
			if($i % 3 == 0) echo '</div>';
		}
	}
}
?>
	</ion-content>
</ion-view>

<script id="image-modal.html" type="text/ng-template">
  <div class="modal image-modal transparent" 
	   ng-click="closeModal()">
	<ion-slide-box on-slide-changed="slideChanged(index)" show-pager="false">
		{{ $slides }}
	</ion-slide-box>
  </div>
</script>