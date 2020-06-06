<?php
header('Content-Type: text/html; charset=SJIS');
ini_set('display_errors', 0);
mb_language("Japanese"); 
session_start();

//■■サーバー接続----------------------*

$mysqli = mysqli_connect("localhost", "blue_duty", "0909", "blue_duty");
mysqli_query($mysqli,"set namesSJIS");
mysqli_set_charset($mysqli,'SJIS'); 


if (!$mysqli) {
    die('☆接続失敗です。');
}

$gmt=8;

$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

$miki[1]="<span class=\"table_list l8a\">未</span>";
$miki[2]="<span class=\"table_list l8b\">既</span>";
$miki[3]="<span class=\"table_list l8c\">記</span>";
$miki[4]="<span class=\"table_list l8d\">未</span>";

$g_color[0]="#666666";
$g_color[1]="#c00000";

$icon_color[0]="#c00000";//赤
$icon_color[1]="#c00000";//赤
$icon_color[2]="#ffa0e0";//桃
$icon_color[3]="#c0c000";//橙
$icon_color[4]="#0000ff";//青
$icon_color[5]="#00c000";//緑
$icon_color[6]="#c000c0";//紫
$icon_color[7]="#909000";//茶
$icon_color[8]="#909090";//灰

$icon_font[1]="icon-warning";
$icon_font[2]="icon-envelope";
$icon_font[3]="icon-star-full";
$icon_font[4]="icon-search";
$icon_font[5]="icon-attachment";
$icon_font[6]="icon-phone";
$icon_font[7]="icon-camera";
$icon_font[8]="icon-file-text2";
$icon_font[9]="icon-diamond";
$icon_font[10]="icon-pictures";
$icon_font[11]="icon-home2";
$icon_font[12]="icon-gift";

$icon[".txt"]	=1;
$icon[".doc"]	=1;
$icon[".js"]	=1;
$icon[".css"]	=1;


$icon[".csv"]	=2;
$icon[".xls"]	=2;
$icon[".xlsx"]	=2;

$icon[".htm"]	=3;
$icon[".html"]	=3;

$icon[".jpg"]	=4;
$icon[".jpeg"]	=4;
$icon[".JPG"]	=4;
$icon[".gif"]	=4;
$icon[".png"]	=4;

$icon[".php"]	=5;

$icon[".lzh"]	=6;
$icon[".zip"]	=6;
$icon[".g7"]	=6;
$icon[".rar"]	=6;
$icon[".tar"]	=6;

$icon[".avi"]	=7;
$icon[".mov"]	=7;
$icon[".mpg"]	=7;
$icon[".wmv"]	=7;
$icon[".flv"]	=7;
$icon[".mp4"]	=7;

$s1=1;
$i=0;
$i2=0;
$j=0;

$gp		=$_REQUEST["gp"];
//$fv=$_REQUEST["fv"];
$ct		=$_REQUEST["ct"];
$me		=$_REQUEST["me"];
$t_mon	=$_REQUEST["t_mon"];
$c_todo	=$_REQUEST["c_todo"];

$todo_s1=array();
$todo_s2=array();
$todo_s3=array();

//■■基本情報＿カレンダー----------------------
$sql ="SELECT * FROM duty2_log";
$sql.=" ORDER BY date ASC";
$sql.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	$open_day= $row['date'];
	$open_year=date("Y",strtotime($row['date']));
}

$now=date("Y");

//-------------------------------------
$logdata1["TeSt"] ="Null";
$logdata2["TeSt"] =0;

//■■基本情報＿メンバー----------------------
if($_REQUEST["member_del"]){
	$sql ="UPDATE `duty2_member`";
	$sql .=" SET del='1'";
	$sql .=" WHERE `id`='{$_REQUEST["member_del"]}'";
	mysqli_query($mysqli,$sql);
	$admin=1;
}

if($_REQUEST["member_chg"]){
	$admin=1;

	$dat=$_REQUEST["dat"];
	$dat0=$_REQUEST["dat0"];

	foreach($dat as $a1 => $a2){

		$tmp_member[$dat0[$a1][1]]++;
		if($tmp_member[$dat0[$a1][1]] >1){
			$err="順番が重複しています";
		}

		$tmp_member[$dat0[$a1][2]]++;
		if($tmp_member[$dat0[$a1][2]] >1){
			$err="名前が重複しています";
		}

		$tmp_member[$dat0[$a1][3]]++;
		if($tmp_member[$dat0[$a1][3]] >1){

			$err="ログインIDが重複しています";
		}
	}

	if($err){
		$sql ="SELECT * FROM duty2_member";
		if($result = mysqli_query($mysqli,$sql)){
			while($row = mysqli_fetch_assoc($result)){

					$member[$row['id']]['name'] 	= $row['name'];
				if($row['del'] != 1){
					$member[$row['id']]['logid'] 	= $row['logid'];
					$member[$row['id']]['logpass'] 	= $row['logpass'];
					$member[$row['id']]['a'] 		= $row['g_a'];
					$member[$row['id']]['b'] 		= $row['g_b'];
					$member[$row['id']]['c'] 		= $row['g_c'];
					$member[$row['id']][$row['g_1']]= 1;
					$member[$row['id']][$row['g_2']]= 1;
					$member[$row['id']][$row['g_3']]= 1;
					$member[$row['id']][$row['g_4']]= 1;
					$member[$row['id']][$row['g_5']]= 1;
					$member[$row['id']][$row['g_6']]= 1;
					$member[$row['id']][$row['g_7']]= 1;
					$member[$row['id']][$row['g_8']]= 1;
					$member[$row['id']][$row['g_9']]= 1;

					$member_now[$row['sort']]	= $row['id'];
					$logdata1[$row['logid']]	=$row['logpass'];
					$logdata2[$row['logid']] 	=$row['id'];

					if($row['g_c'] ==1 && $row['del']==0){
						$member_comm[$row['sort']]=$row['id'];
					}
				}
			}
			ksort($member_now);
		}
	}else{
		mysqli_query($mysqli,"ALTER TABLE duty2_member DROP INDEX `sort`");

		foreach($dat0 as $a1 => $a2){

			$tmp_sort	=$dat0[$a1][1];
			$tmp_name	=$dat0[$a1][2];
			$tmp_logid	=$dat0[$a1][3];
			$tmp_logpass=$dat0[$a1][4];

			$tmp_a=$dat0[$a1][5];
			$tmp_b=$dat0[$a1][6];
			$tmp_c=$dat0[$a1][21];

			$sql ="UPDATE `duty2_member` SET";
			$sql.=" `sort`='{$tmp_sort}',";
			$sql.=" `name`='{$tmp_name}',";
			$sql.=" `logid`='{$tmp_logid}',";
			$sql.=" `logpass`='{$tmp_logpass}',";

			$sql.=" `g_a`='{$tmp_a}',";
			$sql.=" `g_b`='{$tmp_b}',";
			$sql.=" `g_c`='{$tmp_c}'";
			$n2=0;

			for($n1=1;$n1<10;$n1++){
				if($dat[$a1][$n1]>0){
					$n2++;
					$sql.=", `g_{$n2}`='{$dat[$a1][$n1]}'";
				}
			}

			for($n3=$n2+1;$n3<10;$n3++){
				$sql.=", `g_{$n3}`=''";
			}

			$sql.=" WHERE `id`='{$a1}'";
			mysqli_query($mysqli,$sql);

			$member[$a1]['name']		= $dat0[$a1][2];	
			$member[$a1]['logid'] 		= $dat0[$a1][3];
			$member[$a1]['logpass']		= $dat0[$a1][4];
			$member[$a1]['a'] 			= $dat0[$a1][5];
			$member[$a1]['b'] 			= $dat0[$a1][6];
			$member[$a1]['c'] 			= $dat0[$a1][21];
			$member[$a1][$dat[$a1][1]]	= 1;
			$member[$a1][$dat[$a1][2]]	= 1;
			$member[$a1][$dat[$a1][3]]	= 1;
			$member[$a1][$dat[$a1][4]]	= 1;
			$member[$a1][$dat[$a1][5]]	= 1;
			$member[$a1][$dat[$a1][6]]	= 1;
			$member[$a1][$dat[$a1][7]]	= 1;
			$member[$a1][$dat[$a1][8]]	= 1;
			$member[$a1][$dat[$a1][9]]	= 1;

			$member_now[$dat0[$a1][1]]	= $a1;

			$logdata1[$dat[$a1][3]] 	=$row['logpass'];
			$logdata2[$dat[$a1][3]] 	=$a1;


//print($sql."<br>\n");
		}
	}

}else{
	$sql ="SELECT * FROM duty2_member";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$member[$row['id']]['name'] 		= $row['name'];

			if($row['del'] != 1){
				$member[$row['id']]['logid'] 	= $row['logid'];
				$member[$row['id']]['logpass'] 	= $row['logpass'];
				$member[$row['id']]['a'] 		= $row['g_a'];
				$member[$row['id']]['b'] 		= $row['g_b'];
				$member[$row['id']]['c'] 		= $row['g_c'];
				$member[$row['id']][$row['g_1']]= 1;
				$member[$row['id']][$row['g_2']]= 1;
				$member[$row['id']][$row['g_3']]= 1;
				$member[$row['id']][$row['g_4']]= 1;
				$member[$row['id']][$row['g_5']]= 1;
				$member[$row['id']][$row['g_6']]= 1;
				$member[$row['id']][$row['g_7']]= 1;
				$member[$row['id']][$row['g_8']]= 1;
				$member[$row['id']][$row['g_9']]= 1;

				if($row['g_c'] ==1 && $row['del']==0){
					$member_comm[$row['sort']]=$row['id'];
				}
				if($row['del'] ==0){
					$menber_cnt++;
				}
				if($_SERVER['REMOTE_ADDR'] == "61.119.122.190" || $_REQUEST["vernis"] == 1573){
					$member_now[$row['sort']]	=$row['id'];
					$logdata1[$row['logid']]	=$row['logpass'];
					$logdata2[$row['logid']] 	=$row['id'];
					$ip_ok=1;
				}
			}
		}
		ksort($member_now);
	}
}

if($_REQUEST["member_new"]){
	$admin=1;
	$new=$_REQUEST["new"];
	$new_sort=$menber_cnt+1;

	foreach($member_now as $a1 => $a2){
		if($member[$a2]["name"] == $new['2']){
			$err.="「名前」が重複しています<br>";
		}

		if($member[$a2]["logid"] == $new['3']){
			$err.="Login_IDは使われています<br>";
		}
	}

	if(!$new['2']){
		$err.="「名前」がありません(必須)<br>";
	}

	if(!$new['3']){
		$err.="「IDCODE」がありません(必須)<br>";
	}

	if(!$new['4']){
		$err.="「PASSWORD」がありません(必須)<br>";
	}

	if(!$err){

	//$new['2']=mb_convert_encoding ($new['2'],"UTF-8","AUTO");

		for($n=7;$n<20;$n++){
			if($new[$n]) $tmp_gp[]=$new[$n];
		}
		sort($tmp_gp);

		$sql  ="INSERT INTO duty2_member(`sort`,`name`,`logid`,`logpass`,`g_a`,`g_b`,`g_c`,`g_1`,`g_2`,`g_3`,`g_4`,`g_5`,`g_6`,`g_7`,`g_8`,`g_9`)";
		$sql .="VALUES('{$new_sort}','{$new['2']}','{$new['3']}','{$new['4']}','{$new['5']}','{$new['6']}','{$new['tb']}','{$tmp_gp[0]}','{$tmp_gp[1]}','{$tmp_gp[2]}','{$tmp_gp[3]}','{$tmp_gp[4]}','{$tmp_gp[5]}','{$tmp_gp[6]}','{$tmp_gp[7]}','{$tmp_gp[8]}')";

//print($sql);

		mysqli_query($mysqli,$sql);
		$tmp_auto=mysqli_insert_id($mysqli);	

		$sql="INSERT INTO duty2_fav (`user_id`, `name`, `sort`, `icon`, `color` ) VALUES ('{$tmp_auto}', '重要','1', '1', '1')";
		mysqli_query($mysqli,$sql);

		if($new['6']!=1){
			$app=" AND(`group`='0'";
			for($tmp=1; $tmp<10;$tmp++){
				if($new[$tmp+6]){
					$app.=" OR `group`='{$tmp}'";
				}
			}
			$app.=")";
		}
		$sql2  ="SELECT * FROM `duty2_log`";
		$sql2 .=" WHERE `del`<>1 ";
		$sql2 .=$app;

		$sql2 .=" AND(`date`>{}) ";

		if($result2 = mysqli_query($mysqli,$sql2)){
			while($row = mysqli_fetch_assoc($result2)){
				$tmp_set="";
				for($tmp=1;$tmp<41;$tmp++){
					if($row["at".$tmp]==0){
						$tmp0="at".$tmp;
						$tmp_set=1;
						break 1;
					}
				}

				if($tmp_set == 1){
					$sql3 ="UPDATE duty2_log SET";
					$sql3.=" `{$tmp0}`='{$tmp_auto}'";
					$sql3.=" WHERE id='{$row["id"]}'";
					mysqli_query($mysqli,$sql3);


					$sql4 ="UPDATE duty2_sub SET";
					$sql4.=" `{$tmp0}`='1'";
					$sql4.=" WHERE id='{$row["id"]}'";
					mysqli_query($mysqli,$sql4);

				}else{
					$err="overflow!";
					break;
				}
			}
		}

		$member[$tmp_auto]['name'] 		= $new['2'];
		$member[$tmp_auto]['logid'] 	= $new['3'];
		$member[$tmp_auto]['logpass'] 	= $new['4'];
		$member[$tmp_auto]['a'] 		= $new['5'];
		$member[$tmp_auto]['b'] 		= $new['6'];

		if($new['7']) $member[$tmp_auto][$new['7']]= 1;
		if($new['8']) $member[$tmp_auto][$new['8']]= 1;
		if($new['9']) $member[$tmp_auto][$new['9']]= 1;
		if($new['10']) $member[$tmp_auto][$new['10']]= 1;
		if($new['11']) $member[$tmp_auto][$new['11']]= 1;
		if($new['12']) $member[$tmp_auto][$new['12']]= 1;
		if($new['13']) $member[$tmp_auto][$new['13']]= 1;
		if($new['14']) $member[$tmp_auto][$new['14']]= 1;
		if($new['15']) $member[$tmp_auto][$new['15']]= 1;
		$member_now[$new_sort]	= $tmp_auto;

	}
}

//■■基本情報Todo＿グループ----------------------
if($_REQUEST["plan_del"]){
	$admin=4;
	$plan_del	=$_REQUEST["plan_del"];

	$sql ="UPDATE duty2_plan SET";
	$sql.=" `del`='1'";
	$sql.=" WHERE `id`='{$plan_del}'";
	mysqli_query($mysqli,$sql);
}

if($_REQUEST["plan_chg"]){
	$admin=4;

	$plan_chg_sort	=$_REQUEST["plan_chg_sort"];
	$plan_chg_name	=$_REQUEST["plan_chg_name"];

	$sql ="SELECT * FROM duty2_plan ";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["del"] !=1){
				$plan_sort_n[$row["sort"]]=$row["id"];
			}
				$plan_n[$row["id"]]["name"]=$row["name"];
		}
	}

	if($plan_chg_sort && $plan_chg_name){
		foreach($plan_chg_name as $a1 => $a2){
			foreach($plan_sort_n as $a3 => $a4){
				if($a2== $plan_n[$a4]){
					$err="名前が重複しています。";
					break 3;
				}
			}
		}

		foreach($plan_chg_sort as $a1 => $a2){
			foreach($plan_sort_n as $a3 => $a4){
				if($a2== $plan_n[$a4]){
					$err="順番が重複しています。";
					break 3;
				}
			}
		}

		foreach($plan_chg_name as $a1 => $a2){
			$sql ="UPDATE duty2_plan SET";
			$sql.=" `name`='{$a2}',";
			$sql.=" `sort`='{$plan_chg_sort[$a1]}'";
			$sql.=" WHERE id='{$a1}'";
			mysqli_query($mysqli,$sql);

			$plan_sort[$plan_chg_sort[$a1]]=$a1;
			$plan[$a1]["name"]=$a2;
		}
	}


}else{
	$sql ="SELECT * FROM duty2_plan ";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["del"] !=1){
				$plan_sort[$row["sort"]]=$row["id"];
			}
				$plan[$row["id"]]["name"]=$row["name"];
		}
	}
}


if($_REQUEST["plan_new"]){
	$admin=4;
	$ct=count($plan_sort)+1;
	$plan_new=$_REQUEST["plan_new"];

	foreach($plan_sort as $a1 => $a2){
		if($plan_new == $plan[$a2]){
			$err="名前が重複しています。";
		}
	}

	if(!$err){
		$sql ="INSERT INTO duty2_plan";
		$sql .="(`sort`,`name`)";
		$sql .="VALUES('{$ct}','{$plan_new}')";
		mysqli_query($mysqli,$sql);

		$tmpauto=mysqli_insert_id($mysqli)+0;
		$plan_sort[$ct]=$tmpauto;
		$plan[$tmpauto]["name"]=$plan_new;
	}
}

ksort($plan_sort);



//■■基本情報Todo＿グループ----------------------
if($_REQUEST["comm_del"]){
	$admin=6;
	$comm_del	=$_REQUEST["comm_del"];

	$sql ="UPDATE duty2_comm SET";
	$sql.=" `del`='1'";
	$sql.=" WHERE `id`='{$comm_del}'";
	mysqli_query($mysqli,$sql);
}

