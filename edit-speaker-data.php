<?php
/**
 * Template Name: Edit Speaker Profile
 
 * @author Oliver Pincus
 * @link http://opincus.com
 * @uses TML
 */

//* Full page
add_action( 'genesis_meta', 'op_force_layout' );
function op_force_layout() {
    add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
}

//* Remove the post content (requires HTML5 theme support)
if (!is_user_logged_in() )
    remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Reposition Breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content', 'genesis_do_breadcrumbs' );

//* Remove the entry header markup (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_post_meta' );

    
if (!is_user_logged_in() )
add_action( 'genesis_entry_content', 'op_custom_post_content' );

function op_custom_post_content() {
echo '<p>Welcome!</p>';
echo 'To submit your speaker details and presentations you need to register. If you do not have an account, click <a href="http://wp.xlearnlab.net/speakers/register/">here</a>.</p>';
echo 'If you do have an account, click <a href="http://wp.xlearnlab.net/speakers/login/">here</a> to log in.</p>';    
}

//* To remove empty markup, '<p class="entry-meta"></p>' for entries that have not been assigned to any Genre
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_footer', 'sk_custom_post_meta' );

//* Run the Genesis loop
genesis();