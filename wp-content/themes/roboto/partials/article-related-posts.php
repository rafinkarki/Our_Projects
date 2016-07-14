<?php // Exit if accessed directly

if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<header class="heading">

    <h2><?php _e('Related Posts','rabto');?></h2>

</header>

<?php

global $post;

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

			'posts_per_page'=> 2,

			'orderby'=>'rand'

			);

		$my_query = new wp_query( $args );

		if( $my_query->have_posts() ) :

			echo '<div class="article-content same-height">

					<div class="holder row">';

			while( $my_query->have_posts() )  :



				$my_query->the_post(); ?>

			<div class="col-sm-6 height">

	            <div class="article-box">

	                <div class="img-holder">

	                    <?php

                            $thumbnail = get_post_thumbnail_id($post->ID);

                            $img_url = wp_get_attachment_image_src( $thumbnail,'full');

                            $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);

                        if($img_url):
                            $n_img = aq_resize( $img_url[0], $width =390, $height = 230, $crop = true, $single = true, $upscale = true ); ?>
                            <img src="<?php echo esc_url($n_img);?>"  alt="<?php echo esc_attr($alt);?>">

                        <?php else:?>

                            <img src="<?php echo esc_url( get_template_directory_uri() ).'/assets/images/no-image.gif';?>" height="230" width="390" alt="No image">

                        <?php endif;?>

	                </div>

	                <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

	                <ul class="sub-list">

	                    <li><?php _e('by ','rabto');?><?php the_author_posts_link(); ?></li>

	                    <li><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></li>

	                    <li><?php comments_number( '0', '1 Comment', '% Comments' ); ?></li>

	                </ul>

	            </div>

	        </div>

	        <?php endwhile;?>

		    </div>

		</div>

<?php endif; wp_reset_postdata();

}?>