<?php
require_once("../../../../wp-load.php");
global $wpdb;
$html="";$height="";$width="";
$paged=$_POST['paged'];
if($_POST['action_type'] == 'loadmore' || $_POST['action_type'] == 'loadmore_tranding'|| $_POST['action_type'] == 'loadmore_tranding2'){
    if($_POST['action_type'] == 'loadmore'){
     $posts_per_page=10; $h='136';$w='205';$class='article-block';
    }
    if($_POST['action_type'] == 'loadmore_tranding'||$_POST['action_type'] == 'loadmore_tranding2') {
      $posts_per_page=3;$h='170';$w='300';$class='article-box';
    }
    $args_ajax = array(
        'posts_per_page'   => $posts_per_page,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'paged' => $paged,
        'post_type'        => 'post',

    );
    $query_ajax = new WP_Query($args_ajax);
    while($query_ajax->have_posts()): $query_ajax->the_post();
        $image=wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full');
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
        $categories = get_the_category();
        $separator = ' / ';
        $output = '';
        if ( ! empty( $categories ) ) {
            foreach( $categories as $category ) {
                $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'buzz' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
            }
        }
        if($image){
          $url = aq_resize( $image[0], $width =$w, $height = $h, $crop = true, $single = true, $upscale = true );
          $text=$alt;
        }
        else{
          $url=get_template_directory_uri().'/assets/images/no-image.png';
          $text='No Image';
        }
        $html='<div class="'.$class.'"><div class="img-holder"><img src="'.esc_url($url).'" alt="'.esc_attr($text).'"></div><div class="text-block"><h2><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2><p>'.get_the_excerpt().'</p><ul class="sub-list"><li>'.trim( $output, $separator ).'</li><li><time datetime="'.get_the_date('Y-m-d').'">'.get_the_date("m.d.y").'</time></li><li>'.get_the_author_posts_link().'</li></ul></div></div>';

    endwhile;
    echo $html;
    wp_reset_postdata();
}