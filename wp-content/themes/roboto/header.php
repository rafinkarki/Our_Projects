<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Buzz_leak
 * @since Buzz Lea
 */

?><!DOCTYPE html>
<?php global $buzz_options;?>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(isset($buzz_options['meta_author']) && $buzz_options['meta_author']!='') : ?>
    <meta name="author" content="<?php echo esc_attr($buzz_options['meta_author']); ?>">
    <?php else: ?>
    <meta name="author" content="<?php esc_attr(bloginfo('name')); ?>">
    <?php endif; ?>
    <?php if(isset($buzz_options['meta_author']) && $buzz_options['meta_desc']!='') : ?>
    <meta name="description" content="<?php echo esc_attr($buzz_options['meta_desc']); ?>">
    <?php endif; ?>
    <?php if(isset($buzz_options['meta_author']) && $buzz_options['meta_keyword']!='') : ?>
    <meta name="keyword" content="<?php echo esc_attr($buzz_options['meta_keyword']); ?>">
    <?php endif; ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <title><?php wp_title( ' | ', true, 'right' );?></title>
    <?php if(isset($buzz_options['favicon']['url'])) :  ?>
    <link rel="shortcut icon" href="<?php echo esc_url($buzz_options['favicon']['url']); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class('buzzleak-page');?>>
  <?php
  $sticky = '';
        if( $buzz_options['sticky'] == 1 ){
          $sticky = __('navbar-fixed-top','buzz');
          $main=__('main-class','buzz');
        }

  ?>

  <div id="wrapper">
    <header id="header">
      <nav class="navbar navbar-default <?php echo $sticky; ?>">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only"><?php _e('Toggle navigation','buzz');?></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php if($buzz_options['logo']['url']!=""):?>
                <img src="<?php echo esc_url($buzz_options['logo']['url']);?>" data-at2x="<?php echo esc_url($buzz_options['retina']['url']); ?>" alt="<?php bloginfo( 'name' ); ?>" width="194" height="31">
            <?php else:?>
                <?php bloginfo( 'name' ); ?>
            <?php endif;?>
            </a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php
                wp_nav_menu( array(
                'theme_location'    => 'primary',
                'container'         => '',
                'container_class'   => '',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'bl_bootstrap_navwalker::fallback',
                'walker'            => new bl_bootstrap_navwalker())
                );


            ?>
            <ul class="nav navbar-nav navbar-right">
            <?php
            $facebook=$buzz_options['social_facebook'];
            $twitter=$buzz_options['social_twitter'];
            $google=$buzz_options['social_googlep'];
            $youtube=$buzz_options['social_youtube'];
            if($facebook!=""&& $twitter!="" && $google!="" && $youtube!=""):?>
              <li>
                <div class="social-networks">
                  <ul>
                    <?php if($facebook):?>
                        <li><a href="<?php echo esc_url($facebook);?>" target="_blank" class="facebook"><?php _e('Facebook','buzz');?></a></li>
                    <?php endif; if($twitter):?>
                        <li><a href="<?php echo esc_url($twitter);?>" target="_blank" class="twitter"><?php _e('Twitter','buzz');?></a></li>
                    <?php endif; if($google):?>
                        <li><a href="<?php echo esc_url($google);?>" target="_blank" class="google"><?php _e('Google Plus','buzz');?></a></li>
                    <?php endif; if($youtube):?>
                        <li><a href="<?php echo esc_url($youtube);?>" target="_blank" class="youtube"><?php _e('Youtube','buzz');?></a></li>
                    <?php endif;?>
                  </ul>
                </div>
              </li>
            <?php endif;?>
            <?php if(isset($buzz_options['search'])&&$buzz_options['search']==1):?>
                  <li class="dropdown search-wrap">
                    <a href="#" class="dropdown-toggle search-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php _e('Search','buzz');?></a>
                    <div class="dropdown-menu search-form inner">
                        <form role="search" method="get" class="navbar-form" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="form-box">
                          <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="s">
                          </div>
                          <button type="submit" class="btn btn-default"><?php _e('Submit','buzz');?></button>
                        </div>
                      </form>
                    </div>
                  </li>
              <?php endif;?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>
<main id="main" class="<?php echo $main;?>">