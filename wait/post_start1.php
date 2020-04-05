<?
$rnd=array(0,1,2,3,4,5,6,7,8,9,10,11);

shuffle($rnd);
$dat["a"]=$rnd;
$dat1=$rnd;

shuffle($rnd);
$dat["b"]=$rnd;

shuffle($rnd);
$dat["c"]=$rnd;

shuffle($rnd);
$dat["d"]=$rnd;

shuffle($rnd);
$dat["card"]=$rnd;
echo json_encode($dat);
exit;
?>

