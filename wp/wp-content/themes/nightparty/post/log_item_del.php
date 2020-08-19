<?
/*
BlogSet
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$list_id	=$_POST["list_id"];

$sort=0;

$sql ="SELECT * FROM wp01_0cast_log_table"; 
$sql.=" WHERE cast_id='{$cast_id}'"; 
$sql.=" ORDER BY `sort` ASC"; 

$res = $wpdb->get_results($sql,ARRAY_A );
foreach($res as $res2){

	if($res2["sort"] !=$list_id){
		$sql=" UPDATE wp01_0cast_log_table SET";
		$sql.=" `sort`='{$sort}'"; 
		$sql.=" WHERE cast_id='{$cast_id}'"; 
		$sql.=" AND `sort`='{$res2["sort"]}'"; 
		$wpdb->query($sql);
		$sort++;

	}else{
		$sql ="DELETE FROM wp01_0cast_log_table"; 
		$sql.=" WHERE cast_id='{$cast_id}'"; 
		$sql.=" AND `sort`='{$list_id}'"; 
		$wpdb->query($sql);
	}

}
exit();
?>
