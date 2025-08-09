<?php get_header();?>

<header class="bg-dark pt-l">
    <div class="container row">
        <div class="col-12">
            <?php single_term_title('<h1 class="has-x-large-font-size light">', '</h1>'); ?>
            <?php the_archive_description('<div class="taxonomy-description has-medium-font-size">', '</div>'); ?>
        </div>
    </div>
</header>

<section id="post" class="bg-dark section--culture py-l">
    <div class="container">
        <div class="publicaciones row">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="col-12 col-md-11 pb-l post-culture">
                    <?php
                        echo '<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array('echo' => 0) ) . '">';
                        echo '<h2 class="has-large-font-size light">';
                        the_title();
                        echo '</h2>';
                        echo '</a>';
                    ?>
                </article>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>

<?php get_footer();?>
