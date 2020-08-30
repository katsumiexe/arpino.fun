	var VwBase	=$(window).width()/100;
	var Rote	=0;
	var Zoom	=100;
	var ImgCode	="";

	var Cvs_Y=VwBase *10;
	var Cvs_H=VwBase *40;

$(function(){
	$('#cvs1').css({'height':Cvs_H,'width':Cvs_H,'top':Cvs_Y,'left':Cvs_Y});
	$('#img_top').val(VwBase *10);
	$('#img_left').val(VwBase *10);

	$('#upd').on('change', function(e){
		var file = e.target.files[0];
		var reader = new FileReader();

		//画像でない場合は処理終了
		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}

		Rote	=0;
		Zoom	=100;

		var img = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		reader.onload = (function(file){
			return function(e){

				img.src = e.target.result;
				$("#view").attr("src", e.target.result);
				$("#view").attr("title", file.name);

				img.onload = function() {
					img_W=img.width;
					img_H=img.height;

					img_S2=40*VwBase;

					if(img_H > img_W){
						cvs_W=400;
						cvs_H=img_H*(cvs_W/img_W);
						cvs_A=Math.ceil(cvs_H);

						cvs_X=(cvs_H-cvs_W)/2;
						cvs_Y=0;

						css_W=40*VwBase;
						css_H=img_H*(css_W/img_W);

						css_A=css_H;
						css_B=10*VwBase-(css_A-40*VwBase)/2;

					}else{
						cvs_H=400;
						cvs_W=img_W*(cvs_H/img_H);
						cvs_A=Math.ceil(cvs_W);

						cvs_Y=(cvs_W-cvs_H)/2;
						cvs_X=0;

						css_H=40*VwBase;
						css_W=img_W*(css_H/img_H);

						css_A=css_W;
						css_B=10*VwBase-(css_A-40*VwBase)/2;

					}				

					$("#cvs1").attr({'width': cvs_A,'height': cvs_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_B});

					ctx.drawImage(img, 0,0, img_W, img_H,cvs_X, cvs_Y, cvs_W, cvs_H);
					ImgCode = cvs.toDataURL("image/jpeg");

					$('#img_top').val(css_B);
					$('#img_left').val(css_B);

				}
			};
		})(file);
		reader.readAsDataURL(file);

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
			$('#rote_ck').html(Rote+"□");
		});
	});

	$("#cvs1").draggable();
	$("#cvs1").on("mousemove", function() {

		Left = $("#cvs1").css("left");
		Top = $("#cvs1").css("top");

		$('#img_top').val(Top);
		$('#img_left').val(Left);
	});

	$('#qr_option').hide();
	$('#qr_select,.item2_box_d').on('click',function(){
		$('#qr_option').slideUp(150);
		if($('#qr_option').css('display') == 'none'){
			$('#qr_option').slideDown(150);
		}
	});

	$('.qr_option_a').on('click',function(){
		Clr2 =$(this).attr('id').replace("qr", "");
		Clr1 =$(this).html();
		$('#qr_select').html(Clr1);
		$('#qr').val(Clr2);
		$('#qr_option').slideUp(150);
	});

	$('#set1').on('click',function(){
		$('.pop00,.pop01').fadeIn(100);
	});

	$('#set2').on('click',function(){
		$('.pop00,.pop02').fadeIn(100);
	});

	$('#set3').on('click',function(){
		$('.pop00,.pop03').fadeIn(100);
	});

	$('#yes_1').on('click',function(){
		$('#form1').attr('action','chg.php').submit();
	});

	$('#yes_2').on('click',function(){
		$('#form1').attr('action','config.php').submit();
	});

	$('#yes_3').on('click',function(){
		$('#form1').attr('action','out.php').submit();
	});

	$('#yes_5').on('click',function(){

		if($('#upd').val() == '') {
			$('#err').text('画像の登録がありません');
			$('#err').fadeIn(100).delay(500).fadeOut(500);
			return false;
		}else{
			$('#wait').show();
			var ImgTop		=$('#img_top').val();
			var ImgLeft		=$('#img_left').val();
			var ImgWidth	=$('#img_width').val();
			var ImgHeight	=$('#img_Height').val();
			var ImgZoom		=$('#img_zoom').val();

			$.post("post_config_img_set.php",
			{
				'img_id':IdTmp,
				'img_code':ImgCode.replace(/^data:image\/jpeg;base64,/, ""),
				'img_top':ImgTop,
				'img_left':ImgLeft,
				'img_width':cvs_W,
				'img_height':cvs_H,
				'vw_base':VwBase,
				'img_zoom':ImgZoom,
				'img_rote':Rote
				},
			function(data){

				$('.pop00,.pop05').hide();
				var cvs = document.getElementById('cvs1');
				var ctx = cvs.getContext('2d');
				ctx.clearRect(0, 0, cvs_A,cvs_A);
				$('.config_img_a1, #my_face, #sumb' + IdTmp).attr('src',data + '?t=<?=time()?>');

				$('#s1, #s2, #s3').removeClass('img_sel');
				$('#s' +IdTmp).addClass('img_sel btn_chg');
				$('#d' +IdTmp).addClass('btn_del');
				$('#wait').hide();

				$('.zoom_box').text('100');
				$('#img_zoom').val('100');
				$('#input_zoom').val('100');
			});
		}
	});

	$('.img_rote').on('click',function(){
		$({deg:Rote}).animate({deg:-90 + Rote}, {
			duration:500,
			progress:function() {
				$('#cvs1').css({
					'transform':'rotate(' + this.deg + 'deg)',
				});
			},
		});

		Rote -=90;
		if(Rote <0){
			Rote+=360;
		}
	});

	$('.pop00,.c1').on('click',function(){
		$('.pop00,.pop01,.pop02,.pop03,.pop04,.pop05').fadeOut(150);
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
	});

	$('.zoom_mi').on( 'click', function () {
		Zoom--;
		if(Zoom <100){
			Zoom=100;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$( '.zoom_pu' ).on( 'click', function () {
		Zoom++;
		if(Zoom >200){
			Zoom=200;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$( '#input_zoom' ).on( 'input', function () {
		Zoom=$(this).val();
		if(Zoom > 200){
			Zoom=200;
		}
		if(Zoom < 100){
			Zoom=100;	
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
	});

	$('.img_reset').on( 'click', function () {
		Zoom=100;
		Left=css_B;
		Right=css_B;
		Rote=0;
		$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B, 'transform':'rotate(0deg)'});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);

	});

	$('input:text[name="twitter"]').on('change',function(){
		if($(this).val() ==''){
			$('#qr_3').addClass('sel_off');
			$('#switch1').prop('disabled', true).val();

		}else{
			$('#qr_3').removeClass('sel_off');
			$('#switch1').prop('disabled', false);
		}
	});

	$('input:text[name="insta"]').on('change',function(){
		if($(this).val() ==''){
			$('#qr_4').addClass('sel_off');
			$('#switch2').prop('disabled', true).val();
		}else{
			$('#qr_4').removeClass('sel_off');
			$('#switch2').prop('disabled', false);
		}
	});

	$('input:text[name="cosp"]').on('change',function(){
		if($(this).val() ==''){
			$('#qr_5').addClass('sel_off');
			$('#switch4').prop('disabled', true).val();
		}else{
			$('#qr_5').removeClass('sel_off');
			$('#switch4').prop('disabled', false);
		}
	});

	$('.btn_del').on('click',function(){//削除
		IdTmp =$(this).attr('id').replace("d", "");
		TmpAttr=$('#sumb'+IdTmp).attr('src');
		$('#prv').attr('src',TmpAttr);
		$('#msg').html('登録画像[' +IdTmp+ ']を削除します。<br>よろしいですか');
		$('.pop00').fadeIn(100);
		$('.pop04').fadeIn(100);
	});

	$('.btn_set').on('click',function(){//登録
		IdTmp =$(this).attr('id').replace("t", "");
		$('.pop00').fadeIn(100);
		$('.pop05').fadeIn(100);
	});

	$('.config_img').on('click','.btn_chg',function () {
		IdTmp =$(this).attr('id').replace("s", "");
		$.post("post_config_img_chg.php",
			{
				'user_id':User_id,
				'img_id':IdTmp
			},
			function(){
				NewImg=$('#sumb' + IdTmp).attr('src');
				$('.config_img_a1,#my_face').attr('src',NewImg);
				$('.img_sel').removeClass('img_sel');			
				$('#s'+IdTmp).addClass('img_sel');			
			}
		);
		console.log(IdTmp);
	});

	$('.q_on').on('click',function(){
		$('#q_on_off').val('1');
		$(this).hide();
		$('.q_off').show();
	});

	$('.q_off').on('click',function(){
		$('#q_on_off').val('0');
		$(this).hide();
		$('.q_on').show();
	});

	$('#yes_4').on('click',function(){
		$.post("post_config_img_del.php",
			{
				'user_id':User_id,
				'img_id':IdTmp
			},
			function(data){
				var TOP=$('#sumb' +data ).attr('src');
				$('.config_img_a1').attr('src',TOP);
				$('#sumb' + IdTmp).attr('src',NoImg);
				$('#s1, #s2, #s3').removeClass('img_sel');
				$('#s' + IdTmp).removeClass('btn_chg');
				$('#s' +data).addClass('img_sel');
				$('#d' + IdTmp).removeClass('btn_del');
				$('.pop00,.pop04').fadeOut(150);
			}
		);
	});
});


