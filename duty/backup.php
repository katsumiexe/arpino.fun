<?php
header('Content-Type: text/html; charset=UTF-8');
mb_language("Japanese"); 
//■■サーバー接続----------------------*
$mysqli = mysqli_connect("localhost", "blue_duty", "0909", "blue_duty");
mysqli_set_charset($mysqli,'UTF-8'); 
if (!$mysqli) {
    die('☆接続失敗です。');
}

$w=date("w");

$sql ="DROP TABLE IF EXISTS";
$sql.="bp{$w}_duty2_log,";
$sql.="bp{$w}_duty2_fav,";
$sql.="bp{$w}_duty2_group,";
$sql.="bp{$w}_duty2_list,";
$sql.="bp{$w}_duty2_member,";
$sql.="bp{$w}_duty2_plan,";
$sql.="bp{$w}_duty2_res,";
$sql.="bp{$w}_duty2_sub,";
$sql.="bp{$w}_duty2_todo,";
$sql.="bp{$w}_duty2_category";
mysqli_query($mysqli,$sql);


$sql="CREATE TABLE bp{$w}_duty2_log LIKE duty2_log";
$sql2="INSERT INTO bp{$w}_duty2_log SELECT * FROM duty2_log";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_fav LIKE duty2_fav";
$sql2="INSERT INTO bp{$w}_duty2_fav SELECT * FROM duty2_fav";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_group LIKE duty2_group";
$sql2="INSERT INTO bp{$w}_duty2_group SELECT * FROM duty2_group";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_list LIKE duty2_list";
$sql2="INSERT INTO bp{$w}_duty2_list SELECT * FROM duty2_list";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_member LIKE duty2_member";
$sql2="INSERT INTO bp{$w}_duty2_member SELECT * FROM duty2_member";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_plan LIKE duty2_plan";
$sql2="INSERT INTO bp{$w}_duty2_plan SELECT * FROM duty2_plan";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_res LIKE duty2_res";
$sql2="INSERT INTO bp{$w}_duty2_res SELECT * FROM duty2_res";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_sub LIKE duty2_sub";
$sql2="INSERT INTO bp{$w}_duty2_sub SELECT * FROM duty2_sub";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_todo LIKE duty2_todo";
$sql2="INSERT INTO bp{$w}_duty2_todo SELECT * FROM duty2_todo";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


$sql="CREATE TABLE bp{$w}_duty2_category LIKE duty2_category";
$sql2="INSERT INTO bp{$w}_duty2_category SELECT * FROM duty2_category";
mysqli_query($mysqli,$sql);
mysqli_query($mysqli,$sql2);

print($sql."<br>\n");
print($sql2."<br><br><br>\n");


?>

