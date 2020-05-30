<?php
$mysqli = mysqli_connect("localhost", "tiltowait_greed", "kk1941", "tiltowait_greed");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
$url[1]="https://www.buyma.com/ranking/buyer/fashion.html";
$url[2]="https://www.buyma.com/ranking/buyer/mens.html";
$url[3]="https://www.buyma.com/ranking/buyer/baby_kids.html";
$url[4]="https://www.buyma.com/ranking/buyer/beauty.html";
$url[5]="https://www.buyma.com/ranking/buyer/lifestyle.html";
$url[6]="https://www.buyma.com/ranking/buyer/sports.html";

mysqli_set_charset($mysqli,'UTF-8'); 
$now=date("Y/m/d",time()-80000);
$now_8=date("Ymd",time()-80000);
$t_date=date("Y-m-d H:i:s");

$f=date(H)+1;

//$list_0=file_get_contents($url[$f]);
//$list_1=explode("\n", $list_0);

$result = curl_get_contents( $url[$f], 360 );
$list_1=explode("\n", $result);
$roop=count($list_1);

$roop=count($list_1);
for($n=600;$n<$roop;$n++){
	if(strpos($list_1[$n],"rankIcon")>0){
		if(strpos($list_1[$n],"icon/rank_")>0){
			$tmp_1=explode("icon/rank_", $list_1[$n]);
			$tmp=substr($tmp_1[1],0,1);			

			$tmp_sp=explode('"', $list_1[$n+4]);
			$shop_name[$tmp]=$tmp_sp[5];

			$tmp_sp2=explode('/', $tmp_sp[3]);
			$shop_id[$tmp]=$tmp_sp2[6];
			$n+=60;

		}else{
			$tmp_1=explode(">", $list_1[$n]);
			$tmp=str_replace("</p","", $tmp_1[1]);

			$tmp_sp=explode('"', $list_1[$n+4]);
			$shop_name[$tmp]=$tmp_sp[5];

			$tmp_sp2=explode('/', $tmp_sp[3]);
			$shop_id[$tmp]=$tmp_sp2[6];
			$n+=27;
		}
	}
}

for($p=1;$p<101;$p++){
	$pg=0;
	while($pg<1){
		$pg++;
		$url="https://www.buyma.com/buyer/{$shop_id[$p]}/sales_{$pg}.html";

		$list_0=file_get_contents($url);
		$list_1=explode("\n", $list_0);
		$roop=count($list_1);

		for($n=830;$n<$roop;$n++){
			if(strpos($list_1[$n],"data_line")>0){
	
				if(strpos($list_1[$n+15],"/")>0){
					$tmp_day=str_replace("<span>","", trim($list_1[$n+15]));
					$tmp_day=str_replace("</span>","", $tmp_day);
					$tmp_cnt=str_replace("<span>成約：","", $list_1[$n+13]);
					$tmp_cnt=str_replace("個 </span>","", $tmp_cnt);

				}else{
					$tmp_day=str_replace("<span>","", trim($list_1[$n+14]));
					$tmp_day=str_replace("</span>","", $tmp_day);
					$tmp_cnt=str_replace("<span>成約：","", $list_1[$n+12]);
					$tmp_cnt=str_replace("個 </span>","", $tmp_cnt);
				}

				if($tmp_day < $now){
					break 2;

				}elseif($tmp_day == $now){

					$list_2=explode('"', $list_1[$n+5]);
					if(strpos($list_2[0],"href")>0){
						$item_id=str_replace("/item/","", $list_2[1]);
						$item_id=str_replace("/","", $item_id);
						$item_img[$item_id]=$list_2[3];
/*
					}else{
						$list_3=explode('/', $list_2[1]);
						$item_id=$list_3[6]+0;
						$item_img[$item_id]=$list_2[1];
*/
					$app.=" ('{$f}','{$now_8}','{$shop_id[$p]}','{$shop_name[$p]}','{$p}','{$item_id}','{$list_2[5]}','{$tmp_cnt}'),";
					}
					$n+=19;
				}
			}
		}
	}
}

$sql	 ="INSERT INTO `buyma_main`(`sh`,`contact_date`,`shop_id`,`shop_name`,`shop_rank`,`item_id`,`item_name`,`count`)VALUES";
$sql	 .=substr($app,0,-1);
mysqli_query($mysqli,$sql);


function curl_get_contents( $url, $timeout = 300 ){
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_HEADER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
	$result = curl_exec( $ch );
	curl_close( $ch );
	return $result;
}

?>
<html>
<head>
<meta name="robots" content="noindex, nofollow">
</head>
<body>
Done
</body>
</html>
