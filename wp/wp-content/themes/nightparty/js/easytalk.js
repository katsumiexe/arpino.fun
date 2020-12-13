$(function(){ 
	Tmp=$('.main_mail').height();
	$('.main_mail').scrollTop(Tmp);

	$('#send_mail').on('click',function(){
		$.post({
			url:Dir + "/post/easytalk_send.php",
			data:{
				'send'	:'2',
				'log'	:$('#send_msg').val(),
				'sid'	:$('#ssid').val(),
				'img'	:$('#img').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			$('.main_mail').append(data);
			$('#send_msg').val('');


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
});

