<?php 
/*
Template Name: Inicio
*/
if (!defined( 'ABSPATH' )) {
    die( 'No script kiddies please!' );
}
get_header(); 
$base_dir       = get_template_directory();
$base_url       = get_home_url();
$theme_url      = get_template_directory_uri();
$current_user   = wp_get_current_user();
$upload_dir     = wp_upload_dir();
$thumbID        = get_post_thumbnail_id($post->ID);
$imgDestacada   = wp_get_attachment_image_src($thumbID, 'full');
get_template_part ( 'template-parts/header/header-page' );
the_content(); 
get_footer(); 
?>
