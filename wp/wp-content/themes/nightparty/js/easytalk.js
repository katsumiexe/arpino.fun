$(function(){ 
	Tmp=$('.main_mail').height();
	$('.main_mail').scrollTop(Tmp);
console.log(Tmp);

	$('#send_mail').on('click',function(){
		$.post({
			url:Dir + "/post/easytalk_send.php",
			data:{
				'log'	:$('#send_msg').val(),
				'sid'	:$('#ssid').val(),
				'img'	:$('#img').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			$('.main_mail').prepend(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
});