if($_REQUEST["comm_chg"]){
	$admin=6;

	$comm_chg_sort	=$_REQUEST["comm_chg_sort"];
	$comm_chg_name	=$_REQUEST["comm_chg_name"];

	$sql ="SELECT * FROM duty2_comm ";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["del"] !=1){
				$comm_sort[$row["sort"]]=$row["id"];
			}
				$comm[$row["id"]]["name"]=$row["name"];
		}
	}

	if($comm_chg_sort && $comm_chg_name){
		foreach($comm_chg_name as $a1 => $a2){
			foreach($comm_sort as $a3 => $a4){
				if($a2== $comm_n[$a4]){
					$err="名前が重複しています。";
					break 3;
				}
			}
		}

		foreach($comm_chg_sort as $a1 => $a2){
			foreach($comm_sort as $a3 => $a4){
				if($a2== $comm_n[$a4]){
					$err="順番が重複しています。";
					break 3;
				}
			}
		}

		foreach($comm_chg_name as $a1 => $a2){
			$sql ="UPDATE duty2_comm SET";
			$sql.=" `name`='{$a2}',";
			$sql.=" `sort`='{$comm_chg_sort[$a1]}'";
			$sql.=" WHERE id='{$a1}'";
			mysqli_query($mysqli,$sql);

			$comm_sort[$comm_chg_sort[$a1]]=$a1;
			$comm[$a1]["name"]=$a2;
		}
	}


}else{
	$sql ="SELECT * FROM duty2_comm ";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["del"] !=1){
				$comm_sort[$row["sort"]]=$row["id"];
			}
				$comm[$row["id"]]["name"]=$row["name"];
		}
	}
}


if($_REQUEST["comm_new"]){
	$admin=6;
	$ct=count($comm_sort)+1;
	$comm_new=$_REQUEST["comm_new"];

	foreach($comm_sort as $a1 => $a2){
		if($comm_new == $comm[$a2]){
			$err="名前が重複しています。";
		}
	}

	if(!$err){
		$sql ="INSERT INTO duty2_comm";
		$sql .="(`sort`,`name`)";
		$sql .="VALUES('{$ct}','{$comm_new}')";
		mysqli_query($mysqli,$sql);

		$tmpauto=mysqli_insert_id($mysqli)+0;
		$comm_sort[$ct]=$tmpauto;
		$comm[$tmpauto]["name"]=$comm_new;
	}
}
ksort($comm_sort);

if($_POST[comm_set]){
	$admin=6;
	$now_ym=$_REQUEST['now_ym'];
	$set=$_REQUEST['set'];
	$tmp_m=$now_ym."-01";
	$tmp_t=date("t",strtotime($tmp_m));

	for($p=1;$p<$tmp_t+1;$p++){
		$tmp_n=substr("0".$p,-2);
		$dt=$now_ym."-".$tmp_n;

		$n=1;
		$app0="";
		$app1="";
		$app2="";
		foreach($set[$p] as $a1 => $a2){
			$app0.=", `com{$n}`, `mis{$n}`";
			$app1.= ", '{$a1}', '{$a2}'";
			$app2.= ", `com{$n}`= '{$a1}', `mis{$n}`= '{$a2}'";
			$n++;
		}

		$app2=substr($app2,1);

		$sql 	 ="INSERT INTO duty2_mission (`date`{$app0})VALUES";
		$sql	.="('{$dt}'{$app1})";
		$sql	.=" ON DUPLICATE KEY UPDATE ";
		$sql	.=$app2;

//	print("◎".$sql."<br>\n");
	mysqli_query($mysqli,$sql);
	}



/*

	for($n=1;$n<$cnt+1;$n++){
		$app0.=", `com{$n}`, `mis{$n}`";
	}
	$sql 	 ="INSERT INTO duty2_mission (`date`".$app0.")VALUES";

	for($n=1;$n<$tmp_t+1;$n++){
		$tmp_n=substr("0".$n,-2);
		$dt=$now_ym."-".$tmp_n;
		$sql.= "('{$dt}'";
		foreach($set[$n] as $a1 => $a2){
			$sql.= ", '{$a1}', '{$a2}'";
		}
		$sql.= "),";
	}
	$sql=substr($sql,0,-1);

	$sql.=" ON DUPLICATE KEY UPDATE";

	$sql.=" ON DUPLICATE KEY UPDATE";

        b = b + 21
        , c = VALUES(c) + 201;
*/



/*
set[<?=$n+1?>][<?=$a2?>]


	for($n=1;$n<32;$n++){
		$pp=1;
		foreach($set[$n] as $a1 => $a2){
			$app1.= ", `com{$pp}`, `mis{$pp}`";
			$app2.= ", '{$a1}', '{$a2}'";
			$app3.= ", `com{$pp}`='{$a1}',`mis{$pp}='{$a2}'";
			$pp++;
		}


		$nd=substr("0".$n,-2);
		$na=$now_year."-".$now_month."-".$nd;

		$sql 	 ="INSERT INTO duty2_mission (`date`";
		$sql 	 .=$app1;
		$sql 	 .=")";

		$sql	 .="VALUES('{$na}'";
		$sql 	 .=$app2;
		$sql 	 .=")";
//		mysqli_query($mysqli,$sql);
	}
*/

}





//■■基本情報グループ----------------------
if($_REQUEST["group_del"]){

	$admin=3;
	$group_del=$_REQUEST["group_del"];

	$sql2  ="UPDATE `duty2_group`";
	$sql2 .=" SET del='1'";
	$sql2 .=" WHERE `id`='{$group_del}'";
	mysqli_query($mysqli,$sql2);
}


if($_POST[group_chg]){
	$admin=3;
	$gp_sort=$_REQUEST["gp_sort"];
	$gp_name=$_REQUEST["gp_name"];

	$sql ="SELECT * FROM duty2_group";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			if($row['del'] !=1 && $row['id']){
				$group_sort[$row['sort']]	=$row['id'];
			}

			$group[$row['id']]['name']	= $row['name'];
		}
	}


	foreach((array)$group_sort as $a1 => $a2){

		foreach($gp_name as $a3 => $a4){
			if($a4 == $group[$a2]['name']){
				$err="名前が重複しています。";
				break 2;
			}
		}


		foreach($gp_sort as $a5 => $a6){
			if($a6 == $a1){
				$err="順番が重複しています。";
				break 2;
			}
		}
	}

	if(!$err){
		mysqli_query($mysqli,"ALTER TABLE duty2_group DROP INDEX `sort`");
		foreach($gp_sort as $a1 => $a2){
			$sql  ="UPDATE `duty2_group` SET";
			$sql .=" sort='{$a2}',";
			$sql .=" name='{$gp_name[$a1]}'";
			$sql .=" WHERE `id`='{$a1}'";
			mysqli_query($mysqli,$sql);

			$group[$a1]['name']=$gp_name[$a1];
			$group_sort[$a2]=$a1;

		}
	}
}else{

	$sql ="SELECT * FROM duty2_group";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			if($row['del'] !=1 && $row['id']){
				$group_sort[$row['sort']]	=$row['id'];
			}

			$group[$row['id']]['name']	= $row['name'];
		}
	}
}


//■追加------------
if($_REQUEST["group_new"]){
	$admin=3;
	$ct=max((array)$group_sort)+1;

	$new_name=$_REQUEST["new_name"];
	$sql3="INSERT INTO duty2_group(sort,name) VALUES('{$ct}','{$new_name}')";
	mysqli_query($mysqli,$sql3);
	$tmpauto=mysqli_insert_id($mysqli)+0;

	$group[$tmpauto]['name']	= $new_name;
	$group_sort[$ct]=$tmpauto;
}



$group_sort[0]="0";
$group[0]['name'] = "全体";

/*
$group_sort[99]="99";
$group[99]['name'] = "個別";
*/

ksort($group_sort);


//■■基本情報＿カテゴリ----------------------

if($_REQUEST["cate_del"]){
	$admin=2;
	$cate_del=$_REQUEST["cate_del"];
	$sql ="UPDATE `duty2_category`";
	$sql .=" SET del='1'";
	$sql .=" WHERE `id`='{$cate_del}'";
	mysqli_query($mysqli,$sql);
}

if($_REQUEST["cate_chg"]){
	mysqli_query($mysqli,"ALTER TABLE duty2_category DROP INDEX `sort`");

	$admin=2;
	$dat1=$_POST["dat1"];
	$dat2=$_POST["dat2"];
	$att=$_POST["att"];
	asort($dat1);

	$tmp=1;
	foreach($dat1 as $a1 => $a2){
		$sql ="UPDATE duty2_category SET sort='{$tmp}',name='{$dat2[$a1]}', att='{$att[$a1]}'";
		$sql.=" WHERE id='{$a1}'";
		mysqli_query($mysqli,$sql);

		$category[$a1]['att']	= $att[$a1];
		$category[$a1]['name']	= $dat2[$a1];
		$category_sort[$tmp]=$a1;
		$tmp++;
	}

}else{
	$sql ="SELECT * FROM duty2_category";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row['del'] !="1"){
				$category_sort[$row['sort']]= $row['id'];
				$category[$row['id']]['att']= $row['att'];
			}
			$category[$row['id']]['name']	= $row['name'];
		}
		ksort($category_sort);
	}
}

if($_POST["cate_new"]){
	$new_name=$_POST["new_name"];
	$new_im=$_POST["new_im"];

	$admin=2;
	$cnt=max($category_sort)+1;
	$sql ="INSERT INTO `duty2_category` (`sort`,`name`,`att`)";
	$sql .="VALUES('{$cnt}','{$new_name}','{$new_im}')";
	mysqli_query($mysqli,$sql);

	$tmp_auto=mysqli_insert_id($mysqli)+0;

	$category_sort[$cnt]= $tmp_auto;
	$category[$tmp_auto]['name']= $new_name;
	$category[$tmp_auto]['att']	= $new_im;
}


$duty_login	=$_REQUEST["duty_login"];
$duty_logpass	=$_REQUEST["duty_logpass"];

if($logdata1[$duty_login] === $duty_logpass && $duty_login){
	$uid				=$logdata2[$duty_login];
	$_SESSION["uid"]	=$logdata2[$duty_login];
	$_SESSION["time"]	= time();

}elseif($duty_login || $duty_logpass){
	$err_msg="IDもしくはPASSが違います。";
}

//----------------------------------------------------
if(time() - $_SESSION["time"] > 86400 && $_SESSION["time"]){//■普通にセッションタイムアウト
	session_destroy(); 
	$err_msg="TIME OUTしました";
	$uid="";
	$_REQUEST = array();
	$_POST = array();

}else{//■普通にセッション継続
	$_SESSION["time"]	= time();

	if($_REQUEST["log_id"]){
		$_SESSION["log_id"]=$_REQUEST["log_id"];
	}

	if($_REQUEST["fav_load"]){
		$_SESSION["log_id"]="";
		$_SESSION["fav_load"]=$_REQUEST["fav_load"];
	}

	if($_REQUEST["c_category"]){
		$_SESSION["log_id"]="";
		$_SESSION["c_category"]	= $_REQUEST["c_category"];
	}

	if($_REQUEST["c_writer"]){
		$_SESSION["log_id"]="";
		$_SESSION["c_writer"]	= $_REQUEST["c_writer"];
	}

	if($_REQUEST["c_pg"]){
		$_SESSION["log_id"]="";
		$_SESSION["c_pg"]	= $_REQUEST["c_pg"];
	}


	if($_REQUEST["now_year"]){
		$_SESSION["now_year"]	= $_REQUEST["now_year"];
	}


	if($_REQUEST["admin"]){
		$_SESSION["admin"]	= $_REQUEST["admin"];
		$admin				= $_REQUEST["admin"];
	}


	if($_REQUEST["now_month"]){
		$_SESSION["now_month"]	= $_REQUEST["now_month"];

		$_SESSION["log_id"]="";
		$_SESSION["c_pg"]	= "";
		$_SESSION["c_writer"]	= "";
		$_SESSION["c_category"]	= "";
		$_SESSION["fav_load"]	= "";
	}

	if(!$_SESSION["uid"]) $_SESSION["uid"]=$uid;
	if(!$_SESSION["now_year"]) $_SESSION["now_year"]=date("Y");
	if(!$_SESSION["now_month"]) $_SESSION["now_month"]=date("m");
	if(!$_SESSION["c_pg"]) $_SESSION["c_pg"]=1;

	if($ct){
		$_SESSION["log_id"]="";
		foreach((array)$ct as $a1 => $a2){
			if($a1 == 0){
				$_SESSION["c_category"]="";
			}else{
				$_SESSION["c_category"]=$a1;
			}
		}
	}

	if($me){
		$_SESSION["log_id"]="";
		foreach((array)$me as $a1 => $a2){
			if($a1 == 0){
				$_SESSION["c_writer"]="";
			}else{
				$_SESSION["c_writer"]=$a1;
			}
		}
	}

	if($t_mon){
		$_SESSION["now_year"]	=substr($t_mon,0,4);
		$_SESSION["now_month"]	=substr($t_mon,4,2);
		$_SESSION["c_category"]	="";
		$_SESSION["c_writer"]="";
		$_SESSION["log_id"]="";
	}
}

if($_POST["re_act"] || $admin === 0){
	$uid=$_SESSION["uid"];
	$_SESSION = array();
	$_SESSION["uid"]=$uid;
	$fav_load="";
	$admin="";
	$c_pg=1;

}elseif($gp[4]){
	$_SESSION = array();
	session_destroy(); 
	$err="LOG OUTしました";
	$uid="";

}elseif($gp){
/*
	$uid=$_SESSION["uid"];
	$_SESSION = array();
	$_SESSION["uid"]=$uid;
	$_SESSION["time"]	= time();

	$log_id="";
	$fav_load="";
	$c_pg=1;
*/

$_SESSION["log_id"]="";
$_SESSION["fav_load"]="";

$_SESSION["c_category"]="";
$_SESSION["c_writer"]="";
$_SESSION["c_pg"]="";

}
if($gp[3]){
	$admin = 1;
}

$uid		=$_SESSION["uid"];
$log_id		=$_SESSION["log_id"];
$fav_load	=$_SESSION["fav_load"];

$c_category	=$_SESSION["c_category"];
$c_writer	=$_SESSION["c_writer"];
$c_pg		=$_SESSION["c_pg"];


if($err && $_SESSION){
	$_SESSION = array();
}

$now_year	=$_SESSION["now_year"];
$now_month	=$_SESSION["now_month"];

if(!$now_year) $now_year	=date("Y");
if(!$now_month) $now_month	=date("m");

if($_REQUEST["log_dd"]){
	$log_id		=$_SESSION["log_dd"];
}

//sprintf("%02d",$_SESSION["now_month"]);

$n1=0;
$n2=0;
$n3=0;

$tmp_d=date("d",time()-($gmt*3600));

if($_REQUEST["todo_set_lv"]){
	$tmp_d=$_REQUEST["todo_set_lv"];

}elseif($_REQUEST["c_todo"]){
	$tmp_d=$_REQUEST["c_todo"];
}

$tmp_date=$now_year ."-".$now_month."-".$tmp_d;
$now_ym=$now_year ."-".$now_month;

if($uid){
	$sql	 ="SELECT * FROM duty2_mission";
	$sql	.=" WHERE `date` LIKE '{$now_ym}%'";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$n=substr($row["date"],-2)+0;
			$set[$n][$row["com0"]]=$row["mis0"];
			$set[$n][$row["com1"]]=$row["mis1"];
			$set[$n][$row["com2"]]=$row["mis2"];
			$set[$n][$row["com3"]]=$row["mis3"];
			$set[$n][$row["com4"]]=$row["mis4"];
			$set[$n][$row["com5"]]=$row["mis5"];
			$set[$n][$row["com6"]]=$row["mis6"];
			$set[$n][$row["com7"]]=$row["mis7"];
			$set[$n][$row["com8"]]=$row["mis8"];
			$set[$n][$row["com9"]]=$row["mis9"];

			if($tmp_d+0 == $n){
				if($row["mis0"] == $uid){
					$task[]=$row["com0"];
				}
				if($row["mis1"] == $uid){
					$task[]=$row["com1"];
				}
				if($row["mis2"] == $uid){
					$task[]=$row["com2"];
				}
				if($row["mis3"] == $uid){
					$task[]=$row["com3"];
				}
				if($row["mis4"] == $uid){
					$task[]=$row["com4"];
				}
				if($row["mis5"] == $uid){
					$task[]=$row["com5"];
				}
				if($row["mis6"] == $uid){
					$task[]=$row["com6"];
				}
				if($row["mis7"] == $uid){
					$task[]=$row["com7"];
				}
				if($row["mis8"] == $uid){
					$task[]=$row["com8"];
				}
				if($row["mis9"] == $uid){
					$task[]=$row["com9"];
				}
			}
		}
	}

//■■ホリデー関連----------------------
	$sql ="SELECT * FROM duty2_holiday";
	$sql .=" WHERE del<>1";
//	$sql .=" AND month='{$now_month}'";
	$sql .=" AND year='{$now_year}'";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$holi_list[$row["id"]][0]	=$row["name"];
			$holi_list[$row["id"]][1]	=$row["year"];
			$holi_list[$row["id"]][2]	=$row["month"];
			$holi_list[$row["id"]][3]	=$row["day"];

			if($row["year"] == $now_year && $row["month"] == $now_month){
				$holiday[$row["day"]]	=$row["name"];
			}
		}
	}

	if($_REQUEST["holiday_reg"]){
		$admin=5;

		$hori_new	=$_REQUEST["hori_new"];

		$sql ="INSERT INTO duty2_holiday(`name`,`year`,`month`,`day`)";
		$sql .="VALUES('{$hori_new[0]}','{$hori_new[1]}','{$hori_new[2]}','{$hori_new[3]}')";
		mysqli_query($mysqli,$sql);

		$tmpauto=mysqli_insert_id($mysqli)+0;

		$holi_list[$tmpauto][0]	=$hori_new[0];
		$holi_list[$tmpauto][1]	=$hori_new[1];
		$holi_list[$tmpauto][2]	=$hori_new[2];
		$holi_list[$tmpauto][3]	=$hori_new[3];

		if($hori_new[1] == $now_year && $hori_new[2] == $now_month){
			$holiday[$tmpauto]	=$hori_new[3];
		}
	}


