
var  Cd=[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
$(function(){ 
	for(i=0;i<50;i++){
		var No1		= Math.floor(Math.random() * 22);
		var No2		= Math.floor(Math.random() * 22);
		var Tmp		=Cd[No1];
		 Cd[No1]	=Cd[No2];
		 Cd[No2]	=Tmp;
	}
	console.log(Cd);

/*
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
*/
	$('.btn').on('click',function(){
	    $('#c0').animate({'left':'240px','top':'160px'},{
			duration: 300,
			step: function (now) {
				 $('#c0').css({ transform: 'rotate(' + now* + 'deg)' })
			}
	    })
	    .animate({'left':'250px','top':'10px'},{
			duration: 300,
			step: function (now) {
				 $('#c0').css({ transform: 'rotate(' + now* + 'deg)' })
			}
	    })
	    .animate({'left':'20px','top':'30px'},{
			duration: 300,
			step: function (now) {
				 $('#c0').css({ transform: 'rotate(' + now* + 'deg)' })
			}
	    })

	});


});


$("div").mousemove(function(e){
  var pageCoords = "( " + e.pageX + ", " + e.pageY + " )";
  var clientCoords = "( " + e.clientX + ", " + e.clientY + " )";
  $("span:first").text("( e.pageX, e.pageY ) - " + pageCoords);
  $("span:last").text("( e.clientX, e.clientY ) - " + clientCoords);
});



