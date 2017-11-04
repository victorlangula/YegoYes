<?php
if(! isset($head_included_map) || ! $head_included_map)
{
?>
<script src="http://cdn.leafletjs.com/leaflet-0.7.1/leaflet.js"></script>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.1/leaflet.css">
<link href="{{ url('/widgets/map/assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('/widgets/map/assets/vendor/leaflet-routing-machine/leaflet-routing-machine.css') }}" rel="stylesheet" type="text/css">
<script src="{{ url('widgets/map/assets/vendor/angular-leaflet/angular-leaflet-directive.min.js') }}"></script>
<script src="{{ url('widgets/map/assets/vendor/leaflet-routing-machine/leaflet-routing-machine.min.js') }}"></script>
<script src="{{ url('widgets/map/assets/js/app.js') }}"></script>
<?php
}
?>