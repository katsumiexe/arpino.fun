<?
//■■サーバー接続----------------------*
$ip_ok=1;
if ($dir = opendir("config/")) {
	while (($file = readdir($dir)) !== false) {
		if ($file != "." && $file != ".." ) {
			$fp=fopen("./config/{$file}","r");
			if($fp){
				$set_title=trim(fgets($fp));
				$set_host=trim(fgets($fp));
				$set_user=trim(fgets($fp));
				$set_pass=trim(fgets($fp));
				$set_data=trim(fgets($fp));
				$set_key=str_replace('kk','',$file);
				$set_key=str_replace('.txt','',$set_key);
			}
		}
	} 
closedir($dir);
}
$mysqli = mysqli_connect($set_host, $set_user, $set_pass, $set_data);
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 

$chg	=$_POST["chg"];
$uid	=$_POST["uid"];
$log_id	=$_POST["log_id"];


$sql ="SELECT * FROM duty_list"; 
$sql.=" WHERE user='{$uid}'";
$sql.=" AND fav_log='{$log_id}'";

if (mysqli_query($mysqli,$sql)){
	$sql1 ="UPDATE duty_list SET"; 
	$sql1.=" fav_id='{$chg}'";
	$sql1.=" WHERE user='{$uid}'";
	$sql1.=" AND fav_log='{$log_id}'";
}else{
	$sql1 ="INSERT INTO duty_list(fav_id,fav_log,user)VALUES('{chg}','{log_id}','{uid}')"; 
}
mysqli_query($mysqli,$sql1);

exit;
?>

