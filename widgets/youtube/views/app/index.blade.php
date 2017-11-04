<ion-view title="{{ $page->name }}">
    <ion-content padding="false" class="{{ $app->content_classes }}">
<?php 
if ($api_key == '') 
{
    echo '<div class="transparent">' . trans('widget::global.no_api_key') . '</div>';
} 
elseif ($channel_url == '') 
{
    echo '<div class="transparent">' . trans('widget::global.channel_url_required') . '</div>';
}
else
{
?>
		<div id="youmax"></div>
<?php } ?>
	</ion-content>
</ion-view>
<?php if($api_key != '') { ?>
<script type="text/javascript">
$('#youmax').youmax({
	apiKey: '{{ $api_key }}',
	youTubeChannelURL: "{{ $channel_url }}",
	youTubePlaylistURL: "{{ $playlist_url }}",
	youmaxDefaultTab: "{{ $tab }}",
	youmaxColumns: {{ $columns }},
	showVideoInLightbox: true,
	showFeaturedVideoOnLoad: false,
	maxResults: {{ $max_results }}
});
</script>
<?php } ?>