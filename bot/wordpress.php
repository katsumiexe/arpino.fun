<?php
$mysqli = mysqli_connect("localhost", "tiltowait_greed", "kk1941", "tiltowait_greed");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
//------------------------------------
//theme
//------------------------------------
$now_y	=date("Ymd",time()-172800);
$now	=date("Y-m-d H:i:s");
$val	="";

//-----------------------------------------------------------------------
$app="";
$sql	 ="SELECT cate_id2,tag_id,tag_name FROM buyma_main";
$sql	.=" LEFT JOIN cate2_list as c2 ON cate_id2=c2.tag_id";
$sql	.=" WHERE c2.tag_name IS NULL";
$sql	.=" AND contact_date>='{$now_y}'";

if($res	 = mysqli_query($mysqli,$sql)){
	while($bas = mysqli_fetch_assoc($res)){
		$dat[$bas["cate_id2"]]=1;
	}
}

$sql	 ="SELECT cate_id3,tag_id,tag_name FROM buyma_main";
$sql	.=" LEFT JOIN cate2_list as c2 ON cate_id3=c2.tag_id";
$sql	.=" WHERE c2.tag_name IS NULL";
$sql	.=" AND contact_date>='{$now_y}'";

if($res	 = mysqli_query($mysqli,$sql)){
	while($bas = mysqli_fetch_assoc($res)){
		$dat[$bas["cate_id3"]]=2;
	}
}

foreach($dat as $a1 => $a2){
	if($a2 == 1){
		$list_0=file_get_contents("https://www.buyma.com/r/-S".$a1);

	}else{
		$list_0=file_get_contents("https://www.buyma.com/r/-C".$a1);

	}

	$list_1=explode("\n", $list_0);
	for($n=0;$n<10;$n++){
		if(strpos($list_1[$n],"title")>0){
			if(strpos($list_1[$n],"-")===false){
//				break 2;

			}else{
				$tmp_1=explode("｜", $list_1[$n]);
				$tmp_2=explode("-", $tmp_1[1]);

				$tag_name=trim($tmp_2[0]);
				$app.="('{$now}','{$a1}','{$tag_name}'),";
				$ml_log0.="{$a1}:{$tag_name}\n";
			}
		}
	}
}

if($ml_log0){
	$app=substr($app,0,-1);
	$sql ="INSERT INTO cate2_list (`set_date`,`tag_id`,`tag_name`) VALUES";
	$sql.=$app;
	mysqli_query($mysqli,$sql);
}


//-----------------------------------------------------------------------
$app="";
$sql	 ="SELECT group(thm_id) as gp ,tag_id,tag_name FROM buyma_main";
$sql	 .=" LEFT JOIN thm_list ON gp=tag_id";
$sql	 .=" WHERE thm_id>0";
$sql	 .=" AND tag_id IS NULL";
//$sql	 .=" GROUP BY thm_id";

//$sql	 .=" AND contact_date>='{$now_y}'";

if($res	 = mysqli_query($mysqli,$sql)){
	while($bas = mysqli_fetch_assoc($res)){
		if(!$bas["tag_id"]){
			$dat[$bas["thm_id"]]=1;
			print($bas["thm_id"]."<br>\n");
		}
	}
}

if($dat){
	foreach($dat as $a1 => $a2){
		$list_0=curl_get_contents("https://www.buyma.com/r/-T".$a1."/",360);
		$list_1=explode("\n", $list_0);

		for($n=0;$n<10;$n++){
			if(strpos($list_1[$n],"title")>0){

				if(strpos($list_1[$n]," - ")>0){
					$tmp_1=explode("｜", $list_1[$n]);
					$tmp_2=explode("-", $tmp_1[1]);
					$tmp_3=trim($tmp_2[0]);
					$val.="('{$now}','{$a1}','{$tmp_3}'),";
					$ml_log.="{$a1}:{$tmp_3}\n";
				}
			}
		}
	}
	if($val){
		$val=substr($val,0,-1);
		$sql ="INSERT INTO thm_list (`set_date`,`tag_id`,`tag_name`) VALUES ";
		$sql.=$val;
		mysqli_query($mysqli,$sql);
	}
}

