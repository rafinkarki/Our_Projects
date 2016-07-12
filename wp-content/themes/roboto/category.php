<?php get_header();?>
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
        <div class="post-block category">
          <div class="row content-frame">
            <div class="sidebar">
               <?php if ( is_active_sidebar( 'buzz-widgets-sidebar' ) ) {
                    dynamic_sidebar( 'buzz-widgets-sidebar' );
                 } ?>
            </div>
            <div class="content-main">
              <header class="heading">
              <?php
	              $category=get_queried_object(); $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	              $total_pages=$wp_query->max_num_pages;
              ?>
                <h2><?php _e('Category: ','buzz'); echo $category->name;?></h2>
              </header>
              <div class="article-content same-height">
                <div class="holder row">
              <?php
              if(have_posts()):
                while ( have_posts()) : the_post();
                   ?>
                    <div class="col-sm-12 col-md-6 height">
                    	<div class="article-box">
	                        <div class="img-holder">
	                            <?php
	                                $thumbnail = get_post_thumbnail_id($post->ID);
	                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
	                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
	                            if($img_url):
	                                $n_img = aq_resize( $img_url[0], $width =390, $height = 230, $crop = true, $single = true, $upscale = true ); ?>
	                                <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
	                            <?php else:
	                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';
	                            $n_img = aq_resize( $img_url, $width =390, $height = 230, $crop = true, $single = true, $upscale = true );?>
	                                <img src="<?php echo esc_url($img_url);?>" height="136" width="205" alt="No image">
	                            <?php endif;?>

	                        </div>
                            <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            <ul class="sub-list">
                                <li><?php echo date("m.d.y");  ?></li>
                                <li><?php the_author_posts_link(); ?></li>
                        		<li><?php comments_number( '0', '1 Comment', '% Comments' ); ?></li>
                            </ul>
	                    </div>
                    </div>
                <?php
                endwhile;
                endif;
                ?>
               </div>
              </div>
              <div class="pagination-frame text-center">
                    <ul class="pagination">
                    <?php
                      $big=999999999;
                      $args=array(
                        'base'=>str_replace($big, "%#%", esc_url(get_pagenum_link($big))),
                        'current'=>$paged,
                        'total'=>$total_pages,
                        'type'=>'array',
                        'next_text'=>'»',
                        'prev_text'=>'«'
                        );
                      $links= paginate_links($args);
                      if(count($links)>0) :
                        $links=str_replace("span", "a", $links);
                        if($paged>1)
                          $i=0;
                        else
                          $i=1;

                        foreach ($links as $link) {
                          if($i==$paged)
                            $active="class='active'";
                          else
                            $active="";
                          ?>
                            <li <?php echo $active; ?>><?php echo $link; ?></li>
                        <?php
                          # code...
                        $i++;
                        }
                      endif;
                    ?>
                </ul>
              </div>
              <?php
                wp_reset_query();
               ?>
            </div>
          </div>
        </div>
      </div>
<?php get_footer();?>