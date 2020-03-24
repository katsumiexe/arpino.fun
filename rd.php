<?
$s=0;
for($n=13215;$n<20000;$n++){
$dat[$s]=$n;
$s++;
}
$a1=0;
shuffle($dat);
foreach($dat as $a2){
	print($a1.",".$a2.",\n");
$a1++;
}

?>
