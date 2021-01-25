$(function(){ 
	var VwBase	=$(window).width()/100;
	var VhBase	=$(window).height()/100;
	
	var Fav			=[];
	var cvs_A		=[];
	var Rote		=[];
	var Zoom		=[100,100,100,100,100];
	var Chg			='';

	var ImgTop	=[];
	var ImgLeft	=[];
	var ImgZoom	=[];
	var ImgRote	=[];

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
					img_S2=Base_l;

					if(img_H /200> img_W/150){
						cvs_W=1200;
						cvs_H=img_H*(cvs_W/img_W);
						cvs_A=Math.ceil(cvs_H);

						cvs_X=(cvs_H-cvs_W)/2;
						cvs_Y=0;

						css_W=Base_l;
						css_H=img_H*(css_W/img_W);

						css_A=css_H;
						css_B=20-(css_A-150)/2;
						css_C=20-(css_A-200)/2;

					}else{
						cvs_H=1200;
						cvs_W=img_W*(cvs_H/img_H);
						cvs_A=Math.ceil(cvs_W);

						cvs_Y=(cvs_W-cvs_H)/2;
						cvs_X=0;

						css_H=Base_l;
						css_W=img_W*(css_H/img_H);

						css_A=css_W;
						css_B=20-(css_A-150)/2;
						css_C=20-(css_A-200)/2;
					}				

					$("#cvs"+Tmp).attr({'width': cvs_A,'height': cvs_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_C});
					ctx.drawImage(img, 0,0, img_W, img_H,cvs_X, cvs_Y, cvs_W, cvs_H);
					ImgCode = cvs.toDataURL("image/jpeg");

						ImgTop[Tmp]		=css_B;
						ImgLeft[Tmp]	=css_C;
						Rote[Tmp]		=0;
						Zoom[Tmp]		=100;
				}
			};
		})(file);
		reader.readAsDataURL(file);
/*
		$('#upd').fileExif(function(exif) {

			if (exif['Orientation']) {

				switch (exif['Orientation']) {
				case 3:
					Rote = 180;
					$('#cvs1').css({
						'transform':'rotate(180deg)',
					});
					break;

				case 8:
					Rote = 270;
					$('#cvs1').css({
						'transform':'rotate(270deg)',

					});
					break;

				case 6:
					Rote = 90;
					$('#cvs1').css({
						'transform':'rotate(90deg)',
					});
					break;
				}
			}
		});
*/


	});

	$(".cvs0").draggable();
	$(".cvs0").on("mousemove", function() {

		Tmp=$(this).attr("id").replace('cvs','');

		ImgLeft[Tmp]	= $(this).css("left");
		ImgTop[Tmp]		= $(this).css("top");

	});

/*
	$('#img_set').on('click',function(){	
		if(ImgCode){
			console.log(Rote);
			
			$('#wait').show();
			$.post({
				url:Dir + "/post/img_set.php",
				data:{
					'img_code'	:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),
					'img_top'	:ImgTop,
					'img_left'	:ImgLeft,
					'img_zoom'	:$('.zoom_box').text(),
					'img_rote'	:Rote,
					'vw_base'	:Base_s/10,
				},

			}).done(function(data, textStatus, jqXHR){
				base_64=data;
				$('.img_box').animate({'top':'120vh'},200);
				var cvs = document.getElementById('cvs'+Tmp);
				var ctx = cvs.getContext('2d');
				ctx.clearRect(0, 0, cvs_A,cvs_A);
				if(base_64){
					$('.mail_img_view').attr('src',"data:image/jpg;base64,"+base_64);
					$('#img_code').val(base_64);

				}else{
					$('.mail_img_view').attr('src',ImgSrc);
					$('#img_code').val();

				}
				$('.set_back').fadeOut(200);	

				$('#wait').hide();
				$('.zoom_box').text('100');
				$('#input_zoom').val('100');
				Rote=0;

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}else{
			$('.img_box').animate({'top':'120vh'},200);
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
			ctx.clearRect(0, 0, cvs_A,cvs_A);
			$('.set_back').fadeOut(200);
			$('#img_code').val('');

		}
	});
*/

	$('.img_up_del').on('click',function(){	
		Tmp=$(this).attr("id").replace('del','');
/*
		var cvs[Tmp] = document.getElementById('cvs'+Tmp);
		var ctx[Tmp] = cvs[Tmp].getContext('2d');
*/
		ctx[Tmp].clearRect(0, 0, 1200,1200);
	});


	$('.img_up_rote').on('click',function(){
		Tmp=$(this).attr("id").replace('rote','');

		for(n=0;n<9;n++){
			Rote[Tmp]-=10;
			$('#cvs'+Tmp).css({'transform':'rotate(' + Rote[Tmp] + 'deg)'});
console.log("●");
		}

//		Rote[Tmp] -=90;
		if(Rote[Tmp] <0){
			Rote[Tmp]+=360;
		}
	});


/*
$('.rotate').animate( { opacity: 1 }, {
	duration: 1000,
		step: function (now) {
			$(this).css({ transform: 'rotate(' + now * -45 + 'deg)' })
	}
});

	$('.img_up_rote').on('click',function(){

		Tmp=$(this).attr("id").replace('rote','');

		$({deg:Rote}).animate({deg:-90 + Rote}, {
			duration:500,
			progress:function() {
				$('#cvs'+Tmp).css({
					'transform':'rotate(' + this.deg + 'deg)',
				});
			},
		});
		Rote -=90;
		if(Rote <0){
			Rote+=360;
		}
	});
*/
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

	$('#img_reset').on( 'click', function () {
		Zoom=100;
		Left=css_B;
		Right=css_B;
		Rote=0;
		$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B, 'transform':'rotate(0deg)'});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

});
