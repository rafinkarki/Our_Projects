<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (comments_open()) : ?>
<div id="comments-single" class="clearfix">
    <?php if ( post_password_required() ) : ?>
        <p class="nopassword">
            <?php _e( 'This post is password protected. Enter the password to view any comments.', 'buzz' ); ?>
        </p>
    <?php return; endif;
    $ncom = get_comments_number();
    if ($ncom>0) :
        echo '<header class="heading"><h2>';
        if ($ncom==1) _e('1 ', 'buzz'); else echo sprintf (__('%s ','buzz'), $ncom);
        _e('Comments','buzz');
        echo '</h2></header>';
        if ($ncom >= get_option('comments_per_page') && get_option('page_comments')) : ?>
            <nav id="comment-nav-above">
                <?php paginate_comments_links(); ?>
            </nav>
        <?php endif; ?>
        <div class="comment-list">
            <ul class="comment-reply">
                <?php
                // Comment List
                $args = array (
                    'paged' => true,
                    'avatar_size'       => 54,
                    'callback'=> 'buzz_comment',
                    'style'=> 'ul',

                );
                wp_list_comments($args);
                ?>
            </ul>
        </div>
        <?php if ($ncom >= get_option('comments_per_page') && get_option( 'page_comments' ) ) : ?>
            <nav id="comment-nav-below">
                <?php paginate_comments_links(); ?>
            </nav>
        <?php endif;
     endif; ?>
    <header class="heading" id="heading">
        <h2><?php _e('Leave a reply','buzz'); ?></h2>
    </header><!-- end section title -->
        <?php global $req,$commenter;
        // Comment Form
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields =  array(
            'author' => '<div class="input-wrap"><div class="form-group"><input  id="author" type="text" class="form-control" name="author" placeholder="Name*" value="' . esc_attr( $commenter['comment_author'] ) . '" '. $aria_req . '></div>',
            'email'  => '<div class="form-group"><input id="email" type="text" class="form-control" placeholder="Email*" name="email"  value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' ></div>',
             'website'  => '<div class="form-group"><input id="website" type="text" class="form-control" placeholder="Website" name="website"  value="' . esc_attr(  $commenter['comment_author_website'] ) . '"></div></div>',
        );
        $args = array (
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            'id_form' => 'comments_form',
            'cancel_reply_link'=>'Cancel',
            'id_submit' => 'comment-submit',
            'comment_field' =>  '<div class="form-group"><textarea id="comment" name="comment" cols="30" rows="10" class="form-control" placeholder="Comment*"></textarea></div>',
            'comment_notes_after' => '<div class="btn-wrap"><input type="submit" id="submit" value="Post Comment" class="btn-load"></div>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','buzz'), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink($post->ID) ) ) ) . '</p>',
        );
        comment_form($args);
        //echo str_replace('class="comment-form"','class="reply-form"',ob_get_clean());
        ?>
</div>
<?php endif; ?>