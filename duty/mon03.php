<?

$fp_dl=fopen('http://admin.e-kantei.net/a8mon/data/chan.txt','r');
$x=0;
if($fp_dl){
	while(!feof($fp_dl)){
		$dl1=fgets($fp_dl);
		$dl2=explode(";", $dl1);

		for($p=0;$p<17;$p++){
			$dl3=explode("=", $dl2[$p]);
			$dat[$dl3[0]][$x]=$dl3[1];
		}

		if($dat["ST"][$x] == "Talk"){
			$count++;
		}
	$x++;
	}
	fclose($fp_dl);
}

$count2=floor($count/2)+0;
?>

<html>
<head>
<meta charset="shift_jis">
<style>

table.tb{
	display			:inline-block;
    border-collapse	:collapse;
    border-spacing	:0;
    empty-cells		:show;
	background		:#000000;
	margin:2px;
}

td{
/*	border-top:1px solid #202020;*/
	border-bottom:1px solid #202020;
	font-size:10px;
	color:#ffffff;
}

td.t_prog01_T{
	background:#0000ff;

}

td.t_prog02_T{
	background:#00e000;
}


td.t_prog03_T{
	background:#d0d000;
}




td.t_ope1_T{
	color:#ff30ff;

}

td.t_ope2_T{
	color:#00f000;

}

td.t_ope3_T{
	color:#ffff00;

}





.st_Talk{
	color:#ff9000;

}


.st_Toku{
	color:#c00000;

}

.st_Select{
	color:#00e000;

}

</style>

 
</head>
<body>
<?if($_SERVER['REMOTE_ADDR'] == "61.119.122.190"){?>
<SCRIPT LANGUAGE="JavaScript">
<!--
setTimeout("location.reload()",1000*10);
//-->
</SCRIPT>

<table width="95%"><tr>
<td style="border:none; color:#000000; font-size:18px;text-align:left;">カ○ス CTI</td>
<td style="border:none; color:#000000; font-size:18px;text-align:right;"><?=date("H:i:s")?>＿　鑑定中：<?=$count2?>　　　　　</td>
</tr></table>

<div style="display:flex">
<?for($n=0;$n<5;$n++){?>
<table class="tb">
<tr>
	<td colspan="9" style="text-align:center"> Channel</td>
</tr>
<tr>
	<td style="text-align:center">Ch</td>
	<td style="text-align:center">Call</td>
	<td style="text-align:center">time</td>
	<td style="text-align:center">R</td>
	<td style="text-align:center">ID</td>
	<td style="text-align:center">Name</td>
	<td style="text-align:center">Point</td>
	<td style="text-align:center">TOTAL</td>
	<td style="text-align:center">Status</td>
</tr>
<?for($c=48*$n;$c<48*$n+48;$c++){?>
	<?if($dat["ST"][$c] != "RingWait" && $dat["ST"][$c] != "Select") $dat["ST2"][$c]="T"?>
	<tr>
		<td style="text-align:right; width:25px; padding:0px 2px;"><?=$dat["NO"][$c]?></td>
		<td style="text-align:right; width:25px; padding:0px 2px;"><?=$dat["CL"][$c]?></td>
		<td style="text-align:right; width:45px; padding:0px 2px;"><?if($dat["CT"][$c]) print(date("i:s",$dat["CT"][$c]))?></td>
		<td style="text-align:right; width:15px; padding:0px 2px;"><?if($dat["RA"][$c]) print($dat["RA"][$c])?></td>
		<td class="t_<?=$dat["PR"][$c]?>_<?=$dat["ST2"][$c]?>" style="text-align:leftt; width:55px; padding:0px 2px;"><?=$dat["ID"][$c]?></td>
		<td style="text-align:right; width:50px; padding:0px 2px;">　</td>
		<td style="text-align:right; width:50px; padding:0px 2px;"><?if($dat["ID"][$c]) print($dat["PO"][$c]+0)?></td>
		<td style="text-align:right; width:55px; padding:0px 2px;"><?if($dat["UP"][$c]) print($dat["UP"][$c])?></td>
		<td class="st_<?=$dat["ST"][$c]?>" style="text-align:left; width:60px; padding:0px 2px;"><?=$dat["ST"][$c]?></td>
	</tr>
<? } ?>

</table>
<? } ?>
</div>

<?}else{?>

<div style="text-align:center; font-size:16px;">
只今工事中です。<br>
<img src="./img/out.jpg" style="width:200px;">
<img src="./img/out.jpg" style="width:200px;">
<img src="./img/out.jpg" style="width:200px;"><br>
</div>
<? } ?>

</body>
</html>