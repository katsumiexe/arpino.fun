<?
include_once("./library/session.php");
$t=time();

$log_id=$_POST["log_id"];
$getpts=$_POST["getpts"];

/*
$sql=" UPDATE log_data SET";
$sql.=" WHERE id='{$log_id}'";

$res = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($res);

$bonus=$row["bonus_1"]+$row["bonus_2"]+$row["bonus_3"]+$row["bonus_4"]+$row["bonus_5"];
if($bonus<0){
$bonus="<span class=\"turn_ptb\">{$bonus}</span>";
}else{
$bonus="+".$bonus;

}
*/

echo $getpts;
exit();
?>

