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

	var css_inX	=[];
	var css_inY	=[];

	var css_outX=[];
	var css_outY=[];

	var Tmp_Top	=[];
	var Tmp_Left=[];

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
						img_B=150/img_W;

						cvs_X=Math.ceil((img_H-img_W)/2);
						cvs_Y=0;

						css_A=Math.ceil(img_H*Base_l/img_W);
						css_X=Math.ceil( Base_s - ( css_A - Base_l) / 2 );
						css_Y=Math.ceil( Base_s - ( css_A - Base_h) / 2 );

						css_inX[Tmp]=( css_A - Base_l) / 2;
						css_inY[Tmp]= 0;

						css_outX[Tmp]=(( css_A - Base_l) / 2)+ Base_l;
						css_outX[Tmp]= Base_l;
						css_outY[Tmp]= css_A;



					}else{
						img_A=img_W;
						img_B=200/img_H;

						cvs_Y=Math.ceil((img_W-img_H)/2);
						cvs_X=0;

						css_A=Math.ceil(img_W*Base_h/img_H);
						css_X=Math.ceil( Base_s - ( css_A - Base_l) / 2 );
						css_Y=Math.ceil( Base_s - ( css_A - Base_h) / 2 );

						css_inX[Tmp]=0;
						css_inY[Tmp]=( css_A - Base_h) / 2;

						css_outX[Tmp]= css_A;
						css_outY[Tmp]=( ( css_A - Base_h) / 2 ) + Base_h;
						css_outY[Tmp]=Base_h;

					}


					$("#cvs"+Tmp).attr({'width': img_A,'height': img_A}).css({'width': css_A,'height': css_A,'left': css_X,'top': css_Y});
					ctx.drawImage(img, 0,0, img_W, img_H, cvs_X, cvs_Y, img_W, img_H);
		Tmp_Top[Tmp]	=css_inY[Tmp];
		Tmp_Left[Tmp]	=css_inX[Tmp];

console.log(img_W)
console.log(img_H)
console.log(cvs_X)
console.log(cvs_Y)

console.log("in_y" + css_inY[Tmp]);
console.log("in_x" + css_inX[Tmp]);

console.log("ou_y" + css_outY[Tmp]);
console.log("ou_x" + css_outX[Tmp]);


					ImgCode = cvs.toDataURL("image/jpeg");
					ImgCode=ImgCode.replace(/^data:image\/jpeg;base64,/, "");


					ImgWidth[Tmp]		=css_A;
					ImgLeft[Tmp]		=css_X;
					ImgTop[Tmp]			=css_Y;
					Zoom[Tmp]			=100;

					Rote[Tmp]			=0;



					$('#c_'+Tmp).val(ImgCode);
					$('#r_'+Tmp).val(0);

					$('#w_'+Tmp).val(img_W);
					$('#h_'+Tmp).val(img_H);

					$('#x_'+Tmp).val(css_X);
					$('#y_'+Tmp).val(css_Y);

					$('#zoom'+Tmp).val(100);
					$('#zoom_box'+Tmp).text(100);
					$('#v_'+Tmp).val(img_B);
				}
			}
		})(file);
		reader.readAsDataURL(file);
	});

	$(".cvs0").draggable({
		drag: function( event, ui ){
		var Tmp=$(this).attr("id").replace('cvs','');

			if(ui.position.top > Base_s-css_inY[Tmp]*Zoom[Tmp]/100){
				ui.position.top=Tmp_Top[Tmp];
			}

			if(ui.position.left > Base_s-css_inX[Tmp]*Zoom[Tmp]/100){
				ui.position.left=Tmp_Left[Tmp];
			}

			if(ui.position.top  < Base_s + Base_h - (css_outY[Tmp] + css_inY[Tmp]) * Zoom[Tmp] / 100 ){
				ui.position.top=Tmp_Top[Tmp];
			}

			if(ui.position.left < Base_s + Base_l - (css_outX[Tmp] + css_inX[Tmp])  * Zoom[Tmp] / 100 ){
				ui.position.left=Tmp_Left[Tmp];
			}

			Tmp_Top[Tmp]	=ui.position.top;
			Tmp_Left[Tmp]	=ui.position.Left;
		}
	});


	$(".cvs0").on("mousemove", function() {
		var Tmp=$(this).attr("id").replace('cvs','');
		var TL=$(this).css("left");
		var TT=$(this).css("top");

		$('#x_'+Tmp).val(TL);
		$('#y_'+Tmp).val(TT);
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
		css_X		=ImgLeft[Tmp];
		css_Y		=ImgTop[Tmp];

		$("#cvs"+Tmp).css({'width': ImgWidth[Tmp],'height': ImgWidth[Tmp],'left': ImgLeft[Tmp],'top': ImgTop[Tmp], 'transform':'rotate(0deg)'});
		$('#zoom_box'+Tmp).text(100);
		$('#zoom'+Tmp).val(100);

		$('#x_'+Tmp).val(ImgLeft[Tmp]);
		$('#y_'+Tmp).val(ImgTop[Tmp]);
		$('#r_'+Tmp).val(0);
	});
});

