
<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Barberia
 * @since Barberia 1.0
 */

if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); global $buzz_options; ?>
<div class="container">
<div class="message-box">
  <div class="message-content">
    <h1><?php _e('404','buzz');?></h1>
    <p><?php _e('The Page You Looking For Doesn’t Exist','buzz');?></p>
  </div>
</div>
</div>
<?php get_footer(); ?>
