        <?php 
            $footer_layout = get_theme_mod('footer_layout', '3'); 
            $footer_width = get_theme_mod('footer_width', 'content-width'); 
        ?>
        </main><!-- #main-content -->
        <footer class="site-footer">
            <div class="<?php echo $footer_width; ?>">
                <div class="footer-columns columns-<?php echo $footer_layout; ?>">
                    <?php for ($i = 1; $i <= $footer_layout; $i++) : ?>
                        <div class="footer-column footer-column-<?php echo $i; ?>">
                            <?php if (is_active_sidebar('footer-' . $i)) : ?>
                                <?php dynamic_sidebar('footer-' . $i); ?>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
                <small class="text-gray"><?php bloginfo('name'); ?> © <?php echo date("Y") ?> | Todos los derechos reservados</small> 
            </div>
        </footer>
    </div><!-- #page-container -->
    <?php wp_footer(); ?>
    </body>
</html>
