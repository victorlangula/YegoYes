@extends('../app.layouts.partial')
@section('content')

    <div class="spinner" id="spinner">
      <div class="rect1"></div>
      <div class="rect2"></div>
      <div class="rect3"></div>
      <div class="rect4"></div>
      <div class="rect5"></div>
    </div>

<script>
if(window.jQuery)
{
	$('#spinner').css('margin', (parseInt($(window).outerHeight()) / 2) - 60 + 'px auto 0 auto');
}
else
{
	var w = window,
		d = document,
		e = d.documentElement,
		g = d.getElementsByTagName('body')[0],
		x = w.innerWidth || e.clientWidth || g.clientWidth,
		y = w.innerHeight|| e.clientHeight|| g.clientHeight;

	document.getElementById('spinner').style.margin = ((parseInt(y) / 2) - 60) + 'px auto 0 auto';
}
</script>
@stop