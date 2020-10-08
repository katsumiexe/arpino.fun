<?php
//---------------------------------------
$from_mail		="kwsk_ggrks@i.softbank.jp";//■問い合わせをした相手への自動通知（空＝なし）
$to_mail		="counterpost2016@gmail.com";//■問い合わせが入った際に内容を通知する（空＝なし）
$host			="localhost";
$user_name		="tiltowait_db";
$user_pass		="kk1941";
$db_name		="tiltowait_db";
//---------------------------------------
$mysqli = mysqli_connect($host, $user_name, $user_pass, $db_name);
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$send				=$_POST["send"];
$step				=$_POST["step"];
$ask_name			=$_POST["ask_name"];
$ask_manage_id		=$_POST["ask_manage_id"];
$ask_park_name		=$_POST["ask_park_name"];
$ask_owner_name		=$_POST["ask_owner_name"];
$ask_tel			=$_POST["ask_tel"];
$ask_gps			=$_POST["ask_gps"];
$ask_memo			=$_POST["ask_memo"];

if($send=="戻る"){
	$step=0;
}
if($step==2){
	if($to_mail){
		if(!$from_mail) $from_mail=$to_mail; 
		$subject	= "お問合せメール";
		$ret		= "-f ".$from_mail;

		$body="以下の内容でお問合せ承りました\r\n\r\n";
		$body.="名　　前：{$ask_name}\r\n";
		$body.="管理番号：{$ask_manage_id}\r\n";
		$body.="駐車場名：{$ask_park_name}\r\n";
		$body.="オーナー：{$ask_owner_name}\r\n";
		$body.="電話番号：{$ask_tel}\r\n";
		$body.="位置情報：{$ask_gps}\r\n";
		$body.="-----------------------\r\n{$ask_memo}\r\n";

		$head  = "From: " . mb_encode_mimeheader($from_mail,"ISO-2022-JP") . "<{$from_mail}> \r\n";
		$head .= "Content-type: text/plane; charset=UTF-8";
		$head = "From: {$from_mail}" . "\r\n";
		mb_send_mail($to_mail, $subject, $body, $head);
	}
/*---------------------------------------------
	if($from_mail){
		$subject	= "メールアドレス登録";
		$ret		= "-f ".$from_mail;

		$body ="{$ask_name}様\r\n";
		$body.="メールアドレスの登録を承りました\r\n";
		$body.="※当メールへの返信はできません。\r\n\r\n";

		$head  = "From: " . mb_encode_mimeheader($from_name,"ISO-2022-JP") . "<{$from_mail}> \r\n";
		$head .= "Content-type: text/plane; charset=UTF-8";
		$head = "From: {$from_mail}" . "\r\n";
		mb_send_mail($ask_mail, $subject, $body, $head);
	}
----------------------------------------------*/
	$now=date("Y-m-d H:i:s");
	$sql="INSERT INTO log_data (d_date, d_name, d_manage_id, d_park_name, d_owner_name, d_tel, d_gps, d_memo)";
	$sql.=" VALUES ('{$now}','{$ask_name}','{$ask_manage_id}','{$ask_park_name}','{$ask_owner_name}','{$ask_tel}','{$ask_gps}','{$ask_memo}')";
	mysqli_query($mysqli,$sql);

print($sql);
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<style>
</style>
</head>
<body class="body">
<?if($step==1){?>
<form id="send_form" method="post" action="index.php">
これでよろしいでしょうか。<br>
<input id="step" type="hidden" value="2" name="step">
<input name="ask_name" value="<?=$ask_name?>" type="hidden">
<input name="ask_manage_id" value="<?=$ask_manage_id?>" type="hidden">
<input name="ask_park_name" value="<?=$ask_park_name?>" type="hidden">
<input name="ask_owner_name" value="<?=$ask_owner_name?>" type="hidden">
<input name="ask_tel" value="<?=$ask_tel?>" type="hidden">
<input name="ask_gps" value="<?=$ask_gps?>" type="hidden">
<input name="ask_memo" value="<?=$ask_memo?>" type="hidden">
<div class="box_1">
<table>
<tr>
<td class="lv">名前</td><td class="lv_2"><?=$ask_name?></td>
</tr><tr>
<td class="lv">管理番号</td><td class="lv_2"><?=$ask_manage_id?></td>
</tr><tr>
<td class="lv">駐車場名</td><td class="lv_2"><?=$ask_park_name?></td>
</tr><tr>
<td class="lv">オーナー</td><td class="lv_2"><?=$ask_owner_name?></td>
</tr><tr>
<td class="lv">電話番号</td><td class="lv_2"><?=$ask_tel?></td>
</tr><tr>
<td class="lv">位置情報</td><td class="lv_2"><?=$ask_gps?></td>
</tr>
<td class="lv" colspan="2"><?=str_replace("\n","<br>",$ask_memo)?></td>
<tr>
<td class="lv_3" colspan="2">
<input type="submit" value="送信" name="send">
<input type="submit" value="戻る" name="send">
</td>
<td></td>
</tr>
</table>
</form>


<?}elseif($step==2){?>
送信しました。<br>
<?}else{?>
<form id="send_form" method="post" action="index.php">
<div class="box_1">
<input type="hidden" value="1" name="step">
<table>
<tr><td class="lv">名前</td><td class="lv"><input name="ask_name" value="<?=$ask_name?>" type="text"></td></tr>
<tr><td class="lv">管理番号</td><td class="lv"><input name="ask_manage_id" value="<?=$ask_manage_id?>" type="text"></td></tr>
<tr><td class="lv">駐車場名</td><td class="lv"><input name="ask_park_name" value="<?=$ask_park_name?>" type="text"></td></tr>
<tr><td class="lv">オーナー</td><td class="lv"><input name="ask_owner_name" value="<?=$ask_owner_name?>" type="text"></td></tr>
<tr><td class="lv">電話番号</td><td class="lv"><input name="ask_tel" value="<?=$ask_tel?>" type="text"></td></tr>
<tr><td class="lv">位置情報</td><td class="lv"><input name="ask_gps" value="<?=$ask_gps?>" type="text"></td></tr>
<tr><td class="lv" colspan="2">メモ<br>
<textarea name="ask_memo"><?=$ask_memo?></textarea><br>
<button id="send" type="submit">送信</button>
</td></tr>
</table>
<div>
</form>
<? } ?>
</body>
</html>
