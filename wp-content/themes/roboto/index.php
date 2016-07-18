<?php 
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); global $rabto_options; ?>
<?php if ( is_active_sidebar( 'rabto-banner-sidebar' ) ) : 
    dynamic_sidebar('rabto-banner-sidebar');
endif;
$trending_args=array('posts_per_page'=>-1,'meta_key'=>'post_views_count','orderby'=>'meta_value_num','order'=>'DESC');
global $wpdb;
$trending_query= new WP_Query($trending_args);
if($trending_query->have_posts()):
echo '<section class="rabto-trending-news-section">
        <h3 class="rabto-section-heading">Trending Now</h3>

        <div class="rabto-trending-news-wrapper">
            <ul id="rabto-news-ticker">';
            while($trending_query->have_posts()):
                $trending_query->the_post();
                    $view=get_post_meta(get_the_ID(),'post_views_count',true);
                    if($view!=0)
                    echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';

            endwhile;

        echo '</ul>
    </div>
</section>';
endif; wp_reset_postdata();?>
  <!-- LATEST ARTICLE SECTION -->
        <section class="rabto-latest-article-section rabto-section">
            <div class="container">
                <div class="row">
                    <?php $posts_per_page=6;
                    $latest_args = array( 'posts_per_page' => $posts_per_page, 'order'=> 'DESC', 'orderby' => 'date' );
                    $lateset_posts = new WP_Query( $latest_args );
                    if($lateset_posts->have_posts()): 
                        echo '<div class="rabto-main-content col-md-8 col-sm-8 col-xs-12">
                                <h3 class="rabto-section-title">Latest Articles</h3>
                                    <div id="latest_post" class="rabto-latest-article-wrapper">';
                                        while ( $lateset_posts->have_posts()) : $lateset_posts->the_post();?>
                                             <!-- Latest Article -->
                                            <div class="rabto-latest-article">
                                            <?php
                                                $thumbnail = get_post_thumbnail_id($post->ID);
                                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                                            if($img_url):
                                                $n_img = aq_resize( $img_url[0], $width =315, $height = 315, $crop = true, $single = true, $upscale = true ); ?>
                                                <div class="rabto-image-wrapper">
                                                    <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
                                                </div>
                                            <?php else:
                                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';
                                            $n_img = aq_resize( $img_url, $width =315, $height = 315, $crop = true, $single = true, $upscale = true );?>
                                                <div class="rabto-image-wrapper">
                                                    <img src="<?php echo esc_url($img_url);?>" alt="No image">
                                                </div>
                                            <?php endif;?>
                                                <div class="rabto-latest-article-details">
                                                    <div class="rabto-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>
                                                    <h3 class="rabto-news-post-heading">
                                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                                    </h3>
                                                    <p class="rabto-news-post-excerpt"><?php echo robto_the_excerpt_max_charlength(150);?></p>
                                                    <div class="rabto-news-post-meta">
                                                        <span class="rabto-news-post-date"><?php echo date("m.d.y");  ?></span>
                                                        <div class="rabto-news-post-author"><?php the_author_posts_link(); ?></div>
                                                    </div>
                                                </div>
                                                <!-- End -->
                                            </div>
                                            <!-- End -->
                                        <?php 
                                        endwhile;
                                    echo '</div>';
                                if($lateset_posts->found_posts<=$posts_per_page)
                                {
                                  $style="display:none";
                                }
                                $total_post = $lateset_posts->found_posts;
                                $raw_page = $total_post%$posts_per_page;
                                if($raw_page==0){$page_count_raw = $total_post/$posts_per_page; }else{$page_count_raw = $total_post/$posts_per_page+1;}
                                   $page_count = floor($page_count_raw);
                                          ?>
                                <div class="rabto-load-more-wrapper" id="loadmore" style="<?php echo $style;?>">
                                    <input type="hidden" value="2" id="paged">
                                    <input type="hidden" value="<?php echo $posts_per_page?>" id="post_per_page">
                                    <input type="hidden" value="<?php echo $page_count;?>" id="max_paged">
                                    <a href="javascript:void(0);" class="rabto-btn rabto-outline-btn rabto-load-more">Load More</a>
                                </div><?php
                            echo'</div>';
                    endif;
                    wp_reset_postdata();?>
                    <!-- Sidebar -->
                    <div class="rabto-sidebar-wrapper col-md-4 col-sm-4 col-xs-12">
                        <div class="rabto-sidebar">
                            <?php if ( is_active_sidebar( 'rabto-widgets-sidebar' ) ) : 
                                dynamic_sidebar('rabto-widgets-sidebar');
                            endif;
                            if ( is_active_sidebar( 'rabto-trending-sidebar' ) ) : 
                                dynamic_sidebar('rabto-trending-sidebar');
                            endif;
                            ?>
                        </div>
                    </div>
                    <!-- End -->
                </div>
            </div>
        </section>
        <!-- LATEST ARTICLE SECTION END -->
         <!-- MUST READ SECTION -->
         <?php if(isset($rabto_options['must_read'])&& $rabto_options['must_read']==1):?>
            <section class="rabto-must-read-news-section rabto-section">
                <div class="container">
                    <div class="row">
                        <div class="rabto-section-title-wrapper">
                            <h3 class="rabto-section-btn-style-title"><?php _e('Must Read','robto');?></h3>
                        </div>
                        <div class="rabto-main-content">
                             <?php
                             $header_args=array(
                                'post_type'=>'post',
                                'posts_per_page'=>esc_attr($rabto_options['right_must_read']),
                                'orderby' => 'date',
                                'order'   => 'DESC',
                                'meta_query' => array(
                                    array(
                                        'key'     => '_rabto_must',
                                        'value'   => 'on',
                                        'compare' => '=',
                                    ),
                                ),
                            );
                            $header_query= new WP_Query($header_args);
                                $header_query= new WP_Query($header_args);
                                if($header_query->have_posts()):$i=1;
                                    echo ' <div class="rabto-numbered-news-post-wrapper col-md-5 col-sm-6 col-xs-12">';
                                    while($header_query->have_posts()):
                                    $header_query->the_post(); ?>
                                        <div class="rabto-numbered-news-post">
                                            <span class="rabto-post-number"><?php echo $i;?></span>
                                            <h3 class="rabto-news-post-heading">
                                                <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                            </h3>
                                        </div>
                                     <?php $i++;
                                    endwhile;
                                echo '</div>';
                            endif;
                            wp_reset_postdata();
                             $header_args=array(
                                'post_type'=>'post',
                                'posts_per_page'=>esc_attr($rabto_options['left_must_read']),
                                'orderby' => 'date',
                                'order'   => 'DESC',
                                'offset' =>esc_attr($rabto_options['right_must_read']),
                                'meta_query' => array(
                                    array(
                                        'key'     => '_rabto_must',
                                        'value'   => 'on',
                                        'compare' => '=',
                                    ),
                                ),
                            );
                            $header_query= new WP_Query($header_args);
                                $header_query= new WP_Query($header_args);
                                if($header_query->have_posts()):$i=1;
                                    echo '<div class="rabto-must-read-news-wrapper col-md-7 col-sm-6 col-xs-12">';
                                    while($header_query->have_posts()):
                                    $header_query->the_post(); ?>
                                        <div class="rabto-must-read-news">
                                            <!-- Image -->
                                            <?php
                                                $thumbnail = get_post_thumbnail_id($post->ID);
                                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                                            if($img_url):
                                                $n_img = aq_resize( $img_url[0], $width =220, $height = 220, $crop = true, $single = true, $upscale = true ); ?>
                                                <div class="rabto-image-wrapper">
                                                    <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
                                                </div>
                                            <?php else:
                                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';
                                            $n_img = aq_resize( $img_url, $width =220, $height = 220, $crop = true, $single = true, $upscale = true );?>
                                                <div class="rabto-image-wrapper">
                                                    <img src="<?php echo esc_url($img_url);?>" alt="No image">
                                                </div>
                                            <?php endif;?>
                                            <div class="rabto-must-read-news-details">
                                                <span class="rabto-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></span>
                                                <h3 class="rabto-news-post-heading">
                                                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                                </h3>
                                                <div class="rabto-news-post-meta">
                                                    <span class="rabto-news-post-date"><?php echo date("m.d.y");  ?></span>
                                                    <div class="rabto-news-post-author"><?php the_author_posts_link(); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                     <?php $i++;
                                    endwhile;
                                echo '</div>';
                            endif;
                            wp_reset_postdata();                          
                            ?>                      
                        </div>
                    </div>
                </div>
            </section>
        <?php endif;?>
<?php get_footer(); ?>