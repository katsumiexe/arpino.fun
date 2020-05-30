<?php
$mysqli = mysqli_connect("localhost", "tiltowait_greed", "kk1941", "tiltowait_greed");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$now=date("Ymd",time()-86400);
$f=date(H)+1;
$peep_date=date("Y-m-d H:i:s");

$sql	 ="SELECT id, item_id FROM `buyma_main`";
$sql	.=" WHERE sh='{$f}'";
$sql	.=" AND done<>1";
$sql	.=" AND contact_date='{$now}'";

if($res	 = mysqli_query($mysqli,$sql)){
	while($bas = mysqli_fetch_assoc($res)){
		$url="https://www.buyma.com/item/{$bas["item_id"]}/";

		$result = curl_get_contents( $url, 360 );
		$list_1=explode("\n", $result);
		$roop=count($list_1);

		$img_sub	="";
		$state		="";
		$price		="";

		$cate_id1	="";
		$cate_id2	="";
		$cate_id3	="";

		$brand_id	="";
		$brand_name	="";
		$model_id	="";
		$season_id	="";
		$tag_id		="";
		$thm_id		="";
		$state_id	="";

		for($n=10;$n<$roop;$n++){
			if(strpos($list_1[$n],"og:image")>0){
				$list_2=explode("item/", $list_1[$n]);
				$list_3=explode('"', $list_2[1]);
				$img_sub=$list_3[0];

			}elseif(strpos($list_1[$n],"twitter:data2")>0){
				$list_2=explode('"', $list_1[$n]);
				$state=$list_2[3];
				$n+=150;

			}elseif(strpos($list_1[$n],"item.tanka")>0){
				$list_2=explode("=", $list_1[$n]);
				$price=str_replace(array(';','"'),array('',''),trim($list_2[1]));

			}elseif(strpos($list_1[$n],"item.cate_id1")>0){
				$list_2=explode("=", $list_1[$n]);
				$cate_id1=str_replace(";","",trim($list_2[1]));

			}elseif(strpos($list_1[$n],"item.cate_id2")>0){
				$list_2=explode("=", $list_1[$n]);
				$cate_id2=str_replace(";","",trim($list_2[1]));

			}elseif(strpos($list_1[$n],"item.cate_id3")>0){
				$list_2=explode("=", $list_1[$n]);
				$cate_id3=str_replace(";","",trim($list_2[1]));

			}elseif(strpos($list_1[$n],"item.brand_id")>0){
				$list_2=explode("=", $list_1[$n]);
				$brand_id=str_replace(";","",trim($list_2[1]));

			}elseif(strpos($list_1[$n],"item.model_id")>0){
				$list_2=explode("=", $list_1[$n]);
				$model_id=str_replace(";","",trim($list_2[1]));

			}elseif(strpos($list_1[$n],"season_id")>0){
				$list_2=explode("=", $list_1[$n]);
				$season_id=str_replace(";","",trim($list_2[1]));

			}elseif(strpos($list_1[$n],"em.tag_ids")>0){
				$list_2=explode("=", $list_1[$n]);
				$tag_ids=str_replace(";","",trim($list_2[1]));
				$tag_ids=str_replace("[",",",$tag_ids);
				$tag_ids=str_replace(" ","",$tag_ids);
				$tag_ids=str_replace("]",",",$tag_ids);

			}elseif(strpos($list_1[$n],"thm_id")>0){
				$list_2=explode("=", $list_1[$n]);
				$thm_id=str_replace(";","",trim($list_2[1]));
				$n+=590;

			}elseif(strpos($list_1[$n],">商品一覧<")>0){
				$list_2=explode("/", $list_1[$n]);
				$brand_name=trim($list_2[2]);
				break 1;

			}elseif(strpos($list_1[$n],">申し訳ございません")>0){
				$list_2=explode("/", $list_1[$n+17]);
				$brand_name=trim($list_2[6]);
				break 1;
			}


		}

		$sql	 ="UPDATE `buyma_main` SET";
		$sql	.=" peep_date='{$peep_date}',";
		$sql	.=" state='{$state}',";
		$sql	.=" price='{$price}',";

		$sql	.=" cate_id1='{$cate_id1}',";
		$sql	.=" cate_id2='{$cate_id2}',";
		$sql	.=" cate_id3='{$cate_id3}',";

		$sql	.=" brand_id='{$brand_id}',";
		$sql	.=" brand_name='{$brand_name}',";
		$sql	.=" model_id='{$model_id}',";
		$sql	.=" season_id='{$season_id}',";

		$sql	.=" tag_ids='{$tag_ids}',";
		$sql	.=" thm_id='{$thm_id}',";
		$sql	.=" img_sub='{$img_sub}',";
		$sql	.=" done='1'";

		$sql	.=" WHERE id='{$bas["id"]}'";
		mysqli_query($mysqli,$sql);
	}
}

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
Done!!!
</body>
</html>
