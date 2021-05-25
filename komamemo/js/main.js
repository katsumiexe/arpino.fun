$(function(){
	var KB=[0,1,2,3,3,4,4,5,5,5,5,6,6,6,6,7,7,7,7,8,8,8,8,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9];
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

			Tmp_T=$(this).css('top');
			Tmp_L=$(this).css('left');
			TmpId=$(this).attr('id').replace('c','');
			Tmp2	=$(this).attr('id').replace('koma','');
			Tmp		=$('.koma_on').attr('id').replace('koma','');
			Tmp_cc	=$(this).attr('cc');
			Tmp_ll	=$(this).attr('ll');

			$('.koma').removeClass('koma_on');
			$('.koma_on').animate({'left':Tmp_L,'top':Tmp_T},400);
			$(this).fadeOut(400);

			if($(this).hasClass('s0')){

				if(	KB[Tmp] == 9 ||	KB[Tmp] == 8){

					//■恐怖無条件成
					if(Tmp_ll == 1 && Player ==0){
						Tmp_ch=1;

					}else if(Tmp_ll == 9 && Player ==1){
						Tmp_ch=1;


					//■恐怖成確認
					}else if(Tmp_ll < 4 && Player ==0){
					
					}else if(Tmp_ll > 6 && Player ==1){

					}
				} else if(KB[Tmp] == 7){

					//■K無条件成
					if(Tmp_ll < 3 && Player ==0){
						Tmp_ch=1;

					}else if(Tmp_ll >7 && Player ==1){
						Tmp_ch=1;


					//■K成確認
					}else if(Tmp_ll == 3 && Player ==0){
					
					}else if(Tmp_ll == 7 && Player ==1){

					}

				} else	if(	KB[Tmp] == 3 ||	KB[Tmp] == 4 ||	KB[Tmp] == 6){
					if(Tmp_ll < 4 && Player ==0){
					
					}else if(Tmp_ll > 6 && Player ==1){

					}
				}
			}


			$.post({
				url:"./post/move_get.php",
				data:{
					'move_id'	:Tmp,
					'get_id'	:Tmp2,
					'move_ll'	:Tmp_ll,
					'move_cc'	:Tmp_cc,
					'move_ch'	:Tmp_ch,
				},
				dataType: 'json',

			}).done(function(data, textStatus, jqXHR){
				Te_Count++;
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
			Tmp_T=$(this).css('top');
			Tmp_L=$(this).css('left');
			$('.koma_on').animate({'left':Tmp_L,'top':Tmp_T},300);
			$('.koma').removeClass('koma_on');
		}
	});
});


