<?php 
/*
Template Name: Ancho de contenido
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();
?>
<article id="page-content-width" class="container">
	<?php the_content(); ?>
</article>
<?php 
	get_footer(); 
?>