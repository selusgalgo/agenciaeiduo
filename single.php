<?php 
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	get_header();

	while ( have_posts() ) : the_post();
?>

  <article class="post-culture">
  	<?php get_template_part ( 'template-parts/header/header-entry' ); ?>

  	<section class="container bg-light py-l">
		<div class="row">
			<div class="col-12 col-lg-7 offset-md-5">
				<?php 
					the_content();
					get_template_part ( 'template-parts/footer/share-social' );
				?>
			</div>
		</div>
  	</section>	  
  </article>

<?php 
	endwhile;
	get_footer(); 
?>