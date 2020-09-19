<?
include_once("./library/session.php");

$sql="SELECT * FROM unit_data";

if($res2 = mysqli_query($mysqli,$sql)){
while($row2 = mysqli_fetch_assoc($res2)){
		$unit_data[$row2["id"]]=$row2;
	}
}
$unit_select	=$_POST["unit_select"];
$level_select	=$_POST["level_select"];

$date=date("Y-m-d H:i:s");

$dat["name"]=$unit_data[$unit_select]["name"];
$dat["s1"]="on".$unit_data[$unit_select]["status_1"];
$dat["s2"]="on".$unit_data[$unit_select]["status_2"];
$dat["s3"]="on".$unit_data[$unit_select]["status_3"];
$dat["s4"]="on".$unit_data[$unit_select]["status_4"];
$dat["s5"]="on".$unit_data[$unit_select]["status_5"];

$base=array(1,2,3,4,5,6,7,8,9,10);
shuffle($base);
$ch=0;
for($n=0;$n<4;$n++){
	if($unit_select == $base[$ch]){
		$ch++;
	}
	$unit[$n]=$base[$ch];
	$ch++;
}

$unit[4]=$unit_select;
$card=array(0,1,2,3,4);
shuffle($card);

$cd_1[0]=11;
$cd_1[1]=10;
$cd_1[2]=9;
$cd_1[3]=8;

$cd_2[0]=7;
$cd_2[1]=6;
$cd_2[2]=5;

$cd_3[0]=4;
$cd_3[1]=3;
$cd_3[2]=2;

$cd_4[0]=1;
$cd_4[1]=0;

$dat["p1"]=$card[0];
$dat["p2"]=$card[1];
$dat["p3"]=$card[2];
$dat["p4"]=$card[3];

for($s=0;$s<4;$s++){
	$c1=0;
	$c2=0;
	$c3=0;
	$c4=0;
	shuffle($cd_1);
	shuffle($cd_2);
	shuffle($cd_3);
	shuffle($cd_4);

	for($n=0;$n<12;$n++){
		if($card[$n]==0){
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==1){
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==2 && $unit_data[$unit[$s]]["status_1"]== 1){	
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==3 && $unit_data[$unit[$s]]["status_2"]== 1){	
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==4 && $unit_data[$unit[$s]]["status_3"]== 1){	
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==5 && $unit_data[$unit[$s]]["status_4"]== 1){	
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==6 && $unit_data[$unit[$s]]["status_5"]== 1){	
			$hand[$s][$n]=$cd_1[$c1];
			$c1++;

		}elseif($card[$n]==7 && $unit_data[$unit[$s]]["status_1"]== 1){	
			$hand[$s][$n]=$cd_4[$c4];
			$c4++;

		}elseif($card[$n]==8 && $unit_data[$unit[$s]]["status_2"]== 1){	
			$hand[$s][$n]=$cd_4[$c4];
			$c4++;

		}elseif($card[$n]==9 && $unit_data[$unit[$s]]["status_3"]== 1){	
			$hand[$s][$n]=$cd_4[$c4];
			$c4++;

		}elseif($card[$n]==10 && $unit_data[$unit[$s]]["status_4"]== 1){	
			$hand[$s][$n]=$cd_4[$c4];
			$c4++;

		}elseif($card[$n]==11 && $unit_data[$unit[$s]]["status_5"]== 1){	
			$hand[$s][$n]=$cd_4[$c4];
			$c4++;

		}elseif($card[$n]==7){	
			$hand[$s][$n]=$cd_3[$c3];
			$c3++;

		}elseif($card[$n]==8){	
			$hand[$s][$n]=$cd_3[$c3];
			$c3++;

		}elseif($card[$n]==9){	
			$hand[$s][$n]=$cd_3[$c3];
			$c3++;

		}elseif($card[$n]==10){	
			$hand[$s][$n]=$cd_3[$c3];
			$c3++;

		}elseif($card[$n]==11){	
			$hand[$s][$n]=$cd_3[$c3];
			$c3++;

		}else{
			$hand[$s][$n]=$cd_2[$c2];
			$c2++;
		}
	}
}

	shuffle($hand[0]);

if($level_select==0){
	shuffle($hand[1]);
	shuffle($hand[2]);
	shuffle($hand[3]);

}elseif($level_select==1){
	for($b=0;$b<4;$b++){
		for($t=0;$t<5;$t++){
			$a1=rand(0,11);
			$a2=rand(0,11);
			$tmp			=$hand[$b][$a1];
			$hand[$b][$a1]	=$hand[$b][$a2];
			$hand[$b][$a2]	=$tmp;
		}
	}

}

$dat['u']=$unit;
$dat['a']=$hand[0];
$dat['b']=$hand[1];
$dat['c']=$hand[2];
$dat['d']=$hand[3];
$dat['e']=$card;

$t_re=$_SERVER["HTTP_REFERER"];
$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER["REMOTE_ADDR"];

$sql="INSERT INTO log_data(`start`,`ua`,`ref`,`ip`,`level`,`unit_p`,`unit_a`,`unit_b`,`unit_c`,`unit_d`)";
$sql.="VALUES('{$date}','{$t_ua}','{$t_re}','{$t_ip}','{$level_select}','{$unit_select}','{$unit[0]}','{$unit[1]}','{$unit[2]}','{$unit[3]}')";
mysqli_query($mysqli,$sql);

$dat['i']=mysqli_insert_id($mysqli);

echo json_encode($dat);
exit();
?>
