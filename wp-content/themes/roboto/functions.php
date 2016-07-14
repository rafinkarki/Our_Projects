<?php
/**
 * rabto functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

global $rabto_options;

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

function rabto_setup() {

    global $rabto_options;
    // Set content width
    global $content_width;
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

    // Load plugin checker
    require(get_template_directory() . '/inc/plugin-activation.php');

     // Nav Menu (Custom menu support)
    if (function_exists('register_nav_menu')) :
        global $rabto_options;
        register_nav_menu('primary', __('Rabto Primary Menu', 'rabto'));
        register_nav_menu('secondary', __('Rabto Footer Menu', 'rabto'));
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
add_action('after_setup_theme', 'rabto_setup');


function rabto_widgets_setup() {

    global $rabto_options;
    // Widget areas
    if (function_exists('register_sidebar')) :
        // Sidebar right
        register_sidebar(array(
            'name' => __("Post Sidebar Widget Here", 'rabto'),
            'id' => "rabto-post-sidebar",
            'description' => __('Widgets placed here will display in the post detail page', 'rabto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s rabto-addvertisment-space rabto-sidebar-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="rabto-sidebar-widget-title">',
            'after_title'   => '</h3>'
        ));
        
        register_sidebar(array(
            'name' => __("Ad Widget Here", 'rabto'),
            'id' => "rabto-widgets-sidebar",
            'description' => __('Widgets placed here will display in the right sidebar', 'rabto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s rabto-addvertisment-space rabto-sidebar-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="rabto-sidebar-widget-title">',
            'after_title'   => '</h3>'
        ));

        register_sidebar(array(
            'name' => __("Trending Widget Here", 'rabto'),
            'id' => "rabto-trending-sidebar",
            'description' => __('Sidebar for trending posts', 'rabto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s rabto-sidebar-widget rabto-trending-news-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="rabto-sidebar-widget-title">',
            'after_title'   => '</h3>'
        ));
         register_sidebar(array(
            'name' => __("Top Banner Widget Here", 'rabto'),
            'id' => "rabto-banner-sidebar",
            'description' => __('Sidebar for Banner posts', 'rabto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s featured-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<header class="heading"><h2>',
            'after_title'   => '</h2></header>'
        ));
          register_sidebar(array(
            'name' => "Footer Block Widgets Here",
            'id' => "rabto-widgets-footer-block-1",
            'description' => __('Widgets placed here will display in the footer block', 'rabto'),
            'before_widget' => '<div id="%1$s" class="widget %2$s rabto-footer-widget rabto-links-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="rabto-footer-widget-title">',
            'after_title'   => '</h3>'
        ));

    endif;

}
add_action('widgets_init', 'rabto_widgets_setup');


// The excerpt "more" button
function rabto_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','rabto'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','rabto') . '</a>', $text);
}
add_filter('the_excerpt', 'rabto_excerpt');

// wp_title filter
function rabto_title($output) {
    echo $output;
    // Add the blog name
    bloginfo('name');
    // Add the blog description for the home/front page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) echo ' - '.$site_description;
    // Add a page number if necessary
    if (!empty($paged) && ($paged >= 2 || $page >= 2)) echo ' - ' . sprintf(__('Page %s', 'rabto'), max($paged, $page));
}
add_filter('wp_title', 'rabto_title');
add_image_size( 'tranding-size', 170, 300, true );
add_image_size( 'related-posts-thumbnails', 390, 390, true );
/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function rabto_load_theme_assets() {
    global $rabto_options;
    wp_enqueue_style( 'rabto-rabtoleak-font', 'https://fonts.googleapis.com/css?family=Montserrat:400,700%7CRaleway:400,500" rel="stylesheet', '', '' );
    // Enqueue all the theme CSS   
    wp_enqueue_style('rabto-main-css', get_template_directory_uri().'/assets/css/style.css');
    wp_enqueue_style('rabto-color-style', get_template_directory_uri().'/assets/css/color.css');
    wp_enqueue_style( 'rabto-style', get_stylesheet_uri() );
    // Enqueue all the js files of theme
    //wp_enqueue_script('jquery');
    wp_enqueue_script('rabto_jquery-js', get_template_directory_uri().'/assets/js/vendors/jquery.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('rabto_plugins-js', get_template_directory_uri().'/assets/js/plugins.js', array(), FALSE, TRUE);
    wp_enqueue_script('rabto_jquery-main', get_template_directory_uri().'/assets/js/main.js', array(), FALSE, TRUE);
    // custom css append code here

    $inline_css='';
    if(isset($rabto_options['extra-css'])){
    $inline_css.=$rabto_options['extra-css'];
    }
    wp_add_inline_style( 'rabto-style', $inline_css );
    if(isset($rabto_options['typography-body']['font-family']) && $rabto_options['typography-body']['font-family']!=''&& $rabto_options['typography-body']['font-weight']!='') {
    wp_enqueue_style('googlefont-custom', 'http://fonts.googleapis.com/css?family='.esc_attr($rabto_options['typography-body']['font-family']));
    }
    if(isset($rabto_options['typography-h1']['font-family']) && $rabto_options['typography-h1']['font-family']!=''&& $rabto_options['typography-h1']['font-weight']!='') {
    wp_enqueue_style('googlefont-h1', 'http://fonts.googleapis.com/css?family='.esc_attr($rabto_options['typography-h1']['font-family']));
    }
    if(isset($rabto_options['typography-h2']['font-family']) && $rabto_options['typography-h2']['font-family']!=''&& $rabto_options['typography-h2']['font-weight']!='') {
    wp_enqueue_style('googlefont-h2', 'http://fonts.googleapis.com/css?family='.esc_attr($rabto_options['typography-h2']['font-family']));
    }
    if(isset($rabto_options['typography-h3']['font-family']) && $rabto_options['typography-h3']['font-family']!=''&& $rabto_options['typography-h3']['font-weight']!='') {
    wp_enqueue_style('googlefont-h3', 'http://fonts.googleapis.com/css?family='.esc_attr($rabto_options['typography-h3']['font-family']));
    }
    if(isset($rabto_options['typography-h4']['font-family']) && $rabto_options['typography-h4']['font-family']!=''&& $rabto_options['typography-h4']['font-weight']!='') {
    wp_enqueue_style('googlefont-h4', 'http://fonts.googleapis.com/css?family='.esc_attr($rabto_options['typography-h4']['font-family']));
    }
    if(isset($rabto_options['typography-h5']['font-family']) && $rabto_options['typography-h5']['font-family']!=''&& $rabto_options['typography-h5']['font-weight']!='') {
    wp_enqueue_style('googlefont-h5', 'http://fonts.googleapis.com/css?family='.$rabto_options['typography-h5']['font-family']);
    }
    if(isset($rabto_options['typography-h6']['font-family']) && $rabto_options['typography-h6']['font-family']!=''&& $rabto_options['typography-h6']['font-weight']!='') {
    wp_enqueue_style('googlefont-h6', 'http://fonts.googleapis.com/css?family='.$rabto_options['typography-h6']['font-family']);
    }

    // theme color variation code here
    $color_variation ='';
    if(isset($rabto_options['custom_color_primary']) && $rabto_options['custom_color_primary']!=''){
    $main_custom_color_primary= esc_attr($rabto_options['custom_color_primary']);
    } else {
    $main_custom_color_primary= "#ed1c24";
    }
    if(isset($rabto_options['custom_color_hover']) && $rabto_options['custom_color_hover']!=''){
    $main_custom_color_hover= esc_attr($rabto_options['custom_color_hover']);
    } else {
    $main_custom_color_hover= "#c61017";
    }
    $color_variation='

        .rabtoleak-page .top-banner .cap-btn:hover {
            background: '.$main_custom_color_hover.';
        }
        .rabtoleak-page .article-content .cap-btn:hover {
            background: '.$main_custom_color_hover.';
        }

        .rabtoleak-page .article-main .cap-btn:hover {
            background: '.$main_custom_color_hover.';
        }
        .rabtoleak-page .more-info-block .form-control.button:hover {
            background: '.$main_custom_color_hover.';
        }
        .rabtoleak-page .navbar-default .navbar-nav > li > a:hover,
        .rabtoleak-page .navbar-default .navbar-nav > li > a:focus,
        .rabtoleak-page .navbar-default .navbar-nav > .open > a,
        .rabtoleak-page .navbar-default .navbar-nav > .open > a:hover,
        .rabtoleak-page .navbar-default .navbar-nav > .open > a:focus {
            color: '.$main_custom_color_primary.';
        }
        .rabtoleak-page .dropdown-menu > li > a:hover,
        .rabtoleak-page .dropdown-menu > li > a:focus {

            color: '.$main_custom_color_primary.';
        }
        .rabtoleak-page .top-banner .cap-btn {
            background: '.$main_custom_color_primary.';
        }
        .rabtoleak-page .article-content .cap-btn {
            background: '.$main_custom_color_primary.';
        }

        .rabtoleak-page .article-content .cap-btn:hover {
            background: #c61017;
        }

        .rabtoleak-page .article-main .cap-btn {
            background: '.$main_custom_color_primary.';
        }

        .rabtoleak-page .article-main .cap-btn:hover {
            background: #c61017;
        }

        .rabtoleak-page .more-info-block .form-control.button {
            background: '.$main_custom_color_primary.';
        }
        .rabtoleak-page .post-block.category .video-box:before {
            background: '.$main_custom_color_primary.';
        }
        .rabtoleak-page .post-block.search .sub-list a {
            color: '.$main_custom_color_primary.';
        }
        .rabtoleak-page .post-block.search h2 a:hover,
        .rabtoleak-page .post-block.search h3 a:hover,
        .rabtoleak-page .post-block.search h4 a:hover {
            color: '.$main_custom_color_primary.';
        }

        .rabtoleak-page .pagination li.active a {
            background: '.$main_custom_color_primary.';
        }

        .rabtoleak-page .pagination li a:hover {
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
        .rabtoleak-page .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
            .rabtoleak-page .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                color: '.$main_custom_color_primary.';
            }

        .post-block h3 a:hover {
            color: '.$main_custom_color_primary.';
        ';
    wp_add_inline_style( 'rabto-color-style', $color_variation );

  }
add_action('wp_enqueue_scripts', 'rabto_load_theme_assets');


// Enqueue comment-reply script if comments_open and singular
function rabto_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
}
add_action( 'wp_enqueue_scripts', 'rabto_enqueue_comment_reply' );

add_filter('nav_menu_css_class' , 'rabto_special_nav_class' , 10 , 2);
function rabto_special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     global $rabto_options;
     return $classes;
}

add_action( 'tgmpa_register', 'rabto_register_required_plugins' );

function rabto_register_required_plugins() {


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
            'page_title'                      => __( 'Install Required Plugins', 'rabto' ),
            'menu_title'                      => __( 'Install Plugins', 'rabto' ),
            'installing'                      => __( 'Installing Plugin: %s', 'rabto' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'rabto' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' , 'rabto'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'rabto' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'rabto' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'rabto' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'rabto' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'rabto' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'rabto' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'rabto'), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'rabto' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'rabto' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'rabto' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'rabto' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'rabto' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}


function rabto_comment($comment, $args, $depth) {
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
                            printf( __('%1$s at %2$s','rabto'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)','rabto' ), '  ', '' );
                        ?>
                </span>
            </h3>
            <p><?php comment_text(); ?></p>
            <div class="reply-box"><span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span></div>
            <div class="comment-block">
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','rabto' ); ?></em>
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

function rabto_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function rabto_setPostViews($postID) {
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
function rabto_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'rabto_excerpt_more');

function rabto_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'rabto_excerpt_length', 999 );
// cmb2
function rabto_post_meta() {

    $cmb = new_cmb2_box( array(
        'id'           => 'rabto_post_meta',
        'title'        => 'Post Information',
        'object_types' => array( 'post' ),
    ) );

    $cmb->add_field( array(
        'name' => 'Featured Post',
        'id'   => '_rabto_featured',
        'type' => 'checkbox',
        'desc' => 'Check if post is featured post.',
    ) );$cmb->add_field( array(
        'name' => 'Must Post',
        'id'   => '_rabto_must',
        'type' => 'checkbox',
        'desc' => 'Check if post is must read post.',
    ) );

}
add_action( 'cmb2_admin_init', 'rabto_post_meta' );
// rabto leak comment arrange
add_filter( 'comment_form_fields', 'rabto_move_comment_field' );
function rabto_move_comment_field( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}


if ( ! function_exists( 'rabto_load_widgets' ) ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function rabto_load_widgets() {
        // Advanced Recent Posts widget.
        register_widget( 'Rabto_Recent_Posts_Widget' );
    }

endif;

add_action( 'widgets_init', 'rabto_load_widgets' );
if ( ! class_exists( 'Rabto_Recent_Posts_Widget' ) ) :

    /**
     * Advanced Recent Posts Widget Class
     *
     * @since 1.0.0
     */
    class Rabto_Recent_Posts_Widget extends WP_Widget {

        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        function __construct() {
            $opts = array(
                'classname'   => 'rabto_advanced_recent_posts',
                'description' => __( 'Featured Post Widget. Displays recent posts with thumbnail.', 'rabto' ),
            );

            parent::__construct( 'rabto-advanced-recent-posts', __( 'Rabto: Featured Posts', 'rabto' ), $opts );
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
                        'key'     => '_rabto_featured',
                        'value'   => 'on',
                        'compare' => '=',
                    ),
                ),
            );
        }
        $header_query= new WP_Query($header_args);
                $header_query= new WP_Query($header_args);
                if($header_query->have_posts()):$i=1;
                    echo ' <!-- FEATURED NEWS SECTION -->
                            <section class="rabto-featured-news-section">
                                <div class="rabto-featured-news-wrapper">';
                        while($header_query->have_posts()):
                            $header_query->the_post(); ?>
                        <?php
                            $thumbnail = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                            $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                            if($i==1 || $i==2){
                              $w=449;$h=618;
                            }
                            else{
                              $w=449;$h=300;
                            }
                            if($img_url)
                                $url = aq_resize( $img_url[0], $width =$w, $height = $h, $crop = true, $single = true, $upscale = true );
                            else{
                                $url=get_template_directory_uri().'/assets/images/no-image.png';
                                $alt="No Image";
                            }
                        if($i!=4)
                            echo '<div class="rabto-featured-news-column">';?>
                                <div class="rabto-featured-news <?php if($i==3 || $i==4) echo 'rabto-half-height';?>">
                                    <div class="rabto-featured-img">
                                        <img src="<?php echo esc_url($url);?>" alt="<?php echo esc_attr($alt);?>">
                                    </div>
                                    <div class="rabto-news-details">
                                        <span class="rabto-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></span>
                                        <h3 class="rabto-news-post-heading">
                                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                        </h3>
                                        <div class="rabto-news-post-meta">
                                            <span class="rabto-news-post-date"><?php echo date("m.d.y");  ?></span>
                                            <div class="rabto-news-post-author"><?php the_author_posts_link(); ?></div>
                                        </div>
                                    </div>
                                </div>
                        <?php if($i!=3) echo '</div>';
                            $i++;
                        endwhile;
                    echo '</div>
                    </section>';
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Select Category:', 'rabto' ); ?></label>
                <?php
                $cat_args = array(
                    'orderby'         => 'name',
                    'hide_empty'      => 0,
                    'taxonomy'        => 'category',
                    'name'            => $this->get_field_name( 'post_category' ),
                    'id'              => $this->get_field_id( 'post_category' ),
                    'selected'        => $post_category,
                    'show_option_all' => __( 'All Categories','rabto' ),
                );
                wp_dropdown_categories( $cat_args );
                ?>
            </p>
            <?php
        }
    }

endif;
// excerpt
//excerpt max charlenght
function robto_the_excerpt_max_charlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 7 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            return mb_substr( $subex, 0, $excut );
        } else {
            return $subex;
        }
    } else {
        return $excerpt;
    }
}
