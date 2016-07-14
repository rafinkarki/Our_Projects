<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>
<?php global $rabto_options; rabto_setPostViews(get_the_ID());?>
<section class="rabto-latest-article-section rabto-section rabto-single-post-section">
    <div class="container">
        <div class="row">
            <?php
                if (have_posts()) :
                    echo '<div class="rabto-main-content col-md-8 col-sm-8 col-xs-12">';
                    while (have_posts()) : the_post();
                        get_template_part('partials/article');
                        if(isset($rabto_options['author_detail']) && $rabto_options['author_detail']==1)
                            get_template_part('partials/article-author');
                        if(isset($rabto_options['related_post']) && $rabto_options['related_post']==1)
                            get_template_part('partials/article-related-posts');
                        comments_template( '', true );
                    endwhile;
                    echo '</div>';
                endif;?>
            <?php if(isset($rabto_options['single_blog']) && $rabto_options['single_blog']==1):?>
                 <div class="rabto-sidebar-wrapper col-md-4 col-sm-4 col-xs-12">
                    <?php if ( is_active_sidebar( 'rabto-post-sidebar' ) ) {
                        dynamic_sidebar( 'rabto-post-sidebar' );
                     } ?>
                    <div class="rabto-sidebar">
                         <?php if ( is_active_sidebar( 'rabto-widgets-sidebar' ) ) {
                            dynamic_sidebar( 'rabto-widgets-sidebar' );
                         } ?><?php if ( is_active_sidebar( 'rabto-trending-sidebar' ) ) {
                            dynamic_sidebar( 'rabto-trending-sidebar' );
                         } ?>
                    </div>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>