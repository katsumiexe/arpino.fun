$(function(){ 
	$('.main_mail').animate({scrollTop: $('.main_mail')[0].scrollHeight},1000);
	$('#send_mail').on('click',function(){
		$.post({
			url:Dir + "/post/easytalk_send.php",
			data:{
				'log'	:$('#send_msg').val(),
				'sid'	:$('#ssid').val(),
				'img'	:$('#img').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			if(data){
				$('.main_mail').append(data);
				$('#send_msg').val('');
				$('.main_mail').animate({ scrollTop: $('.main_mail')[0].scrollHeight},300);
			}



		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
});


