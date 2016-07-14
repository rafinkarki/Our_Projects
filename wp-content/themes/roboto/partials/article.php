<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} global $blog_page;$var_quote='';?>
<?php if (is_single() OR is_page()) :$check_video=0;$check_gallery=0;$check_audio=0;$check_link=0; $var_quote=0;  ?>
<div id="post-<?php the_ID(); ?>" <?php post_class("post-article");?>>
   	<div class="rabto-post-title-metas">
        <span class="rabto-category-meta"><?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></span>
        <h1 class="rabto-news-post-heading">
            <a href="javascript:void(0);"><?php the_title();?></a>
        </h1>
        <div class="rabto-news-post-excerpt"><?php the_content();?></div>
        <div class="rabto-author-commnets-count">
            <div class="rabto-posting-time-wrapper">
                <div class="rabto-author-short-img">
                   <?php echo str_replace('avatar-54 photo', '', get_avatar(get_the_author_meta('email'),54 )); ?>
                </div>
                <p><?php _e('by ','rabto');?> <a href="<?php echo get_the_author_link(); ?> " class="rabto-author-name"><?php echo get_the_author(); ?> </a> - <span class="rabto-post-date"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span></p>
            </div>

            <div class="rabto-comment-view-wrapper">
                <ul>
                    <li class="rabto-view-counter"><?php echo rabto_getPostViews(get_the_ID()); _e(' Views','rabto');?></li>
                    <li class="rabto-comments-counter">
                        <a href="<?php comments_link(); ?>"><?php comments_number( '0', '1 Comment', '% Comments' ); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php get_template_part('partials/article-related'); ?>
</div>
<?php endif; ?>