$(function(){
	KH=$('#koma1').height();
	KW=$('#koma1').width();
	
	MH=$('.masu').height();
	MW=$('.masu').width();

	$('#k_size_h').text(KH);
	$('#k_size_w').text(KW);
	$('#m_size_h').text(MH);
	$('#m_size_w').text(MW);

console.log(KH);
console.log(KW);

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

			Tmp_C	=72-$(this).attr('cc')*8;
			Tmp_L	=$(this).attr('ll') *9 -5 ;
			$('.koma_on').animate({'left':Tmp_C+'vw','top':Tmp_L+'vw'},300);

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

			Tmp_C	=72-$(this).attr('cc')*8;
			Tmp_L	=$(this).attr('ll') *9 -5 ;

			$('.koma_on').animate({'left':Tmp_C+'vw','top':Tmp_L+'vw'},300);
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

console.log("□"+Coma[Player]  + Tmp_cc+ Masu_L[Tmp_ll]);

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


