<?php get_header(); ?>
      <div class="top-banner">
        <div class="container-fluid">
          <?php
         $tranding_args = array( 'posts_per_page' => $posts_per_page_tranding ,'meta_key' => 'post_views_count','orderby' => 'meta_value_num'); $trending_query= new WP_Query($tranding_args);
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
        <div class="post-block search">
          <div class="row content-frame">
            <div class="sidebar">
               <?php if ( is_active_sidebar( 'buzz-widgets-sidebar' ) ) {
                    dynamic_sidebar( 'buzz-widgets-sidebar' );
                 } ?>
            </div>
            <div class="content-main">
              <header class="heading">
                <h2><?php _e('Latest Article','buzz');?></h2>
              </header>
              <div class="holder">
              <?php
               $paged = (get_query_var('page')) ? get_query_var('page') : 1;
              $latest_args = array( 'posts_per_page' => 5, 'order'=> 'DESC',  'orderby' => 'date','s'=>get_search_query() );
               $lateset_posts = query_posts( $latest_args );
              if(have_posts()):
                while(have_posts()) : the_post();
                   ?>
                    <div class="article-block">
                        <div class="img-holder">
                            <?php
                                $thumbnail = get_post_thumbnail_id($post->ID);
                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                            if($img_url):
                                $n_img = aq_resize( $img_url[0], $width =330, $height = 300, $crop = true, $single = true, $upscale = true ); ?>
                                <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
                            <?php else:
                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';
                            $n_img = aq_resize( $img_url, $width =330, $height = 300, $crop = true, $single = true, $upscale = true );?>
                                <img src="<?php echo esc_url($img_url);?>" height="300" width="330" alt="No image">
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
                else:
                  echo __('No results found','buzz');

                endif;
                wp_reset_postdata();
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php get_footer();?>