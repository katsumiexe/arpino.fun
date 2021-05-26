$(function(){

	Base_h=Math.floor($('.masu').height());
	Base_w=Math.floor($('.masu').width());

	Base_hb=Math.floor($('.masu_c').height());
	Base_wb=Math.floor($('.masu_l').width());

	$('.koma,.masu').css({'width':Base_w,'height':Base_h});
	$('.masu_c').css({'width':Base_w,'height':Base_hb});
	$('.masu_l').css({'width':Base_wb,'height':Base_h});
	$('.masu_cl').css({'width':Base_wb,'height':Base_hb});

	$('.ban').css({'width':Base_w * 9+ Base_wb,'height':Base_h * 9+ Base_hb});

$('.c1').css('left',Base_w*8);
$('.c2').css('left',Base_w*7);
$('.c3').css('left',Base_w*6);
$('.c4').css('left',Base_w*5);
$('.c5').css('left',Base_w*4);
$('.c6').css('left',Base_w*3);
$('.c7').css('left',Base_w*2);
$('.c8').css('left',Base_w*1);
$('.c9').css('left',0);

$('.l1').css('top',Base_h*0+Base_hb);
$('.l2').css('top',Base_h*1+Base_hb);
$('.l3').css('top',Base_h*2+Base_hb);
$('.l4').css('top',Base_h*3+Base_hb);
$('.l5').css('top',Base_h*4+Base_hb);
$('.l6').css('top',Base_h*5+Base_hb);
$('.l7').css('top',Base_h*6+Base_hb);
$('.l8').css('top',Base_h*7+Base_hb);
$('.l9').css('top',Base_h*8+Base_hb);

	KH=$('#koma1').height();
	KW=$('#koma1').width();
	
	MH=$('.masu').height();
	MW=$('.masu').width();

	$('#k_size_h').text(KH);
	$('#k_size_w').text(KW);
	$('#m_size_h').text(MH);
	$('#m_size_w').text(MW);

	K1=$('#koma1').css('top');
	K2=$('#koma3').css('top');
	K3=$('#koma25').css('top');

	K7=$('#koma35').css('top');
	K8=$('#koma4').css('top');
	K9=$('#koma2').css('top');

	$('#k_l1').text(K1);
	$('#k_l2').text(K2);
	$('#k_l3').text(K3);
	$('#k_l7').text(K7);
	$('#k_l8').text(K8);
	$('#k_l9').text(K9);

	$('.koma').attr('cc')

	var KB=[0,1,2,3,3,4,4,5,5,5,5,6,6,6,6,7,7,7,7,8,8,8,8,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9];
	var Coma=["▲","△"];
	var Masu_L=["","一","二","三","四","五","六","七","八","九"];

	var Te_Count=0;
	var Player='';
	var Opponent='';

	var Tmp_ch	="";
	var Tmp_T	="";
	var Tmp_L	="";
	var TmpId	="";
	var Tmp2	="";
	var Tmp		="";
	var Tmp_cc	="";
	var Tmp_ll	="";

	$('.koma').on('click',function(){
		Player		=Te_Count % 2
		Opponent	=(Te_Count+1) % 2

		if($('.koma_on').hasClass('u' + Player) && $(this).hasClass('u' + Opponent)){

			TmpId	=$(this).attr('id').replace('c','');
			Tmp2	=$(this).attr('id').replace('koma','');
			Tmp		=$('.koma_on').attr('id').replace('koma','');

			Tmp_cc	=$(this).attr('cc');
			Tmp_ll	=$(this).attr('ll');

			Tmp_C	=72-Base_w*($(this).attr('cc'));
			Tmp_L	=Base_h*($(this).attr('ll')-1)+Base_hb;

			$('.koma_on').animate({'left':Tmp_C,'top':Tmp_L},300);

			$(this).fadeOut(400);
			$('.koma').removeClass('koma_on');

			if($(this).hasClass('s0')){
				if(	KB[Tmp] == 9 ||	KB[Tmp] == 8){

					//■恐怖無条件成
					if(Tmp_ll == 1 && Player ==0){
						Tmp_ch=1;

					}else if(Tmp_ll == 9 && Player ==1){
						Tmp_ch=1;


					//■恐怖成確認
					}else if(Tmp_ll < 4 && Player ==0){
						Tmp_ch=2;

					}else if(Tmp_ll > 6 && Player ==1){
						Tmp_ch=2;

					}
				} else if(KB[Tmp] == 7){
					//■K無条件成
					if(Tmp_ll < 3 && Player ==0){
						Tmp_ch=1;

					}else if(Tmp_ll >7 && Player ==1){
						Tmp_ch=1;


					//■K成確認
					}else if(Tmp_ll == 3 && Player ==0){
						Tmp_ch=2;

					}else if(Tmp_ll == 7 && Player ==1){
						Tmp_ch=2;

					}

				}else	if(	KB[Tmp] == 3 ||	KB[Tmp] == 4 ||	KB[Tmp] == 6){
					if(Tmp_ll < 4 && Player ==0){
						Tmp_ch=2;

					}else if(Tmp_ll > 6 && Player ==1){
						Tmp_ch=2;

					}
				}
			}

			Te_Count++;
			$.post({
				url:"./post/move_get.php",
				data:{
					'move_id'	:Tmp,
					'get_id'	:Tmp2,
					'move_ll'	:Tmp_ll,
					'move_cc'	:Tmp_cc,
					'move_ch'	:Tmp_ch,
					'count'		:Te_Count,
				},

			}).done(function(data, textStatus, jqXHR){
				TmpId	="";
				Tmp2	="";
				Tmp		="";
				Tmp_cc	="";
				Tmp_ll	="";
				Tmp_ch	="";

				Tmp_C	="";
				Tmp_L	="";

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});


		}else if($(this).hasClass('koma_on')){
			$(this).removeClass('koma_on');

		}else if($(this).hasClass('u' + Player)){
			$('.koma').removeClass('koma_on');
			$(this).addClass('koma_on');
		}
	});

	$('.masu').on('click',function(){
		if($('.koma').hasClass('koma_on')){

			Tmp		=$('.koma_on').attr('id').replace('koma','');
			Tmp_cc	=$(this).attr('cc');
			Tmp_ll	=$(this).attr('ll');

			Tmp_C	=Base_w*(9-$(this).attr('cc'));
			Tmp_L	=Base_h*($(this).attr('ll')-1)+Base_hb;

			$('.koma_on').animate({'left':Tmp_C,'top':Tmp_L},300);
			$('.koma').removeClass('koma_on');



			if($(this).hasClass('s0')){
				if(	KB[Tmp] == 9 ||	KB[Tmp] == 8){

					//■恐怖無条件成
					if(Tmp_ll == 1 && Player ==0){
						Tmp_ch=1;

					}else if(Tmp_ll == 9 && Player ==1){
						Tmp_ch=1;


					//■恐怖成確認
					}else if(Tmp_ll < 4 && Player ==0){
						Tmp_ch=2;

					}else if(Tmp_ll > 6 && Player ==1){
						Tmp_ch=2;

					}
				} else if(KB[Tmp] == 7){
					//■K無条件成
					if(Tmp_ll < 3 && Player ==0){
						Tmp_ch=1;

					}else if(Tmp_ll >7 && Player ==1){
						Tmp_ch=1;


					//■K成確認
					}else if(Tmp_ll == 3 && Player ==0){
						Tmp_ch=2;

					}else if(Tmp_ll == 7 && Player ==1){
						Tmp_ch=2;

					}

				}else	if(	KB[Tmp] == 3 ||	KB[Tmp] == 4 ||	KB[Tmp] == 6){
					if(Tmp_ll < 4 && Player ==0){
						Tmp_ch=2;

					}else if(Tmp_ll > 6 && Player ==1){
						Tmp_ch=2;

					}
				}
			}


			Te_Count++;
			$.post({
				url:"./post/move_get.php",
				data:{
					'move_id'	:Tmp,
					'move_ll'	:Tmp_ll,
					'move_cc'	:Tmp_cc,
					'move_ch'	:Tmp_ch,
					'count'		:Te_Count,
				},

			}).done(function(data, textStatus, jqXHR){

				TmpId	="";
				Tmp2	="";
				Tmp		="";
				Tmp_cc	="";
				Tmp_ll	="";
				Tmp_ch	="";

				Tmp_C	="";
				Tmp_L	="";

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});
});