//--------------------------------------------------------------
$sql	 ="SELECT season_id,tag_id,tag_name FROM buyma_main";
$sql	.=" LEFT JOIN season_list ON season_id=tag_id";
$sql	.=" WHERE season_id>0";
$sql	.=" AND tag_id IS NULL";
$sql	.=" GROUP BY season_id";

//$sql	.=" AND contact_date>='{$now_y}'";

if($res	 = mysqli_query($mysqli,$sql)){
	while($bas = mysqli_fetch_assoc($res)){
		if(!$bas["tag_id"]){
			$dat2[$bas["season_id"]]=1;
		}
	}
}

if($dat2){
	foreach($dat2 as $a1 => $a2){
	$list_0=curl_get_contents("https://www.buyma.com/r/-S".$a1."/",360);
		$list_1=explode("\n", $list_0);

		for($n=0;$n<10;$n++){
			if(strpos($list_1[$n],"title")>0){

				if(strpos($list_1[$n],"-")>0){
					$tmp_1=explode("｜", $list_1[$n]);
					$tmp_2=explode(" - ", $tmp_1[1]);
					$tmp_3=trim($tmp_2[0]);
					$val2.="('{$now}','{$a1}','{$tmp_3}'),";
					$ml_log2.="{$a1}:{$tmp_3}\n";
				}
			}
		}
	}

	if($val2){
		$val2=substr($val2,0,-1);
		$sql ="INSERT INTO season_list (`set_date`,`tag_id`,`tag_name`) VALUES ";
		$sql.=$val2;
		mysqli_query($mysqli,$sql);
	}
}


//-----------------------------------------------------------------------
$app="";
$sql	 ="SELECT model_id, model_list.tag_id,item_id FROM buyma_main";
$sql	.=" LEFT JOIN model_list ON  model_id=tag_id";
$sql	.=" WHERE model_id>0";
$sql	.=" AND tag_name IS NULL";
$sql	.=" ORDER BY buyma_main.id DESC";

//$sql	.=" GROUP BY model_id";
$sql	.=" LIMIT 200";
if($res	 = mysqli_query($mysqli,$sql)){
	while($bas = mysqli_fetch_assoc($res)){
		$url="https://www.buyma.com/item/{$bas["item_id"]}/";

		$result = curl_get_contents( $url, 360 );
		$list_1=explode("\n", $result);
		$roop=count($list_1);
		$list2="";
		$list3="";
		$code="";
		$name="";

		$tmp=$bas["model_id"];
		for($n=800;$n<$roop;$n++){
			if(strpos($list_1[$n],'/同じモデル/')>0){
				$list_2	=explode('/', $list_1[$n]);
				$list_3	=explode('"', $list_2[3]);
				$code	=str_replace("model:","",trim($list_3[0]));
				$name	=str_replace(array('">','<'),array('',''),trim($list_2[8]));;
				if(strpos($app,$tmp)>0){
				}else{
					$app.="('{$now}','{$tmp}','{$code}','{$name}'),";
					$ml_log1.="{$tmp}:{$code}/{$name}\n";
				}
				break 1;
			}
		}
	}
}

if($ml_log1){
	$app=substr($app,0,-1);
	$sql ="INSERT INTO model_list (`set_date`,`tag_id`,`tag_code`,`tag_name`) VALUES";
	$sql.=$app;
	mysqli_query($mysqli,$sql);
}

//--------------------------------------------------------------
	$to      = "counterpost2016@gmail.com";
	$subject = "trace_on_buyma_thm";
	$message .= "Category\n";
	$message .= "{$ml_log0}\n";
	$message .= "Model\n";
	$message .= "{$ml_log1}\n";
	$message .= "Theme\n";
	$message .= "{$ml_log}\n";
	$message .= "season\n";
	$message .= "{$ml_log2}\n";
	$headers = 'From: dummy@tko.pw' . "\r\n";
	mb_send_mail($to, $subject, $message, $headers);

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
只今準備中です<br>
</body>
</html>