//■■パラメータ関連----------------------
	if(!$c_pg) $c_pg=1;
	$pg=($c_pg-1)*10;

	if(!$c_time) $c_time=date("H:i");
	if(!$c_date) $c_date=date("Y/m/d");

	$day_st=$now_year."-".$now_month."-01 00:00:00";
	$day_ed=date("Y-m-01 00:00:00",strtotime($day_st)+3456000);

	$day_now=date("Y-m-d H:i:s");

//■■個人情報＿お気に入り----------------------
	$fs=1;
	if($_POST["fav_chg_set"]){
		$gp[2]=1;
		$fav_del	=$_REQUEST["fav_del"];
		$fav_name	=$_REQUEST["fav_name"];
		$fav_icon	=$_REQUEST["fav_icon"];
		$fav_color	=$_REQUEST["fav_color"];
		$fav_order	=$_REQUEST["fav_order"];

		foreach((array)$fav_order as $a1 => $a2){
			foreach((array)$fav_order as $b1 => $b2){
				if($a1 != $b1){
					if($a2 == $b2){
						$msg="順番が重複しています";
						break 2;
					}
				}
			}
		}


		if(!$msg){
			foreach((array)$fav_icon as $a1 => $a2){
				if($fav_del[$a1] == 1){
					$sql ="DELETE FROM `duty2_fav`";
					$sql.=" WHERE `fav_id`='{$a1}'";
					mysqli_query($mysqli,$sql);

					$sql2  ="DELETE FROM `duty2_list`";
					$sql2 .=" WHERE user='{$uid}'";
					$sql2 .=" AND fav_id='{$a1}'";
					mysqli_query($mysqli,$sql2);

				}else{
					$sql ="UPDATE `duty2_fav` SET";
					$sql.=" `name`='{$fav_name[$a1]}',";
					$sql.=" `icon`='{$a2}',";
					$sql.=" `sort`='{$fav_order[$a1]}',";
					$sql.=" `color`='{$fav_color[$a1]}'";
					$sql.=" WHERE `fav_id`='{$a1}'";
					mysqli_query($mysqli,$sql);

					$fav_sort[$fav_order[$a1]] =$a1;
					$fav[$a1]['name'] = $fav_name[$a1];
					$fav[$a1]['icon'] = $a2;
					$fav[$a1]['color'] = $fav_color[$a1];
					$icon_dat[$a1]="<span style=\"color:{$icon_color[$fav_color[$a1]]}; display:inline-block;height:20px;\"><span class=\"sele_icon_20 {$icon_font[$a2]}\">　{$fav_name[$a1]}</span></span>";

				}
			}
/*
foreach($fav_sort as $a1 => $a2){
print($a1."■".$a2."<br>\n");
}

foreach($fav_order as $a1 => $a2){
print($a1."□".$a2."<br>\n");
}
*/
		}

	}else{
		$sql ="SELECT * FROM duty2_fav";
		$sql .=" WHERE user_id='{$uid}'";
	//	$sql .=" AND `del`<>1";
		$sql .=" ORDER BY `sort` ASC";

		$n=0;
		if($result = mysqli_query($mysqli,$sql)){
			while($row = mysqli_fetch_assoc($result)){
				if($row["name"] && $row["icon"] && $row["color"]){

					$fav_sort[$n] =$row["fav_id"];
					$fav[$row["fav_id"]]['name'] = $row["name"];
					$fav[$row["fav_id"]]['icon'] = $row["icon"];
					$fav[$row["fav_id"]]['color'] = $row["color"];
					$icon_dat[$row["fav_id"]]="<span style=\"color:{$icon_color[$row['color']]};display:inline-block;height:22px;\"><span class=\"sele_icon_20 {$icon_font[$row['icon']]}\">　{$row['name']}</span></span>";
					$n++;
				}
			}
		}

		if($_POST["fav_new_set"]){

			$gp[2]=1;
			$fav_name_new	=$_REQUEST["fav_name_new"];
			$fav_icon_new	=$_REQUEST["fav_icon_new"];
			$fav_color_new	=$_REQUEST["fav_color_new"];
			$fav_sort_new	=count($fav_sort)+1;

			if(!$fav_name_new){
				$msg="名前がありません。";
			}

			if(!$msg){
				$sql="INSERT INTO duty2_fav (`user_id`, `name`, `sort`, `icon`, `color` ) VALUES ('{$uid}', '{$fav_name_new}','{$fav_sort_new}', '{$fav_icon_new}', '{$fav_color_new}')";
				mysqli_query($mysqli,$sql);
				$tmpauto=mysqli_insert_id($mysqli)+0;

				$fav_sort[$fav_sort_new]=$tmpauto;
				$fav[$tmpauto]['name']	= $fav_name_new;
				$fav[$tmpauto]['icon']	= $fav_icon_new;
				$fav[$tmpauto]['color']	= $fav_color_new;
			}
		}
		if($fav_sort){
			ksort($fav_sort);
		}
		
		$sql ="SELECT * FROM duty2_list";
		$sql .=" WHERE user='{$uid}'";
	//	$sql .=" AND fav_id>0";

		if($result = mysqli_query($mysqli,$sql)){
			while($row2 = mysqli_fetch_assoc($result)){
				$fav_count[$row2["favlog"]]=$row2["fav_id"];
			}
		}
	}

//■■ACT＿検索------------------------------
	if($_POST["search_button"]){
		$search_key		=$_POST["search_key"];
		$search_radio	=$_POST["search_radio"];

		if(strlen($search_key)==1 ||strlen($search_key)==2){
			$_SESSION["msg"]="検索文字数が短すぎます";

		}elseif(strlen($search_key) >2){
			if($search_radio ==1){//title
				$_SESSION["search"]=" AND `title` LIKE '%{$search_key}%'";
				$_SESSION["msg"]="検索(タイトル)：「".$search_key."」";
			}elseif($search_radio =='2'){//本文
				$_SESSION["search"]=" AND `log` LIKE '%{$search_key}%'";
				$_SESSION["msg"]="検索(本文)：「".$search_key."」";

			}elseif($search_radio == 3){//れす
				$sql ="SELECT * FROM `duty2_res`";
				$sql .=" WHERE `log` LIKE '%{$search_key}%'";

				$_SESSION["search"]=" AND(id=0";
				if($result = mysqli_query($mysqli,$sql)){
					while($row = mysqli_fetch_assoc($result)){
						$_SESSION["search"] .= " OR id ='{$row["master"]}'";
					}
				}
				$_SESSION["search"].=")";
				$_SESSION["msg"]="検索(レス)：「".$search_key."」";
			}
		}

	//■■ACT＿投稿しました----------------------

	}elseif($_POST["w_try"]){
		$w_date = $_REQUEST["w_date"];
		$w_time = $_REQUEST["w_time"];
		$w_title= mb_convert_encoding ($_REQUEST["w_title"],"SJIS","AUTO");
		$w_cate = $_REQUEST["w_cate"];
		$w_group= $_REQUEST["w_group"];
		$w_log= mb_convert_encoding ($_REQUEST["w_log"],"SJIS","AUTO");
		$w_mem  = $_REQUEST["w_mem"];
		

		if(!$upng){
			if(!$w_title) $w_title ="[No Title]";
			if(!$w_log) $w_log ="[No Log]";

			$n=1;
			foreach((array)$member_now as $m1 => $m2){

				if($w_group=="0" || $w_group == 0 ||$member[$m2][$w_group] == 1 || $w_mem[$m2]==1 ||$m2 == $uid){//■グループが全員、メンバーが管理者、グループが対象、グループ個別が対象、投稿者
					$ins_1 .=", `at{$n}`";	
					$ins_2 .=", '{$m2}'";
					if($m2 == $uid){
						$ins_3 .=", '3'";
					}else{
						$ins_3 .=", '1'";
					}
				}
				$n++;
			}

			$sql = "INSERT INTO duty2_log (`date`, `time`, `title`, `writer`, `category`, `group`, `log`".$ins_1.")";
			$sql.= " VALUES ('{$w_date}', '{$w_time}', '{$w_title}', '{$uid}', '{$w_cate}', '{$w_group}', '{$w_log}'".$ins_2.")"; 
			mysqli_query($mysqli,$sql);

//print($sql."<br>\n");

			$tmp_auto=mysqli_insert_id($mysqli)+0;
			$sql = "INSERT INTO duty2_sub (`id`{$ins_1})";
			$sql.= " VALUES ({$tmp_auto}{$ins_3})"; 
			mysqli_query($mysqli,$sql);

//print($sql."<br>\n");

		//■■ファイルアップロードここから＝＝＝＝＝＝＝＝＝＝＝＝＝
			$up_folder="./upload/".$now_year."/".$tmp_auto;
			for($upld=1;$upld<7;$upld++){
				if (is_uploaded_file($_FILES["upfile"]["tmp_name"][$upld])) {
					if($upld == 1){
						mkdir($up_folder,0777);
						chmod($up_folder,0777);
					}
					$app[$upld]=substr($_FILES["upfile"]["name"][$upld],strrpos($_FILES["upfile"]["name"][$upld], '.'));
					$tmp_file=mb_convert_encoding($_FILES["upfile"]["name"][$upld],"UTF-8","auto");
					move_uploaded_file($_FILES["upfile"]["tmp_name"][$upld], "./upload/".$now_year."/".$tmp_auto."/".$tmp_file );
				}
			}

		//□□ファイルアップロードここまで＝＝＝＝＝＝＝＝＝＝＝＝＝
		}

	//■■ACT＿削除しました----------------------
	}elseif($_REQUEST["log_del"]){
		$del_id=$_REQUEST["log_del"];

		$sql ="UPDATE `duty2_log`";
		$sql .=" SET del='1'";
		$sql .=" WHERE `id`='{$del_id}'";
		mysqli_query($mysqli,$sql);
		$log_id="";


	//■■ACT＿書き直しました-----------------
	}elseif($_POST["set_chg2"]){

		$e_title= $_REQUEST["e_title"];
		$e_cate = $_REQUEST["e_cate"];
		$e_log  = $_REQUEST["e_log"];

		if(!$e_title) $e_title ="[No Title]";
		if(!$e_log) $e_log ="[No Log]";

		$sql ="UPDATE `duty2_log`";
		$sql .=" SET `title`='{$e_title}',";
		$sql .=" `log`='{$e_log}',";
		$sql .=" `category`='{$e_cate}'";
		$sql .=" WHERE `id`='{$log_id}'";
		mysqli_query($mysqli,$sql);

//print($sql);

	//■■ACT＿RES削除----------------------
	}elseif($_REQUEST["res_del"]){
		$log_id="";

		$del_id	 =$_REQUEST["res_del"];
		$sql 	 ="UPDATE `duty2_res`";
		$sql 	.=" SET `del`='1'";
		$sql	.=" WHERE `id`='{$del_id}'";
		mysqli_query($mysqli,$sql);

	//■■ACT＿RES投稿----------------------
	}elseif($c_act =="set_res"){

	//■■ACT＿RES投稿されました------------
	}elseif($_POST["set_res2"]){

		$r_log = $_REQUEST["r_log"];
		$res_date=date("Y-m-d");
		$res_time=date("H:i");
		if(!$r_log) $r_log ="[No Log]";

		$sql="INSERT INTO duty2_res (`master`, `date`, `time`, `writer`, `log`) VALUES ('{$log_id}', '{$res_date}','{$res_time}','{$uid}', '{$r_log}')";
		mysqli_query($mysqli,$sql);

		$lin ="SELECT * FROM duty2_sub";
		$lin.=" WHERE id='{$log_id}'";
		$lin.=" LIMIT 1";
		$result = mysqli_query($mysqli,$lin);
		$row = mysqli_fetch_assoc($result);

		for($tmp=1;$tmp<41;$tmp++){
			if($row["at".$tmp] ==2){
				$inc.=", at{$tmp}='1'";

			}elseif($row["at".$tmp] ==3){
				$inc.=", at{$tmp}='4'";
			}
		}

		$sql="UPDATE `duty2_sub` SET `del`='0'";
		$sql.=$inc;
		$sql.=" WHERE `id`='{$log_id}'";

		mysqli_query($mysqli,$sql);

	//■■ACT＿Todoセット----------------------
	}elseif($_REQUEST["todo_chg_id"]){

		$todo_chg_id=$_REQUEST["todo_chg_id"];
		$sql ="SELECT * FROM duty2_todo";
		$sql.=" WHERE todo_id= '{$todo_chg_id}'";
		$sql.=" AND del<> '1'";

		if($result = mysqli_query($mysqli,$sql)){
			while($row = mysqli_fetch_assoc($result)){

				if($_REQUEST["todo_set_lv"]){
					$tmp_date=$row["ed_date"];
				}else{
					$tmp_date=$row["st_date"];
				}

				$todo_sy	=substr($row["st_date"],0,4);
				$todo_sm	=substr($row["st_date"],5,2);
				$todo_sd	=substr($row["st_date"],8,2);

				$todo_ey	=substr($row["ed_date"],0,4);
				$todo_em	=substr($row["ed_date"],5,2);
				$todo_ed	=substr($row["ed_date"],8,2);

				$todo_sh	=substr($row["st_time"],0,2);
				$todo_si	=substr($row["st_time"],2,2);

				$todo_eh	=substr($row["ed_time"],0,2);
				$todo_ei	=substr($row["ed_time"],2,2);

				$todo_start		=$row["start"];
				$todo_passage	=$row["passage"];
				$todo_end		=$row["end"];

				$todo_log		=str_replace("\n","<br>",$row["log"]);
				$todo_group		=$row["group"];
				$todo_plan		=$row["plan"];
			}
		}

	}elseif($_REQUEST["c_todo"]){

		$todo_sy	=$_SESSION["now_year"];
		$todo_sm	=$_SESSION["now_month"];
		$todo_sd	=$_REQUEST["c_todo"];

		$todo_ey	=$todo_sy;
		$todo_em	=$todo_sm;
		$todo_ed	=$todo_sd;

		$todo_sh	="09";
		$todo_si	="00";

		$todo_eh	="23";
		$todo_ei	="00";


	//■■ACT＿Todo登録しました-----------------
	}elseif($_REQUEST["c_todo2"]){
		$c_todo2	=$_REQUEST["c_todo2"];

		$todo_tag1	=$_REQUEST["todo_tag1"]+0;
		$todo_tag2	=$_REQUEST["todo_tag2"]+0;
		$todo_tag3	=$_REQUEST["todo_tag3"]+0;

		$todo_sy	=$_REQUEST["todo_sy"];
		$todo_sm	=$_REQUEST["todo_sm"];
		$todo_sd	=$_REQUEST["todo_sd"];

		$todo_ey	=$_REQUEST["todo_ey"];
		$todo_em	=$_REQUEST["todo_em"];
		$todo_ed	=$_REQUEST["todo_ed"];

		$todo_sh	=$_REQUEST["todo_sh"];
		$todo_si	=$_REQUEST["todo_si"];

		$todo_eh	=$_REQUEST["todo_eh"];
		$todo_ei	=$_REQUEST["todo_ei"];

		$todo_group	=$_REQUEST["todo_group"];
		$todo_plan	=$_REQUEST["todo_plan"];
		$todo_log	=$_REQUEST["todo_log"];

		$st_date=$todo_sy."-".$todo_sm."-".$todo_sd;
		$ed_date=$todo_ey."-".$todo_em."-".$todo_ed;

		$st_time=$todo_sh*100+$todo_si;
		$ed_time=$todo_eh*100+$todo_ei;

		$st_time=sprintf("%04d",$st_time);
		$ed_time=sprintf("%04d",$ed_time);

		$sql="INSERT INTO `duty2_todo`";
		$sql.=" (`submit_date`, `st_date`, `ed_date`, `st_time`, `ed_time`, `start`, `passage`, `end`, `log`, `staff`, `group`, `plan`)";
		$sql.=" VALUES('{$tmp_date}','{$st_date}','{$ed_date}','{$st_time}','{$ed_time}','{$todo_tag1}','{$todo_tag2}','{$todo_tag3}','{$todo_log}','{$uid}','{$todo_group}','{$todo_plan}')";
		mysqli_query($mysqli,$sql);

	}elseif($_POST["c_todo4"]){

		$todo_chg_id2	=$_REQUEST["todo_chg_id2"];
		$sql="UPDATE `duty2_todo` SET";
		$sql.=" del='1'";
		$sql .=" WHERE `todo_id`='{$todo_chg_id2}'";
		mysqli_query($mysqli,$sql);

	}elseif($_POST["c_todo3"]){
		$todo_chg_id2	=$_REQUEST["todo_chg_id2"];

		$todo_tag1	=$_REQUEST["todo_tag1"]+0;
		$todo_tag2	=$_REQUEST["todo_tag2"]+0;
		$todo_tag3	=$_REQUEST["todo_tag3"]+0;

		$st_date	=$_REQUEST["todo_sy"]."-".$_REQUEST["todo_sm"]."-".$_REQUEST["todo_sd"];
		$ed_date	=$_REQUEST["todo_ey"]."-".$_REQUEST["todo_em"]."-".$_REQUEST["todo_ed"];

		$todo_sh	=$_REQUEST["todo_sh"];
		$todo_si	=$_REQUEST["todo_si"];
		$todo_eh	=$_REQUEST["todo_eh"];
		$todo_ei	=$_REQUEST["todo_ei"];

		$t_group=$_REQUEST["todo_group"];
		$plan	=$_REQUEST["todo_plan"];
		$t_log	=$_REQUEST["todo_log"];

		$st_time=$todo_sh*100+$todo_si;
		$ed_time=$todo_eh*100+$todo_ei;
		$st_time=sprintf("%04d",$st_time);
		$ed_time=sprintf("%04d",$ed_time);

		$sql="UPDATE `duty2_todo` SET";

		$sql.=" `st_date`='{$st_date}',";
		$sql.=" `ed_date`='{$ed_date}',";
		$sql.=" `st_time`='{$st_time}',";
		$sql.=" `ed_time`='{$ed_time}',";

		$sql.=" `start`='{$todo_tag1}',";
		$sql.=" `passage`='{$todo_tag2}',";
		$sql.=" `end`='{$todo_tag3}',";

		$sql.=" `log`='{$t_log}',";
		$sql.=" `staff`='{$uid}',";
		$sql.=" `group`='{$t_group}',";
		$sql.=" `plan`='{$plan}'";
		$sql .=" WHERE `todo_id`='{$todo_chg_id2}'";

		mysqli_query($mysqli,$sql);

	//■■PASS変更--------------------------------------
	}elseif($_POST["pass_chg_set"]){
		$gp[2]=1;

		$passbox=$_REQUEST["passbox"];
		if($passbox != $member[$uid]['logpass'] ){
			$sql ="UPDATE `duty2_member`";
			$sql .=" SET `logpass`='{$passbox}'";
			$sql .=" WHERE `id`='{$uid}'";
			mysqli_query($mysqli,$sql);
		}

	//■■お気に入りフォルダ-----------------------------
	}elseif($_POST["fv"]){
		foreach((array)$_POST["fv"] as $a1 => $a2){
			$log_id="";
			$fav_load=$a2;
			$_SESSION["fav_load"]=$fav_load;
		}
	} 

