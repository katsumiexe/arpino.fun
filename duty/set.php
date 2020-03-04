<?
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

if($_POST["send"]){
	$set_title	=$_REQUEST["set_title"];
	$set_key	=$_REQUEST["set_key"];
	$set_host	=$_REQUEST["set_host"];
	$set_user	=$_REQUEST["set_user"];
	$set_pass	=$_REQUEST["set_pass"];
	$set_data	=$_REQUEST["set_data"];

	$set_login_name	=$_REQUEST["set_login_name"];
	$set_login_id	=$_REQUEST["set_login_id"];
	$set_login_pass	=$_REQUEST["set_login_pass"];

	$mysqli = @mysqli_connect($set_host, $set_user, $set_pass, $set_data);
	if($mysqli){
		mysqli_set_charset($mysqli,'UTF-8'); 

		$url="./config/kk".$set_key.".txt";

		$log	 =$set_title."\n";
		$log	.=$set_host."\n";
		$log	.=$set_user."\n";
		$log	.=$set_pass."\n";
		$log	.=$set_data."\n";
		$log	.=$set_login_id."\n";
		$log	.=$set_login_pass."\n";
		file_put_contents($url,$log);

$sql="
CREATE TABLE  `duty_log` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`date` DATE NOT NULL ,
`time` VARCHAR( 5 ) NOT NULL ,
`title` VARCHAR( 50 ) NOT NULL ,
`del` INT( 1 ) NOT NULL ,
`writer` INT( 3 ) NOT NULL ,
`category` INT( 3 ) NOT NULL ,
`group` INT( 3 ) NOT NULL ,
`log` VARCHAR( 5000 ),
`at1` INT( 3 ) NOT NULL ,
`at2` INT( 3 ) NOT NULL ,
`at3` INT( 3 ) NOT NULL ,
`at4` INT( 3 ) NOT NULL ,
`at5` INT( 3 ) NOT NULL ,
`at6` INT( 3 ) NOT NULL ,
`at7` INT( 3 ) NOT NULL ,
`at8` INT( 3 ) NOT NULL ,
`at9` INT( 3 ) NOT NULL ,
`at10` INT( 3 ) NOT NULL ,
`at11` INT( 3 ) NOT NULL ,
`at12` INT( 3 ) NOT NULL ,
`at13` INT( 3 ) NOT NULL ,
`at14` INT( 3 ) NOT NULL ,
`at15` INT( 3 ) NOT NULL ,
`at16` INT( 3 ) NOT NULL ,
`at17` INT( 3 ) NOT NULL ,
`at18` INT( 3 ) NOT NULL ,
`at19` INT( 3 ) NOT NULL ,
`at20` INT( 3 ) NOT NULL ,
`at21` INT( 3 ) NOT NULL ,
`at22` INT( 3 ) NOT NULL ,
`at23` INT( 3 ) NOT NULL ,
`at24` INT( 3 ) NOT NULL ,
`at25` INT( 3 ) NOT NULL ,
`at26` INT( 3 ) NOT NULL ,
`at27` INT( 3 ) NOT NULL ,
`at28` INT( 3 ) NOT NULL ,
`at29` INT( 3 ) NOT NULL ,
`at30` INT( 3 ) NOT NULL ,
`at31` INT( 3 ) NOT NULL ,
`at32` INT( 3 ) NOT NULL ,
`at33` INT( 3 ) NOT NULL ,
`at34` INT( 3 ) NOT NULL ,
`at35` INT( 3 ) NOT NULL ,
`at36` INT( 3 ) NOT NULL ,
`at37` INT( 3 ) NOT NULL ,
`at38` INT( 3 ) NOT NULL ,
`at39` INT( 3 ) NOT NULL ,
`at40` INT( 3 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE `duty_member` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`sort` VARCHAR( 3 ) NOT NULL ,
`name` VARCHAR( 20 ) NOT NULL ,
`logid` VARCHAR( 50 ) NOT NULL ,
`logpass` VARCHAR( 50 ) NOT NULL ,
`g_a` INT( 3 ) NOT NULL ,
`g_b` INT( 3 ) NOT NULL ,
`g_c` INT( 3 ) NOT NULL ,
`g_0` INT( 3 ) NOT NULL ,
`g_1` INT( 3 ) NOT NULL ,
`g_2` INT( 3 ) NOT NULL ,
`g_3` INT( 3 ) NOT NULL ,
`g_4` INT( 3 ) NOT NULL ,
`g_5` INT( 3 ) NOT NULL ,
`g_6` INT( 3 ) NOT NULL ,
`g_7` INT( 3 ) NOT NULL ,
`g_8` INT( 3 ) NOT NULL ,
`g_9` INT( 3 ) NOT NULL ,
`del` INT( 3 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_mission` (
`date` date NOT NULL ,
`com1` INT( 3 ) NOT NULL ,
`com2` INT( 3 ) NOT NULL ,
`com3` INT( 3 ) NOT NULL ,
`com4` INT( 3 ) NOT NULL ,
`com5` INT( 3 ) NOT NULL ,
`com6` INT( 3 ) NOT NULL ,
`com7` INT( 3 ) NOT NULL ,
`com8` INT( 3 ) NOT NULL ,
`com9` INT( 3 ) NOT NULL ,
`com10` INT( 3 ) NOT NULL ,
`com11` INT( 3 ) NOT NULL ,
`com12` INT( 3 ) NOT NULL ,
`com13` INT( 3 ) NOT NULL ,
`com14` INT( 3 ) NOT NULL ,
`com15` INT( 3 ) NOT NULL ,
`com16` INT( 3 ) NOT NULL ,
`com17` INT( 3 ) NOT NULL ,
`com18` INT( 3 ) NOT NULL ,
`com19` INT( 3 ) NOT NULL ,
`com20` INT( 3 ) NOT NULL ,
`com21` INT( 3 ) NOT NULL ,
`com22` INT( 3 ) NOT NULL ,
`com23` INT( 3 ) NOT NULL ,
`com24` INT( 3 ) NOT NULL ,
`com25` INT( 3 ) NOT NULL ,
`com26` INT( 3 ) NOT NULL ,
`com27` INT( 3 ) NOT NULL ,
`com28` INT( 3 ) NOT NULL ,
`com29` INT( 3 ) NOT NULL ,
`com30` INT( 3 ) NOT NULL ,
`com31` INT( 3 ) NOT NULL ,
`com32` INT( 3 ) NOT NULL ,
`com33` INT( 3 ) NOT NULL ,
`com34` INT( 3 ) NOT NULL ,
`com35` INT( 3 ) NOT NULL ,
`com36` INT( 3 ) NOT NULL ,
`com37` INT( 3 ) NOT NULL ,
`com38` INT( 3 ) NOT NULL ,
`com39` INT( 3 ) NOT NULL ,
`com40` INT( 3 ) NOT NULL ,
`mis1` INT( 3 ) NOT NULL ,
`mis2` INT( 3 ) NOT NULL ,
`mis3` INT( 3 ) NOT NULL ,
`mis4` INT( 3 ) NOT NULL ,
`mis5` INT( 3 ) NOT NULL ,
`mis6` INT( 3 ) NOT NULL ,
`mis7` INT( 3 ) NOT NULL ,
`mis8` INT( 3 ) NOT NULL ,
`mis9` INT( 3 ) NOT NULL ,
`mis10` INT( 3 ) NOT NULL ,
`mis11` INT( 3 ) NOT NULL ,
`mis12` INT( 3 ) NOT NULL ,
`mis13` INT( 3 ) NOT NULL ,
`mis14` INT( 3 ) NOT NULL ,
`mis15` INT( 3 ) NOT NULL ,
`mis16` INT( 3 ) NOT NULL ,
`mis17` INT( 3 ) NOT NULL ,
`mis18` INT( 3 ) NOT NULL ,
`mis19` INT( 3 ) NOT NULL ,
`mis20` INT( 3 ) NOT NULL ,
`mis21` INT( 3 ) NOT NULL ,
`mis22` INT( 3 ) NOT NULL ,
`mis23` INT( 3 ) NOT NULL ,
`mis24` INT( 3 ) NOT NULL ,
`mis25` INT( 3 ) NOT NULL ,
`mis26` INT( 3 ) NOT NULL ,
`mis27` INT( 3 ) NOT NULL ,
`mis28` INT( 3 ) NOT NULL ,
`mis29` INT( 3 ) NOT NULL ,
`mis30` INT( 3 ) NOT NULL ,
`mis31` INT( 3 ) NOT NULL ,
`mis32` INT( 3 ) NOT NULL ,
`mis33` INT( 3 ) NOT NULL ,
`mis34` INT( 3 ) NOT NULL ,
`mis35` INT( 3 ) NOT NULL ,
`mis36` INT( 3 ) NOT NULL ,
`mis37` INT( 3 ) NOT NULL ,
`mis38` INT( 3 ) NOT NULL ,
`mis39` INT( 3 ) NOT NULL ,
`mis40` INT( 3 ) NOT NULL ,
`del` INT( 3 ) NOT NULL
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_plan` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`sort` INT( 3 ) NOT NULL ,
`name` VARCHAR( 20 ) NOT NULL ,
`del` INT( 1 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_res` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`master` INT( 10 ) NOT NULL ,
`date` DATE NOT NULL ,
`time` VARCHAR( 5 ) NOT NULL ,
`writer` INT( 3 ) NOT NULL ,
`log` VARCHAR(4000 ) NOT NULL ,
`del` INT( 1 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_sub` (
`id` INT( 10 ) NOT NULL ,
`at1` INT( 3 ) NOT NULL ,
`at2` INT( 3 ) NOT NULL ,
`at3` INT( 3 ) NOT NULL ,
`at4` INT( 3 ) NOT NULL ,
`at5` INT( 3 ) NOT NULL ,
`at6` INT( 3 ) NOT NULL ,
`at7` INT( 3 ) NOT NULL ,
`at8` INT( 3 ) NOT NULL ,
`at9` INT( 3 ) NOT NULL ,
`at10` INT( 3 ) NOT NULL ,
`at11` INT( 3 ) NOT NULL ,
`at12` INT( 3 ) NOT NULL ,
`at13` INT( 3 ) NOT NULL ,
`at14` INT( 3 ) NOT NULL ,
`at15` INT( 3 ) NOT NULL ,
`at16` INT( 3 ) NOT NULL ,
`at17` INT( 3 ) NOT NULL ,
`at18` INT( 3 ) NOT NULL ,
`at19` INT( 3 ) NOT NULL ,
`at20` INT( 3 ) NOT NULL ,
`at21` INT( 3 ) NOT NULL ,
`at22` INT( 3 ) NOT NULL ,
`at23` INT( 3 ) NOT NULL ,
`at24` INT( 3 ) NOT NULL ,
`at25` INT( 3 ) NOT NULL ,
`at26` INT( 3 ) NOT NULL ,
`at27` INT( 3 ) NOT NULL ,
`at28` INT( 3 ) NOT NULL ,
`at29` INT( 3 ) NOT NULL ,
`at30` INT( 3 ) NOT NULL ,
`at31` INT( 3 ) NOT NULL ,
`at32` INT( 3 ) NOT NULL ,
`at33` INT( 3 ) NOT NULL ,
`at34` INT( 3 ) NOT NULL ,
`at35` INT( 3 ) NOT NULL ,
`at36` INT( 3 ) NOT NULL ,
`at37` INT( 3 ) NOT NULL ,
`at38` INT( 3 ) NOT NULL ,
`at39` INT( 3 ) NOT NULL ,
`at40` INT( 3 ) NOT NULL
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_todo` (
`todo_id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`submit_date` DATETIME NOT NULL ,
`st_date` DATE NOT NULL ,
`ed_date` DATE NOT NULL ,
`st_time` VARCHAR( 4 ) NOT NULL ,
`ed_time` VARCHAR( 4 ) NOT NULL ,
`start` INT( 1 ) ,
`passage` INT( 1 ) ,
`end` INT( 1 ) ,
`log` VARCHAR(1000 ),
`staff` INT( 3 ) ,
`group` INT( 3 ) ,
`plan` INT( 3 ) ,
`del` INT(1 ) ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_comm` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`sort` VARCHAR( 3 ) NOT NULL ,
`name` VARCHAR( 20 ) NOT NULL ,
`del` INT( 3 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_category` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`sort` VARCHAR( 3 ) NOT NULL ,
`name` VARCHAR( 20 ) NOT NULL ,
`del` INT( 3 ) NOT NULL ,
`att` INT( 3 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_fav` (
`fav_id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`user_id` INT( 10 ) NOT NULL ,
`name` VARCHAR( 30 ) NOT NULL ,
`sort` VARCHAR( 3 ) NOT NULL ,
`icon` VARCHAR( 3 ) NOT NULL ,
`color` VARCHAR( 3 ) NOT NULL ,
`del` INT( 3 ) NOT NULL ,
PRIMARY KEY (  `fav_id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_group` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`sort` VARCHAR( 3 ) NOT NULL ,
`name` VARCHAR( 20 ) NOT NULL ,
`del` INT( 3 ) NOT NULL ,
PRIMARY KEY (  `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE  `duty_holiday` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`year` VARCHAR( 4 ) NOT NULL ,
`month` VARCHAR( 2 ) NOT NULL ,
`day` VARCHAR( 2 ) NOT NULL ,
`name` VARCHAR( 20 ) NOT NULL ,
`del` INT( 3 ) NOT NULL ,
PRIMARY KEY ( `id` )
)
";
mysqli_query($mysqli,$sql);

$sql="
CREATE TABLE `duty_list` (
`list_id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`fav_id` INT( 10 ) NOT NULL ,
`favlog` INT( 10 ) NOT NULL ,
`user` INT( 3 ) NOT NULL ,
PRIMARY KEY ( `list_id` )
)
";
mysqli_query($mysqli,$sql);


$sql="INSERT INTO `duty_member` (`sort`, `name`, `logid`, `logpass`,`g_a`) VALUES('1','{$set_login_name}','{$set_login_id}','{$set_login_pass}','1' )";
mysqli_query($mysqli,$sql);

$sql="INSERT INTO `duty_fav` (`user_id`, `name`, `sort`, `icon`, `color`) VALUES('1','重要','0','1','1')";
mysqli_query($mysqli,$sql);
		$msg="正常に設定されました。<br>
		<a href=\"./index.php\">ログイン後、他設定をしてください。</a>";		
	}else{
		$msg="ERROR! mysqlの設定ができません。ご確認下さい。";
	}
}
?>


<html>
<head>
<title>初期設定</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex, nofollow">
</head>
<body>

<form action="set.php" method="post">
<div style="text-align:center">
<div style="text-align:left; width:400px;margin:5px auto;">
<div>基本設定</div>
<div>title(20文字まで)</div>
<div><input type="text" value="<?=$set_title?>" name="set_title"></div>
<div>seculity_key(8桁の半角英数字)</div>
<div><input type="text" value="<?=$set_key?>" name="set_key" maxlength=8></div>

<div>Mysqlの設定</div>
<div>mysql: host</div>
<div><input type="text" value="<?=$set_host?>" name="set_host"></div>
<div>mysql: user</div>
<div><input type="text" value="<?=$set_user?>" name="set_user"></div>
<div>mysql: pass</div>
<div><input type="text" value="<?=$set_pass?>" name="set_pass"></div>
<div>mysql: database</div>
<div><input type="text" value="<?=$set_data?>" name="set_data"></div>

<div>Admin設定</div>
<div>管理者:名前(全角10文字まで)</div>
<div><input type="text" value="<?=$set_login_name?>" name="set_login_name"></div>
<div>管理者:id(半角20文字まで)</div>
<div><input type="text" value="<?=$set_login_id?>" name="set_login_id"></div>
<div>管理者:pass(半角20文字まで)</div>
<div><input type="text" value="<?=$set_login_pass?>" name="set_login_pass"></div>
</div>
<div><button type="submit" value="dataset" name="send">DataSet</button></div>
</div>
</form>
<?=$msg?>
</body>
</html>