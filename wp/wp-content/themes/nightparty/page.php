<?php
global	$post;
$slug = $post->post_name;
$html = $post->post_content;
get_header(); ?>
<?php echo $html;?>
<?php
get_footer();
?>

