<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>
<?php global $rabto_options; rabto_setPostViews(get_the_ID());?>
<div class="top-banner"></div>
    <div class="container">
        <div class="post-block category">
            <div class="row content-frame">
            <?php if(isset($rabto_options['single_blog']) && $rabto_options['single_blog']==1):?>
                <div class="sidebar">
                    <?php if ( is_active_sidebar( 'rabto-widgets-sidebar' ) ) {
                        dynamic_sidebar( 'rabto-widgets-sidebar' );
                     } ?>
                </div>
            <?php endif;?>
            <?php if($rabto_options['single_blog']!=1):?>
                <div class="content-main">
            <?php else:?>
                <div class="content-main">
            <?php endif;
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('partials/article');
                        if(isset($rabto_options['author_detail']) && $rabto_options['author_detail']==1)
                            get_template_part('partials/article-author');
                        if(isset($rabto_options['related_post']) && $rabto_options['related_post']==1)
                            get_template_part('partials/article-related-posts');
                        comments_template( '', true );
                    endwhile;
                endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>