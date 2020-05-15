<?
$b=strtotime("2020-04-01");
$n=date("w",$b);
$t=date("t",$b);

for($m=0; $m<$t+$n;$m++){

	$d=$m-$n+1;

	if($m%7==0){
		echo "<br>";
	}
	if($m-$n>=0){
		echo $d.",";

	}else{
		echo ",";
	}
}
?>
<hr>

