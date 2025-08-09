
<?php get_header(); ?>

<article id="post-author" class="post-author">

    <!-- Esto establece la variable $ curauth -->
    <header class="post-header bg-dark nav--light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="content-text separation-top pb-5">
                        <?php
                            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
                        ?>
                        <h2 class="f-1 text-light"><?php echo $curauth->nickname; ?></h2>
                        <ul class="text-light">
                            <li class="pb-1"><?php echo $curauth->user_description; ?></li>
                            <li class="pb-1"><a class="text-primary" href="<?php echo $curauth->user_url; ?>"><?php _e('@'); ?><?php echo $curauth->nickname; ?></a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>

    <section class="separation bg-light nav--dark">
        <div class="row">
            <div class="col-12 col-lg-8 order-lg-2">

                     <ul class="row">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <li class="col-12 col-lg-6">

                                <article class="post-entry">
                                    <a href="<?php the_permalink(); ?>">
                                        <header class="post-header">
                                            <figure>
                                                <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid', 'title' => 'Feature image']); ?>
                                            </figure>
                                        </header>
                                    </a>

                                    <div class="p-1">

                                        <main class="main-content text-medium">
                                            <h3 class="text-dark mb-2"><?php the_title(); ?></h3>
                                            <?php the_excerpt(); ?>
                                        </main>

                                        <footer class="post-footer text-dark">
                                            <li class="mb-1"><strong><?php the_author(); ?></strong></li>
                                                <li><?php the_date(); ?></li>
                                                <?php the_category(); ?>
                                        </footer>
                                                
                                    </div>
                            
                                </article>
                            </li>
                        <?php endwhile; else: ?>
                                <p><?php _e('No hay publicaciones de este autor.'); ?></p>
                        <?php endif; ?>
                    </ul>

            </div>
            <?php get_sidebar('left'); ?>
        </div>
    </section>

</article>

<?php
    get_template_part('template-parts/footer/site-newsletter'); 
    get_footer(); 
?>