<?php
if(! isset($head_included_coupons) || ! $head_included_coupons)
{
?>
<script src="{{ url('widgets/coupons/assets/js/app.js') }}"></script>
<script src="{{ url('widgets/coupons/assets/js/fingerprint2.js') }}"></script>
<?php
}
?>