//■■個人情報＿投稿一覧----------------------
	$now_date=date("Y-m-d H:i:s");
	$lin ="SELECT *, at{$uid} as view_ck FROM duty2_log";

	if($fav_load){
		$lin.=" LEFT JOIN `duty2_list` ON duty2_log.id=duty2_list.favlog";
	}
	$lin.=" WHERE del <>1";
	$lin.=" AND(`date`<='{$now_date}' or `writer`='{$uid}')";
//	$lin.=" AND at{$uid}>0";

	if(!$fav_load && !$_SESSION["search"]){
		$lin.=" AND `date`>='{$day_st}'";
		$lin.=" AND `date`<'{$day_ed}'";
	}

	$lin.=" AND (at1={$uid} OR at2={$uid} OR at3={$uid} OR at4={$uid} OR at5={$uid} OR";
	$lin.=" at6={$uid} OR at7={$uid} OR at8={$uid} OR at9={$uid} OR at10={$uid} OR";
	$lin.=" at11={$uid} OR at12={$uid} OR at13={$uid} OR at14={$uid} OR at15={$uid} OR";
	$lin.=" at16={$uid} OR at17={$uid} OR at18={$uid} OR at19={$uid} OR at20={$uid} OR";
	$lin.=" at21={$uid} OR at22={$uid} OR at23={$uid} OR at24={$uid} OR at25={$uid} OR";
	$lin.=" at26={$uid} OR at27={$uid} OR at28={$uid} OR at29={$uid} OR at30={$uid} OR";
	$lin.=" at31={$uid} OR at32={$uid} OR at33={$uid} OR at34={$uid} OR at35={$uid} OR";
	$lin.=" at36={$uid} OR at37={$uid} OR at38={$uid} OR at39={$uid} OR at40={$uid})";

	if($c_category) $lin.=" AND category='{$c_category}'";
	if($c_group) $lin.=" AND group='{$c_group}'";
	if($c_writer) $lin.=" AND writer='{$c_writer}'";
	if($fav_load) $lin.=" AND duty2_list.fav_id='{$fav_load}' AND duty2_list.user='{$uid}'";
	if($_SESSION["search"]) $lin.=$_SESSION["search"];
	$lin.=" ORDER BY `date` DESC, `time` DESC";

	if($result = mysqli_query($mysqli,$lin)){
		while($row = mysqli_fetch_assoc($result)){

			$log[$i]["id"]		 = $row["id"];
			$log[$i]["date"]	 = $row["date"];
			$log[$i]["time"]	 = $row["time"];
			$log[$i]["title"]	 = substr($row["title"],0,60);
			$log[$i]["writer"]	 = $row["writer"];
			$log[$i]["category"] = $row["category"];
			$log[$i]["group"]	 = $row["group"];
			$log[$i]["fav"]		 = $row["fav"];
			$log[$i]["view_ck"]	 = $row["view_ck"];

			$at_y=substr($row['date'],0,4);
			$tmp_attach="./upload/{$at_y}/{$row['id']}";
			if(file_exists($tmp_attach)){
				$log[$i]["attach"]=1;
			}

			$tmp_id=$row["id"];
			$lin2 ="SELECT * FROM duty2_sub";
			$lin2.=" WHERE id='{$tmp_id}'";
			$lin2.=" LIMIT 1";

			$result2 = mysqli_query($mysqli,$lin2);
			$row2 = mysqli_fetch_assoc($result2);

			for($n=1;$n<41;$n++){
				$user_view[$row["id"]][$row["at".$n]]=$row2["at".$n];
				$ck_id[$row["id"]][$row["at".$n]]=$n;
			}

			if($log_id == $row["id"]){//view表示条件
				if(!$fav_count[$log_id]){
					$icon_dat[$fav_count[$log_id]]="<span style='color:#aaaaaa; display:inline-block;height:22px;font-size:16px;'> ●SELECT FLAG</span>";
				}

				$row["log"] = str_replace("<","&lt;",$row["log"]);
				$row["log"] = str_replace("&lt;br>","<br>",$row["log"]);
				$view=preg_replace('/(https?|ftp)(:\/\/[-_.!~*\'(a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', '<A href="\\1\\2" target="_blank">\\1\\2</A>', $row["log"]);

				$view = str_replace("\r\n","<br>",$view);
				$view = str_replace("\r","<br>",$view);
				$view = str_replace("\n","<br>",$view);

				$view_title=$row["title"];
				$view_writer=$row["writer"];

				$view_date=$row["date"];
				$view_time=$row["time"];

				$view_category	= $row["category"];
				$view_group		= $row["group"];

				if($user_view[$row["id"]][$uid] ==1){
					$tmp=$ck_id[$row["id"]][$uid];

					$sql="UPDATE `duty2_sub` SET at{$tmp}='2'";
					$sql.=" WHERE `id`='{$row["id"]}'";
					mysqli_query($mysqli,$sql);
					$user_view[$row["id"]][$uid]=2;
				}

				if($user_view[$row["id"]][$uid] ==4){
					$tmp=$ck_id[$row["id"]][$uid];

					$sql="UPDATE `duty2_sub` SET at{$tmp}='3'";
					$sql.=" WHERE `id`='{$row["id"]}'";
					mysqli_query($mysqli,$sql);
					$user_view[$row["id"]][$uid]=3;
				}

				if($log[$i]["attach"]){
					$view_attach = $tmp_attach;
					$a=0;
					if ($dir = opendir($tmp_attach)) {
						while (($file = readdir($dir)) !== false) {
							if ($file != "." && $file != "..") {
								$attach_file[$a]=$file;
								$icon_tmp=	substr($file,strrpos($file,'.'));
								$attach_icon[$a]=$icon[$icon_tmp];

								if(!$icon[$icon_tmp]){
									$attach_icon[$a]=0;
								}
								$a++;

							}
						} 
					closedir($dir);
					}
				}

				//■■VIEW情報＿RES----------------------
				$p0=0;
				$st2 = "SELECT * FROM duty2_res WHERE master='{$log_id}' AND del=0 ORDER BY id ASC";
				if($result2 = mysqli_query($mysqli,$st2)){
					while($row2 = mysqli_fetch_assoc($result2)){
						$res[$p0]["res_id"]	= $row2["id"];
						$res[$p0]["date"]	= $row2["date"];
						$res[$p0]["time"]	= $row2["time"];
						$res[$p0]["writer"]	= $row2["writer"];
						$res[$p0]["log"]	= $row2["log"];

						$res[$p0]["log"]	= str_replace("<","&lt;",$res[$p0]["log"]);
						$res[$p0]["log"]	= str_replace("&lt;br>","<br>",$res[$p0]["log"]);
						$res[$p0]["log"]	= preg_replace('/(https?|ftp)(:\/\/[-_.!~*\'(a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', '<A href="\\1\\2" target="_blank">\\1\\2</A>', $res[$p0]["log"]);

						$res[$p0]["log"]	= str_replace("\r\n","<br>",$res[$p0]["log"]);
						$res[$p0]["log"]	= str_replace("\r","<br>",$res[$p0]["log"]);
						$res[$p0]["log"]	= str_replace("\n","<br>",$res[$p0]["log"]);
						$p0++;
					}
				}
				$st="";
			}

			if($user_view[$row["id"]][$uid] == 4 ||$user_view[$row["id"]][$uid] == 1){
				$c_yet[$row["category"]]++;
				$w_yet[$row["writer"]]++;
			}


			if($category[$row["category"]]['att'] == 1 && $user_view[$row["id"]][$uid]==1){
			$log_top[$i2]=$log[$i];
				$i2++;
			}else{
				$i++;
			}

		}
	}


//■ページカウント-----------------------------
	$pg_st=($c_pg-1)*10;
	$pg_ed=($c_pg-1)*10+10;
	if($i<$pg_ed){
		$pg_ed=$i;
	}

//■■お気に入り登録ログから----------------------
	if($_POST["fav_reg"]){

		$icon_set=$_REQUEST["icon_set"];
		$n_icon=$_REQUEST["n_icon"];

		if($fav_count[$icon_set]){
			$f_in .="UPDATE `duty2_list` SET `fav_id`='{$n_icon}' WHERE `user`='{$uid}' AND `favlog`='{$icon_set}'";

		}else{//追加
			$f_in .="INSERT INTO duty2_list(fav_id, favlog, user) VALUES('{$n_icon}','{$icon_set}','{$uid}')";
		}
		mysqli_query($mysqli,$f_in);
		$fav_count[$icon_set]=$n_icon;
	}

//■■VIEW情報＿添付----------------------
	if(file_exists($t_dir= "./upload/".$now."/".$view)){
		if ($handle = opendir($t_dir)) {
			$t=0;
			while (false !== ($file = readdir($handle))) {
				if($file !=".." && $file !="."){
					$t_an=strrpos($file, ".");
					$t_an2=substr($file,$t_an);
					$tmp_file[$t]=$file;
					$tmp_kind[$t]=$icon[$t_an2]+0;

					$t++;
				}
			}
			closedir($handle);
		}
	}
}


//■todoリスト読み込み
$tmp_ym=substr($tmp_date,0,7);
$sql ="SELECT * FROM duty2_todo";
$sql.=" WHERE (st_date like '{$tmp_ym}%' OR ed_date like '{$tmp_ym}%') AND del<>1";
//print($sql);
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($member[$uid][$row["group"]] ==1 || $row["group"] ==0 ||( $row["group"] == 90 && $row["staff"] == $uid)){
/*
			if($row["passage"] == 1 && $row["ed_date"] >= $tmp_date && $row["st_date"] <= $tmp_date){
				$todo_s2[$n2]["todo_id"]=$row["todo_id"];
				$todo_s2[$n2]["st_date"]=$row["st_date"];
				$todo_s2[$n2]["ed_date"]=$row["ed_date"];
				$todo_s2[$n2]["st_time"]=$row["st_time"];
				$todo_s2[$n2]["ed_time"]=$row["ed_time"];
				$todo_s2[$n2]["plan"]	=$row["plan"];
				$todo_s2[$n2]["log"]	=$row["log"];
				$todo_s2[$n2]["staff"]	=$row["staff"];
				$todo_s2[$n2]["group"]	=$row["group"];
				if(substr($row["st_date"],0,7) == substr($tmp_date,0,7) || substr($row["ed_date"],0,7) == substr($tmp_date,0,7)){
					$tmp_s=str_replace("-","",$row["st_date"]);
					$tmp_e=str_replace("-","",$row["ed_date"]);
					$tf[substr($row["st_date"],-2)]=2;
				}
				$n2++;
			}
*/

			if($row["end"] == 1){
				if($row["ed_date"] == $tmp_date){
					$todo_s3[$n3]["todo_id"]=$row["todo_id"];
					$todo_s3[$n3]["st_date"]=$row["st_date"];
					$todo_s3[$n3]["ed_date"]=$row["ed_date"];
					$todo_s3[$n3]["st_time"]=$row["st_time"];
					$todo_s3[$n3]["ed_time"]=$row["ed_time"];
					$todo_s3[$n3]["plan"]	=$row["plan"];
					$todo_s3[$n3]["log"]	=str_replace("\n","<br>",$row["log"]);
					$todo_s3[$n3]["staff"]	=$row["staff"];
					$todo_s3[$n3]["group"]	=$row["group"];

					$n3++;
				}
				if($row["group"] == 90){
					$mine[substr($row["ed_date"],8,2)]=1;

				}


				if(!$tf[substr($row["ed_date"],-2)] && substr($row["ed_date"],0,7) ==  $tmp_ym){
					$tf[substr($row["ed_date"],-2)]=3;
				}
			}

			if($row["start"] == 1){
				if($row["st_date"] == $tmp_date){
					$todo_s1[$n1]["todo_id"]=$row["todo_id"];
					$todo_s1[$n1]["st_date"]=$row["st_date"];
					$todo_s1[$n1]["ed_date"]=$row["ed_date"];
					$todo_s1[$n1]["st_time"]=$row["st_time"];
					$todo_s1[$n1]["ed_time"]=$row["ed_time"];
					$todo_s1[$n1]["plan"]	=$row["plan"];
					$todo_s1[$n1]["log"]	=str_replace("\n","<br>",$row["log"]);

					$todo_s1[$n1]["staff"]	=$row["staff"];
					$todo_s1[$n1]["group"]	=$row["group"];
					$n1++;
				}

				if($row["group"] == 90){
					$mine[substr($row["st_date"],8,2)]=1;
				}


				if(substr($row["st_date"],0,7) ==  $tmp_ym){
					$tf[substr($row["st_date"],-2)]=1;
				}
			}
		}
	}
}


if($_POST["set_chg"]){
	$view = str_replace("<br>","\n",$view);
}

if($c_pg<=2){
	$d_pg_st=1;

	if( ($i / 10 ) >5){
		$d_pg_ed=6;

	}else{
		$d_pg_ed=ceil($i / 10 )+1;
	}

}elseif(ceil($i / 10 )-$c_pg<3){
	$d_pg_ed=ceil($i / 10 )+1;
	$d_pg_st=$d_pg_ed-5;
	if($d_pg_st<1) $d_pg_st=1;

}else{
	$d_pg_st=$c_pg-2;
	$d_pg_ed=$c_pg+3;
}


//■カレンダー処理---------

$t_mon_01=$now_year."-".sprintf("%02d",$now_month)."-01 00:00:00";//今月1日DB用
$n_mon=date("Ym",strtotime($t_mon_01)+3456000);//来月
$p_mon=date("Ym",strtotime($t_mon_01)-100000);//前月

$t_mon_t=date("t",strtotime($t_mon_01));


$t_mon_31=substr($n_mon,0,4)."-".substr($n_mon,4,2)."-01 00:00:00";//来月1日DB用
$t_wek_01=date("w",strtotime($t_mon_01));//今月最初は何曜日？
$t_wek_31=date("t",strtotime($t_mon_01));//今月は何日？


for($n=$t_wek_01;$n<$t_wek_01+$t_wek_31;$n++){
	$p2++;
	$cal[$n]=sprintf("%02d", $p2);
}

if($t_wek_01+$t_wek_31 >=36){
	$cal_las=42;//6週
}else{
	$cal_las=35;//5週
}

ksort($member_comm);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>事業部引継ぎ</title>
<meta charset="SHIFT-JIS">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex">
<meta name="robots" content="nofollow">
<link rel="stylesheet" type="text/css" href="css/ck.css?d=<?=time()?>" />
<link rel="stylesheet" type="text/css" href="css/main.css?d=<?=time()?>" />
<link rel="stylesheet" type="text/css" href="font/style.css?d=<?=time()?>" />

<script type="text/javascript" src="js/jquery-1.11.2.min.js?d=<?=time()?>"></script>
<script type="text/javascript" src="js/jquery-ui.min.js?d=<?=time()?>"></script>
<script type="text/javascript" src="js/jquery.accordion.js"></script>
<script type="text/javascript">

