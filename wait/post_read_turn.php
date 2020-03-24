<?
$turn	=$_REQUEST["turn"];
$bet	=$_REQUEST["bet"];

$sort["p"]=$bet;

$sort["a"]=$_SESSION["a"][$turn];
$sort["b"]=$_SESSION["b"][$turn];
$sort["c"]=$_SESSION["c"][$turn];

$p=0;
arsort($sort);
foreach($sort as $a1 => $a2){
    $check[$p]=$a2;
    $name[$p]=$a1;
    $p++;
} 

if($check[0] >$check[1]){
    $win=$name[0];

}elseif($check[0] >$check[2] && $check[2] >$check[3]){
    $win=$name[2];

}elseif($check[0] == $check[2] && $check[2] !=$check[3]){
    $win=$name[3];

}else{
    $win="d";
}
$doll[$win]=$_SESSION["a"]["doll"];
echo $d;

?>

