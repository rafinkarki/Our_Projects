<?php // Exit if accessed directly



if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>



<!-- About the author -->

<header class="heading">

    <h2><?php _e('About The Author','rabto');?></h2>

</header>

<div class="author-block">

    <div class="img-holder">

        <?php echo str_replace('avatar-130', 'media-object pull-left', get_avatar(get_the_author_meta('email'),130 )); ?>

    </div>

    <div class="text-block">

        <h3><?php the_author(); ?></h3>

        <p><?php the_author_meta('description'); ?>.</p>

    </div>

</div>

