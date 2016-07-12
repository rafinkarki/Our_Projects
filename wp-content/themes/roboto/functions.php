<?php
/**
 * roboto functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

global $roboto_options;

if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/options-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/options-config.php' );
}
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-admin/includes/template.php' );
require( trailingslashit( get_template_directory() ) . 'inc/aq_resizer.php' );
require( trailingslashit( get_template_directory() ) . 'inc/navwalker.php' );
require( trailingslashit( get_template_directory() ) . 'inc/widgets.php' );
require( trailingslashit( get_template_directory() ) . 'inc/metabox.php' );
/*********************************************************************
* THEME SETUP
*/

function roboto_setup() {

    global $roboto_options;
    // Set content width
    global $content_width;
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

    // Load plugin checker
    require(get_template_directory() . '/inc/plugin-activation.php');

     // Nav Menu (Custom menu support)
    if (function_exists('register_nav_menu')) :
        global $roboto_options;
        register_nav_menu('primary', __('Buzz Primary Menu', 'roboto'));
        register_nav_menu('secondary', __('Buzz Footer Menu', 'roboto'));
    endif;

    // Theme Features: Automatic Feed Links
    add_theme_support('automatic-feed-links');

    add_theme_support( 'title-tag' );
    // Theme Features: Dynamic Sidebar
    add_post_type_support( 'post', 'simple-page-sidebars' );


    // Theme Features: Post Thumbnails and custom image sizes for post-thumbnails
    add_theme_support('post-thumbnails', array('post', 'page','menu'));

    // Theme Features: Post Formats
    add_theme_support('post-formats', array( 'gallery', 'image', 'link', 'quote', 'video', 'audio'));



}
add_action('after_setup_theme', 'roboto_setup');


function roboto_widgets_setup() {

    global $roboto_options;
    // Widget areas
    if (function_exists('register_sidebar')) :
        // Sidebar right
        register_sidebar(array(
            'name' => __("Blog Sidebar", 'roboto'),
            'id' => "roboto-widgets-sidebar",
            'description' => __('Widgets placed here will display in the right sidebar', 'roboto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s featured-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<header class="heading"><h2>',
            'after_title'   => '</h2></header>'
        ));

        register_sidebar(array(
            'name' => __("Trending Sidebar", 'roboto'),
            'id' => "roboto-trending-sidebar",
            'description' => __('Sidebar for trending posts', 'roboto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s featured-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<header class="heading"><h2>',
            'after_title'   => '</h2></header>'
        ));
         register_sidebar(array(
            'name' => __("Banner", 'roboto'),
            'id' => "roboto-banner-sidebar",
            'description' => __('Sidebar for Banner posts', 'roboto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s featured-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<header class="heading"><h2>',
            'after_title'   => '</h2></header>'
        ));

    endif;

}
add_action('widgets_init', 'roboto_widgets_setup');


// The excerpt "more" button
function roboto_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','roboto'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','roboto') . '</a>', $text);
}
add_filter('the_excerpt', 'roboto_excerpt');

