$(function(){ 
	var VwBase =$(window).width()/100;
	$('#vw_set').val(VwBase);

	$('#page_p0').siblings('.page_in').hide();
	$('#lid0').siblings('.card_list').hide();
	$('#wait').hide();
	$('.image_frame').hide();
	$('#err').hide();

	$('#tab1').click(function(){
		$('#tab1').addClass('tab_set1');
		$('#tab1').animate({'top': '0px','height': '10vw'});

		$('#tab2').removeClass('tab_set2');
		$('#tab3').removeClass('tab_set3');
		$('#tab2,#tab3').animate({'top': '3vw','height': '6vw'});

		$('.folder_all1').fadeIn(200);
		$('.folder_all2, .folder_all3').fadeOut(0);
	});

	$('#tab2').click(function(){
		$('#tab2').addClass('tab_set2');
		$('#tab2').animate({'top': '0px','height': '10vw'});

		$('#tab1').removeClass('tab_set1');
		$('#tab3').removeClass('tab_set3');
		$('#tab1,#tab3').animate({'top': '3vw','height': '6vw'});

		$('.folder_all2').fadeIn(200);
		$('.folder_all1, .folder_all3').fadeOut(0);
	});

	$('#tab3').click(function(){
		$('#tab3').addClass('tab_set3');
		$('#tab3').animate({'top': '0px','height': '10vw'});

		$('#tab2').removeClass('tab_set2');
		$('#tab1').removeClass('tab_set1');
		$('#tab2,#tab1').animate({'top': '3vw','height': '8vw'});

		$('.folder_all3').fadeIn(200);
		$('.folder_all2, .folder_all1').fadeOut(0);
	});

	$('input[name="tmpl_style3"]:radio' ).change(function() { 
		var rV = $(this).val();
		$('#page_p' + rV).siblings('.page_in').hide();
		$('#page_p' + rV).show();

		$('#lid' + rV).siblings('.card_list').hide();
		$('#lid' + rV).show();
	});

	$('.sub_slide,.sub_slide2,.sub_slide3').hide();
	$('.grid_a,.grid_b').hide();

	if($('.contact_orgin').val() ==''){
		$('.word3_orgin').hide();
	}

	if($('#ck_twitter').val() =='' && $('#ck_cosp').val() =='' && $('#ck_insta').val() ==''){
		$('.word2').hide();
	}

	if($('#ck_twitter').val() ==''){
		$('#qr_twitter,.word2_twitter').hide();
	}

	if($('#ck_cosp').val() ==''){
		$('#qr_cosp,.word2_cosp').hide();
	}

	if($('#ck_insta').val() ==''){
		$('#qr_insta,.word2_insta').hide();
	}
/*
	$('#bs01').text(Height*VwBase);
	$('#bs02').text(Width*VwBase);
	$('#id_height').val(Height*VwBase);
	$('#id_width').val(Width*VwBase);
*/

	$('.trim_img2').draggable();
	$('.trim_img2').on("mousemove", function() {
		Left = $('.trim_img2').css("left");
		Top = $('.trim_img2').css("top");

		$('.trim_img').css('top',Top);
		$('.trim_img').css('left',Left);

		Top_v=parseFloat(Top)/parseFloat(VwBase);
		Left_v=parseFloat(Left)/parseFloat(VwBase);

		$('#st01').text(Top_v);
		$('#st02').text(Left_v);
		$('#id_top').val(Top_v);
		$('#id_left').val(Left_v);
	});

	$('.main_slide').on('click',function(){
		$('.main_slide,.main_slide2').removeClass("main_ck");
		$('.sub_slide,.sub_slide2').slideUp(50);
		if($('.sub_slide').css('display') == 'none'){
			$('.sub_slide').slideDown(150);
			$('.main_slide').addClass("main_ck");
		}
	});

	$('.main_slide2').on('click',function(){
		$('.main_slide,.main_slide2').removeClass("main_ck");
		$('.sub_slide,.sub_slide2').slideUp(50);
		if($('.sub_slide2').css('display') == 'none'){
			$('.sub_slide2').slideDown(150);
			$('.main_slide2').addClass("main_ck");
		}
	});

	$('.main_slide3').on('click',function(){
		$('.sub_slide3').animate({width: "toggle", opacity: "toggle"},100);
		$('.main_slide3').toggleClass("main_ck");
	});

	$('.main_slide4').on('click',function(){
		$('#forms').submit();
	});

	$('.close1,.close2').on('click',function(){
		$('.sub_slide,.sub_slide2').slideUp(5);
		$('.main_slide, .main_slide2').removeClass("main_ck");
	});

	$('#reset_text').on('click',function(){
		$(this).toggleClass('text_on');
		$('.word').toggle();
	});


	$('#reset_all').on('click',function(){
	    setTimeout(function(){
			$(this).removeClass("on3").addClass("on3");
	    },100);

		$('#cl9').addClass("on1");
		$('#edit_b2').removeClass("on2");
		$('#edit_b3').removeClass("on5");
		$('.range_pt').text(100);
		$('.range_bar').val(100);

		$('.trim_img').css({
			'width':Width+'vw',
			'height':Height+'vw',
			'top'	:'3vw',
			'left'	:'3vw',
			'transform'	:'rotate(0deg)',
			'transform'	:'scale(1,1)',
			'filter':'brightness(100%) sepia(0%) grayscale(0%)'
		});

		var TW=Width*VwBase;
		var TH=Height*VwBase;
		
		$('.trim_img2').css({
			'width'	:TW,
			'height':TH,
			'top'	:'3vw',
			'left'	:'3vw',
		});

		Top	=3;
		Left=3;
		Rote=0;
		Zoom=100;
		wTurn=0;
		vTurn=0;
		Bright=100;
		Gray=0;
		Sepia=0;
	});

	$( '#input_lxs' ).on( 'input', function () {
		Bright=	$(this).val();
		if(Bright > 200){
			Bright=200;
		}
		if(Bright < 5){
			Bright=5;	
		}

		$('.trim_img').css({'filter':'brightness('+ Bright +'%) grayscale('+Gray+'%) sepia('+Sepia+'%)'});
		$('#lxs').text(Bright);
		$('#input_lxs,#id_bright').val(Bright);
	});


	$('.lxs_mi').on( 'click', function () {
		Bright--;
		if(Bright <5){
			Bright=5;
		}

		$('.trim_img').css({'filter':'brightness('+ Bright +'%) grayscale('+Gray+'%) sepia('+Sepia+'%)'});
		$('#lxs').text(Bright);
		$('#input_lxs,#id_bright').val(Bright);
	});

	$( '.lxs_pu' ).on( 'click', function () {
		Bright++;
		if(Bright >200){
			Bright=200;
		}

		$('.trim_img').css({'filter':'brightness('+ Bright +'%) grayscale('+Gray+'%) sepia('+Sepia+'%)'});
		$('#lxs').text(Bright);
		$('#input_lxs,#id_bright').val(Bright);
	});



	$('.zoom_mi').on( 'click', function () {
		Zoom--;
		if(Zoom <10){
			Zoom=10;
		}

		var vWidth	=Math.floor(Zoom*Width*VwBase/100);
		var vHeight	=Math.floor(Zoom*Height*VwBase/100);
		$('.trim_img, .trim_img2').css({'width':vWidth,'height':vHeight});

		$('#zoomin,#st05').text(Zoom);
		$('#id_zoom').val(Zoom);
		$('#bs01').text(vWidth);
		$('#bs02').text(vHeight);
		$('#id_height').val(vHeight);
		$('#id_width').val(vWidth);

	});

	$( '.zoom_pu' ).on( 'click', function () {
		Zoom++;
		if(Zoom >200){
			Zoom=200;
		}

		var vWidth	=Math.floor(Zoom*Width*VwBase/100);
		var vHeight	=Math.floor(Zoom*Height*VwBase/100);
		$('.trim_img, .trim_img2').css({'width':vWidth,'height':vHeight});

		$('#zoomin,#st05').text(Zoom);
		$('#input_zoom').val(Zoom);
		$('#bs01').text(vWidth);
		$('#bs02').text(vHeight);
		$('#id_height').val(vHeight);
		$('#id_width').val(vWidth);

	});

	$( '#input_zoom' ).on( 'input', function () {
		Zoom=$(this).val();
		if(Zoom > 200){
			Zoom=200;
		}
		if(Zoom < 10){
			Zoom=10;	
		}
		var vWidth	=Math.floor(Zoom*Width*VwBase/100);
		var vHeight	=Math.floor(Zoom*Height*VwBase/100);
		
		$('.trim_img,.trim_img2').css({'width':vWidth,'height':vHeight});

		$('#zoomin,#st05').text(Zoom);
		$('#id_zoom').val(Zoom);
		$('#bs01').text(vWidth);
		$('#bs02').text(vHeight);
		$('#id_height').val(vHeight);
		$('#id_width').val(vWidth);

	});

/*
	$('#cl3').click(function(){
		$(this).addClass("on3");
	    setTimeout(function(){
			$('#cl3').removeClass("on3");
	    },100);
		Bright+=5;
		if(Bright > 200){
			Bright=200;
		}
		$('.trim_img').css({'filter':'brightness('+ Bright +'%) grayscale('+Gray+'%) sepia('+Sepia+'%)'});
		$('#st04').text(Bright);
		$('#id_bright').val(Bright);
	});
*/

/*
	$('#cl4').click(function(){
		$(this).addClass("on3");
	    setTimeout(function(){
			$('#cl4').removeClass("on3");
	    },100);
		Bright=100;
		$('.trim_img').css({'filter':'brightness('+ Bright +'%) grayscale('+Gray+'%) sepia('+Sepia+'%)'});
		$('#st04').text(Bright);
		$('#id_bright').val(Bright);
	});

*/

/*
	$('#cl5').click(function(){
		$(this).addClass("on3");
	    setTimeout(function(){
			$('#cl5').removeClass("on3");
	    },100);
		Bright-=5;
		if(Bright < 0){
			Bright=0;
		}
		$('.trim_img').css({'filter':'brightness('+ Bright +'%) grayscale('+Gray+'%) sepia('+Sepia+'%)'});
		$('#st04').text(Bright);
		$('#id_bright').val(Bright);
	});
*/

/*-------------------------------------------------------------------- */
	$('#edit_a1').on('click',function(){
		$({deg:vTurn}).animate({deg:180 + vTurn}, {
			duration:500,
			progress:function() {
				$('.trim_img').css({
					'transform': 'rotateX(' + this.deg + 'deg) rotateY(' + wTurn + 'deg)',
				});
			},
		});
		vTurn +=180;
		if(vTurn >= 360){
			vTurn-=360;
		}
		$('#id_vturn').val(vTurn);
	});

	$('#edit_a2').on('click',function(){
		$({deg:wTurn}).animate({deg:180 + wTurn}, {
			duration:500,
			progress:function() {
				$('.trim_img').css({
					'transform': 'rotateY(' + this.deg + 'deg) rotateX(' + vTurn + 'deg)',
				});
			},
		});
		wTurn +=180;
		if(wTurn >= 360){
			wTurn-=360;
		}
		$('#id_wturn').val(wTurn);
	});

	$('#edit_a3').click(function(){/*たてそろえ*/
		$(this).addClass("on3");
	    setTimeout(function(){
			$('#edit_a3').removeClass("on3");
	    },100);

		if(Rote == 90 || Rote == 270){
			Zoom=Math.floor(14560 / Width);
			Fitt=Math.floor(Zoom * height/100);
			$('.trim_img').css({'top':'3vw','left':'3vw','width':'145.6vw','height':Fitt +'vw'});
			$('.trim_img2').css({'top':'3vw','left':'3vw','width':'145.6vw','height':Fitt +'vw'});

		}else{
			Zoom=Math.floor(14560 / Height);
			Fitt=Math.floor(Zoom * Width/100);
			$('.trim_img').css({'top':'3vw','left':'3vw','height':'145.6vw','width':Fitt +'vw'});
			$('.trim_img2').css({'top':'3vw','left':'3vw','height':'145.6vw','width':Fitt +'vw'});
		}
		$('#st01').text('10');
		$('#st02').text('10');
		$('#st05').text(Zoom);
		$('#zoomin').text(Zoom);
		$('#input_zoom').val(Zoom);
		$('#id_zoom').val(Zoom);
	});

	$('#edit_a4').click(function(){/*よこそろえ*/
		$(this).addClass("on3");
	    setTimeout(function(){
			$('#edit_a4').removeClass("on3");
	    },100);

		Zoom=Math.floor(27500 / Width);
		Fitt=Math.floor(Zoom * Height/100);
		$('.trim_img').css({'top':'3vw','left':'3vw','height':Fitt +'px','width':'78vw'});
		$('.trim_img2').css({'top':'3vw','left':'3vw','height':Fitt +'px','width':'78vw'});
		$('#st01').text('3');
		$('#st02').text('3');
		$('#st05').text(Zoom);
		$('#zoomin').text(Zoom);
		$('#input_zoom').val(Zoom);
		$('#id_zoom').val(Zoom);
	});

	$('#edit_b1').click(function(){
		Bright=100;
		Sepia=0;
		Gray=0;
		$('.trim_img').css({'filter':'brightness(100%)'});
		$('#edit_b1').addClass("on1");
		$('#edit_b2').removeClass("on2");
		$('#edit_b3').removeClass("on3");

		$('#st06').text(Bright);
		$('#id_bright').val(Bright);
		$('#id_sepia').val(Sepia);
		$('#id_gray').val(Gray);
	});

	$('#edit_b2').click(function(){
		Bright=100;
		Sepia=120;
		Gray=0;
		$('.trim_img').css({'filter':'sepia(120%)'});
		$('#edit_b1').removeClass("on1");
		$('#edit_b2').addClass("on2");
		$('#edit_b3').removeClass("on3");

		$('#st06').text(Bright);
		$('#id_bright').val(Bright);
		$('#id_sepia').val(Sepia);
		$('#id_gray').val(Gray);
	});

	$('#edit_b3').click(function(){
		Bright=100
		Sepia=0;
		Gray=100;
		$('.trim_img').css({'filter':'grayscale(100%)'});
		$('#edit_b1').removeClass("on1");
		$('#edit_b2').removeClass("on2");
		$('#edit_b3').addClass("on3");
		$('#st06').text(Bright);

		$('#id_bright').val(Bright);
		$('#id_sepia').val(Sepia);
		$('#id_gray').val(Gray);
	});

	$('#edit_c1').click(function(){
		$('#edit_c1').addClass("on4");
		$('#edit_c2').removeClass("on4");
		$('#edit_c3').removeClass("on4");

		$('.grid_a').hide(0);
		$('.grid_b').hide(0);
	});

	$('#edit_c2').click(function(){
		$('#edit_c2').addClass("on4");
		$('#edit_c1').removeClass("on4");
		$('#edit_c3').removeClass("on4");

		$('.grid_a').show(0);
		$('.grid_b').hide(0);
	});

	$('#edit_c3').click(function(){
		$('#edit_c3').addClass("on4");
		$('#edit_c2').removeClass("on4");
		$('#edit_c1').removeClass("on4");

		$('.grid_a').show(0);
		$('.grid_b').show(0);
	});

/*---------------------------------------------- */

	$('#name_chg').click(function(){
		var NameText = $("#name_text").val();
		var NameClr = $("#name_text").val();

		$("#string").text(newText);
	});
/*
	$('#myfile').change(function(e){
		//ファイルオブジェクトを取得する
		var file = e.target.files[0];
		var reader = new FileReader();

		//画像でない場合は処理終了
		if(file.type.indexOf("image") < 0){
			alert("画像ファイルを指定してください。");
			return false;
		}

		//アップロードした画像を設定する
		reader.onload = (function(file){
			return function(e){
				$("#img1").attr("src", e.target.result);
				$("#img1").attr("title", file.name);
			};
		})(file);
		reader.readAsDataURL(file);
	});
*/

	$('.input-file').on('change', function() {
		var file_name = $(this).prop('files')[0].name;
		$(this).parent().next().html(file_name);
	});

	$('#ck_name').on('change', function() {
		var val = $(this).val();
		$('.word1_1').text(val);
		$('#err').fadeOut(50);
	});

	$('#ck_orgin').on('change', function() {
		var val = $(this).val();
		$('.word3').text(val);
	});

	$('#ck_twitter').on('change', function() {
		var val = $(this).val();

		$('.contact_twitter').text(val);
		if($('#ck_twitter').val() =='' && $('#ck_cosp').val() =='' && $('#ck_insta').val() ==''){
			$('.word2').hide();
		}else{
			$('.word2').show();
		}

		if(val ==""){
			$('.word2_twitter').hide();
		}else{
			$('.word2_twitter').show();
		}
	});

	$('#ck_insta').on('change', function() {
		var val = $(this).val();

		$('.contact_insta').text(val);
		if($('#ck_twitter').val() =='' && $('#ck_cosp').val() =='' && $('#ck_insta').val() ==''){
			$('.word2').hide();
		}else{
			$('.word2').show();
		}
		if(val ==""){
			$('.word2_insta').hide();
		}else{
			$('.word2_insta').show();
		}
	});

	$('#ck_cosp').on('change', function() {
		var val = $(this).val();

		$('.contact_cosp').text(val);
		if($('#ck_twitter').val() =='' && $('#ck_cosp').val() =='' && $('#ck_insta').val() ==''){
			$('.word2').hide();
		}else{
			$('.word2').show();
		}
		if(val ==""){
			$('.word2_cosp').hide();

		}else{
			$('.word2_cosp').show();
		}
	});

    $('#ok').on('click',function(){
	    $('#forms').attr('action', './making_ok.php');
	    $('#forms').submit();
    });
	
    $('#ch').on('click',function(){
	    $('#forms').attr('action', './making_mk.php');
	    $('#forms').submit();
    });
	
    $('#no').on('click',function(){
	    $('#forms').attr('action', './index.php');
	    $('#forms').submit();
    });
});
