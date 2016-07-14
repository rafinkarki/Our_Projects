<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
  <?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>
      <div class="prev-next-btn" style="display:none;">
        <ul class="pager">
          <li class="previous">
          <?php
          previous_posts_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous feature', 'rabto' ) . '</span> %title' ); ?>
          </li>
          <li class="next">
          <?php
          next_posts_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next feature', 'rabto' ) . '</span>' ); ?>
          </li>
        </ul>
      </div>
      <?php
  $defaults = array(
    'before'           => '<p>' . __( 'Pages:','rabto' ),
    'after'            => '</p>',
    'link_before'      => '',
    'link_after'       => '',
    'next_or_number'   => 'number',
    'separator'        => ' ',
    'nextpagelink'     => __( 'Next page' ,'rabto'),
    'previouspagelink' => __( 'Previous page','rabto' ),
    'pagelink'         => '%',
    'echo'             => 1
  );        wp_link_pages( $defaults );

 endif; ?>
 <?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>
   	<div class="rabto-next-prev-post-pagination">
	    <?php $prevPost = get_previous_post(true);?>
	    <div class="rabto-prev-post"><?php
		      if($prevPost) {
		        echo '<a href="#!" class="rabto-page-icon-wrapper">
		                                    <i class=""></i>
		                                </a> <div class="rabto-other-post-title-wrapper">
		                                    <h4 class="rabto-pagination-title">Previous Article</h4>';                                
		        previous_post_link('%link',"<h2>%title</h2>", TRUE);
		        echo '</div>';
		      } ?>

	    </div>
	    <div class="rabto-next-post">
		    <?php $nextPost = get_next_post(true);
		    if($nextPost) {
		      echo ' <a href="#" class="rabto-page-icon-wrapper">
		                <i class=""></i>
		            </a>
		            <div class="rabto-other-post-title-wrapper">
		                <h4 class="rabto-pagination-title">Next Article</h4>';
		      next_post_link('%link',"<h2>%title</h2>", TRUE);
		      echo '</div>';
		    } ?>
	    </div>
  	</div>
<?php
 endif; ?>