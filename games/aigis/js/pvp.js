var Level_Select=0;;
var Turn=0;
var St=[];
var Items=["","","","","","","","","","","",""];
var Up=[];

var GetP=new Object();
var GetN=new Object();
var Persona= new Object();
var Doll= new Object();

var Get_a;
var Get_b;
var Get_c;
var Get_d;
var Get_p;

var SubUser;
var RingUser;


var Cnt={
		"a": 0,
		"b": 0,
		"c": 0,
		"d": 0,
		"e": 0,
		"p": 0
};
var Pts={
		"a": 0,
		"b": 0,
		"c": 0,
		"d": 0,
		"p": 0
};

if ($(window).width()>619) {
	var W10="10px";
	var W20="20px";


	var W50="50px";
	var W110="110px";
	var W150="150px";

	var Size_t="190px";
	var Size_r="200px";
	var Size_h="240px";
	var Size_w="200px";


	var W540="540px";
	var W420="420px";
	var W300="360px";
	var W180="180px";

	var W700="700px";

}else{
	var W10="2vw";
	var W20="4vw";
	var W50="10vw";
	var W110="20vw";
	var W150="29vw";


	var Size_t="46vw";
	var Size_r="26vw";
	var Size_h="51vw";
	var Size_w="43vw";

	var W540="87.5vw";
	var W420="62.5vw";
	var W300="37.5vw";
	var W180="12.5vw";
	var W700="150vw";
}

var R=0;
var N1=2;

$(function(){ 
	setInterval(function(){
		$.post({
			url:'post_pvp_read_turn.php',
			dataType: 'json',
			data:{
				'log_id':LogId,
				'turn':Turn,
			},
		}).done(function(data, textStatus, jqXHR){






		});
	},5000);


    $('#lv5').on('click',function(){
	    $('.howto').fadeIn(500);
    });

	$('.td_b2').on('click','.pvp_pts_on',function(){
		$(this).removeClass('p_pts_on');
		No=$(this).attr('id').replace('i','');

		$('.guard').show();
		$('.player_e').slideUp(100);		

		$.post({
			url:'post_pvp_set_turn.php',
			data:{
				'log_id':LogId,
				'turn':Turn,
				'item':No,
			},
		}).done(function(data, textStatus, jqXHR){

		});
	});
});

