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
    $('#tbl_lv2').show();

	setInterval(function(){
		N1--;
		if(N1<'0') N1=2;
	    $('.score_lv').removeClass('score_lv_on');
	    $('#s_lv'+N1).addClass('score_lv_on');
	    $('.score_table').fadeOut(1000);
	    $('#tbl_lv'+N1).fadeIn(1000);
	},10000);

	$('.rank_detail').on('click',function(){
		Tmp=$(this).attr('id').replace('d','tr');
		$('.tr0,.tr1,.tr2').slideUp(500);

		if($(this).css('background')=="#d00000"){
			$(this).css('background','#909090');

		}else{
			$(this).css('background',"#d00000");
			$('.'+Tmp).slideDown(500);

		}

    });

    $('#lv5').on('click',function(){
	    $('.howto').fadeIn(500);
    });

    $('#lv4').on('click',function(){
	    $('.score').fadeIn(500);
    });

    $('.howto_back').on('click',function(){
	    $('.howto').fadeOut(500);
    });

    $('.score_back').on('click',function(){
	    $('.score').fadeOut(500);
    });

    $('.score_lv').on('click',function(){
		Tag=$(this).attr('id').replace('s_','');
	    $('.score_lv').removeClass('score_lv_on');
	    $(this).addClass('score_lv_on');
	    $('.score_table').hide();
	    $('#tbl_'+Tag).fadeIn(1000);
    });

    $('.howto_page_tag').on('click',function(){
		Tag=$(this).attr('id').replace('i','');
	    $('.howto_in').hide();
	    $('#'+Tag).fadeIn(500);
    });

    $('#lv0, #lv1, #lv2').on('click',function(){
	    $('.page_00').fadeOut(500);
		Lv=$(this).attr('id').replace('lv','');

    });
    $('.sel').on('click',function(){
		$('.pop_back,.pop_a').show();
		Img=$(this).children('.sel_a').attr('src');
		Sel=$(this).children('.sel_b').html();
		Name=$(this).children('.sel_c').html();
		Unit_Select=$(this).attr('id').replace('s','');

		$('.pop_a_3').html(Sel);
		$('.pop_a_2').html(Name);
		$('.pop_a_1').attr('src',Img);
    });

	$('#reset').on('click',function(){
		$('.pop_back,.pop_a').hide();
    });

	$('#start').on('click',function(){
		$('.pop_back,.pop_a').fadeOut(500);
		$('.page_01').fadeOut(500);
		$('.page_02').fadeIn(500);
		$.post({
			url:'post_read_start.php',
			dataType: 'json',
			data:{
				'unit_select':Unit_Select,
				'level_select':Lv
			},
		}).done(function(data, textStatus, jqXHR){
			LogId=data.i;

			Up['a']=data.a;
			Up['b']=data.b;
			Up['c']=data.c;
			Up['d']=data.d;
			Up['e']=data.e;

			Doll['a']=parseInt(data['u'][0]);
			Doll['b']=parseInt(data['u'][1]);
			Doll['c']=parseInt(data['u'][2]);
			Doll['d']=parseInt(data['u'][3]);
			Doll['p']=parseInt(data['u'][4]);

			Persona["a"]=data['p1'];
			Persona["b"]=data['p2'];
			Persona["c"]=data['p3'];
			Persona["d"]=data['p4'];

			$('#myicon').attr('src','./img/unit/unit_'+ Unit_Select +'.png');
			$('#p1').attr('src','./img/chr/chr'+ Persona['a'] +'.jpg');
			$('#p2').attr('src','./img/chr/chr'+ Persona['b'] +'.jpg');
			$('#p3').attr('src','./img/chr/chr'+ Persona['c'] +'.jpg');
			$('#p4').attr('src','./img/chr/chr'+ Persona['d'] +'.jpg');


			$('#myname').text(data.name);
			$('#status_1').addClass(data.s1);
			$('#status_2').addClass(data.s2);
			$('#status_3').addClass(data.s3);
			$('#status_4').addClass(data.s4);
			$('#status_5').addClass(data.s5);
/*
			DollJ	= JSON.stringify(Doll);
			PersonaJ= JSON.stringify(Persona);
*/


			console.log(Persona);
			console.log('a◆:'+Persona.a);
			console.log('b◆:'+Persona.b);
			console.log('c◆:'+Persona.c);
			console.log('d◆:'+Persona.d);

			console.log(data.i);
			console.log(Doll);
			console.log(Up['a']);
			console.log(Up['b']);
			console.log(Up['c']);
			console.log(Up['d']);
			console.log(Up['e']);

		});
	});

	$('.turn_start,.turn_start_main').on('click',function(){
		$('.guard').hide();
		$('.guard3').fadeIn(500);
		$('.player_c,.player_e').slideUp(100);		
		$('.turn_count').text(Turn+1);

		$.post({
			url:"post_read_set.php",
			data:{
				"card":Up['e'][Turn]
			},
		}).done(function(data, textStatus, jqXHR){
			$('#rest'+Turn).animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':W10,'border-radius':W20},300).delay(100).fadeOut(200);
			$('.main_card').delay(300).fadeIn(0).html(data);
		
		}).fail(function(xhr, textStatus, errorThrown){
   			console.log("NG:" + xhr.status);
			console.log("ST:" + textStatus);
      	});
    });

	$('.player_d').on('click',function(){

		Tmp_Id=$(this).attr('id')+'1';
		Tmp_No=$(this).attr('id').replace('down_','');

		$('.f'+Tmp_No).css('color','#e0e0e0');		

		if($('#'+Tmp_Id).css("display") == 'none'){
			for(i=Turn ;i<12;i++){
				$('#'+Tmp_Id).children('.f'+Up[Tmp_No][i]).css('color','#906000');		
			}
			$('#'+Tmp_Id).slideDown(200);		

		}else{
			$('#'+Tmp_Id).slideUp(150);		
		}


    });

    $('.td_b2').on('click','.p_pts_on',function(){
		$('.guard').show();
		$('.player_e').slideUp(100);		

        $(this).removeClass('p_pts_on');
        No=$(this).attr('id').replace('i','');
		$.post({
			url:'post_read_turn.php',
			dataType: 'json',
			data:{
				'log_id':LogId,
				'turn':Turn,
				'bet':No,
				'data_a':Up['a'][Turn],
				'data_b':Up['b'][Turn],
				'data_c':Up['c'][Turn],
				'data_d':Up['d'][Turn],
				'data_e':Up['e'][Turn],

				'unit_a':Doll['a'],
				'unit_b':Doll['b'],
				'unit_c':Doll['c'],
				'unit_d':Doll['d'],
				'unit_p':Doll['p'],
			},
		}).done(function(data2, textStatus, jqXHR){

			Pts[data2.z]=parseFloat(Pts[data2.z])+parseFloat(data2.pts);
			Cnt[data2.z]++;
            $('.main_card').html(data2.cord);

            $('#set_z').text(data2.z);
			$('#set_a').delay(200).slideDown(500).text(Items[Up['a'][Turn]]);
			$('#set_b').delay(250).slideDown(500).text(Items[Up['b'][Turn]]);
			$('#set_c').delay(300).slideDown(500).text(Items[Up['c'][Turn]]);
			$('#set_d').delay(350).slideDown(500).text(Items[Up['d'][Turn]]);

			GetN[Turn]=parseInt(data2.pts);

			if(data2.z=='p'){
				GetP[Turn]=data2.z;
				$.when(
			 		$('.main_card').delay(2000)
					.animate({'top':'90vh','right':W540,'height':'0','width':'0','border-width':'0px','border-radius':'20px'},300).fadeOut(0)
					.animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':'10px','border-radius':'20px'},0)
		         ).done(function(){
					if(data2.ring==2){
						$('#sub_' + data2.z).css('color','#ff90a0');
						SubUser=data2.z;

					}else if(data2.ring==1){
						$('#ring_' + data2.z).css('color','#ff90a0');
						RingUser=data2.z;
					}

					Pts_n=parseInt(Pts['p']);
					$('#pts_p').text(Pts_n);
					$('#count_'+data2.z).text(Cnt[data2.z]);
				});               

			}else if(data2.z=='a'){
				GetP[Turn]=data2.z;
				$.when(
					$('.main_card').delay(2000)
					.animate({'top':W50,'right':W540,'height':'0','width':'0','border-width':'0px','border-radius':'20px'},300).fadeOut(0)
					.animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':'10px','border-radius':'20px'},0)
		         ).done(function(){
					if(data2.ring==2){
						$('#sub_' + data2.z).css('color','#ff90a0');
						SubUser=data2.z;

					}else if(data2.ring==1){
						$('#ring_' + data2.z).css('color','#ff90a0');
						RingUser=data2.z;
					}

					$('#count_'+data2.z).text(Cnt[data2.z]);
				});               

			}else if(data2.z=='b'){
				GetP[Turn]=data2.z;
				$.when(
					$('.main_card').delay(2000)
					.animate({'top':W50,'right':W420,'height':'0','width':'0','border-width':'0px','border-radius':'20px'},300).fadeOut(0)
					.animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':'10px','border-radius':'20px'},0)
		         ).done(function(){
					if(data2.ring==2){
						$('#sub_' + data2.z).css('color','#ff90a0');
						SubUser=data2.z;

					}else if(data2.ring==1){
						$('#ring_' + data2.z).css('color','#ff90a0');
						RingUser=data2.z;
					}
					$('#count_'+data2.z).text(Cnt[data2.z]);
				});               

			}else if(data2.z=='c'){
				GetP[Turn]=data2.z;
				$.when(
					$('.main_card').delay(2000)
					.animate({'top':W50,'right':W300,'height':'0','width':'0','border-width':'0px','border-radius':'20px'},300).fadeOut(0)
					.animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':'10px','border-radius':'20px'},0)
		         ).done(function(){
					if(data2.ring==2){
						$('#sub_' + data2.z).css('color','#ff90a0');
						SubUser=data2.z;

					}else if(data2.ring==1){
						$('#ring_' + data2.z).css('color','#ff90a0');
						RingUser=data2.z;
					}
					$('#count_'+data2.z).text(Cnt[data2.z]);
				});               

			}else if(data2.z=='d'){
				GetP[Turn]=data2.z;
				$.when(
					$('.main_card').delay(2000)
					.animate({'top':W50,'right':W180,'height':'0','width':'0','border-width':'0px','border-radius':'20px'},300).fadeOut(0)
					.animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':'10px','border-radius':'20px'},0)
		         ).done(function(){
					if(data2.ring==2){
						$('#sub_' + data2.z).css('color','#ff90a0');
						SubUser=data2.z;

					}else if(data2.ring==1){
						$('#ring_' + data2.z).css('color','#ff90a0');
						RingUser=data2.z;
					}
					$('#count_'+data2.z).text(Cnt[data2.z]);
				});               

			}else if(data2.z=='l'){
				$('.main_card').delay(2000)
				.animate({'right':W700},800).fadeOut(0)
				.animate({'top':Size_t,'right':Size_r,'height':Size_h,'width':Size_w,'border-width':'10px','border-radius':'20px'},0);
			}

			if(Turn<11){
				$('.guard3').delay(2000).fadeOut(1000);

			}else{
				var DollJ 		= JSON.stringify(Doll);
				var PtsJ 		= JSON.stringify(Pts);
				var GetPJ	 	= JSON.stringify(GetP);
				var GetNJ	 	= JSON.stringify(GetN);
				var PersonaJ	= JSON.stringify(Persona);
/*
				console.log(GetN);
				console.log(GetNJ);
*/
				$('.player_c').stop(false, true).delay(2800).slideUp(100);
				$('.pl1').delay(4500).animate({'top':'100vh'},500);
				$('.pl2').delay(3500).animate({'left':0},200).delay(1000).animate({'top':'100vh'},500);
				$('.pl3').delay(3600).animate({'left':0},400).delay(900).animate({'top':'100vh'},500);
				$('.pl4').delay(3800).animate({'left':0},600).delay(700).animate({'top':'100vh'},500);
				$('.pl5').delay(3500).fadeOut(500);

				$.post({
					url:'post_sort.php',
					data:{
						"lv"		:Lv,
						"log_id"	:LogId,
						"persona"	:PersonaJ,
						"getp"		:GetPJ,
						"getn"		:GetNJ,
						"doll"		:DollJ,
						"pts"		:PtsJ
					}

				}).done(function(data3, textStatus, jqXHR){
					$('.table_a,.table_b,.myimg').delay(4700).animate({'top':'100vh'},500);
					$('.last_res').html(data3).delay(6000).animate({'top':'2vh'},500);

				}).fail(function(xhr, textStatus, errorThrown) {
		   			console.log("NG:" + xhr.status);
					console.log("ST:" + textStatus);
				});
			}
/*
			console.log(data2);
			console.log(Turn);
*/
			Turn++;
		});
	});

    $('.last_res').on('click','.thanks_btn',function(){
		$.post({
			url:'post_score.php',
			data:{
				"name"		:$('.thanks_name').val(),
				"log_id"	:$('#log_id').val(),
			}
		}).done(function(data3, textStatus, jqXHR){
//			console.log(data3);
			$('#reset_top').submit();
	    });
    });

    $('.last_res').on('click','.thanks_back',function(){
		$('#reset_top').submit();
    });
});


