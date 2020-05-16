<?php 
get_header();
$res = $wpdb->get_results('
 SELECT * FROM wp01_0cast
');

$dat[$res->id]["genji"]=$res->genji;
print($res->genji);

?>

<div class="main">
	<div class="main_b_all">
		<?PHP foreach($res as $a1):?>
			<div class="main_b_1">
			<?PHP echo $res->genji?><br>
			<?PHP echo $a1?><br>
			</div>
		<?PHP  endforeach; wp_reset_postdata();?>

	</div>
</div>
<?php get_footer(); ?>
