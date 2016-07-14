<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); global $rabto_options;?>
 <section class="rabto-latest-article-section rabto-section rabto-category-post-section">
    <div class="container">
        <div class="row">
            <div class="rabto-latest-article-details">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <span class="rabto-news-post-excerpt"><?php the_content(); ?>   </span>                         
                        <?php endwhile; ?>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>