<?php
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	get_header();
    // Obtén el título de la página actual
    $page_title = get_the_title();
    // Limpia el título para usarlo como clase (reemplaza espacios con guiones)
    $page_class = sanitize_title($page_title);
?>

<article class="page-<?php echo esc_attr($page_class); ?>">
    <div class="entry-content">
        <?php the_content();?>
    </div><!-- entry-content -->
</article>

<?php get_footer(); ?>