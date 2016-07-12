<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); global $roboto_options;?>
<section class="clearfix">
    <div class="container">
        <div id="blog-page" class="row clearfix">
            <div class="pull-left col-md-8 col-sm-8 col-xs-12">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>                            
                        <?php endwhile; ?>
                    <?php endif; ?>
            </div>
        </div>
</section>
<?php get_footer(); ?>