<?
$mysqli = mysqli_connect("210.150.110.204", "blue_db", "0909", "blue_db");
if(!$mysqli){
	die('ERROR!');
}
mysqli_set_charset($mysqli,'UTF8'); 
$id		=$_POST["id"];

$sql="SELECT * FROM blog_memo_slave"; 
$sql.=" WHERE id='{$id}'"; 

if($res = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($res);
	echo json_encode($row);
}
exit()
?>
