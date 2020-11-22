$(function(){ 
	$('#send_mail').on('click',function(){
		Tmp=$('.main_mail')[0].scrollHeight;
		Tmp1=$('.main_mail').scrollTop();

		$.post({
			url:Dir + "/post/easytalk_send.php",
			data:{
				'log'	:$('#send_msg').val(),
				'sid'	:$('#ssid').val(),
				'img'	:$('#img').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			$.when(
				$('.main_mail').prepend(data)
			).done(function(){
				Tmp2=$('.main_mail')[0].scrollHeight - Tmp + Tmp1,
				$('#send_msg').val('')
				$('.main_mail').scrollTop(Tmp2);
			});
			$('.main_mail').animate({ scrollTop:0},500);

//				.animate({ scrollTop:0},1000);
//				$('.main_mail').animate({ scrollTop: $('.main_mail')[0].scrollHeight},300);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
});