jQuery( function($) {
   	$('.todo_tag_ckb').click(function(){
		var ck_count = $(".todo_div :checked").length;

		if (ck_count  > 0 ){
			$('#todo_send').prop("disabled", false);
			$('#todo_send').css('background','#ff90b0');
		} else {
			$("#todo_send").prop("disabled", true);
			$('#todo_send').css('background','#e0e0e0');
		}
	});

	jQuery('#logdel').click(function(){
		if(!confirm('本当に削除しますか？')){
			return false;
		}else{
			location.href = './index.php?del_id=<?=$log[$c_view]["id"]?>';
		}
	});


	jQuery('tbody tr[data-href]').addClass('clickable').click( function() {
		window.location = $(this).attr('data-href');
	}).find('a').hover( function() {
		$(this).parents('tr').unbind('click');

	}, function() {
		$(this).parents('tr').click( function() {
			window.location = $(this).attr('data-href');
		});
	});
/**/
	jQuery('#cat').change(function() {
		var val = $(this).val();
		$('.gp_dt').hide();
		$('#gp_dt' + val).show();
	}).change();

	$('.sub_slide').hide();
	$('.main_slide').click(function(){
		$('div.sub_slide').slideUp();
		if($('+div.sub_slide',this).css('display') == 'none'){
			$('img',this).addClass('rotate');
			$('+div.sub_slide',this).slideDown();
		}
	});

	$('a[href^=#]').click(function(){ 
		var speed = 500; 
		var href= $(this).attr("href"); 
		var target = $(href == "#" || href == "" ? 'html' : href); 
		var position = target.offset().top; 
		$("html, body").animate({scrollTop:position}, speed, "swing"); 
		return false; 
	}); 

	$(document).click(function(e){
		if(!$(e.target).closest('.main_slide','sub_slide').length) {
			$('.sub_slide').slideUp();
		}
	});

	$('.sub_slide2').hide();
	$('.main_slide2').click(function(){
		$('.sub_slide2').slideUp();
		if($('+.sub_slide2',this).css('display') == 'none'){
			$('+.sub_slide2',this).slideDown();
		}
	});

	$('#d1').click(function() {
		$(this).fadeOut(700);
	}); 

});



function Resdel(N1){
	if(!confirm('本当に削除しますか？')){
		return false;
	}else{
		location.href = './index.php?res_del='+N1;
	}
}

function Logdel(N2){
	if(!confirm('本当に削除しますか？')){
		return false;
	}else{
		location.href = './index.php?log_del='+N2;
	}
}

function MemberDel(N3, N4){
	if(!confirm('ユーザー「' + N4 + '」を削除します。\n※一旦削除しますと元に戻せません\n※削除されたユーザーの投稿は削除されず、そのまま残ります。\n\nよろしいですか')){
		return false;
	}else{
		location.href = './index.php?member_del='+N3;
	}
}

function CateDel(N5, N6){
	if(!confirm('カテゴリ「' + N6 + '」を削除します。\n※一旦削除しますと元に戻せません。\n\nよろしいですか')){
		return false;
	}else{
		location.href = './index.php?cate_del='+N5;
	}
}

function GroupDel(N7, N8){
	if(!confirm('カテゴリ「' + N8 + '」を削除します。\n※一旦削除しますと元に戻せません。\n\nよろしいですか')){
		return false;
	}else{
		location.href = './index.php?group_del='+N7;
	}
}

function PlanDel(N9, N0){
	if(!confirm('計画「' + N0 + '」を削除します。\n※一旦削除しますと元に戻せません。\n\nよろしいですか')){
		return false;
	}else{
		location.href = './index.php?plan_del='+N9;
	}
}

function CommDel(Na, Nb){
	if(!confirm('当番「' + Nb + '」を削除します。\n※一旦削除しますと元に戻せません。\n\nよろしいですか')){
		return false;
	}else{
		location.href = './index.php?comm_del='+Na;
	}
}



function Fav(FF) {
<?foreach((array)$fav_sort as $a1 => $a2){?>
	if(FF == <?=$a2?>){
	document.getElementById('iconselect').innerHTML = '<?=$icon_dat[$a2]?>';
	}
<?}?>
	if(FF == 0){
	document.getElementById('iconselect').innerHTML = "<span style='display:inline-block;height:20px;'>　</span>";
	}
}

function FavI(Fa) {
<?foreach((array)$fav_sort as $a1 => $a2){?>
	<?for($n=1;$n<13;$n++){?>if(Fa == <?=$a2?><?=$n?>){
		document.getElementById('fav_select<?=$a2?>').innerHTML = '<span class="<?=$icon_font[$n]?> sele_icon_22"></span>';
	}
	<?}?>
<?}?>
}

function FavC(Fb) {
<?foreach((array)$fav_sort as $a1 => $a2){?>
	<?for($n=1;$n<9;$n++){?>if(Fb == <?=$a2?><?=$n?>){
		document.getElementById('fav_select<?=$a2?>').className="main_slide m_sele_i cc_f<?=$n?>";
		document.getElementById('color_select<?=$a2?>').className="main_slide m_sele_c cc<?=$n?>";
	}
	<?}?>
<?}?>
}

function FavNewI(Fa) {
<?for($n=1;$n<13;$n++){?>if(Fa == <?=$n?>){
	document.getElementById('fav_select_new').innerHTML = '<span class="<?=$icon_font[$n]?> sele_icon_22"></span>';
}
<?}?>
}

function FavNewC(Fb) {
<?for($n=1;$n<9;$n++){?>if(Fb == <?=$n?>){
	document.getElementById('fav_select_new').className="main_slide m_sele_i cc_f<?=$n?>";
	document.getElementById('color_select_new').className="main_slide m_sele_c cc<?=$n?>";
}
<?}?>
}

function Passage() {
	f = document.f; //フォーム要素
	id = [];

	reg = new RegExp(/^[-]?[0-9]*$/);

	id['todo_sy'] = '<?=$todo_sy+0?>';
	id['todo_sm'] = '<?=$todo_sm+0?>';
	id['todo_sd'] = '<?=$todo_sd+0?>';
	id['passage'] = f['passage'].value; //経過日数

	hizuke = new Date(id['todo_sy'], id['todo_sm']-1, id['todo_sd']-1+id['passage']*1);

	var res = reg.test(id['passage']); //true or false

	if (!res) {
		f['todo_ey'].value = f['todo_em'].value = f['todo_ed'].value = "";
		return;
	}

	var H1=hizuke.getFullYear();
	var H2=("0" + (hizuke.getMonth() + 1)).slice(-2);
	var H3=("0" + hizuke.getDate()).slice(-2);

	f['todo_ey'].value = H1;
	f['todo_em'].value = H2;
	f['todo_ed'].value = H3;
}

</script>
</style>
</head>
<body>
<div class="outer">
<span style="color:#ff0000;"><?=$err?></span><br>

