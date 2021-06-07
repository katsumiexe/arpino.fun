<?
$mysqli = mysqli_connect("210.150.110.204", "blue_db", "0909", "blue_db");
if(!$mysqli){
	die('ERROR!');
}
mysqli_set_charset($mysqli,'UTF8'); 

$id		=$_POST["id"];

$sql="SELECT * FROM blog_memo_slave"; 
$sql.=" WHERE m_id='{$id}'"; 
$sql.=" ORDER BY id DESC"; 
$ck="rev_ck";
if($res = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res)){
		$tm=str_replace("-",".",$row["date_time"]);
		$html.="<div id=\"rev{$row["id"]}\" class=\"revision_box {$ck}\">{$tm}</div>";
		$ck="";
	}
}

echo $html;
exit()
?>
