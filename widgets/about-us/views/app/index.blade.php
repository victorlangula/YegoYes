<ion-view title="{{ $page->name }}">
    <ion-content padding="true" class="{{ $app->content_classes }}">
<?php
if($image != '')
{
    $box = \Mobile\Controller\WidgetController::getData($page, 'box_image', 1);
    if($box == 1)
    {
        echo '<div class="card" style="margin-top:5px">';
        echo '<div class="item item-image">';
    }

    echo '<img src="' . url($image) . '" class="full-image">';

    if($box == 1)
    {
        echo '</div>';
        echo '</div>';
    }
}
?>
		<div class="transparent">
			<h2><?php echo \Mobile\Controller\WidgetController::getData($page, 'title', trans('widget::global.default_title')); ?></h2>
			<div>
				<?php echo \Mobile\Controller\WidgetController::getData($page, 'content', trans('widget::global.default_content')); ?>
			</div>
		</div>

<?php
if($list != NULL)
{
?>
		<br>
        <ion-list type="card">
<?php
$i = 0;
$js = '';
foreach($list->icon as $row)
{
	if($list->url[$i] != '' && $list->label[$i] != '' && $list->icon[$i] != '')
	{
?>
          <a href="{{ $list->url[$i] }}" class="item item-icon-left" target="_blank">
            <i class="icon {{ $list->icon[$i] }}"></i>
            {{ $list->label[$i] }}
          </a>
<?php
	}
	$i++;
}
?>
        </ion-list>
<?php
}

if ($social_share)
{
	echo '<div class="transparent m-top text-center">
	<div id="share' . $page->id . '"></div>
</div>';

	echo \Mobile\Core\Social::shareButtons($app, $page, 'share' . $page->id);
}
?>
    </ion-content>
</ion-view>