// wp_title filter
function roboto_title($output) {
    echo $output;
    // Add the blog name
    bloginfo('name');
    // Add the blog description for the home/front page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) echo ' - '.$site_description;
    // Add a page number if necessary
    if (!empty($paged) && ($paged >= 2 || $page >= 2)) echo ' - ' . sprintf(__('Page %s', 'roboto'), max($paged, $page));
}
add_filter('wp_title', 'roboto_title');
add_image_size( 'tranding-size', 170, 300, true );
add_image_size( 'related-posts-thumbnails', 390, 390, true );
/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function roboto_load_theme_assets() {
    global $roboto_options;
    wp_enqueue_style( 'roboto-robotoleak-font', 'https://fonts.googleapis.com/css?family=Montserrat%7cRaleway:300,400,500,700', '', '' );
    // Enqueue all the theme CSS
    wp_enqueue_style('roboto-bootstrap-css', get_template_directory_uri().'/assets/css/bootstrap.css');
    wp_enqueue_style('roboto-main-css', get_template_directory_uri().'/assets/css/main.css');
    wp_enqueue_style('roboto-color-style', get_template_directory_uri().'/assets/css/color.css');
    wp_enqueue_style( 'roboto-style', get_stylesheet_uri() );
    // Enqueue all the js files of theme
    //wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-js', get_template_directory_uri().'/assets/js/jquery-1.11.2.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/assets/js/bootstrap.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('jquery-main', get_template_directory_uri().'/assets/js/jquery.main.js', array(), FALSE, TRUE);
    // custom css append code here

    $inline_css='';
    if(isset($roboto_options['extra-css'])){
    $inline_css.=$roboto_options['extra-css'];
    }
    wp_add_inline_style( 'roboto-style', $inline_css );
    if(isset($roboto_options['typography-body']['font-family']) && $roboto_options['typography-body']['font-family']!=''&& $roboto_options['typography-body']['font-weight']!='') {
    wp_enqueue_style('googlefont-custom', 'http://fonts.googleapis.com/css?family='.esc_attr($roboto_options['typography-body']['font-family']));
    }
    if(isset($roboto_options['typography-h1']['font-family']) && $roboto_options['typography-h1']['font-family']!=''&& $roboto_options['typography-h1']['font-weight']!='') {
    wp_enqueue_style('googlefont-h1', 'http://fonts.googleapis.com/css?family='.esc_attr($roboto_options['typography-h1']['font-family']));
    }
    if(isset($roboto_options['typography-h2']['font-family']) && $roboto_options['typography-h2']['font-family']!=''&& $roboto_options['typography-h2']['font-weight']!='') {
    wp_enqueue_style('googlefont-h2', 'http://fonts.googleapis.com/css?family='.esc_attr($roboto_options['typography-h2']['font-family']));
    }
    if(isset($roboto_options['typography-h3']['font-family']) && $roboto_options['typography-h3']['font-family']!=''&& $roboto_options['typography-h3']['font-weight']!='') {
    wp_enqueue_style('googlefont-h3', 'http://fonts.googleapis.com/css?family='.esc_attr($roboto_options['typography-h3']['font-family']));
    }
    if(isset($roboto_options['typography-h4']['font-family']) && $roboto_options['typography-h4']['font-family']!=''&& $roboto_options['typography-h4']['font-weight']!='') {
    wp_enqueue_style('googlefont-h4', 'http://fonts.googleapis.com/css?family='.esc_attr($roboto_options['typography-h4']['font-family']));
    }
    if(isset($roboto_options['typography-h5']['font-family']) && $roboto_options['typography-h5']['font-family']!=''&& $roboto_options['typography-h5']['font-weight']!='') {
    wp_enqueue_style('googlefont-h5', 'http://fonts.googleapis.com/css?family='.$roboto_options['typography-h5']['font-family']);
    }
    if(isset($roboto_options['typography-h6']['font-family']) && $roboto_options['typography-h6']['font-family']!=''&& $roboto_options['typography-h6']['font-weight']!='') {
    wp_enqueue_style('googlefont-h6', 'http://fonts.googleapis.com/css?family='.$roboto_options['typography-h6']['font-family']);
    }

    // theme color variation code here
    $color_variation ='';
    if(isset($roboto_options['custom_color_primary']) && $roboto_options['custom_color_primary']!=''){
    $main_custom_color_primary= esc_attr($roboto_options['custom_color_primary']);
    } else {
    $main_custom_color_primary= "#ed1c24";
    }
    if(isset($roboto_options['custom_color_hover']) && $roboto_options['custom_color_hover']!=''){
    $main_custom_color_hover= esc_attr($roboto_options['custom_color_hover']);
    } else {
    $main_custom_color_hover= "#c61017";
    }
    $color_variation='

        .robotoleak-page .top-banner .cap-btn:hover {
            background: '.$main_custom_color_hover.';
        }
        .robotoleak-page .article-content .cap-btn:hover {
            background: '.$main_custom_color_hover.';
        }

        .robotoleak-page .article-main .cap-btn:hover {
            background: '.$main_custom_color_hover.';
        }
        .robotoleak-page .more-info-block .form-control.button:hover {
            background: '.$main_custom_color_hover.';
        }
        .robotoleak-page .navbar-default .navbar-nav > li > a:hover,
        .robotoleak-page .navbar-default .navbar-nav > li > a:focus,
        .robotoleak-page .navbar-default .navbar-nav > .open > a,
        .robotoleak-page .navbar-default .navbar-nav > .open > a:hover,
        .robotoleak-page .navbar-default .navbar-nav > .open > a:focus {
            color: '.$main_custom_color_primary.';
        }
        .robotoleak-page .dropdown-menu > li > a:hover,
        .robotoleak-page .dropdown-menu > li > a:focus {

            color: '.$main_custom_color_primary.';
        }
        .robotoleak-page .top-banner .cap-btn {
            background: '.$main_custom_color_primary.';
        }
        .robotoleak-page .article-content .cap-btn {
            background: '.$main_custom_color_primary.';
        }

        .robotoleak-page .article-content .cap-btn:hover {
            background: #c61017;
        }

        .robotoleak-page .article-main .cap-btn {
            background: '.$main_custom_color_primary.';
        }

        .robotoleak-page .article-main .cap-btn:hover {
            background: #c61017;
        }

        .robotoleak-page .more-info-block .form-control.button {
            background: '.$main_custom_color_primary.';
        }
        .robotoleak-page .post-block.category .video-box:before {
            background: '.$main_custom_color_primary.';
        }
        .robotoleak-page .post-block.search .sub-list a {
            color: '.$main_custom_color_primary.';
        }
        .robotoleak-page .post-block.search h2 a:hover,
        .robotoleak-page .post-block.search h3 a:hover,
        .robotoleak-page .post-block.search h4 a:hover {
            color: '.$main_custom_color_primary.';
        }

        .robotoleak-page .pagination li.active a {
            background: '.$main_custom_color_primary.';
        }

        .robotoleak-page .pagination li a:hover {
            background: '.$main_custom_color_primary.';
        }
        .note-banner:after {
            background: '.$main_custom_color_primary.';
        }

        .note-banner .tending-now {
            background: '.$main_custom_color_primary.';
        }
        .note-banner .note-list li:before {
            background: '.$main_custom_color_primary.';
        }
        .post-block h2 a:hover {
            color: '.$main_custom_color_primary.';
        }
        .post-block a {
            color: '.$main_custom_color_primary.';
        }
        .post-block .sub-list li:before {
            background: '.$main_custom_color_primary.';
        }
        .post-block .load-more:hover {
            background: '.$main_custom_color_primary.';
            border-color: '.$main_custom_color_primary.';
        }
        .post-block .video-box:before {
            background:'.$main_custom_color_primary.';
        }
        .robotoleak-page .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
            .robotoleak-page .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                color: '.$main_custom_color_primary.';
            }

        .post-block h3 a:hover {
            color: '.$main_custom_color_primary.';
        ';
    wp_add_inline_style( 'roboto-color-style', $color_variation );

  }
