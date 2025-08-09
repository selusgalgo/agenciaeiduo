<?php 
get_header();
// WP_Query arguments
$args = array(
    'post_type'      => 'proyectos',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
);
// The Query
$proyectos_query = new WP_Query( $args );
?>
<section id="portfolio" class="bg-dark section--proyectos py-l">
    <div class="container">
            <ul class="proyectos row">
            <?php 
                // The Loop
                if ( $proyectos_query->have_posts() ) {
                    while ( $proyectos_query->have_posts() ) {
                        $proyectos_query->the_post();
                        // do something
            ?>
                <li class="col-6 col-md-4 proyecto">
                    <article class="post-proyecto pb-l">
                        <?php
                            echo '<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array('echo' => 0) ) . '">';
                            if ( has_post_thumbnail() ) {the_post_thumbnail('large');}
                            echo '</a>';
                        ?>
                        <div class="meta-proyecto">
                            <?php
                                echo '<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array('echo' => 0) ) . '">';
                                echo '<h2 class="h4 text-color-light medium">';
                                the_title();
                                echo '</h2>';
                                echo '</a>';
                                $categories = get_the_terms(get_the_ID(), 'categorias_proyectos');
                                if ( ! empty( $categories ) ) {
                                    echo '<p class="post-categories text-color-medium">';
                                    $cat_count = count($categories);
                                    foreach ( $categories as $index => $category ) {
                                        $category_link = get_term_link($category->term_id, 'categorias_proyectos'); // Aquí se ha añadido el enlace a la categoría
                                        echo '<a href="' . esc_url( $category_link ) . '">' . esc_html( $category->name ) . '</a>';
                                        if ($index < $cat_count - 1) {
                                            echo ' - ';
                                        }
                                    }
                                    echo '</p>';
                                }
                            ?>
                        </div>
                    </article>
                </li>
                <?php     }
                    } else {
                        // no posts found
                        echo 'No se encontraron proyectos.';
                    }

                    // Restore original Post Data
                    wp_reset_postdata();
                ?>
            </ul>
    </div>
</section>
<?php get_footer();?>