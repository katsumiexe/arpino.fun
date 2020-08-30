$(function(){ 
	$('.foot').hide();
	$(window).scroll(function () {
		var doch = $(document).innerHeight();
		var winh = $(window).innerHeight();
		var bottom = doch - winh-80;

		if (bottom+50 <= $(window).scrollTop()) {
	        $('.foot').fadeIn(50);
	    } else {
	        $('.foot').hide();
		}
	});

	$('.btn_login').on('click',function () {
	$('#user_login').submit();	
	});

	$("#index").on('click',function () {
	    window.location.href = './index.php';
	});

	$("#album").on('click',function () {
	    window.location.href = './album.php';
	});

	$("#making").on('click',function () {
	    window.location.href = './making.php';
	});

	$("#config").on('click',function () {
	    window.location.href = './index.php?logout=1';
	});


});