add_action('wp_enqueue_scripts', 'roboto_load_theme_assets');


// Enqueue comment-reply script if comments_open and singular
function roboto_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
}
add_action( 'wp_enqueue_scripts', 'roboto_enqueue_comment_reply' );

add_filter('nav_menu_css_class' , 'roboto_special_nav_class' , 10 , 2);
function roboto_special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     global $roboto_options;
     return $classes;
}

add_action( 'tgmpa_register', 'roboto_register_required_plugins' );

function roboto_register_required_plugins() {


    $plugins = array(
        array(
            'name'      => 'CMB2',
            'slug'       => 'cmb2',
            'required'    => true,
        ),
        array(
            'name'      => 'Redux-Framework',
            'slug'       => 'redux-framework',
            'required'    => true,
        ),
        array(
            'name'      => 'MailChimp For Wordpress',
            'slug'       => 'mailchimp-for-wp',
            'required'    => true,
        )
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'roboto' ),
            'menu_title'                      => __( 'Install Plugins', 'roboto' ),
            'installing'                      => __( 'Installing Plugin: %s', 'roboto' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'roboto' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' , 'roboto'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'roboto' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'roboto' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'roboto' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'roboto' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'roboto' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'roboto' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'roboto'), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'roboto' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'roboto' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'roboto' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'roboto' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'roboto' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}


function roboto_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

?>
    <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <div class="holder">
        <div class="img-avatar">
            <img class="img-circle media-object" src="<?php echo get_avatar_url(get_avatar( $comment, $args['avatar_size'] )); ?>" alt="Generic placeholder image">
        </div>
        <div class="text-box">
        <?php if($depth>1): echo '<div class="media">'; else : echo'<div class="media-body">'; endif;?>
            <h3><?php echo get_comment_author_link(); ?>
                <span>- <?php
                            /* translators: 1: date, 2: time */
                            printf( __('%1$s at %2$s','roboto'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)','roboto' ), '  ', '' );
                        ?>
                </span>
            </h3>
            <p><?php comment_text(); ?></p>
            <div class="reply-box"><span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span></div>
            <div class="comment-block">
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','roboto' ); ?></em>
                <br />
            <?php endif; ?>

                <div class="metas">
                    <div class="date">
                        <p><i class="fa fa-calendar"></i> </p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </li>

<?php
}


// BY Rafin

/*====================================*\
    POPULAR POSTS
\*====================================*/

function roboto_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function roboto_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == ''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//For excerpt
function roboto_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'roboto_excerpt_more');

function roboto_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'roboto_excerpt_length', 999 );
// cmb2
function roboto_post_meta() {

    $cmb = new_cmb2_box( array(
        'id'           => 'roboto_post_meta',
        'title'        => 'Post Information',
        'object_types' => array( 'post' ),
    ) );

    $cmb->add_field( array(
        'name' => 'Featured Post',
        'id'   => '_roboto_featured',
        'type' => 'checkbox',
        'desc' => 'Check if post is featured post.',
    ) );

}
add_action( 'cmb2_admin_init', 'roboto_post_meta' );
// roboto leak comment arrange
add_filter( 'comment_form_fields', 'roboto_move_comment_field' );
function roboto_move_comment_field( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}


