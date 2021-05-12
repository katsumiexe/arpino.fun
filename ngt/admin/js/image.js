$(function(){ 
	var VwBase	=$(window).width()/100;
	var VhBase	=$(window).height()/100;
	
	var Fav		=[];
	var cvs_A	=[];
	var Rote	=[];
	var Zoom	=[100,100,100,100,100];
	var Chg		='';

	var ImgTop	=[];
	var ImgLeft	=[];
	var ImgZoom	=[];
	var ImgRote	=[];
	var ImgWidth=[];


	var cvs		=[];
	var ctx		=[];

	var Base_s	=20;
	var Base_l	=150;
	var Base_h	=200;


	$('.img_upd').on('change', function(e){
		Tmp=$(this).attr("id").replace('upd','');

		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}

		var img = new Image();
		var cvs = document.getElementById('cvs'+Tmp);
		var ctx = cvs.getContext('2d');

		reader.onload = (function(file){
			return function(e){
				img.src = e.target.result;
				$("#view").attr("src", e.target.result);
				$("#view").attr("title", file.name);

				img.onload = function() {
					img_W=img.width;
					img_H=img.height;

					if(img_H*3> img_W*4){
						img_A=img_H;

						cvs_X=Math.ceil((img_H-img_W)/2);
						cvs_Y=0;

						css_A=Math.ceil(img_H*Base_l/img_W);
						css_B=Math.ceil( ( Base_l - (img_H*Base_l/img_W)) / 2 );

						$("#cvs"+Tmp).attr({'width': img_A,'height': img_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_B});
						ctx.drawImage(img, 0,0, img_W, img_H, cvs_X, cvs_Y, img_W, img_H);
/*
						cvs_W=1200;
						cvs_H=img_H*(cvs_W/img_W);
						cvs_A=Math.ceil(cvs_H);

						cvs_X=Math.ceil((cvs_H-cvs_W)/2);
						cvs_Y=0;

						css_W=Base_l;
						css_H=Math.ceil(img_H*(css_W/img_W));

						css_A=css_H;
						css_B=Math.ceil(Base_s-(css_A-150)/2);
						css_C=Math.ceil(Base_s-(css_A-200)/2);
*/

					}else{
						cvs_H=1600;
						cvs_W=img_W*(cvs_H/img_H);
						cvs_A=Math.ceil(cvs_W);

						cvs_Y=Math.ceil((cvs_W-cvs_H)/2);
						cvs_X=0;

						css_H=Base_h;
						css_W=Math.ceil(img_W*(css_H/img_H));

						css_A=css_W;
						css_B=Math.ceil(Base_s-(css_A-150)/2);
						css_C=Math.ceil(Base_s-(css_A-200)/2);
					}				

					$("#cvs"+Tmp).attr({'width': cvs_A,'height': cvs_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_C});
					ctx.drawImage(img, 0,0, img_W, img_H,cvs_X, cvs_Y, cvs_W, cvs_H);

					ImgCode = cvs.toDataURL("image/jpeg");
					ImgCode=ImgCode.replace(/^data:image\/jpeg;base64,/, ""),

					ImgWidth[Tmp]		=css_A;
					ImgLeft[Tmp]		=css_B;
					ImgTop[Tmp]			=css_C;

					Rote[Tmp]			=0;
					Zoom[Tmp]			=100;

					$('#c_'+Tmp).val(ImgCode);
					$('#r_'+Tmp).val(0);

					$('#w_'+Tmp).val(img_W);
					$('#h_'+Tmp).val(img_H);

					$('#x_'+Tmp).val(css_B);
					$('#y_'+Tmp).val(css_C);

					$('#zoom'+Tmp).val(100);
					$('#zoom_box'+Tmp).text(100);
				}
			};
		})(file);
		reader.readAsDataURL(file);
	});

	$(".cvs0").draggable();
	$(".cvs0").on("mousemove", function() {
		Tmp=$(this).attr("id").replace('cvs','');

		$('#x_'+Tmp).val($(this).css("left"));
		$('#y_'+Tmp).val($(this).css("top"));
	});

	$('.img_up_del').on('click',function(){	
		Tmp=$(this).attr("id").replace('del','');
		ctx[Tmp].clearRect(0, 0, 1200,1200);
	});

	$('.img_up_rote').on('click',function(){
		Tmp=$(this).attr("id").replace('rote','');

		console.log(Rote[Tmp]);
		$('#cvs'+Tmp).animate( { 'zIndex':1}, {
			duration: 540,
			step: function (now){
				T_rote=Rote[Tmp] - now * 90;
				$(this).css({ transform: 'rotate(' + T_rote + 'deg)' })
			},
			complete:function(){
				$(this).css('zIndex', 0);

				Rote[Tmp] -=90;
				if(Rote[Tmp] <0){
					Rote[Tmp]+=360;
				}
				$('#r_'+Tmp).val(Rote[Tmp]);
			}
		});
	});

	$('.zoom_mi').on( 'click', function () {
		Tmp=$(this).attr("id").replace('mi','');
		Zoom[Tmp]--;
		if(Zoom[Tmp] <100){
			Zoom[Tmp]=100;
		}

		var css_An	=Math.floor(Zoom[Tmp]*css_A/100);
		$("#cvs"+Tmp).css({'width':css_An,'height':css_An});

		$('#zoom_box'+Tmp).text(Zoom[Tmp]);
		$('#zoom'+Tmp).val(Zoom[Tmp]);
	});

	$( '.zoom_pu' ).on( 'click', function () {
		Tmp=$(this).attr("id").replace('pu','');
		Zoom[Tmp]++;
		if(Zoom[Tmp]>200){
			Zoom[Tmp]=200;
		}

		var css_An	=Math.floor(Zoom[Tmp]*css_A/100);
		$("#cvs"+Tmp).css({'width':css_An,'height':css_An});

		$('#zoom_box'+Tmp).text(Zoom[Tmp]);
		$('#zoom'+Tmp).val(Zoom[Tmp]);
	});

	$( '.range_bar' ).on( 'input', function () {

		Tmp=$(this).attr("id").replace('zoom','');
		Zoom[Tmp]=$(this).val();
		if(Zoom[Tmp] > 200){
			Zoom[Tmp]=200;
		}
		if(Zoom[Tmp] < 100){
			Zoom[Tmp]=100;	
		}

		var css_An	=Math.floor(Zoom[Tmp]*css_A/100);
		$("#cvs"+Tmp).css({'width':css_An,'height':css_An});

		$('#zoom_box'+Tmp).text(Zoom[Tmp]);
		$('#zoom'+Tmp).val(Zoom[Tmp]);
	});

	$('.img_up_reset').on( 'click', function () {
		Tmp=$(this).attr("id").replace('reset','');

		Zoom[Tmp]	=100;
		Rote[Tmp]	=0;
		css_A		=ImgWidth[Tmp];
		css_B		=ImgLeft[Tmp];
		css_C		=ImgTop[Tmp];

		$("#cvs"+Tmp).css({'width': css_A,'height': css_A,'left': css_B,'top': css_C, 'transform':'rotate(0deg)'});
		$('#zoom_box'+Tmp).text(100);
		$('#zoom'+Tmp).val(100);

		$('#x_'+Tmp).val(css_B);
		$('#y_'+Tmp).val(css_C);
		$('#r_'+Tmp).val(0);
	});
});
