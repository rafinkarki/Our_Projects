<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<div class="pagination-holder row">
  <?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>
      <div class="prev-next-btn" style="display:none;">
        <ul class="pager">
          <li class="previous">
          <?php
          previous_posts_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous feature', 'roboto' ) . '</span> %title' ); ?>
          </li>
          <li class="next">
          <?php
          next_posts_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next feature', 'roboto' ) . '</span>' ); ?>
          </li>
        </ul>
      </div>
      <?php
  $defaults = array(
    'before'           => '<p>' . __( 'Pages:','roboto' ),
    'after'            => '</p>',
    'link_before'      => '',
    'link_after'       => '',
    'next_or_number'   => 'number',
    'separator'        => ' ',
    'nextpagelink'     => __( 'Next page' ,'roboto'),
    'previouspagelink' => __( 'Previous page','roboto' ),
    'pagelink'         => '%',
    'echo'             => 1
  );        wp_link_pages( $defaults );

 endif; ?>
 <?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>
   <div class="pagination-holder row">
    <?php $prevPost = get_previous_post(true);?>
    <div class="col-sm-6"><?php
      if($prevPost) {
        $prevthumbnail = '<span class="text">Previous Article</span>';
        previous_post_link('%link',"$prevthumbnail  <strong class='title'>%title</strong>", TRUE);
      } ?>

   </div>
   <div class="col-sm-6 right-pagination text-right">
    <?php $nextPost = get_next_post(true);
    if($nextPost) {
      $nextthumbnail = '<span class="text">Next Article</span>' ;
      next_post_link('%link',"$nextthumbnail  <strong class='title'>%title</strong>", TRUE);
    } ?>
    </a></div>
  </div><?php
 endif; ?>