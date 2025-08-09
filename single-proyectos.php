<?php
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	get_header();
	if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
  <article class="post-proyecto">
  	<?php get_template_part ( 'template-parts/header/header-entry' ); ?>
  	<div class="container">
  		<?php the_content();?>
  	</div>
	  <?php
		// SHARE-SOCIAL
		get_template_part ( 'template-parts/footer/share-social' );
	  ?>
  </article>
<?php
	endwhile;endif;
	get_footer();
?>