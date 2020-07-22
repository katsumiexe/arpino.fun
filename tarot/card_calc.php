<?

	$min_x=150;
	$max_x=370;
	$cnt_x=45;

	$min_y=100;
	$max_y=250;
	$cnt_y=45;

	$min_x=100;
	$max_x=420;
	$cnt_x=60;

	$min_y=60;
	$max_y=280;
	$cnt_y=60;

	$min_x=100;
	$max_x=420;
	$cnt_x=50;

	$min_y=60;
	$max_y=280;
	$cnt_y=50;

	$min_x=180;
	$max_x=350;
	$cnt_x=30;

	$min_y=120;
	$max_y=220;
	$cnt_y=30;

	$min_x=180;
	$max_x=350;
	$cnt_x=48;

	$min_y=120;
	$max_y=220;
	$cnt_y=48;


	$min_x=100;
	$max_x=420;
	$cnt_x=56;

	$min_y=60;
	$max_y=280;
	$cnt_y=56;


	$min_x=100;
	$max_x=420;
	$cnt_x=44;

	$min_y=60;
	$max_y=280;
	$cnt_y=44;


	$add_x=$min_x;
	$add_y=floor(($max_y+$min_y)/2);

	$tmp=($max_x-$min_x)/$cnt_x;
	for($s=0;$s<$cnt_x*2;$s++){

		if($s<$cnt_x){
			$add_x+=floor($tmp);
		}else{
			$add_x-=floor($tmp);
		}
		$res_x.=$add_x.",";
	}
	
	$tmp=($max_y-$min_y)/$cnt_y;
	for($s=0;$s<$cnt_y*2;$s++){


		if($s<$cnt_y/2){
			$add_y-=floor($tmp);

		}elseif($s<$cnt_y){
			$add_y+=floor($tmp);

		}elseif($s<$cnt_y*1.5){
			$add_y+=floor($tmp);

		}else{
			$add_y-=floor($tmp);

		}
		$res_y.=$add_y.",";
	}

	print("[".$res_x."],<br>\n");
	print("[".$res_y."],<br>\n");

?>



