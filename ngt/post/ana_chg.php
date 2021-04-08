<?
include_once('../library/sql_post.php');
$t_month	=$_POST["t_month"];

$sql	 ="SELECT * FROM wp01_0schedule";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND sche_date LIKE '{$t_month}%'";
$sql   	.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($row["stime"] && $row["etime"]){
			$days_sche[$row["sche_date"]]="<span class=\"sche_b\"><span class=\"sche_s\">".$row["stime"]."</span>-<span class=\"sche_e\">".$row["etime"]."</span></span>";

			if(substr($sche_table_calc["in"][$row["stime"]],2,1) == 3){
				$tmp_s=$sche_table_calc["in"][$row["stime"]]+20;
			}else{
				$tmp_s=$sche_table_calc["in"][$row["stime"]];
			}		
			if(substr($sche_table_calc["out"][$row["etime"]],2,1) == 3){
				$tmp_e=$sche_table_calc["out"][$row["etime"]]+20;
			}else{
				$tmp_e=$sche_table_calc["out"][$row["etime"]];
			}		
			$ana_time[$row["sche_date"]]=($tmp_e-$tmp_s)/100;

		}else{
			$days_sche[$row["sche_date"]]="<span class=\"sche_s\">休み</span>";
			$sche_dat[$row["sche_date"]]="";
			$ana_time[$row["sche_date"]]=0;
		}
	}
}

if(is_array($ana_time)){
	foreach($ana_time as $a1 => $a2){
		if($a1<=$day_8){
			$ana_salary[$a1]=$a2*$cast_data["cast_salary"];	
			$ana_salary_all+=$a2*$cast_data["cast_salary"];	
		}
			$ana_salary_y[$a1]=$a2*$cast_data["cast_salary"];	
			$ana_salary_y_all+=$a2*$cast_data["cast_salary"];	
	}
}

//■------------------
$sql ="SELECT * FROM wp01_0cast_log_table";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$log_item[$row["sort"]]=$row;
		$log_list_cnt.='"i'.$row["sort"].'",';
	}
	$log_list_cnt=substr($log_list_cnt,0,-1);
}

$sql ="SELECT log_id, sdate, SUM(log_price) AS pts, nickname,name, customer_id FROM wp01_0cast_log AS A ";
$sql.=" LEFT JOIN wp01_0cast_log_list AS B ON B.master_id=A.log_id";
$sql.=" LEFT JOIN wp01_0customer AS C ON A.customer_id=C.id";

$sql.=" WHERE A.cast_id='{$cast_data["id"]}'";
$sql.=" AND A.sdate LIKE '{$ana_ym}%'";
$sql.=" AND A.del=0";
$sql.=" AND B.del=0";
$sql.=" GROUP BY log_id";
$sql.=" ORDER BY sdate ASC,stime ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}
		
		$dat_ana[$row["sdate"]][]	 =$row;
		$pay_item[$row["sdate"]]	+=$row["pts"];

		if($row["sdate"]<=$day_8){
			$pay_item_all			+=$row["pts"];
		}
			$pay_item_yet			+=$row["pts"];
	}
}

<<<EOM
		<tr>
			<td class="ana_top">日時</td>
			<td class="ana_top">シフト</td>
			<td class="ana_top">時間</td>
			<td class="ana_top" colspan="2">給与・歩合</td>
		</tr>

	<?for($n=1;$n<$ana_t+1;$n++){?>
		<?
			$ana_c	=$ana_ym*100+$n;
			$ana_week	=($week_01+$n-1)%7;
			$ana_all = number_format($ana_salary[$ana_c] +$pay_item[$ana_c]);
			if($ana_c >$day_8){
				$f_day="ana_f";
			}
		?>

		<tr>
			<td rowspan="2" class="ana_month <?=$f_day?> <?=$ana_line[$ana_week]?>"><?=$n?>(<?=$week[$ana_week]?>)</td>
			<td class="ana_sche <?=$f_day?> <?=$ana_line[$ana_week]?>"><?=$days_sche[$ana_c]?></td>
			<td class="ana_time <?=$f_day?> <?=$ana_line[$ana_week]?>"><?=$ana_time[$ana_c]?></td>
			<td class="ana_pay <?=$f_day?> <?=$ana_line[$ana_week]?>">	
				<span class="ana_icon"></span><span class="ana_pay_all"><?=$ana_all?></span>
			</td>
			<td id="ana_<?=$n?>" class="ana_detail<?if($ana_all ==0){?>_n<?}?> <?=$ana_line[$ana_week]?>"><span class="ana_arrow"></span></td>
		</tr>

		<tr>
			<td id="lana_<?=$n?>" class="ana_list" colspan="4">
				<div id="dana_<?=$n?>" class="ana_list_div">
					<span class="ana_list_c lc1">
						<span class="ana_list_name">店舗</span>
						<span class="ana_list_item">時給</span>
						<span class="ana_list_pts"><?=$ana_salary[$ana_c]?></span>
					</span>
				<?$tmp_line=0;?>

				<?foreach((array)$dat_ana[$ana_c] as $a1){?>
					<?$tmp_lc=$tmp_line % 2;?>
					<span class="ana_list_c lc<?=$tmp_lc?>">
						<span class="ana_list_name"><?=$a1["nickname"]?>様</span>
						<span class="ana_list_item"><?=$a1["log_comm"]?></span>
						<span class="ana_list_pts"><?=$a1["pts"]?></span>
					</span>
					<?$tmp_line++;?>
				<? } ?>
				</div>
			</td>
		</tr>
EOM;

echo json_decode($dat);
exit();
?>

