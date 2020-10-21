<?
$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

$ck_date=$_POST["ck_date"];
$ck_date="2020-10-22";
$ck=explode("-",$ck_date);
$link="http://koyomi.zing2.org/api/?mode=d&cnt=7&targetyyyy={$ck[0]}&targetmm={$ck[1]}&targetdd={$ck[2]}";
$dat_date=file_get_contents($link);
$eve = json_decode($dat_date, true);

for($n=0;$n<7;$n++){
$tmp	=date("Y-m-d",strtotime($ck_date)+(86400*$n));
$tmp_a	=date("Y年m月d日",strtotime($ck_date)+(86400*$n));
$wk	=date("w",strtotime($ck_date)+(86400*$n));

//echo $tmp ."■". $eve["datelist"][$tmp]["rokuyou"]."<br>\n";
//$dat[$tmp]=$eve["datelist"][$tmp]["rokuyou"];
$dat.="<div class=\"ck_date c{$wk}\">";
$dat.="<div class=\"ck_date_a\">{$tmp_a}</div>";
$dat.="<div class=\"ck_date_b\">{$week[$wk]}</div>";
$dat.="<div class=\"ck_date_c\">{$eve["datelist"][$tmp]["rokuyou"]}</div>";
$dat.="</div>";
}
echo json_encode($dat);
exit()
?>
