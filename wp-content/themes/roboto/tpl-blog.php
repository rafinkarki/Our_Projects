<?php // Exit if accessed directly
/*
* Template Name: Blog Post
*/
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); global $buzz_options; ?>
<div class="top-banner">
        <div class="container-fluid">
        <div class="row">
            <?php dynamic_sidebar('buzz-banner-sidebar');?>
        </div>
        <?php
            $trending_args=array('posts_per_page' => -1 ,'meta_key' => 'post_views_count','orderby' => 'meta_value_num'
        );
        $trending_query= new WP_Query($trending_args);
        if($trending_query->have_posts()):
                    echo ' <div class="row">
                    <div class="note-banner">
                      <span class="tending-now">Trending Now</span>
                      <div class="marquee">
                      <marquee>
                      <ul class="note-list">';
                        while($trending_query->have_posts()):
                            $trending_query->the_post();
                                echo '<li>'.get_the_title().'</li>';

                        endwhile;
                    echo '</ul></marquee></div>
                        </div>
                      </div>';
                endif;
        wp_reset_postdata();?>
        </div>
    </div>
      <div class="container">
        <div class="post-block">
          <div class="row">
            <div class="col-sm-5 col-md-6">
              <header class="heading">
                <h2><?php _e('Latest Article','buzz');?></h2>
              </header>
                <?php $posts_per_page=10;
                $latest_args = array( 'posts_per_page' => $posts_per_page, 'order'=> 'DESC', 'orderby' => 'date' );
                $lateset_posts = new WP_Query( $latest_args );
                if($lateset_posts->have_posts()): echo '<div id="latest_post" class="holder">';
                while ( $lateset_posts->have_posts()) : $lateset_posts->the_post();
                   ?>
                    <div class="article-block">
                        <div class="img-holder">
                            <?php
                                $thumbnail = get_post_thumbnail_id($post->ID);
                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                            if($img_url):
                                $n_img = aq_resize( $img_url[0], $width =205, $height = 136, $crop = true, $single = true, $upscale = true ); ?>
                                <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
                            <?php else:
                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';
                            $n_img = aq_resize( $img_url, $width =205, $height = 136, $crop = true, $single = true, $upscale = true );?>
                                <img src="<?php echo esc_url($img_url);?>" height="136" width="205" alt="No image">
                            <?php endif;?>

                        </div>
                        <div class="text-block">
                            <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            <?php the_excerpt();?>
                            <ul class="sub-list">
                                <li><?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></li>
                                <li><time datetime="<?php echo get_the_date('Y-m-d') ?>"><?php echo date("m.d.y");  ?></time></li>
                                <li><?php the_author_posts_link(); ?></li>
                            </ul>
                        </div>
                    </div>
                <?php
                endwhile;
                echo '</div>';
                global $wp_query;
                    if($lateset_posts->found_posts<=$posts_per_page)
                    {
                      $style="display:none";
                    }
                    $total_post = $lateset_posts->found_posts;
                    $raw_page = $total_post%$posts_per_page;
                    if($raw_page==0){$page_count_raw = $total_post/$posts_per_page; }else{$page_count_raw = $total_post/$posts_per_page+1;}
                       $page_count = floor($page_count_raw);
                              ?>
                    <div class="btn-wrap" id="loadmore" style="<?php echo $style;?>">
                        <input type="hidden" value="2" id="paged">
                        <input type="hidden" value="<?php echo $posts_per_page?>" id="post_per_page">
                        <input type="hidden" value="<?php echo $page_count;?>" id="max_paged">
                        <a href="javascript:void(0);" class="load-more">Load More</a>
                    </div>
                <?php
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <div class="col-sm-4">
              <header class="heading">
                <h2><?php _e('Trending','buzz');?></h2>
              </header>

                <header class="heading">
                <h2><?php _e('Trending','buzz');?></h2>
              </header>
               <?php $posts_per_page_tranding2=3;
                $tranding_args2 = array( 'posts_per_page' => $posts_per_page_tranding2 ,'meta_key' => 'post_views_count','orderby' => 'meta_value_num','order'=>ASC);
                $tranding_posts2 = new WP_Query( $tranding_args2 );
                if($tranding_posts2->have_posts()): echo '<div id="tranding2">';
                while ( $tranding_posts2->have_posts()) : $tranding_posts2->the_post();
                   ?>
                  <div class="article-box">
                    <div class="img-holder">
                        <?php
                            $thumbnail = get_post_thumbnail_id($post->ID);
                            $img_url = wp_get_attachment_image_src( $thumbnail,'tranding-size');
                            $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                        if($img_url):
                             $url = aq_resize( $img_url[0], $width =300, $height = 170, $crop = true, $single = true, $upscale = true );?>
                            <img src="<?php echo esc_url($url);?>" alt="<?php echo esc_attr($alt);?>">
                        <?php else:?>
                            <img src="<?php echo esc_url( get_template_directory_uri() ).'/assets/images/no-image.png';?>" height="170" width="300" alt="No image">
                        <?php endif;?>
                    </div>
                    <div class="text-block">
                      <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                      <?php the_excerpt();?>
                      <ul class="sub-list">
                        <li><?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></li>
                        <li><time datetime="<?php echo get_the_date('Y-m-d') ?>"><?php echo date("m.d.y");  ?></time></li>
                        <li><?php the_author_posts_link(); ?></li>
                      </ul>
                    </div>
                  </div>
                 <?php
                endwhile; echo'</div>';
                    if($tranding_posts2->found_posts<=$posts_per_page_tranding2)
                    {
                      $style_tranding="display:none";
                    }
                    $total_post = $tranding_posts2->found_posts;
                    $raw_page = $total_post%$posts_per_page_tranding2;
                    if($raw_page==0){$page_count_raw = $total_post/$posts_per_page_tranding2; }else{$page_count_raw = $total_post/$posts_per_page_tranding2+1;}
                       $page_count = floor($page_count_raw);
                              ?>
                    <div class="btn-wrap" id="loadmore_tranding2" style="<?php echo $style_tranding2;?>">
                        <input type="hidden" value="2" id="paged_tranding2">
                        <input type="hidden" value="<?php echo $posts_per_page_tranding2?>" id="post_per_page_tranding2">
                        <input type="hidden" value="<?php echo $page_count;?>" id="max_paged_tranding2">
                        <a href="javascript:void(0);" class="load-more">Load More</a>
                    </div>
                <?php
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <?php
            $video_args = array(
                'post_type'  => 'post',
                'order'      => 'DESC',
                'orderby'      => 'date',
                'posts_per_page'=>5,
                'meta_key'     => 'video_id'
            );
            $video_query = new WP_Query( $video_args );
            if($video_query->have_posts()):?>
                <div class="col-sm-3 col-md-2">
                  <header class="heading">
                    <h2><?php _e('Top Video','buzz');?></h2>
                  </header>
                  <ol class="video-frame">
                  <?php while($video_query->have_posts()):$video_query->the_post();?>
                        <li class="video-box">
                        <?php
                            $thumbnail = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                            $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                        if($img_url):
                             $url = aq_resize( $img_url[0], $width =200, $height = 133, $crop = true, $single = true, $upscale = true );?>
                            <div class="img-holder">
                                <img src="<?php echo esc_url($url);?>" height="133" width="200" alt="<?php echo esc_attr($alt);?>">
                            </div>
                        <?php else:?>
                            <div class="img-holder">
                                <img src="<?php echo esc_url( get_template_directory_uri() ).'/assets/images/no-image.png';?>" height="133" width="200" alt="No image>">
                            </div>
                        <?php endif;?>
                          <div class="text-block">
                            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                          </div>
                        </li>
                    <?php endwhile;?>
                  </ol>
                </div>
            <?php endif;
            wp_reset_postdata();?>
          </div>
        </div>
<?php get_footer(); ?>