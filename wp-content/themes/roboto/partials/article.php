<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} global $blog_page;$var_quote='';?>
<?php if (is_single() OR is_page()) :$check_video=0;$check_gallery=0;$check_audio=0;$check_link=0; $var_quote=0;  ?>
<article d="post-<?php the_ID(); ?>" <?php post_class("article-main");?>>
    <div class="cap-btn"><?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>
     <!-- Video Post Format -->
    <?php if (has_post_format('video')) :
    $check_video=1;
    $videoID = get_post_meta( $post->ID, 'video_id', true );
    ?>
        <div class="ImageWrapper">
            <?php echo wp_oembed_get( esc_url($videoID) );?>
        </div>
    <?php endif; ?>
    <?php if (has_post_thumbnail() && ($check_video==0 && $check_gallery==0 && $check_audio==0 && $var_quote==0 && $check_link==0 )) :
            $att = get_post_meta(get_the_ID(),'_thumbnail_id',true);
            $thumb = get_post($att);
            if (is_object($thumb)) { $att_ID = $thumb->ID; $att_url = $thumb->guid; }
            else { $att_ID = $post->ID; $att_url = $post->guid; }
            $att_title = (!empty(get_post($att_ID)->post_excerpt)) ? get_post($att_ID)->post_excerpt : get_the_title($att_ID);
            ?>
            <div class="ImageWrapper">
                <?php $thumbnail = get_post_thumbnail_id(get_the_ID());
                      $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                      $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                 ?>
                 <img src="<?php echo esc_url($img_url[0]);?>"/>
            </div>
        <?php endif; ?>
    <h1><?php the_title();?></h1>
    <span class="text"><?php the_excerpt();?></span>
    <div class="text-box">
        <div class="row">
            <div class="left-block col-xs-6"><span class="avatars"><?php echo str_replace('avatar-54 photo', '', get_avatar(get_the_author_meta('email'),54 )); ?></span><p><?php _e('by ','rabto');?><b><?php the_author_posts_link(); ?></b> - <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></p></div>
            <div class="right-block col-xs-6 text-right">
                <ul>
                    <li>
                        <span class="view"><span class="icon-eye"></span><?php echo rabto_getPostViews(get_the_ID()); _e('Views','rabto');?></span>
                    </li>
                    <li>
                        <span class="comments"><span class="icon-comment"></span><?php comments_number( '0', '1 Comment', '% Comments' ); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
   <!--  <div class="btn-frame">
        <a href="http://www.facebook.com/share.php?u=<?php get_the_permalink(); ?>&t=<?php the_title(); ?>" onclick="return fbs_click()" target="_blank" class="btn btn-facebook"><span class="icon-facebook"></span><?php _e('Facebook','rabto');?></a>
         <a href="http://twitter.com/share" class="btn btn-twitter" target="_blank"
          data-url="<?php the_permalink(); ?>"
          data-via="Rabto"
          data-text="<?php the_title(); ?>"
          data-related="Rabto:Wordpress Theme"
          data-count="none"><span class="icon-twitter"></span><?php _e('Twitter','rabto');?></a>
        <a href="#" class="btn btn-add">+</a>
    </div> -->
    <div class="article-content-box">
        <?php the_content();?>
    </div>
    <!-- <div class="btn-frame">
        <a href="http://www.facebook.com/share.php?u=<?php get_the_permalink(); ?>&t=<?php the_title(); ?>" onclick="return fbs_click()" target="_blank" class="btn btn-facebook"><span class="icon-facebook"></span><?php _e('Facebook','rabto');?></a>
         <a href="http://twitter.com/share" class="btn btn-twitter" target="_blank"
          data-url="<?php the_permalink(); ?>"
          data-via="Rabto"
          data-text="<?php the_title(); ?>"
          data-related="Rabto:Wordpress Theme"
          data-count="none"><span class="icon-twitter"></span><?php _e('Twitter','rabto');?></a>
        <a href="#" class="btn btn-add">+</a>
    </div> -->
    <?php get_template_part('partials/article-related'); ?>

</article>

<?php endif; ?>






