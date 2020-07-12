$(function(){ 
	setInterval(function(){
		N1--;
		if(N1<'0') N1=2;
	    $('.score_lv').removeClass('score_lv_on');
	    $('#s_lv'+N1).addClass('score_lv_on');
	    $('.score_table').fadeOut(1000);
	    $('#tbl_lv'+N1).fadeIn(1000);
	},10000);

    $('#lv5').on('click',function(){
	    $('.howto').fadeIn(500);
    });
});


