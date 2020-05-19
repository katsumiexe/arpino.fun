<?php get_header(); ?>
任意のHTMLコードを入力しページをデザイン可能です。
例えば、画像を表示する。スライドショーを表示するなど、任意のHTMLコードを使えます。
<div id="container">
 
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
 
</div><!-- [ /#container ] -->
 
<div id="news-box" style="margin-top:100px; color:#fafafa;font-size:16px;">
<ul>
<?php
$myposts = get_posts('post_type=post&numberposts=5&category='.$var);
foreach($myposts as $post) : ?>
 
<li><?php the_time('Y年m月d日(D)'); ?><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
 
</ul>
</div><!-- [ /#news-box ] -->
 
<?php get_footer(); ?>