</div><!-- #content -->

<footer id="footer" class="site-footer" role="contentinfo">
 <div class="container">
    <div class="row">
        <?php
                echo '<div class="mt-footer-widget col-md-3">';
                if( is_active_sidebar( 'footer-sidebar-1' ) ) {
                    dynamic_sidebar('footer-sidebar-1');
                } else {
                    the_widget('pixova_lite_widget_about', sprintf( 'title=%s', __('About', 'pixova-lite') ) .'&'. sprintf('about_text=%s.', __('The many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected true of a humour', 'pixova-lite') ) );
                }
                echo '</div><!--/.mt--foter--widget.col-md-3-->';

                echo '<div class="mt-footer-widget col-md-3">';
                if( is_active_sidebar( 'footer-sidebar-2' ) ) {
                    dynamic_sidebar('footer-sidebar-2');
                } else { ?>

                    <div class="widget">
                        <h2 class="widgettitle"><?php _e('Quick Nav', 'pixova-lite'); ?></h2>
                            <ul id="menu-pixova-footer-menu" class="menu">
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#about"><?php _e('About us', 'pixova-lite'); ?></a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#works"><?php _e('Recent Works', 'pixova-lite'); ?></a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#testimonials"><?php _e('Testimonials', 'pixova-lite'); ?></a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#news"><?php _e('News', 'pixova-lite'); ?></a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#team"><?php _e('Team', 'pixova-lite'); ?></a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#contact"><?php _e('Contact', 'pixova-lite'); ?></a></li>
                            </ul>
                    </div>

                <?php }
                echo '</div><!--/.mt--foter--widget.col-md-3-->';

                echo '<div class="mt-footer-widget col-md-3">';
                if( is_active_sidebar( 'footer-sidebar-3' ) ) {
                    dynamic_sidebar('footer-sidebar-3');
                } else {
                    the_widget('pixova_lite_widget_social_media', sprintf( 'title=%s', __('Follow us', 'pixova-lite') ).'&profile_facebook=#&profile_twitter=#&profile_plus=#&profile_pinterest=#&profile_youtube=#&profile_dribbble=#&profile_tumblr=#&profile_instagram=#.');
                }
                echo '</div><!--/.mt--foter--widget.col-md-3-->';

                echo '<div class="mt-footer-widget col-md-3">';
                if( is_active_sidebar( 'footer-sidebar-4' ) ) {
                    dynamic_sidebar('footer-sidebar-4');
                } else {
                    the_widget('pixova_lite_widget_latest_posts', sprintf('title=%s', __('Latest Posts', 'pixova-lite') ).'&items=1' );
                }
                echo '</div><!--/.mt--foter--widget.col-md-3-->';
        ?>
    </div> <!-- /.row-->
 </div> <!-- /.container -->
<?php 

$footer_copyright = get_theme_mod('pixova_lite_copyright', sprintf( __( '&copy; Copyright %s. All Rights Reserved', 'pixova-lite' ), date( 'Y' ) ) );


if( isset( $footer_copyright ) ) { ?>
<div class="fluid-container">
<div class="footer-copyright-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <p class="footer-copyright">
                    <?php _e('Theme:', 'pixova-lite'); ?> <a href="<?php echo esc_url( 'http://www.machothemes.com/themes/pixova-lite/' ); ?>" target="_blank" rel="nofollow" title="<?php _e('Free One Page Parallax WordPress Theme', 'pixova-lite'); ?>"><?php _e('Pixova Lite', 'pixova-lite'); ?></a>
                    &middot;
                    <?php _e('Made with','pixova-lite'); ?> <span class="footer-heart-icon fa fa-heart"></span> <?php _e(' by ', 'pixova-lite'); ?> <a target="_blank" rel="dofollow" href="<?php echo esc_url('http://www.machothemes.com'); ?>"><?php _e('Macho Themes', 'pixova-lite'); ?></a>
                    <?php echo esc_html($footer_copyright); ?>
                </p>
            </div><!--/.text-center-->
        </div><!--/col-lg-12-->
    </div><!--/.row-->
    </div><!--/.footer-copyright-container-->
</div><!--/.fluid-container-->
<?php }  ?>

</footer>
</div><!-- #page -->
    <a href="#" class="mt-top"><?php _e('Top', 'pixova-lite'); ?></a>
<?php wp_footer(); ?>
</body>
</html>
