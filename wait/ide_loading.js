function IdeLoading(){
	var N1=1000;
	var N2=40;
	$('.nowloading_back').show().html('<div class="nowloading"><div class="main_circle"><div class="mid_circle"><div class="line_a"></div><div class="line_b"></div><div class="line_c"></div><div class="line_d"></div><div class="line_e"></div><div class="line_f"></div><div class="line_g"></div><div class="point"></div><div class="point2"></div><div class="circle"><svg width="120" height="120"><circle cx="60" cy="60" r="58"></svg></div></div></div><div id="ld0" class="nowloading_text">U</div><div id="ld1" class="nowloading_text">P</div><div id="ld2" class="nowloading_text">L</div><div id="ld3" class="nowloading_text">O</div><div id="ld4" class="nowloading_text">A</div><div id="ld5" class="nowloading_text">D</div><div id="ld6" class="nowloading_text">I</div><div id="ld7" class="nowloading_text">N</div><div id="ld8" class="nowloading_text">G</div><div id="ld9" class="nowloading_text">.</div><div id="ld10" class="nowloading_text">.</div><div id="ld11" class="nowloading_text">.</div></div></div>');
	setInterval(function(){
		N1=N1-100;
		if(N1<300) N1=300;
		N2=N2+10;
		if(N2>120) N2=120;
		$('.point').animate({width: N2 ,height: N2 , opacity: 0}, N1).animate({width:'5px',height:'5px', opacity: 1}, 1);
	},0);
	setInterval(function(){
		$('#ld0').animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(3000);
		$('#ld1').delay(150).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(2850);
		$('#ld2').delay(300).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(2700);
		$('#ld3').delay(450).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(2550);
		$('#ld4').delay(600).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(2400);
		$('#ld5').delay(750).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(2250);
		$('#ld6').delay(900).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(2100);
		$('#ld7').delay(1050).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(1950);
		$('#ld8').delay(1200).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(1800);
		$('#ld9').delay(1350).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(1650);
		$('#ld10').delay(1500).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(1500);
		$('#ld11').delay(1650).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(1350);
		$('#ld12').delay(1800).animate({bottom: '10px'}, 300).animate({bottom: '5px'}, 300).delay(1200);
	});
	$('.line_a').delay(1200).fadeIn(0).animate({height:'116px'}, 800);
	$('.line_c,.line_b').delay(1600).fadeIn(0).animate({height:'90px'}, 800);
	$('.line_d,.line_e,.line_f').delay(2000).fadeIn(0).animate({height:'56px'}, 500);
	$('.line_g').delay(2200).fadeIn(0).animate({width:'70px'}, 600);
}
