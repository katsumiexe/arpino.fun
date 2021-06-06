<?
$mysqli = mysqli_connect("210.150.110.204", "blue_db", "0909", "blue_db");
if(!$mysqli){
	die('ERROR!');
}
mysqli_set_charset($mysqli,'UTF8'); 
include_once("./opecode.php");

foreach($ope as $a1 => $a2){
	$ddt[$a2]=$a1;
}


$sql="SELECT * FROM blog_memo_master";
$sql.=" WHERE ope_id=''";
echo $sql;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$sql2="UPDATE blog_memo_master SET";
		$sql2.=" ope_id='{$ddt[$row["ope_name"]]}'";
		$sql2.=" WHERE id='{$row["id"]}'";
		mysqli_query($mysqli,$sql2);


//echo $sql2."<br>\n";

	}
}



echo date("YmdHis");
?>

