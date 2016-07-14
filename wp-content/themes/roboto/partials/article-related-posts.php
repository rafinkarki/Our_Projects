<?php // Exit if accessed directly

if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
   <!-- Related Post -->
<div class="rabto-related-post-secion">
    <h3 class="rabto-wrapper-title"><?php _e('Related Posts','rabto');?></h3>
    <?php global $post;
	$categories = get_the_category($post->ID);
	if ($categories) {
		$category_ids = array();
		foreach($categories as $individual_category)
		{
			$category_ids[] = $individual_category->term_id;
		}
		$args=array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=> 3,
			'orderby'=>'rand'
			);
		$my_query = new wp_query( $args );
		if( $my_query->have_posts() ) :
			echo '<div class="rabto-related-post-wrapper rabto-single-wrapper">';
			while( $my_query->have_posts() )  :
				$my_query->the_post(); ?>    
		        <div class="rabto-related-post">
		         	<?php
				    $thumbnail = get_post_thumbnail_id($post->ID);
				    $img_url = wp_get_attachment_image_src( $thumbnail,'full');
				    $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
					if($img_url):
					    $n_img = aq_resize( $img_url[0], $width =227, $height = 177, $crop = true, $single = true, $upscale = true ); ?>
					<div class="rabto-post-img">
					    <img src="<?php echo esc_url($n_img);?>"  alt="<?php echo esc_attr($alt);?>">
					</div>
					<?php else:?>
					<div class="rabto-post-img">
					    <img src="<?php echo esc_url( get_template_directory_uri() ).'/assets/images/no-image.png';?>" height="177" width="227" alt="No image">
					</div>
					<?php endif;?>
		            <h3>
		                <a href="<?php the_permalink();?>"><?php the_title();?></a>
		            </h3>
		            <div class="rabto-news-post-meta">
		            	<a href="<?php echo get_the_author_link(); ?> " class="rabto-news-post-author"><?php echo get_the_author(); ?> </a>
		                <a href="<?php comments_link(); ?>" class="rabto-news-comment-num"><?php comments_number( '0', '1 Comment', '% Comments' ); ?></a>
		            </div>
		        </div>
	        <?php endwhile;
	    echo '</div>';
	endif; 
wp_reset_postdata();
}?>
</div>