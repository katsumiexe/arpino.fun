<?
/*
BlogSet
*/

include_once('../../library/sql_post.php');
include_once("../../library/inc_code.php");

$list_id	=$_POST["list_id"];
$sort=0;

$sql ="SELECT * FROM wp01_0cast_log_table"; 
$sql.=" WHERE cast_id='{$cast_data["id"]}'"; 
$sql.=" ORDER BY `sort` ASC"; 

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["sort"] !=$list_id){
			$sql=" UPDATE wp01_0cast_log_table SET";
			$sql.=" `sort`='{$sort}'"; 
			$sql.=" WHERE cast_id='{$cast_id}'"; 
			$sql.=" AND `sort`='{$row["sort"]}'"; 
			$wpdb->query($sql);
			$sort++;

		}else{
			$sql ="DELETE FROM wp01_0cast_log_table"; 
			$sql.=" WHERE cast_id='{$cast_id}'"; 
			$sql.=" AND `sort`='{$list_id}'"; 
			$wpdb->query($sql);
		}
	}
}
exit();
?>
