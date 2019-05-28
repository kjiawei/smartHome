$('#side-menu').metisMenu();
$(window).bind("load resize", function() {
	width=(this.window.innerWidth>0)?this.window.innerWidth:this.screen.width;
	if (width<768) {
		$('div.sidebar-collapse').removeClass('in');
		$('div.sidebar-collapse').css({"height":"0"});
	} else {
		if (!($('div.sidebar-collapse').hasClass('in'))) {
			$('div.sidebar-collapse').addClass('in');
			$('div.sidebar-collapse').removeAttr('style');
		}
	}
});
$('.dosure').click(function(){
	var to=$(this).attr('data-url');
	if (confirm(suretext)) window.location.href=to;
});