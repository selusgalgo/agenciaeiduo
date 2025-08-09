<?php 
/*
Template Name: Legal
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();
$base_dir 		= get_template_directory();
$base_url 		= get_home_url();
$theme_url 		= get_template_directory_uri();
$current_user 	= wp_get_current_user();
$upload_dir   	= wp_upload_dir();

?>
<!-- Contenido de página de inicio -->
<?php while ( have_posts() ) : the_post(); ?>
<section class="bg-dark nav--light py-l">
	<div class="container">
		<h1 class="light has-large-font-size"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
  
</section>
<?php endwhile; ?>
<!-- Archivo de pié global de Wordpress -->
<?php get_footer(); ?>