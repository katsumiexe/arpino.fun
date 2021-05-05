<?
/*
memo1変更処理
*/
include_once('../../library/sql_post.php');

$c_id	=$_POST["c_id"];
$tmp	=$_POST["tmp"];
$value	=$_POST["value"];

if(substr($tmp,0,2)=="m_"){
	$code=2;

}elseif(substr($tmp,0,2)=="b_"){
	$code=8;

}else{
	$code=str_replace("tbl_a_","",$tmp);
}

$sql ="SELECT id FROM wp01_0customer_list";
$sql .=" WHERE customer_id='{$c_id}'";
$sql .=" AND item='{$code}'";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);

	if($row){
		$sql ="UPDATE wp01_0customer_list SET";
		$sql .=" comm='{$value}'";
		$sql .=" WHERE customer_id={$c_id}";
		$sql .=" AND item='{$code}'";
		mysqli_query($mysqli,$sql);
	
	}else{
		$sql ="INSERT INTO wp01_0customer_list";
		$sql .=" (`customer_id`, `item`, `comm`)values";
		$sql .=" ('{$c_id}','{$code}','{$value}')";
		mysqli_query($mysqli,$sql);
	}	
}

exit();
?>
