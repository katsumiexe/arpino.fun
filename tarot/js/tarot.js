var Cd=[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
var Rt=[0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,105];
var cd_cnt=[];
var Tmp_X=[];
var Tmp_Y=[];
var Sei	=[];
var N	=0;

var Tarot_cd	=[];
var Tarot_rv	=[];

var Tmp=[0,0,0,0,0,0,0];
var CardCnt=60;
var S_G=['rotate(180deg)',''];

var cd_x=[
[105,110,115,120,125,130,135,140,145,150,155,160,165,170,175,180,185,190,195,200,205,210,215,220,225,230,235,240,245,250,255,260,265,270,275,280,285,290,295,300,305,310,315,320,325,330,335,340,345,350,355,360,365,370,375,380,385,390,395,400,395,390,385,380,375,370,365,360,355,350,345,340,335,330,325,320,315,310,305,300,295,290,285,280,275,270,265,260,255,250,245,240,235,230,225,220,215,210,205,200,195,190,185,180,175,170,165,160,155,150,145,140,135,130,125,120,115,110,105,100,],
[154,158,162,166,170,174,178,182,186,190,194,198,202,206,210,214,218,222,226,230,234,238,242,246,250,254,258,262,266,270,274,278,282,286,290,294,298,302,306,310,314,318,322,326,330,326,322,318,314,310,306,302,298,294,290,286,282,278,274,270,266,262,258,254,250,246,242,238,234,230,226,222,218,214,210,206,202,198,194,190,186,182,178,174,170,166,162,158,154,150,],
[106,112,118,124,130,136,142,148,154,160,166,172,178,184,190,196,202,208,214,220,226,232,238,244,250,256,262,268,274,280,286,292,298,304,310,316,322,328,334,340,346,352,358,364,370,376,382,388,394,400,394,388,382,376,370,364,358,352,346,340,334,328,322,316,310,304,298,292,286,280,274,268,262,256,250,244,238,232,226,220,214,208,202,196,190,184,178,172,166,160,154,148,142,136,130,124,118,112,106,100,],
[185,190,195,200,205,210,215,220,225,230,235,240,245,250,255,260,265,270,275,280,285,290,295,300,305,310,315,320,325,330,325,320,315,310,305,300,295,290,285,280,275,270,265,260,255,250,245,240,235,230,225,220,215,210,205,200,195,190,185,180,],
[183,186,189,192,195,198,201,204,207,210,213,216,219,222,225,228,231,234,237,240,243,246,249,252,255,258,261,264,267,270,273,276,279,282,285,288,291,294,297,300,303,306,309,312,315,318,321,324,321,318,315,312,309,306,303,300,297,294,291,288,285,282,279,276,273,270,267,264,261,258,255,252,249,246,243,240,237,234,231,228,225,222,219,216,213,210,207,204,201,198,195,192,189,186,183,180,],
[105,110,115,120,125,130,135,140,145,150,155,160,165,170,175,180,185,190,195,200,205,210,215,220,225,230,235,240,245,250,255,260,265,270,275,280,285,290,295,300,305,310,315,320,325,330,335,340,345,350,355,360,365,370,375,380,375,370,365,360,355,350,345,340,335,330,325,320,315,310,305,300,295,290,285,280,275,270,265,260,255,250,245,240,235,230,225,220,215,210,205,200,195,190,185,180,175,170,165,160,155,150,145,140,135,130,125,120,115,110,105,100,],
[107,114,121,128,135,142,149,156,163,170,177,184,191,198,205,212,219,226,233,240,247,254,261,268,275,282,289,296,303,310,317,324,331,338,345,352,359,366,373,380,387,394,401,408,401,394,387,380,373,366,359,352,345,338,331,324,317,310,303,296,289,282,275,268,261,254,247,240,233,226,219,212,205,198,191,184,177,170,163,156,149,142,135,128,121,114,107,100,],
]

var cd_y=[
[167,164,161,158,155,152,149,146,143,140,137,134,131,128,125,122,119,116,113,110,107,104,101,98,95,92,89,86,83,80,83,86,89,92,95,98,101,104,107,110,113,116,119,122,125,128,131,134,137,140,143,146,149,152,155,158,161,164,167,170,173,176,179,182,185,188,191,194,197,200,203,206,209,212,215,218,221,224,227,230,233,236,239,242,245,248,251,254,257,260,257,254,251,248,245,242,239,236,233,230,227,224,221,218,215,212,209,206,203,200,197,194,191,188,185,182,179,176,173,170,],
[172,169,166,163,160,157,154,151,148,145,142,139,136,133,130,127,124,121,118,115,112,109,106,109,112,115,118,121,124,127,130,133,136,139,142,145,148,151,154,157,160,163,166,169,172,175,178,181,184,187,190,193,196,199,202,205,208,211,214,217,220,223,226,229,232,235,238,241,238,235,232,229,226,223,220,217,214,211,208,205,202,199,196,193,190,187,184,181,178,175,],
[166,162,158,154,150,146,142,138,134,130,126,122,118,114,110,106,102,98,94,90,86,82,78,74,70,74,78,82,86,90,94,98,102,106,110,114,118,122,126,130,134,138,142,146,150,154,158,162,166,170,174,178,182,186,190,194,198,202,206,210,214,218,222,226,230,234,238,242,246,250,254,258,262,266,270,266,262,258,254,250,246,242,238,234,230,226,222,218,214,210,206,202,198,194,190,186,182,178,174,170,],
[167,164,161,158,155,152,149,146,143,140,137,134,131,128,125,128,131,134,137,140,143,146,149,152,155,158,161,164,167,170,173,176,179,182,185,188,191,194,197,200,203,206,209,212,215,212,209,206,203,200,197,194,191,188,185,182,179,176,173,170,],
[168,166,164,162,160,158,156,154,152,150,148,146,144,142,140,138,136,134,132,130,128,126,124,122,124,126,128,130,132,134,136,138,140,142,144,146,148,150,152,154,156,158,160,162,164,166,168,170,172,174,176,178,180,182,184,186,188,190,192,194,196,198,200,202,204,206,208,210,212,214,216,218,216,214,212,210,208,206,204,202,200,198,196,194,192,190,188,186,184,182,180,178,176,174,172,170,],
[167,164,161,158,155,152,149,146,143,140,137,134,131,128,125,122,119,116,113,110,107,104,101,98,95,92,89,86,89,92,95,98,101,104,107,110,113,116,119,122,125,128,131,134,137,140,143,146,149,152,155,158,161,164,167,170,173,176,179,182,185,188,191,194,197,200,203,206,209,212,215,218,221,224,227,230,233,236,239,242,245,248,251,254,251,248,245,242,239,236,233,230,227,224,221,218,215,212,209,206,203,200,197,194,191,188,185,182,179,176,173,170,],
[165,160,155,150,145,140,135,130,125,120,115,110,105,100,95,90,85,80,75,70,65,60,65,70,75,80,85,90,95,100,105,110,115,120,125,130,135,140,145,150,155,160,165,170,175,180,185,190,195,200,205,210,215,220,225,230,235,240,245,250,255,260,265,270,275,280,275,270,265,260,255,250,245,240,235,230,225,220,215,210,205,200,195,190,185,180,175,170,],
]

$(function(){ 
	for(i=0;i<50;i++){
		var No1		= Math.floor(Math.random() * 22);
		var No2		= Math.floor(Math.random() * 22);
		var Tmp_s	=Cd[No1];
		 Cd[No1]	=Cd[No2];
		 Cd[No2]	=Tmp_s;
	}
console.log(Cd);
	cd_cnt[0]=cd_y[0].length;
	cd_cnt[1]=cd_y[1].length;
	cd_cnt[2]=cd_y[2].length;
	cd_cnt[3]=cd_y[3].length;
	cd_cnt[4]=cd_y[4].length;
	cd_cnt[5]=cd_y[5].length;
	cd_cnt[6]=cd_y[6].length;

	for(i=0;i<22;i++){
		var i2	=i % 7;
		Tmp[i]	= Math.floor(Math.random() * cd_cnt[i2]);
		Rt[i]	= Math.floor(Math.random() * 250);
		Sei[i]	=Math.floor(Math.random() * 2);

		Tmp_X=cd_x[i2][Tmp[i]];			
		Tmp_Y=cd_y[i2][Tmp[i]];

		Tmp_i='url("./img/tarot_'+Cd[i]+'.jpg")';

		$('#c'+i).css({'top':Tmp_Y+'px','left':Tmp_X+'px','transform':'rotate('+Rt[i]+'deg)'});
		$('#b'+i).css({'background-image':Tmp_i,'transform':'rotateY(180deg) '+S_G[Sei[i]]});
	}

	$('.hand').draggable({
		drag: function( event, ui ) {
			for(var N=0;N<22;N++){
				var N2=N % 7;

				Tmp[N]+=N%2+1;
				if(Tmp[N]>cd_cnt[N2]){
					Tmp[N]=0;
				}	

				Rt[N]-=N%3+1;
				if(Rt[N]<-359){
					Rt[N]=0;
				}

				Tmp_X=cd_x[N2][Tmp[N]];			
				Tmp_Y=cd_y[N2][Tmp[N]];			
				 $('#c'+N).css({'top':Tmp_Y+'px','left':Tmp_X+'px','transform':'rotate('+Rt[N]+'deg)'});
			}
		},

		stop: function( event, ui ) {
			 $('.hand').fadeOut(1000);
			 $('.card').animate({'top':'250px','left':'25px'},300).css({'transform':'rotate(0deg)'});
			for(var N=0;　N < 22;N++){
				Tmp_a=405-N*18;
				Tmp_b=500+N*40;
				 $('#c'+N).delay(Tmp_b).animate({'left':Tmp_a+'px'},500).addClass('card_sel');
			}
			 $('.guard').delay(2000).fadeOut(0);
			 $('.card').addClass('card_sel').delay(2000).css({'transform':'rotate(0)'});
		},
    });

	$('.hand').hover(
		function(){
			 $(this).css({'color':'#0000d0'});
		},
		function(){
			 $(this).animate({'color':'#d0a060'},200);
	});

	$(document).on({
		'mouseenter': function() {	
			if(CardCnt<230){
				 $(this).animate({'top':'240px'},20).addClass('card_get');
			}
		},

		'mouseleave': function() {
			if(CardCnt<230){
				 $(this).animate({'top':'250px'},0).removeClass('card_get');
			}
		}
	}, '.card_sel');

	$('.main').on('click','.card_get',function(){
		TmpId=$(this).attr('id').replace('c','');
		if(CardCnt<230){
			 $(this)
			 	.removeClass('card_sel')
			 	.animate({'top':'60px','left':CardCnt+'px'},500)
			 $(this).children('.card_f').css('transform','rotateY(-180deg)');
			 $(this).children('.card_b').css('transform','rotateY(0) '+S_G[Sei[TmpId]]);
			CardCnt+=80;
			Tarot_cd[N]=Cd[TmpId];
			Tarot_rv[N]=Sei[TmpId];
			N++;


/*
			$.post({
				url:"post_tarot_set.php",
				data:{
					"card0"	:Tarot_cd[0],
					"card1"	:Tarot_cd[1],
					"card2"	:Tarot_cd[2],
					"rv0"	:Tarot_rv[0],
					"rv1"	:Tarot_rv[1],
					"rv2"	:Tarot_rv[2]
				},
			}).done(function(data, textStatus, jqXHR){
			
			}).fail(function(xhr, textStatus, errorThrown){
			
			}
*/

		}




	});
});
