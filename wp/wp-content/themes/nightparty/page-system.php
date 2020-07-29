<?php
get_header();

$sql="SELECT * FROM wp01_posts WHERE post_name LIKE 'SYSTEM-%' ORDER BY post_date DESC";
$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){
	$sort=str_replace("SYSTEM-","",$a1["post_name"]);
	$sys[$sort]=$a1;
}
print($sql);
  
ksort($sys);
?>
<?foreach($sys as $a1){?>
<div class="sys_box">
<span class="sys_box_ttl"><?=$a1["post_title"]?></span><br>
<span class="sys_box_log"><?=$a1["post_content"]?></span><br>
</div>
<?}?>

<?php get_footer(); ?>