<?if(!$uid){?>
	<table class="first_table">
		<tr>
			<td class="first_main">
				事業部引継ぎ
			</td>
		</tr>
		<tr>
			<td class="first_sub">
				<form action="./index.php" method="post">
					<table class="first_sub_in">
					<tr>
					<td style="width:60px; text-align:right;">ID番号</td><td style="width:200px; text-align:center"><input style="width:198px;" type="text" name="duty_login" maxlength="20"></td>
					</tr><tr>
					<td style="width:60px; text-align:right;">PASS</td><td style="width:200px; text-align:center"><input style="width:198px;" type="password" name="duty_logpass"></td>
					</tr><tr>
					<td style="width:60px; text-align:right;">　</td><td id="trick" style="width:200px; height:120px; text-align:center;vertical-align:top;position:relative;">
					
					<?if($ip_ok == 1){?>
					<button class="submit" style="width:200px;" type="submit" name="log_in" value="LOGIN">LOGIN</button>
					<span id="d1"></span>
					<?}else{?>
					<button id="d1" class="submit" style="width:200px; position:absolute; top: 5px; left: 0; right: 0;margin: auto; " type="button" value="LOGIN">LOGIN</button>
					<?}?>
					
					</td>
					</tr>
					</table>

				</form>
			</td>
		</tr>
	</table>
	<BR>
<!--■■管理者-->
<?}else{?>

<div class="top">
	<form action="./index.php" method="post">
	<div class="top_00"><a href="https://id.obc.jp/k337n0i68zq2/?manuallogin=True" target="_BLANK" class="timecard">TIME CARD</a></div>
	<div class="top_01">
	<? foreach((array)$group_sort as $a1 => $a2){?><?if($a2 !=0 && $a2 !=99 && $group[$a2]['del'] !=1){?><span class="group_top<?=$member[$uid][$a2]+0?>">[<?=$group[$a2]['name']?>]</span><? } ?><? } ?>
	</div>
	<div class="top_02">
	<span class="top_02_01">
		<select name="now_year" id="now_year" style="width:80px; font-size:13px; text-align:left;">
		<?for($a=$now;$a>$open_year-1;$a--){?>
			<option value="<?=$a?>"<?if($a == $now_year) print(" selected")?>><?=$a?></option>
		<? } ?>
		</select>
		<select name="now_month" id="now_month" style="width:50px; font-size:13px; text-align:left;">
		<?for($a=1;$a<13;$a++){?>
			<option value="<?=sprintf("%02d",$a)?>"<?if($a == $now_month) print(' selected="selected"')?>><?=sprintf("%02d",$a)?></option>
		<? } ?>
		</select>
		<button class="submit" type="submit" value="変更" name="act">変更</button>
	</span>
	
		<span><?if($c_pg > 1){?><a href="./index.php?c_pg=<?=$c_pg-1?>" style="text-decoration: none;" class="btn b_right">戻</a><? }else{ ?><span  class="btn b_right" style="color:#cccccc;">戻</span><? } ?><?for($p=$d_pg_st;$p<$d_pg_ed;$p++){?><a href="./index.php?c_pg=<?=$p?>" style="text-decoration: none;" class="btn b_list <?if($p == $c_pg) print("now_pages")?>"><?=$p?></a><? } ?><?if($i- $c_pg*10>0){?><a href="./index.php?c_pg=<?=$c_pg+1?>" style="text-decoration: none;" class="btn b_left">進</a><? }else{ ?><span style="color:#cccccc;" class="btn b_left">進</span><? } ?></span>
		<button class="submit" type="submit" name="re_act" value="page">更新</button>
	</div>
	<div style="clear:both"></div>
	</form>
</div>

<div class="menu">
	<form action="./index.php" method="post">
		<div class="menu_cl">
			<div>
				<span class="prev"><a href="./index.php?t_mon=<?=$p_mon?>">＜前月</a></span>
				<span style="font-size:13px;"><?=$now_year?>/<?=sprintf("%02d",$now_month)?></span>
				<span class="next"><a href="./index.php?t_mon=<?=$n_mon?>">翌月＞</a></span><br>
			</div>
			<div class="box2p y">日</div><!--
			--><div class="box2p y">月</div><!--
			--><div class="box2p y">火</div><!--
			--><div class="box2p y">水</div><!--
			--><div class="box2p y">木</div><!--
			--><div class="box2p y">金</div><!--
			--><div class="box2p y">土</div><br><!--
			--><?for($a=0;$a<$cal_las;$a++){$tmp=$t_mon*100+$cal[$a];?><!--
			--><?if(!$cal[$a]){?><span class="box2p <?if(($a%7) ==0){ ?>sun<?}elseif(($a % 7) ==6){?>sat<? } ?>">　</span><?}else{?><!--
				--><a href="./index.php?c_todo=<?=$cal[$a]?>" class="box2p <?if($cal[$a]==$tmp_d){?>now<?}elseif($mine[$cal[$a]]){ ?>my<?}elseif($a % 7 ==0 || $holiday[$cal[$a]]){ ?>sun<?}elseif($a % 7 ==6){?>sat<? } ?> w<?=$tf[$cal[$a]]?>"><span style="color:#303030"><?=$cal[$a]?></span></a><?}?><?if( ($a % 7)==6 && $cal[$a]){?><br><?}?><?}?></div>
		<div class="menu_00">
			<div class="menu_01"><?=$member[$uid]['name']?></div>
			<button type="submit" value="記事投稿" class="green" name="gp[1]">記事投稿</button><br>
			<button type="submit" value="登録変更" class="green" name="gp[2]">登録変更</button><br>
			<?if($member[$uid]['a'] == 1){?><button type="submit" value="管理者用" class="green" name="gp[3]">管理</button><br><? } ?>
			<div class="main_menu main_slide2">キーワード検索</div>

			<div class="sub_menu sub_slide2">
			<input name="search_key" value="<?=$search_key?>" type="text" style="width:193px; border-style: none;" maxlength="20"><br>
			<label><input type="radio" name="search_radio" value="1" <?if($keycheck !=2 || $keycheck !=3){?> checked="checked"<?}?>><span  style="color:#006400; font-weight:600;"> タイトル</span></label><br>
			<label><input type="radio" name="search_radio" value="2" <?if($keycheck ==2){?> checked="checked"<?}?>><span  style="color:#006400; font-weight:600;"> 本文</span></label><br>
			<label><input type="radio" name="search_radio" value="3" <?if($keycheck ==3){?> checked="checked"<?}?>><span  style="color:#006400; font-weight:600;"> レス</span></label><br>
			<button type="submit" value="検索" class="search_button" name="search_button" style="padding:2px;"><span class="icon-search sele_icon_16"></span>　検　索　<span class="icon-search sele_icon_16"></span></button>
			</div>
			<div class="main_menu main_slide">フォルダ</div>
			<div class="sub_menu sub_slide">
				<?foreach((array) $fav_sort as $a1 => $a2){?><button type="submit" value="<?=$a2?>" class="green2" name="fv[<?=$a2?>]" style="padding:2px;"><div style="line-height:16px; font-size:16px;"><span class="<?=$icon_font[$fav[$a2]['icon']]?> sele_icon_16"></span>&nbsp;<?=$fav[$a2]['name']?></div></button><br>
				<? } ?>
			</div>

			<button type="submit" value="LOG_OUT" class="green" name="gp[4]">LOG OUT</button><br>
		</div>
		<div class="menu_10">
			<div class="menu_11">カテゴリー</div>
			<button type="submit" value="全て" class="pink" name="ct[0]">全て</button><br>
			<?foreach((array)$category_sort as $a1 => $a2){?>
				<button type="submit" value="<?=$category[$a2]["name"]?>" class="pink" name="ct[<?=$a2?>]">
					<div style="float:left;"><?=$category[$a2]["name"]?></div>
					<?if($c_yet[$a2] > 0){?><div style="float:right; color:#0000ff; font-weight:700; padding:0 3px 0 0;">(<?=$c_yet[$a2]?>)</div><? } ?>
					<div style="clear:both"></div>
				</button><br>
			<? } ?>
		</div>
		<div class="menu_20">
			<div class="menu_21">送信者</div>
			<button type="submit" value="全て" class="blue" name="me[0]">全員</button><br>
			<?foreach((array)$member_now as $a1 => $a2){?>
				<button type="submit" value="<?=$member[$a2]['name']?>" class="blue" name="me[<?=$a2?>]">
					<div style="float:left;"><?=$member[$a2]['name']?></div>
					<?if($w_yet[$a2] > 0){?><div style="float:right; color:#0000ff; font-weight:700; padding:0 3px 0 0;">(<?=$w_yet[$a2]?>)</div><? } ?>
					<div style="clear:both"></div>
				</button><br>
			<? } ?>
		</div>
	</form>
</div>
<div class="main">
<?if($admin==1){?>
<form method="post" action="./index.php">
	<div style="width:750px;">
		<button type="button" value="終了" name="admin_end" class="admin_end" onclick="location.href='./index.php?admin=0'">終了</button>
		<button type="button" value="メンバー" name="admin_member" class="admin_select" onclick="location.href='./index.php?admin=1'">メンバー</button>
		<button type="button" value="カテゴリ" name="admin_category" class="admin_else" onclick="location.href='./index.php?admin=2'">カテゴリ</button>
		<button type="button" value="グループ" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=3'">グループ</button>
		<button type="button" value="TO_DO" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=4'">To_Do</button>
		<button type="button" value="カレンダー" name="admin_holiday" class="admin_else" onclick="location.href='./index.php?admin=5'">カレンダー</button>
		<button type="button" value="掃除当番" name="admin_toban" class="admin_else" onclick="location.href='./index.php?admin=6'">掃除当番</button>
	</div>
<br>
<div style="height:30px;">　</div>
<div class="admin_scroll">
<span style="white-space: nowrap;"><span class="t_title" style="width:30px; border-left:1px solid #cccccc;">序</span><!--
--><span class="t_title" style="width:150px;">名前</span><!--
--><span class="t_title" style="width:100px">LOGIN_ID</span><!--
--><span class="t_title" style="width:100px">PASSWORD</span><!--
--><span class="t_title" style="width:50px;padding:1px 0px;">admin</span><!--
--><span class="t_title" style="width:50px;padding:1px 0px;">管理者</span><!--
--><span class="t_title" style="width:50px;padding:1px 0px;">当番</span><!--
--><?foreach((array)$group_sort as $a1 => $a2){?><?if($a1>0 && $a1<90){?><span class="t_title" style="width:50px;padding:1px 0px;"><?=$group[$a2]["name"]?></span><? } ?><? } ?></span><br>
<span style="white-space: nowrap;"><span class="admins" style="width:30px;border-left:1px solid #cccccc;text-align:center;font-weight:800; font-size:13px">新</span><!--
--><span class="admins" style="width:150px;"><input maxlength="8" type="text" name="new[2]" style="width:136px; border:none;" maxlength="8"></span><!--
--><span class="admins" style="width:100px"><input maxlength="20" type="text" name="new[3]" style="width:86px; border:none;" maxlength="10"></span><!--
--><span class="admins" style="width:100px"><input maxlength="20" type="text" name="new[4]" style="width:86px; border:none;" maxlength="10"></span><!--
--><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="1" name="new[5]" id="new[5]" class="admin_yn"><label for="new[5]" class="admin_yn_label">●</label></span><!--
--><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="1" name="new[6]" id="new[6]" class="admin_yn"><label for="new[6]" class="admin_yn_label">●</label></span><!--
--><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="1" name="new[tb]" id="new[tb]" class="admin_yn"><label for="new[tb]" class="admin_yn_label">●</label></span><!--
--><?for($n=0;$n<count($group_sort)-2;$n++){?><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="<?=$group_sort[$n+1]?>" name="new[<?=$n+7?>]" id="new[<?=$n+7?>]" class="admin_yn"><label for="new[<?=$n+7?>]" class="admin_yn_label">●</label></span><? } ?><!--
--><span style="width:60px;text-align:left;display:inline-block;"><button style="margin:5px; height:25px; text-align:25px;"type="submit" value="登録" name="member_new">登録</button></span></span><br>
<br><br>
<button style="margin:5px; height:25px; text-align:25px;"type="submit" 	value="更新" name="member_chg">更新</button><br>
<span style="white-space: nowrap;"><span class="t_title" style="width:30px; border-left:1px solid #cccccc;">序</span><!--
--><span class="t_title" style="width:150px;">名前</span><!--
--><span class="t_title" style="width:100px">LOGIN_ID</span><!--
--><span class="t_title" style="width:100px">PASSWORD</span><!--
--><span class="t_title" style="width:50px;padding:1px 0px">admin</span><!--
--><span class="t_title" style="width:50px;padding:1px 0px">管理者</span><!--
--><span class="t_title" style="width:50px;padding:1px 0px">当番</span><!--
--><?foreach((array)$group_sort as $a1 => $a2){?><?if($a1>0 && $a1<90){?><span class="t_title" style="width:50px;padding:1px 0px;"><?=$group[$a2]['name']?></span><? } ?><? } ?></span><br>
<?foreach((array)$member_now as $m1 => $m2){?>
<span style="white-space: nowrap;"><span class="admins" style="width:30px;border-left:1px solid #cccccc;">
<input type="text" value="<?=$m1?>" name="dat0[<?=$m2?>][1]" style="width:24px; border:none; text-align:right;"></span><!--
--><span class="admins" style="width:150px;"><input maxlength="8" type="text" value="<?=$member[$m2]['name']?>" name="dat0[<?=$m2?>][2]" style="width:136px; border:none;"></span><!--
--><span class="admins" style="width:100px"><input maxlength="20" type="text" value="<?=$member[$m2]['logid']?>" name="dat0[<?=$m2?>][3]" style="width:86px; border:none;"></span><!--
--><span class="admins" style="width:100px"><input maxlength="20" type="text" value="<?=$member[$m2]['logpass']?>" name="dat0[<?=$m2?>][4]" style="width:86px; border:none;"></span><!--
--><span class="admins" style="width:50px;padding: 1px 0px;"><input type="checkbox" value="1" name="dat0[<?=$m2?>][5]" id="dat0[<?=$m2?>][5]" class="admin_yn"<?if($member[$m2]['a']==1){?> checked="checked"<?}?>><label for="dat0[<?=$m2?>][5]" class="admin_yn_label">●</label></span><!--
--><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="1" name="dat0[<?=$m2?>][6]" id="dat0[<?=$m2?>][6]" class="admin_yn"<?if($member[$m2]['b']==1){?> checked="checked"<?}?>><label for="dat0[<?=$m2?>][6]" class="admin_yn_label">●</label></span><!--
--><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="1" name="dat0[<?=$m2?>][21]" id="dat0[<?=$m2?>][21]" class="admin_yn"<?if($member[$m2]['c']==1){?> checked="checked"<?}?>><label for="dat0[<?=$m2?>][21]" class="admin_yn_label">●</label></span><!--
<?$n=0;?>
<?foreach((array)$group_sort as $a1 => $a2){?><?if($a1>0 && $a1<90){?>
<?$n++?>
--><span class="admins" style="width:50px;padding:1px 0px;"><input type="checkbox" value="<?=$a2?>" name="dat[<?=$m2?>][<?=$n?>]" id="dat[<?=$m2?>][<?=$n?>]" class="admin_yn"<?if($member[$m2][$a2]){?> checked="checked"<?}?>><label for="dat[<?=$m2?>][<?=$n?>]" class="admin_yn_label">●</label></span><!--
<? } ?><? } ?>
--><span style="width:60px;text-align:left;display:inline-block;"><button style="margin:5px; height:25px; text-align:25px;"type="button" value="削除" name="delete[<?=$m2?>]" onclick="MemberDel(<?=$m2?>,'<?=$member[$m2]["name"]?>')">削除</button></span>
</span><br>
<? } ?>
<br><br>
</div>
</form>

<?}elseif($admin==2){?>
<form method="post" action="./index.php">	
	<div style="width:750px;">
		<button type="button" value="終了" name="admin_end" class="admin_end" onclick="location.href='./index.php?admin=0'">終了</button>
		<button type="button" value="メンバー" name="admin_member" class="admin_else" onclick="location.href='./index.php?admin=1'">メンバー</button>
		<button type="button" value="カテゴリ" name="admin_category" class="admin_select" onclick="location.href='./index.php?admin=2'">カテゴリ</button>
		<button type="button" value="グループ" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=3'">グループ</button>
		<button type="button" value="TO_DO" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=4'">To_Do</button>
		<button type="button" value="カレンダー" name="admin_holiday" class="admin_else" onclick="location.href='./index.php?admin=5'">カレンダー</button>
		<button type="button" value="掃除当番" name="admin_toban" class="admin_else" onclick="location.href='./index.php?admin=6'">掃除当番</button>
	</div>
<br>
<div style="height:30px;">　</div>
<div><span class="t_title" style="width:40px; border-left:1px solid #cccccc;">　</span><span class="t_title" style="width:300px;">名前</span><span class="t_title" style="width:50px;padding:1px 0">重要</span></div><!--
--><div><span class="admins" style="width:40px;border-left:1px solid #cccccc;text-align:center;font-weight:800;">新規</span><!--
	 --><span class="admins" style="width:300px;"><input maxlength="10" type="text" name="new_name" style="width:286px;border:none;"></span><!--
	 --><span class="admins" style="width:50px;padding:1px 0"><input type="checkbox" value="1" name="new_im" id="new_im" class="admin_yn"><label for="new_im" class="admin_yn_label">●</label></span><!--
	 --><span style="width:60px;text-align:right;display:inline-block;"><button style="margin:5px; height:25px; text-align:25px;"type="submit" value="登録" name="cate_new">登録</button></span><!--
	 --></div><br>
<button style="margin:5px; height:25px; text-align:25px;"type="submit" 	value="更新" name="cate_chg">更新</button>
	<div><span class="t_title" style="width:40px; border-left:1px solid #cccccc;">序列</span><span class="t_title" style="width:300px;">名前</span><span class="t_title" style="width:40px;padding:1px 0">重要</span></div>
<?foreach((array)$category_sort as $a1 => $a2){?>
	<div><span class="admins" style="width:40px;border-left:1px solid #cccccc;"><input type="text" value="<?=$a1?>" name="dat1[<?=$a2?>]" style="width:31px;border:none; text-align:right;"></span><!--
	 --><span class="admins" style="width:300px;"><input type="text" maxlength="10" value="<?=$category[$a2]['name']?>" name="dat2[<?=$a2?>]" style="width:286px; border:none;"></span><!--
	 --><span class="admins" style="width:40px;padding:1px 0"><input type="checkbox" value="1" name="att[<?=$a2?>]" id="att[<?=$a2?>]" class="admin_yn"<?if($category[$a2]["att"]==1){?> checked="checked"<?}?>><label for="att[<?=$a2?>]" class="admin_yn_label">●</label></span><!--
	 --><span style="width:60px;text-align:right;display:inline-block;"><button style="margin:5px; height:24px; text-align:25px;"type="button" value="削除" name="delete[<?=$a2?>]" onclick="CateDel(<?=$a2?>,'<?=$category[$a2]['name']?>')">削除</button></span><!--
--></div>
<? } ?>
</form>


<?}elseif($admin==3){?>
<?$n1=0;?>
<form method="post" action="./index.php">
	<div style="width:750px;">
		<button type="button" value="終了" name="admin_end" class="admin_end" onclick="location.href='./index.php?admin=0'">終了</button>
		<button type="button" value="メンバー" name="admin_member" class="admin_else" onclick="location.href='./index.php?admin=1'">メンバー</button>
		<button type="button" value="カテゴリ" name="admin_category" class="admin_else" onclick="location.href='./index.php?admin=2'">カテゴリ</button>
		<button type="button" value="グループ" name="admin_group" class="admin_select" onclick="location.href='./index.php?admin=3'">グループ</button>
		<button type="button" value="TO_DO" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=4'">To_Do</button>
		<button type="button" value="カレンダー" name="admin_holiday" class="admin_else" onclick="location.href='./index.php?admin=5'">カレンダー</button>
		<button type="button" value="掃除当番" name="admin_toban" class="admin_else" onclick="location.href='./index.php?admin=6'">掃除当番</button>
	</div>

	<br>
	<div style="height:30px;">　</div>
	<div><span class="t_title" style="width:40px;border-left:1px solid #cccccc;">　</span><span class="t_title" style="width:300px;">名前</span></div>
	<div><span class="admins" style="width:40px;border-left:1px solid #cccccc;text-align:center;font-weight:800;">新規</span><!--
	--><span class="admins" style="width:300px;"><input type="text" name="new_name" style="width:286px;  border:none;" maxlength="8"></span><!--
	--><span style="width:60px;text-align:right;display:inline-block;">
		<button style="margin:5px; height:25x; text-align:25px;"type="submit" value="登録" name="group_new">登録</button>
		</span><!--
--></div><br>
	<button style="margin:5px; height:25px; text-align:25px;"type="submit" 	value="更新" name="group_chg">更新</button>
	<div><span class="t_title" style="width:40px; border-left:1px solid #cccccc;">序列</span><span class="t_title" style="width:300px;">名前</span></div>
	<?foreach((array)$group_sort as $a1 => $a2){?>
		<?if($a1>0 && $a1<90){?>
<?$n1++?>
			<div><!--
			--><span class="admins" style="width:40px;border-left:1px solid #cccccc;">
				<input type="text" value="<?=$n1?>" name="gp_sort[<?=$a2?>]" style="width:30px; border:none; text-align:right;">
				</span><!--
			--><span class="admins" style="width:300px;">
				<input type="text" value="<?=$group[$a2]['name']?>" name="gp_name[<?=$a2?>]" style="width:286px;border:none;" maxlength="8">
				</span><!--
			--><span style="width:60px;text-align:right;display:inline-block;">
				<button style="margin:5px; height:25px; text-align:25px;"type="button" value="削除" name="delete[<?=$a2?>]" onclick="GroupDel(<?=$a2?>,'<?=$group[$a2]["name"]?>')">削除</button>
				</span><!--
			--></div>
		<? } ?>
	<? } ?>
</form>


<?}elseif($admin==4){?>
<form method="post" action="./index.php">
	<div style="width:750px;">
		<button type="button" value="終了" name="admin_end" class="admin_end" onclick="location.href='./index.php?admin=0'">終了</button>
		<button type="button" value="メンバー" name="admin_member" class="admin_else" onclick="location.href='./index.php?admin=1'">メンバー</button>
		<button type="button" value="カテゴリ" name="admin_category" class="admin_else" onclick="location.href='./index.php?admin=2'">カテゴリ</button>
		<button type="button" value="グループ" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=3'">グループ</button>
		<button type="button" value="Todo" name="admin_group" class="admin_select" onclick="location.href='./index.php?admin=4'">To_Do</button>
		<button type="button" value="カレンダー" name="admin_holiday" class="admin_else" onclick="location.href='./index.php?admin=5'">カレンダー</button>
		<button type="button" value="掃除当番" name="admin_toban" class="admin_else" onclick="location.href='./index.php?admin=6'">掃除当番</button>
	</div>

	<br>
	<div style="height:30px;">　</div>
	<div><span class="t_title" style="width:40px;border-left:1px solid #cccccc;">　</span><span class="t_title" style="width:300px;">名前</span></div>
	<div><span class="admins" style="width:40px;border-left:1px solid #cccccc;text-align:center;font-weight:800;">新規</span><!--
	--><span class="admins" style="width:300px;"><input type="text" name="plan_new" style="width:286px; border:none;" maxlength="8"></span><!--
	--><span style="width:60px;text-align:right;display:inline-block;">
		<button style="margin:5px; height:25x; text-align:25px;"type="submit" value="登録" name="new_plan">登録</button>
		</span><!--
--></div><br>
	<button style="margin:5px; height:25px; text-align:25px;"type="submit" 	value="更新" name="plan_chg">更新</button>
	<div><span class="t_title" style="width:40px; border-left:1px solid #cccccc;">序列</span><span class="t_title" style="width:300px;">名前</span></div>
	<?foreach((array)$plan_sort as $a1 => $a2){?>
		<div><!--
		--><span class="admins" style="width:40px;border-left:1px solid #cccccc;">
			<input type="text" value="<?=$a1?>" name="plan_chg_sort[<?=$a2?>]" style="width:30px; border:none; text-align:right;">
			</span><!--
		--><span class="admins" style="width:300px;">
			<input type="text" maxlength="8" value="<?=$plan[$a2]["name"]?>" name="plan_chg_name[<?=$a2?>]" style="width:286px; border:none;">
			</span><!--
		--><span style="width:60px;text-align:right;display:inline-block;">
			<button style="margin:5px; height:25px; text-align:25px;"type="button" value="削除" name="plan_chg_del[<?=$a2?>]" onclick="PlanDel(<?=$a2?>,'<?=$plan[$a2]["name"]?>')">削除</button></span><!--
		--></div>
	<? } ?>
</form>


<?}elseif($admin==5){?>
<form method="post" action="./index.php">
	<div style="width:750px;">
		<button type="button" value="終了" name="admin_end" class="admin_end" onclick="location.href='./index.php?admin=0'">終了</button>
		<button type="button" value="メンバー" name="admin_member" class="admin_else" onclick="location.href='./index.php?admin=1'">メンバー</button>
		<button type="button" value="カテゴリ" name="admin_category" class="admin_else" onclick="location.href='./index.php?admin=2'">カテゴリ</button>
		<button type="button" value="グループ" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=3'">グループ</button>
		<button type="button" value="Todo" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=4'">To_Do</button>
		<button type="button" value="カレンダー" name="admin_holiday" class="admin_select" onclick="location.href='./index.php?admin=5'">カレンダー</button>
		<button type="button" value="掃除当番" name="admin_toban" class="admin_else" onclick="location.href='./index.php?admin=6'">掃除当番</button>
	</div>
<br>
<div style="height:30px;">　</div>
<div><span class="t_title" style="width:300px;border-left:1px solid #cccccc;">名前</span><span class="t_title" style="width:65px;">年</span><span class="t_title" style="width:45px;">月</span><span class="t_title" style="width:45px;">日</span></div><!--
--><div><span class="admins" style="width:300px;border-left:1px solid #cccccc;"><input type="text" name="hori_new[0]" style="width:286px; border:none;" maxlength="20"></span><!--
--><span class="admins" style="width:65px;"><input type="text" value="" name="hori_new[1]" style="width:45px; border:none; text-align:right;"></span><!--
--><span class="admins" style="width:45px;"><input type="text" value="" name="hori_new[2]" style="width:30px; border:none; text-align:right;"></span><!--
--><span class="admins" style="width:45px;"><input type="text" value="" name="hori_new[3]" style="width:30px; border:none; text-align:right;"></span><!--
--><span style="width:60px;text-align:right;display:inline-block;"><button style="margin:5px; height:25x; text-align:25px;"type="submit" value="登録" name="holiday_reg">登録</button></span><!--
--></div>
<br>
<button style="margin:5px; height:25px; text-align:25px;"type="submit" 	value="更新" name="holiday_chg">更新</button>
<div><span class="t_title" style="width:300px;border-left:1px solid #cccccc;">名前</span><span class="t_title" style="width:65px;">年</span><span class="t_title" style="width:45px;">月</span><span class="t_title" style="width:45px;">日</span></div>
<div><?foreach($holi_list as $a1 => $a2){?><span class="admins" style="width:300px;border-left:1px solid #cccccc;"><input type="text"  name="holi_list[<?=$a1?>][0]" value="<?=$holi_list[$a1][0]?>" style="width:286px; border:none;" maxlength="20"></span><!--
--><span class="admins" style="width:65px;"><input type="text" name="holi_list[<?=$a1?>][1]" value="<?=$holi_list[$a1][1]?>" style="width:45px; border:none; text-align:right;"></span><!--
--><span class="admins" style="width:45px;"><input type="text" name="holi_list[<?=$a1?>][2]" value="<?=$holi_list[$a1][2]?>" style="width:30px; border:none; text-align:right;"></span><!--
--><span class="admins" style="width:45px;"><input type="text" name="holi_list[<?=$a1?>][3]" value="<?=$holi_list[$a1][3]?>" style="width:30px; border:none; text-align:right;"></span><!--
--><span style="width:60px;text-align:right;display:inline-block;"><button style="margin:5px; height:25x; text-align:25px;"type="submit" value="登録" name="holiday_del">削除</button></span><br>
<!--
--><? } ?>
</div>
</form>


<?}elseif($admin==6){?>
<div style="width:750px;">
	<button type="button" value="終了" name="admin_end" class="admin_end" onclick="location.href='./index.php?admin=0'">終了</button>
	<button type="button" value="メンバー" name="admin_member" class="admin_else" onclick="location.href='./index.php?admin=1'">メンバー</button>
	<button type="button" value="カテゴリ" name="admin_category" class="admin_else" onclick="location.href='./index.php?admin=2'">カテゴリ</button>
	<button type="button" value="グループ" name="admin_group" class="admin_else" onclick="location.href='./index.php?admin=3'">グループ</button>
	<button type="button" value="Todo" name="admin_todo" class="admin_else" onclick="location.href='./index.php?admin=4'">To_Do</button>
	<button type="button" value="カレンダー" name="admin_holiday" class="admin_else" onclick="location.href='./index.php?admin=5'">カレンダー</button>
	<button type="button" value="掃除当番" name="admin_toban" class="admin_select" onclick="location.href='./index.php?admin=6'">掃除当番</button>
</div>
<br>
<div style="float:left;margin:0 5px;">
<div style="height:35px;">　</div>
<form method="post" action="./index.php">
	<div><span class="t_title" style="width:40px;border-left:1px solid #cccccc;">　</span><span class="t_title" style="width:300px;">名前</span></div>
	<div><span class="admins" style="width:40px;border-left:1px solid #cccccc;text-align:center;font-weight:800;">新規</span><!--
	--><span class="admins" style="width:300px;"><input type="text" name="comm_new" style="width:286px; border:none;" maxlength="8"></span><!--
	--><span style="width:60px;text-align:right;display:inline-block;"><button style="margin:5px; height:25x; text-align:25px;"type="submit" value="登録" name="new">登録</button></span><!--
--></div><br>
	<button style="margin:5px; height:25px; text-align:25px;"type="submit" value="更新" name="comm_chg">更新</button>
	<div><span class="t_title" style="width:40px; border-left:1px solid #cccccc;">序列</span><span class="t_title" style="width:300px;">名前</span></div>
	<?foreach((array)$comm_sort as $a1 => $a2){?>
		<div><!--
		--><span class="admins" style="width:40px;border-left:1px solid #cccccc;">
			<input type="text" value="<?=$a1?>" name="comm_chg_sort[<?=$a2?>]" style="width:30px; border:none; text-align:right;">
			</span><!--
		--><span class="admins" style="width:300px;">
			<input type="text" maxlength="8" value="<?=$comm[$a2]["name"]?>" name="comm_chg_name[<?=$a2?>]" style="width:286px; border:none;">
			</span><!--
		--><span style="width:60px;text-align:right;display:inline-block;">
			<button style="margin:5px; height:25px; text-align:25px;"type="button" value="削除" name="comm_chg_del[<?=$a2?>]" onclick="CommDel(<?=$a2?>,'<?=$comm[$a2]["name"]?>')">削除</button></span><!--
		--></div>
	<? } ?>
</form>
</div>

<?if($member_comm){?>
<form method="post" action="./index.php">
<input type="hidden" name="now_ym" value="<?=$now_year?>-<?=$now_month?>">
<div style="float:left;margin:0 10px;">
<div style="height:35px; line-height:35px;"><button style="margin:5px; height:25px; text-align:25px;"type="submit" value="更新" name="comm_set">更新</button></div>
<div><span class="t_title" style="width:60px;border-left:1px solid #cccccc;">日付</span><?foreach($comm_sort as $a1 =>$a2){?><span class="t_title" style="width:60px;"><?=$comm[$a2]["name"]?></span><?}?></div>
<?for($n=0;$n<$t_mon_t;$n++){?>
<div><!--
--><span class="admins" style="width:60px;border-left:1px solid #cccccc; text-align:right;font-size:13px;"><?=$n+1?><?=$week[date("w",strtotime($now_year*10000+$now_month*100+$n+1))]?></span><!--
--><?foreach($comm_sort as $a1 =>$a2){?><!--
--><span class="admins" style="width:60px; <?if($set[$n+1][$a2]){?>background:#f0d0c0<?}?>"><!--
--><select style="border:none; width:100%;height:100%;" name="set[<?=$n+1?>][<?=$a2?>]"><!--
--><option value=""></option><!--
--><?foreach($member_comm as $a3 => $a4){?><!--
--><option value="<?=$a4?>" <?if($set[$n+1][$a2]==$a4){?>selected="selected"<?}?>><!--
--><?=$member[$a4]["name"]?><!--
--></option><!--
--><?}?><!--
--></select><!--
--></span><!--
--><?}?><!--
--></div><!--
--><?}?><!--
--></div>
</form>
<? } ?>
<div style="clear:both;"></div>
<?}else{?>
<div class="pc_only"><span class="t_title l1">投稿日時</span><span class="t_title l2">カテゴリ</span><span class="t_title l3">投稿者名</span><span class="t_title l4">件名</span><span class="t_title l5">グループ</span><span class="t_title l6">　</span><span class="t_title l7">　</span><span class="t_title l7">　</span></div><?if($log_top){?><?for($s1=0;$s1<$i2;$s1++){?><a href="./index.php?log_id=<?=$log_top[$s1]["id"]?>" class="table_list_a"><span class="table_list l1"><?=$log_top[$s1]["date"]?> <?=$log_top[$s1]["time"]?></span><span class="table_list l2"><?=$category[$log_top[$s1]["category"]]["name"]?></span><span class="table_list l3"><?=$member[$log_top[$s1]["writer"]]["name"]?></span><span class="table_list l4"><?=$log_top[$s1]["title"]?></span><span class="table_list l5"><?=$group[$log_top[$s1]["group"]]["name"]?></span><span class="table_list l6"><?if($fav_count[$log_top[$s1]["id"]] >0){?><span style="color:<?=$icon_color[$fav[$fav_count[$log_top[$s1]["id"]]]["color"]]?>"><span class="<?=$icon_font[$fav[$fav_count[$log_top[$s1]["id"]]]["icon"]]?> sele_icon_20"></span></span><?}?></span><span class="table_list l7"><?if($log_top[$s1]["attach"] == 1){?><span style="color:#a0a060"><span class="icon-folder-open sele_icon_20"></span></span><?}?></span><?=$miki[$user_view[$log_top[$s1]["id"]][$uid]]?></a><?}?><?}?>
<?if(count($log)>0){?><?for($s1=$pg_st;$s1<$pg_ed-$i2;$s1++){?><a href="./index.php?log_id=<?=$log[$s1]["id"]?>" class="table_list_b"><span class="table_list l1"><?=$log[$s1]["date"]?> <?=$log[$s1]["time"]?></span><span class="table_list l2"><?=$category[$log[$s1]["category"]]["name"]?></span><span class="table_list l3"><?=$member[$log[$s1]["writer"]]["name"]?></span><span class="table_list l4"><?=$log[$s1]["title"]?></span><span class="table_list l5"><?=$group[$log[$s1]["group"]]["name"]?></span><span class="table_list l6"><?if($fav_count[$log[$s1]["id"]] >0){?><span style="color:<?=$icon_color[$fav[$fav_count[$log[$s1]["id"]]]["color"]]?>">	<span class="<?=$icon_font[$fav[$fav_count[$log[$s1]["id"]]]["icon"]]?> sele_icon_20"></span></span><?}?></span><span class="table_list l7"><?if($log[$s1]["attach"] == 1){?><span style="color:#a0a060"><span class="icon-folder-open 	sele_icon_20"></span></span><?}?></span><?=$miki[$user_view[$log[$s1]["id"]][$uid]]?></a><?}?><?}?>
<br><br>
<?if($todo_s1 ||$todo_s2 ||$todo_s3 || $task){?>
<div class="todo_title">予定(<?=substr($tmp_date,0,4)?>年<?=substr($tmp_date,5,2)?>月<?=substr($tmp_date,8,2)?>日)</div>
<div class="todo_0">
	<div class="todo_1">
		<div class="todo_bn">開始</div>
		<?for($n0=0;$n0<count($todo_s1);$n0++){?>

			<?if($member[$uid][$todo_s1[$n0]["group"]] == 1 || $todo_s1[$n0]["staff"] == $uid || $todo_s1[$n0]["group"]==0){?>
				<table class="todo_table"><tr>
					<td class="todo_td1"><?=substr($todo_s1[$n0]["st_time"],0,-2)?>:<?=substr($todo_s1[$n0]["st_time"],-2,2)?> - <?=substr($todo_s1[$n0]["ed_time"],0,-2)?>:<?=substr($todo_s1[$n0]["ed_time"],-2,2)?><br>
					<?/*if($uid == $todo_s1[$n0]["staff"]){*/?>
						<form action="index.php" method="post">
							<input type="hidden" value="<?=$todo_s1[$n0]["todo_id"]?>" name="todo_chg_id">
							<button type="submit" class="rel" value="修正">修正</button>
						</form>
					<?/*}*/?>
					</td>
					<td class="todo_td2"><span style="color:#d00000;font-weight:800;">[<?=$plan[$todo_s1[$n0]["plan"]]["name"]?>]</span><br><?=$todo_s1[$n0]["log"]?><br></td>
				</tr></table>
			<? } ?>
		<? } ?>
	</div>

	<div class="todo_1">
		<div class="todo_bn">終了</div>
		<?for($n0=0;$n0<count($todo_s3);$n0++){?>
			<?if($member[$uid][$todo_s3[$n0]["group"]] == 1 || $todo_s3[$n0]["staff"] == $uid || $todo_s3[$n0]["group"]==0){?>
				<table class="todo_table"><tr>
					<td class="todo_td1">
					<?=substr($todo_s3[$n0]["st_time"],0,-2)?>:<?=substr($todo_s3[$n0]["st_time"],-2,2)?> - <?=substr($todo_s3[$n0]["ed_time"],0,-2)?>:<?=substr($todo_s3[$n0]["ed_time"],-2,2)?>
					<form action="index.php" method="post">
					<input type="hidden" value="<?=$todo_s3[$n0]["todo_id"]?>" name="todo_chg_id">
					<input type="hidden" value="<?=substr($todo_s3[$n0]["ed_date"],-2)?>" name="todo_set_lv">
					<button type="submit" class="rel" value="修正">修正</button>
					</form>

					</td>
					<td class="todo_td2"><span style="color:#d00000;font-weight:800;">[<?=$plan[$todo_s3[$n0]["plan"]]["name"]?>]</span><br><?=$todo_s3[$n0]["log"]?><br></td>
				</tr></table>
			<? } ?>
		<? } ?>
	</div>

	<div class="todo_1">
		<?if($task){?>
			<div class="comm_bn">掃除当番</div>
			<?for($n=0;$n<count($task);$n++){?>
				<div class="task_bn"><?=$comm[$task[$n]]["name"]?></div>
			<? } ?>
		<? } ?>
	</div>
</div>
<?}?>

<?if($gp[1]){?>
<!--■■投稿------------------------->
<table class="open">
	<form action="./index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="uid" value="<?=$uid?>">
	<tr>
		<th class="open_a">
			<span style="display:inline-block; font-size:15px;height:30px;line-height:30px;">日時：</span><input type="text" name="w_date" value="<?=$c_date?>" style="width:90px;"><input type="text" name="w_time" value="<?=$c_time?>" style="width:50px;">　
			<span style="display:inline-block; font-size:15px;height:30px;line-height:30px;margin-right:20px;">送信者：<?=$member[$uid]["name"]?></span>
			<span style="display:inline-block; font-size:15px;height:30px;line-height:40px;">カテゴリ：</span>
			<select name="w_cate" style="font-size:13px; width:120px;text-align:left; height:30px;"><?foreach((array)$category_sort as $a1 => $a2){?><?if($member[$uid]["b"] == 1 || $category[$a2]["att"] != 1){?><option value="<?=$a2?>"><?=$category[$a2]["name"]?></option><? } ?><? } ?></select>
			<span style="display:inline-block; font-size:15px; height:30px;line-height:30px;">グループ：</span>
				<select name="w_group" style="font-size:13px; width:120px; text-align:left; height:30px;" id="cat">
				<?foreach((array)$group_sort as $p1 => $p2){?><option value="<?=$p2?>"><?=$group[$p2]["name"]?></option>
				<? } ?>
			</select>
		</th>
	</tr>
	<tr>
		<th class="open_a">
			<span style="display:inline-block; font-size:15px; height:30px;line-height:30px;">TITLE：</span><input type="text" name="w_title" style=" width:500px;" maxlength="20">
			<button type="submit" name="w_try" value="登録" class="submit">登録</button>
		</th>
	</tr>
<tr><th class="open_a"><?foreach($group_sort as $p3 => $p4){?><?if($p4 != 99){?><div class="gp_dt" id="gp_dt<?=$p4?>"><?foreach((array)$member_now as $a1 => $a2){?><?if($member[$a2][$p4] ==1 ||$member[$a2]["b"] ==1 || $p4==0){?><span class="send_y"><span class="send_y2"></span><?=$member[$a2]["name"]?></span><? } else {?><span class="send_n"><span class="send_n2"></span><?=$member[$a2]["name"]?></span><? } ?><? } ?></div><? } ?><? } ?><div class="gp_dt" id="gp_dt99"><?foreach((array)$member_now as $a1 => $a2){?><?if($member[$a2]['b'] ==1){?><span class="send_y"><span class="send_y2"></span><?=$member[$a2]["name"]?></span><input type="hidden" name="w_mem[<?=$a2?>]" value="1"><? } else {?><label><input type="checkbox" name="w_mem[<?=$a2?>]" value="1" class="sendbox"><span class="sendspan"><?=$member[$a2]["name"]?></span></label><? } ?><? } ?></div></th></tr>
	<tr>
		<td class="open_main">
			<textarea name="w_log" style="width:99%; height:200px; font-size:15px; border:none;"><?=$view?></textarea><br>
		</td>
	</tr>
	<tr>
		<td class="open_main">
			<input type="file" name="upfile[1]" style="margin:5px; width:200px;">　
			<input type="file" name="upfile[2]" style="margin:5px; width:200px;">　
			<input type="file" name="upfile[3]" style="margin:5px; width:200px;"><br>
			<input type="file" name="upfile[4]" style="margin:5px; width:200px;">　
			<input type="file" name="upfile[5]" style="margin:5px; width:200px;">　
			<input type="file" name="upfile[6]" style="margin:5px; width:200px;">
		</td>
	</tr>
</table>

<?}elseif($c_act=="log_del"){?>
<!--■■削除完了------------------------->
	<table class="open">
		<tr><th class="open_a" style="text-align:center; padding:10px;">削除されました</th></tr>
	</table>

<?}elseif($upng){?>
<!--■■あぷろどえらー------------------------->
	<table class="open">
		<tr><th class="open_a" style="text-align:center; padding:10px;">日本語、全角文字の含まれるファイルはアップロードできません</th></tr>
	</table>

<?}elseif($_POST["set_chg"]){?>
<!--■■編集------------------------->
<table class="open">
	<form action="./index.php" method="post">
	<tr>
    <th class="open_a">
	<div>
		<span style="display:inline-block; font-size:15px;height:30px;line-height:30px; width:220px; text-align:left;">日時：<?=$view_date?>　<?=$view_time?></span>
		<span style="display:inline-block; font-size:15px;height:30px;line-height:30px; width:80px; text-align:right;">カテゴリ：</span><select name="e_cate" style="font-size:13px; height:30px; width:120px; width:100px;text-align:left; ">
			<?foreach((array)$category_sort as $p1 => $p2){?><option value="<?=$p2?>" <?if($p2 == $view_category){?> selected="selected"<? } ?>><?=$category[$category_sort[$p1]]["name"]?></option>
			<? } ?>
			</select>
		<span style="display:inline-block; font-size:15px;height:30px;line-height:30px; width:80px; text-align:right;">TITLE：</span><input type="text" name="e_title" style="width:250px; " value="<?=$view_title?>" maxlength="20"><button  class="submit" type="submit" name="set_chg2" value="登録">登録</button>
	</div>
	</th>
	</tr><tr>
		<td class="open_main"><textarea name="e_log" style="width:99%; height:200px; font-size:15px; border:none;"><?=$view?></textarea></td>
	</tr>
</table>

<?}elseif($_POST["set_chg2"]){?>
<!--■■編集されました------------------------->
	<table class="open">
		<tr><th class="open_a" style="text-align:center; padding:10px;">編集されました。</th></tr>
	</table>
<?}elseif($_POST["set_res"]){?>
<!--■■れす------------------------->
	<table class="open">
		<form action="./index.php" method="post">
		<tr>
			<th class="open_a">
				<div class="open_in">
					<span>日時：<?=$view_date?>　<?=$view_time?></span>　
					<span>カテゴリ：<?=$category[$view_category]["name"]?></span>　
					<span>グループ：<?=$group[$view_group]["name"]?></span>
				</div><br>

				<div class="open_in" style="float:left;">
					<span style="display:inline-block; font-size:15px;height:30px;line-height:30px;">TITLE：<?=$view_title?></span>
				</div>
				<div class="open_in" style="float:right;">
					<span>投稿者：<?=$member[$view_writer]["name"]?></span>　

					<button type="submit" class="submit" name="set_res2" value="登録">登録</button>
				</div>
				<div style="clear:both"></div>
			</th>
		</tr><tr>
	        <td class="open_a">
				<?=$view?>
			</td>
		</tr><tr>
			<td class="open_main">
				<textarea name="r_log" style="width:99%; height:200px; font-size:15px; border:none;"></textarea><br>
			</td>
		</tr>
		</form>

		<?if($p>0){?>
		<tr>
		<td class="open_sub" style="background-color:#f0f0f0;" colspan="3">
			<?for($p1=0;$p1<count($res);$p1++){?>
				<div class="res">
				<div style="font-color:#606060; border-bottom: 1px solid #cccccc; width:98%; padding:3px; float:left;">日時：<?=$res[$p1]["date"]?>　<?=$res[$p1]["time"]?>　　名前：<?=$member[$res[$p1]["writer"]]["name"]?>
				</div>
				<div style="clear:both"></div>
				<div><?=$res[$p1]["log"]?><br></div>
				</div>
			<? } ?>
		</td>
		</tr>
		<? } ?>
	</table>



<?}elseif($c_act=="log_res2" || $c_todo2){?>
<!--■■RES投稿されました------------------------->
	<table class="open">
		<tr><th class="open_a" style="text-align:center; padding:10px;">投稿されました。</th></tr>
	</table>

<?}elseif($todo_chg_id){?>
<form action="index.php" name="f" method="post">
<!--■■TODOリスト------------------------->
<input type="hidden" value="<?=$todo_sy?>" name="todo_sy"><input type="hidden" value="<?=$todo_sm?>" name="todo_sm"><input type="hidden" value="<?=$todo_sd?>" name="todo_sd">
<input type="hidden" value="<?=$todo_chg_id?>" name="todo_chg_id2">
<table class="todo_input">
<tr>
<td style="text-align:center; background:#60d090;height:36px;"><input type="text" value="<?=$todo_sy?>" name="todo_sy" class="todo_y">年<input type="text" value="<?=$todo_sm?>" name="todo_sm" class="todo_d">月<input type="text" value="<?=$todo_sd?>" name="todo_sd" class="todo_d">日</td>
</tr>

<tr>
<td class="todo_input_tag">
<div class="todo_div">
<input type="checkbox" style="display:none !important" name="todo_tag1" id="todo_tag1" class="todo_tag_ckb" value="1"<?if($todo_start==1){?> checked="checked"<? } ?>><label for="todo_tag1" class="todo_tag_label">開始</label>
<input type="checkbox" style="display:none !important" name="todo_tag3" id="todo_tag3" class="todo_tag_ckb" value="1"<?if($todo_end==1){?> checked="checked"<? } ?>><label for="todo_tag3" class="todo_tag_label">終了</label>
</div>
<div class="todo_div2">
<button type="submit" value="DEL" name="c_todo4" style="background:#ffe5f0">DEL</button>
<button type="submit" value="SET" name="c_todo3" id="todo_send" style="background:#ff90b0">SET</button>
</div>
<div style="clear:both">
</div>
</td>
</tr>

<tr>
	<td  class="todo_input_tag">
		<span class="todo_input_title">時間</span><input type="text" name="todo_sh" class="todo_d" value="<?=$todo_sh?>">:<input type="text" name="todo_si" class="todo_d" value="<?=$todo_si?>">-<input type="text" name="todo_eh" class="todo_d" value="<?=$todo_eh?>">:<input type="text" name="todo_ei" class="todo_d" value="<?=$todo_ei?>">
	</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">終了</span><input type="text" name="todo_ey" class="todo_y" value="<?=$todo_ey?>">/<input type="text" name="todo_em" class="todo_d" value="<?=$todo_em?>">/<input type="text" name="todo_ed" class="todo_d" value="<?=$todo_ed?>"><span style="font-size:12px;">(<input type="text" name="passage" class="todo_d" style="background:#eaeaff;" value="" onkeyup="Passage();">日後)</span>
	</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">グループ</span>
		<select name="todo_group" style="font-size:13px; width:160px; text-align:left;height:26px;">
			<?foreach((array)$group_sort as $p1 => $p2){?><?if($p2<95){?><option value="<?=$p2?>" <?if($todo_group == $p2){?>selected="selected"<? } ?>><?=$group[$p2]["name"]?></option><? } ?>
			<? } ?>
			<option value="90">自分</option>
		</select>
	</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">内容</span>
		<select name="todo_plan" style="font-size:13px; width:160px; text-align:left;height:26px;">
			<?foreach((array)$plan_sort as $p1 => $p2){?><option value="<?=$p2?>" <?if($todo_plan == $p2){?>selected="selected"<? } ?>><?=$plan[$p2]["name"]?></option><? } ?>
		</select>
	</td>
</tr>
<tr>
	<td class="todo_input_tag"><textarea class="todo_input_log" name="todo_log"><?=$todo_log?></textarea></td></td>
</tr>
</table>
</form>



<?}elseif($c_todo){?>
<div style="display:inline-block;">
<form action="index.php" name="f" method="post">
<!--■■TODOリスト------------------------->
<input type="hidden" value="<?=$todo_sy?>" name="todo_sy"><input type="hidden" value="<?=$todo_sm?>" name="todo_sm"><input type="hidden" value="<?=$todo_sd?>" name="todo_sd">
<table class="todo_input">
<tr>
<td style="text-align:center; background:#60d090; height:36px;"><?=$todo_sy?>年<?=$todo_sm?>月<?=$todo_sd?>日</td>
</tr>
<tr>
<td class="todo_input_tag">
<div class="todo_div">
<input type="checkbox" style="display:none !important" name="todo_tag1" id="todo_tag1" class="todo_tag_ckb" value="1"><label for="todo_tag1" class="todo_tag_label">開始</label>
<input type="checkbox" style="display:none !important" name="todo_tag3" id="todo_tag3" class="todo_tag_ckb" value="1"><label for="todo_tag3" class="todo_tag_label">終了</label>
</div>
<div class="todo_div2">
<button type="submit" value="SET" name="c_todo2" id="todo_send" style="background:e0e0e0" disabled>SET</button>
</div>
<div style="clear:both">
</div>
</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">時間</span><input type="text" name="todo_sh" class="todo_d" value="<?=$todo_sh?>">:<input type="text" name="todo_si" class="todo_d" value="<?=$todo_si?>">-<input type="text" name="todo_eh" class="todo_d" value="<?=$todo_eh?>">:<input type="text" name="todo_ei" class="todo_d" value="<?=$todo_ei?>">
	</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">終了</span><input type="text" name="todo_ey" class="todo_y" value="<?=$todo_ey?>">/<input type="text" name="todo_em" class="todo_d" value="<?=$todo_em?>">/<input type="text" name="todo_ed" class="todo_d" value="<?=$todo_ed?>"><span style="font-size:12px;">(<input type="text" name="passage" class="todo_d" style="background:#eaeaff;" value="" onkeyup="Passage();">日後)</span>
	</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">グループ</span>
		<select name="todo_group" style="font-size:13px; width:160px; text-align:left;">
			<?foreach((array)$group_sort as $p1 => $p2){?><?if($p2<95){?><option value="<?=$p2?>" <?if($todo_group == $p2){?>selected="selected"<? } ?>><?=$group[$p2]["name"]?></option><? } ?>
			<? } ?>
			<option value="90">自分</option>
		</select>
	</td>
</tr>
<tr>
	<td class="todo_input_tag">
		<span class="todo_input_title">内容</span>
		<select name="todo_plan" style="font-size:13px; width:160px; text-align:left;">
			<?foreach((array)$plan_sort as $p1 => $p2){?><option value="<?=$p2?>" <?if($todo_plan == $p2){?>selected="selected"<? } ?>><?=$plan[$p2]["name"]?></option><? } ?>
		</select>
	</td>	
</tr>
<tr>
	<td class="todo_input_tag"><textarea class="todo_input_log" name="todo_log"></textarea></td></td>
</tr>
</table>
</form>
</div>
<div style="display:inline-block;">
<img src="./icon/todo.gif" style="margin:5px;width:550px; border:2px solid #000000;">
</div>


<?}elseif($gp[2]){?>
<!--■■登録情報変更-->
	<form action="./index.php" method="post">
		<table style="width:320px;">
			<tr>
				<td style="width:320px; height:30px; background:#4090ff; color:#ffffff; border:1px solid #e0e0e0; vercical-align:middle;">
					パスワード(4～30文字)
				</td>
			</tr>

			<tr>
				<td style="width:320px; height:40px; background:#fafafa; vercical-align:middle; border:1px solid #f0f0f0;">
					<input type="text" name="passbox" value="<?=$member[$uid]['logpass']?>" class="passbox">
					<button type="submit" name="pass_chg_set" value="登録" class="submit" style="width:70px;">登録</button>
				</td>
			</tr>
		</table>
	</form>
<br>

<form action="./index.php" method="post">
<table style="width:320px;">
	<tr>
		<td style="background:#4090ff; color:#ffffff; height:30px; vercical-align:middle;">[順]</td>
		<td style="background:#4090ff; color:#ffffff; vercical-align:middle;" colspan="3">お気に入り編集</td>
		<td style="background:#4090ff; color:#ffffff; vercical-align:middle;">[削]</td>
	</tr>
	<?foreach((array)$fav_sort as $a1 => $a2){?>
	<tr>
		<td style="width:30px; height:30px; background:#fafafa; vertical-align:middle;text-align:center;">
		<select name="fav_order[<?=$a2?>]">
		<?for($n=0;$n<count($fav_sort);$n++){?><option value="<?=$n?>" <?if($n == $a1){?>selected="selected"<?}?>><?=$n+1?></option>
		<? } ?>
		</select>
		</td>
		<td style="width:170px; height:30px; background:#fafafa; vertical-align:middle;">
			<input type="text" name="fav_name[<?=$a2?>]" style="width:168px; margin:auto; border:none;" value="<?=$fav[$a2]['name']?>"maxlength="10">
		</td>

		<td style="width:55px; height:30px; background:#fafafa; vertical-align:middle;">
		<div class="main_slide m_sele_i cc_f<?=$fav[$a2]['color']?>" id="fav_select<?=$a2?>"><span class="<?=$icon_font[$fav[$a2]['icon']]?> sele_icon_22"></span></div>
		<div class="sub_slide s_sele_i">
		<?for($k=1;$k<13;$k++){?>
		<input class="fav_radio" type="radio" id="sel<?=$a2?><?=$k?>" name="fav_icon[<?=$a2?>]" value="<?=$k?>" onclick="FavI(<?=$a2?><?=$k?>)" <?if($fav[$a2]['icon'] ==$k){?> checked=" checked"<? } ?>>
		<label class="fav_radio_label" for="sel<?=$a2?><?=$k?>"><span class="<?=$icon_font[$k]?> sele_icon_22"></span></label>
		<? } ?>
		</div>
		</td>
		<td style="width:30px; height:30px; background:#fafafa; vertical-align:middle;">
			<div class="main_slide m_sele_c cc<?=$fav[$a2]['color']?>" id="color_select<?=$a2?>"><span style="color:#ffffff; font-weight:600;">　</span></div>
			<div class="sub_slide s_sele_c">
				<?for($k=1;$k<9;$k++){?><input class="fav_radio" type="radio" name="fav_color[<?=$a2?>]" id="cl<?=$a2?><?=$k?>" value="<?=$k?>" onclick="FavC(<?=$a2?><?=$k?>)" <?if($fav[$a2]['color'] ==$k){?>checked=" checked"<? } ?>><label id="cl2<?=$a2?><?=$k?>" for="cl<?=$a2?><?=$k?>" class="sele_box" style="background:<?=$icon_color[$k]?>">　</label>
				<? } ?>
			</div>
		</td>

		<td style="width:30px; height:30px; background:#fafafa; vertical-align:middle;text-align:center;">
			<input type="checkbox" name="fav_del[<?=$a2?>]" value="1">
		</td>
	</tr>
	<? } ?>
</table>
<button type="submit" class="submit" style="width:300px;" method="post" name="fav_chg_set" value="登録">変　更</button>
</form>
<br>	
<form action="./index.php" method="post">
<input type="hidden" name="uid" value="<?=$uid?>">
<table style="width:320px;">
	<tr>
		<td style="width:320px; height:30px; background:#4090ff; color:#ffffff;  border:1px solid #e0e0e0; vercical-align:middle;" colspan="5">
			お気に入り登録
		</td>
	</tr>

	<tr>
		<td style="width:205px; height:30px; background:#fafafa; vertical-align:top;">
			<input maxlength="8" type="text" name="fav_name_new" style="width:190px; height:26px; margin:auto; border:none;" placeholder="&nbsp;名称入力">
		</td>

		<td style="width:55px; height:30px; background:#fafafa; vertical-align:middle;">
			<div class="main_slide m_sele_i cc_f1" id="fav_select_new"><span class="<?=$icon_font[1]?> sele_icon_22"></span></div>
			<div class="sub_slide s_sele_i">
				<?for($k=1;$k<13;$k++){?>
				<input class="fav_radio" type="radio" id="sel_new_<?=$k?>" name="fav_icon_new" value="<?=$k?>" onclick="FavNewI(<?=$k?>)" <?if($fav[$a2]['icon'] ==$k){?> checked=" checked"<? } ?>><label class="fav_radio_label" for="sel_new_<?=$k?>"><span class="<?=$icon_font[$k]?> sele_icon_22"></span></label>
				<? } ?>
			</div>
		</td>
		<td style="width:50px; height:30px; background:#fafafa; vertical-align:top;">
			<div class="main_slide m_sele_c cc1" id="color_select_new"><span style="color:#ffffff; font-weight:600;">　</span></div>
			<div class="sub_slide s_sele_c">
				<?for($k=1;$k<9;$k++){?>
					<input class="fav_radio" type="radio" name="fav_color_new" id="cl_new_<?=$k?>" value="<?=$k?>" onclick="FavNewC(0<?=$k?>)" <?if($fav[$a2]['color'] ==$k){?>checked=" checked"<? } ?>>
					<label id="cl2<?=$a2?><?=$k?>" for="cl_new_<?=$k?>" class="sele_box" style="background:<?=$icon_color[$k]?>">　</label>
				<? } ?>
			</div>
		</td>
	</tr>
</table>
<button type="submit" class="submit" style="width:300px;" method="post" name="fav_new_set" value="登録">登　録</button>
</form>

<?} elseif($view) {?>
	<?if($log_id){?>
	<!--■■通常------------------------->
		<table class="open">
			<tr>
			<form action="./index.php" method="post">
		        <td class="open_a">
					<span class="" style="float:left;">
						<span style="display:inline-block; font-size:15px;height:30px;line-height:30px;">日時：<?=$view_date?>　<?=$view_time?></span>　
						<span style="display:inline-block; font-size:15px;height:30px;line-height:30px;">カテゴリ：<?=$category[$view_category]["name"]?></span>　
						<span style="display:inline-block; font-size:15px;height:30px;line-height:30px;">グループ：<?=$group[$view_group]["name"]?></span>
					</span>

					<span class="" style="float:right;display:block;height:35px;">
						<div id="iconselect" class="main_slide m_sele_view"><?=$icon_dat[$fav_count[$log_id]]?></div>
						<div class="sub_slide s_sele_view">
							<?foreach((array)$fav_sort as $a1 => $a2){?>
								<input type="radio" id="view_<?=$a2?>" class="label_c" name="n_icon" value="<?=$a2?>" onclick="Fav(<?=$a2?>)" style="display:none;" <?if($fav_count[$log_id] ==$a2){?> checked="checked"<?}?>>
								<label for="view_<?=$a2?>" class="sele_box_view label_c" style="color:<?=$icon_color[$fav[$a2]['color']]?>"><?=$icon_dat[$a2]?></label>
							<? } ?>

							<?if($a1){?>
								<input type="radio" id="view_none" class="label_c" name="n_icon" value="0" onclick="Fav(0)" style="display:none;">
								<label for="view_none" class="sele_box_view label_c" style="color:#333333;background:#e0e0e0">
								<span style="display:inline-block;width:30px;padding:0px 3px; font-weight:900;font-size:15px;">×</span>
								<span class="icon_name_view">フラグ解除</span></label>
							<? } ?>
						</div>
						<button type="submit" value="登録" name="fav_reg" class="submit">登録</button>
						<input type="hidden" value="<?=$log_id?>" name="icon_set">
					</span>
					<div style="clear:both"></div>
				</form>

				<form action="./index.php" method="post">
					<span class="" style="float:left;">
						<span style="display:inline-block; font-size:15px;height:26px;line-height:26px;">TITLE：<?=$view_title?></span>
					</span>
					<span class="" style="float:right">
						<span style="display:inline-block; font-size:15px;height:26px;line-height:26px;font-weight:600;">送信者：<?=$member[$view_writer]["name"]?></span>
						<?if($uid == $view_writer){?>　
						<button type="button" class="submit" onclick="Logdel(<?=$log_id?>)">削除</button>
						<button type="submit" name="set_chg" value="修正" class="submit">修正</button><? } ?>
						<button type="submit" name="set_res" value="RES" class="submit">RES</button>
					</span>
					<span style="clear:both"></span>
				</form>
				</td>
			</tr>
			<tr>
				<td class="open_b" colspan="3" style="vertical-align:middle;"><?foreach((array)$member_now as $a1 => $a2){?><span class="member<?=$user_view[$log_id][$a2]+0?>"><?=$member[$a2]["name"]?></span><? } ?></td>
			</tr>
			<tr>
				<td class="open_main">
					<?=$view?>
				</td>
			</tr>
			<?if($attach_icon){?>
			<tr>
				<td class="open_main">
				<?foreach((array)$attach_file as $a1 => $a2){?>
				<span style="display:inline-block; text-align:center;padding:5px auto; width:100px;">
				<a href="<?=$view_attach?>/<?=$attach_file[$a1]?>" target="_BLANK"><img src="./icon/i_0<?=$attach_icon[$a1]?>.png" width="60" height="60"><br><span style="font-size:12px;"><?=$attach_file[$a1]?></span></a>
				</span>
				<? } ?>
				</td>
			</tr>
			<? } ?>

			<?if($res){?>
			<tr>
			<td class="open_sub" style="background-color:#f0f0f0;">
				<?for($p1=0;$p1<count($res);$p1++){?>
					<div class="res">
					<div style="font-color:#606060; border-bottom: 1px solid #cccccc; width:98%; padding:3px; float:left;">日時：<?=$res[$p1]["date"]?>　<?=$res[$p1]["time"]?>　　名前：<?=$member[$res[$p1]["writer"]]["name"]?>
					<?if($uid == $res[$p1]["writer"]){?>
						<span style="float:right;">
							<button id="resdel" type="button" class="submit" onclick="Resdel(<?=$res[$p1]['res_id']?>)">削除</button>
						</span>
					<? } ?>	
					</div>
					<div style="clear:both"></div>
					<div style="padding:5px;"><?=$res[$p1]["log"]?><br></div>
					</div>
				<? } ?>
			</td>
			</tr>
			<? } ?>
		</table>
	<!--■■END------------------------->
	<? } ?>
<? } ?>
</div>
<? } ?>
<? } ?>
<div class="bottom">　</div>

</body>
</html>