if ( ! function_exists( 'roboto_load_widgets' ) ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function roboto_load_widgets() {

        register_widget( 'Buzz_Trending_Posts_Widget' );
        // Advanced Recent Posts widget.
        register_widget( 'WEN_Planet_Advanced_Recent_Posts_Widget' );
    }

endif;

add_action( 'widgets_init', 'roboto_load_widgets' );

if ( ! class_exists( 'Buzz_Trending_Posts_Widget' ) ) :

    /**
     * Portfolio widget Class.
     *
     * @since 1.0.0
     */
    class Buzz_Trending_Posts_Widget extends WP_Widget {

        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        function __construct() {
            $opts = array(
                'classname'   => 'roboto_trending_posts_widget',
                'description' => esc_html__( 'Displays Trending Posts. Most suitable for home page.', 'roboto' ),
            );
            parent::__construct( 'roboto-trending', esc_html__( 'Buzz: Trending Posts Widget', 'roboto' ), $opts );
        }

        /**
         * Echo the widget content.
         *
         * @since 1.0.0
         *
         * @param array $args     Display arguments including before_title, after_title,
         *                        before_widget, and after_widget.
         * @param array $instance The settings for the particular instance of the widget.
         */
        function widget( $args, $instance ) {

            $title        = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            $posts_number = ! empty( $instance['posts_number'] ) ? $instance['posts_number'] : 4 ;

            echo $args['before_widget'];

            // Render title.
            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
             $posts_per_page_tranding=3;
                $tranding_args2 = array( 'posts_per_page' => $posts_per_page_tranding ,'meta_key' => 'post_views_count','orderby' => 'meta_value_num','order'=>ASC);
                $tranding_posts2 = new WP_Query( $tranding_args2 );
                if($tranding_posts2->have_posts()): echo '<div id="tranding2">';
                while ( $tranding_posts2->have_posts()) : $tranding_posts2->the_post();
                   ?>
                  <div class="article-box">
                    <div class="img-holder">
                        <?php
                            $thumbnail = get_post_thumbnail_id($post->ID);
                            $img_url = wp_get_attachment_image_src( $thumbnail,'tranding-size');
                            $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                        if($img_url):
                             $url = aq_resize( $img_url[0], $width =300, $height = 170, $crop = true, $single = true, $upscale = true );?>
                            <img src="<?php echo esc_url($url);?>" alt="<?php echo esc_attr($alt);?>">
                        <?php else:?>
                            <img src="<?php echo esc_url( get_template_directory_uri() ).'/assets/images/no-image.png';?>" height="170" width="300" alt="No image">
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
                endwhile; echo'</div>';
                    if($tranding_posts2->found_posts<=$posts_per_page)
                    {
                      $style_tranding="display:none";
                    }
                    $total_post = $tranding_posts->found_posts;
                    $raw_page = $total_post%$posts_per_page;
                    if($raw_page==0){$page_count_raw = $total_post/$posts_per_page; }else{$page_count_raw = $total_post/$posts_per_page+1;}
                       $page_count = floor($page_count_raw);
                              ?>
                    <div class="btn-wrap" id="loadmore_tranding2" style="<?php echo $style_tranding2;?>">
                        <input type="hidden" value="2" id="paged_tranding2">
                        <input type="hidden" value="<?php echo $posts_per_page?>" id="post_per_page_tranding2">
                        <input type="hidden" value="<?php echo $page_count;?>" id="max_paged_tranding2">
                        <a href="javascript:void(0);" class="load-more">Load More</a>
                    </div>
                <?php
                endif;
                wp_reset_postdata();

            echo $args['after_widget'] ;
        }

        /**
         * Update widget instance.
         *
         * @since 1.0.0
         *
         * @param array $new_instance New settings for this instance as input by the user via
         *                            {@see WP_Widget::form()}.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update( $new_instance, $old_instance ) {

            $instance                     = $old_instance;

            $instance['title']            = sanitize_text_field( $new_instance['title'] );
            $instance['posts_number'] = absint( $new_instance['posts_number'] );

            return $instance;
        }

        /**
         * Output the settings update form.
         *
         * @since 1.0.0
         *
         * @param array $instance Current settings.
         */
        function form( $instance ) {

            // Defaults.
            $instance = wp_parse_args( (array) $instance, array(
                'title'            => '',
                'posts_number' => 4,


            ) );

            $title            = esc_attr( $instance['title'] );
            $posts_number = esc_attr( $instance['posts_number'] );

            ?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'roboto' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title ; ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php esc_html_e( 'Number of Portfolios:', 'roboto' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" type="number" value="<?php echo esc_attr( $posts_number ); ?>" style="max-width:65px;" />
            </p>


        <?php
        }


    }

endif;


if ( ! class_exists( 'WEN_Planet_Advanced_Recent_Posts_Widget' ) ) :

    /**
     * Advanced Recent Posts Widget Class
     *
     * @since 1.0.0
     */
    class WEN_Planet_Advanced_Recent_Posts_Widget extends WP_Widget {

        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        function __construct() {
            $opts = array(
                'classname'   => 'wen_planet_widget_advanced_recent_posts',
                'description' => __( 'Advanced Recent Posts Widget. Displays recent posts with thumbnail.', 'roboto' ),
            );

            parent::__construct( 'roboto-advanced-recent-posts', __( 'WEN Planet: Recent Posts', 'roboto' ), $opts );
        }

        /**
         * Echo the widget content.
         *
         * @since 1.0.0
         *
         * @param array $args     Display arguments including before_title, after_title,
         *                        before_widget, and after_widget.
         * @param array $instance The settings for the particular instance of the widget.
         */
        function widget( $args, $instance ) {

            $title             = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            $post_category     = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            if ( absint( $post_category ) > 0  ) {

                $header_args=array(
                'post_type'=>'post',
                'posts_per_page'=>4,
                'orderby' => 'date',
                'order'   => 'DESC',
                'cat' => $post_category,
             );
            }
            else{
            $header_args=array(
                'post_type'=>'post',
                'posts_per_page'=>4,
                'orderby' => 'date',
                'order'   => 'DESC',
                'meta_query' => array(
                    array(
                        'key'     => '_roboto_featured',
                        'value'   => 'on',
                        'compare' => '=',
                    ),
                ),
            );
        }
        $header_query= new WP_Query($header_args);
                $header_query= new WP_Query($header_args);
                if($header_query->have_posts()):$i=1;
                    //echo '<div class="row">';
                        while($header_query->have_posts()):
                            $header_query->the_post(); ?>
                        <?php
                            $thumbnail = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                            if($i==1){
                              $w=449;$h=438;
                            }
                            else{
                              $w=299;$h=438;
                            }
                            if($img_url)

                                $url = aq_resize( $img_url[0], $width =$w, $height = $h, $crop = true, $single = true, $upscale = true );
                                //$url=$img_url[0];
                            else
                                $url=get_template_directory_uri().'/assets/images/no-image.png';
                        if($i==2)
                            echo '<div class="col-sm-12 col-md-8 col-frame">';?>
                            <div class="col-frame <?php echo (($i==1)?'col-sm-12 col-md-4':'col-sm-4');?> col-frame" style="background-image:url(<?php echo esc_url($url);?>);">
                                <div class="col-box">
                                    <div class="overlay">
                                    <span class="cap-btn">
                                  <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?>
                                    </span>
                                    <?php if($i==1):?>
                                        <h1>
                                    <?php else:?>
                                        <h2>
                                    <?php endif;?>
                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                    <?php if($i==1):?>
                                        </h1>
                                    <?php else:?>
                                        </h2>
                                    <?php endif;?>
                                    <ul class="sub-list">
                                    <li><?php _e('by ','roboto');?><?php the_author_posts_link(); ?></li>
                                    <?php if($i==1):?>
                                        <li><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></li>
                                        <li><?php comments_number( '0', '1 comment', '% comments' ); ?></li>
                                    <?php endif;?>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        <?php if($i==4) echo '</div>';
                            $i++;
                        endwhile;
                    //echo '</div>';
                endif;
                wp_reset_postdata();
               ?>
            <?php
            echo $args['after_widget'];

        }

        /**
         * Update widget instance.
         *
         * @since 1.0.0
         *
         * @param array $new_instance New settings for this instance as input by the user via
         *                            {@see WP_Widget::form()}.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']             = sanitize_text_field( $new_instance['title'] );
            $instance['post_category']     = absint( $new_instance['post_category'] );

            return $instance;
        }

        /**
         * Output the settings update form.
         *
         * @since 1.0.0
         *
         * @param array $instance Current settings.
         */
        function form( $instance ) {
            // Defaults.
            $instance = wp_parse_args( (array) $instance, array(
                'title'             => '',
                'post_category'     => '',

            ) );

            $title             = esc_attr( $instance['title'] );
            $post_category     = absint( $instance['post_category'] );


            ?>
            <p>
               <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'roboto' ); ?></label>
               <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Select Category:', 'roboto' ); ?></label>
                <?php
                $cat_args = array(
                    'orderby'         => 'name',
                    'hide_empty'      => 0,
                    'taxonomy'        => 'category',
                    'name'            => $this->get_field_name( 'post_category' ),
                    'id'              => $this->get_field_id( 'post_category' ),
                    'selected'        => $post_category,
                    'show_option_all' => __( 'All Categories','roboto' ),
                );
                wp_dropdown_categories( $cat_args );
                ?>
            </p>
            <?php
        }
    }

endif;