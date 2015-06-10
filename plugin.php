<?php
/**
* Plugin Name: Speaker Bureau
* Plugin URI: http://oliverpincus.com
* Description: This plugin adds some features for a Speaker database.
* Version: 1.0.1
* Author: Oliver Pincus
* Author URI: http://oliverpincus.com
* License: GPL2
*/ 

// Step 1: Adding Custom Post Types

// Register Custom Post Type

function custom_post_type_speaker() {

$labels = array(
		'name'                => _x( 'Speakers', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Speaker', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Speakers', 'text_domain' ),
		'name_admin_bar'      => __( 'Speakers', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Speaker:', 'text_domain' ),
		'all_items'           => __( 'All Speakers', 'text_domain' ),
		'add_new_item'        => __( 'Add New Speaker', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Speaker', 'text_domain' ),
		'edit_item'           => __( 'Edit Speaker', 'text_domain' ),
		'update_item'         => __( 'Update Speaker', 'text_domain' ),
		'view_item'           => __( 'View Speaker', 'text_domain' ),
		'search_items'        => __( 'Search Speaker', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'speaker', 'text_domain' ),
		'description'         => __( 'Speaker', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'taxonomies'          => array( 'category', 'topics', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
        'rewrite' => array( 'slug' => 'speakers' ),
        'supports' => array( 'title', 'editor' ,'genesis-cpt-archives-settings', 'thumbnail' ),
	);
	register_post_type( 'speaker', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_speaker', 0 );

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Topic Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Topic Tool Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Speaker Topics', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
        'rewrite'           => array( 'slug' => 'topics' ),
	);
	register_taxonomy( 'topics', array( 'speaker' ), $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy', 0 );


// Step 2: Add custom fields
// https://github.com/WebDevStudios/CMB2/wiki/Field-Types

function cmb2_speaker_metabox() {

    $cmb = new_cmb2_box( array(
        'id'           => 'cmb2_speaker_metabox',
        'title'        => 'Details',
        'object_types' => array( 'speaker' ),
    ) );

    $cmb->add_field( array(
		'name' => __( 'Firstname', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'firstname',
		'type' => 'text',
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Lastname', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'lastname',
		'type' => 'text',
	) );
   
    $cmb->add_field( array(
		'name' => __( 'Title', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'title',
		'type' => 'text',
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Organization', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'organization',
		'type' => 'text',
	) );
        
    $cmb->add_field( array(
		'name' => __( 'Address', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'cmb_address',
		'type' => 'address',
	) );
    
    
    $cmb->add_field( array(
    'name'    => 'Credentials',
    'desc'    => 'Credentials',
    'id'      => 'credentials',
    'type'    => 'multicheck',
    'options' => array(
        'Ph.D.' => 'Ph.D.',
        'Ed.D.' => 'Ed.D',
        'CPT' => 'CPT',
        'SPHR' => 'SPHR',
        'PHR' => 'PHR',
        'PMP' => 'PMP',
        'CPLP' => 'CPLP',
        'MA' => 'MA',
        'MS' => 'MS',
        'M.Ed.' => 'M.Ed.',
        'MBA' => 'MBA',
        'CDR' => 'CDR',
        'LCDR' => 'LCDR',        
    )
    ) );
    
    $cmb->add_field( array(
		'name' => __( 'Other Credentials', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'othercredentials',
		'type' => 'text',
	) );
        
    $cmb->add_field( array(
		'name' => __( 'Other Credentials', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'othercredentials',
		'type' => 'text',
	) );
    
    $cmb->add_field( array(
    'name' => 'Email',
    'id'   => 'email',
    'type' => 'text_email',
    ) );
   
    $cmb->add_field( array(
    'name' => __( 'Website URL', 'cmb' ),
    'id'   => 'website',
    'type' => 'text_url',
    // 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'LinkedIn URL', 'cmb' ),
    'id'   => 'linkedin',
    'type' => 'text_url',
    // 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'Twitter URL', 'cmb' ),
    'id'   => 'twitter',
    'type' => 'text_url',
    // 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
    ) );
    
    $cmb->add_field( array(
		'name' => __( 'Phone Number', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'phonenumber',
		'type' => 'text',
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Other Languages', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'phonenumber',
		'type' => 'text',
	) );
    
   $cmb->add_field( array(
    'name' => 'International Travel',
    'desc' => '',
    'id'   => 'internationaltravel',
    'type' => 'checkbox'
   ) );
    
    $cmb->add_field( array(
    'name' => 'Webinar',
    'desc' => '',
    'id'   => 'webinar',
    'type' => 'checkbox'
    ) );
    
     $cmb->add_field( array(
    'name' => 'Honorarium',
    'desc' => 'Are you willing to present to chapters with no honorarium?',
    'id'   => 'honorarium',
    'type' => 'checkbox'
    ) );
	
   
	$cmb->add_field( array(
    'name' => 'Topics',
    'desc' => 'Analysis',
    'id'   => 'anl',
    'type' => 'checkbox'	
    ) );
    
	$cmb->add_field( array(
    'name' => 'Measurement and Evaluation',
    'desc' => '',
    'id'   => 'mae',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Instructional Intervention',
    'desc' => '',
    'id'   => 'ini',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Process or Tool Intervention',
    'desc' => '',
    'id'   => 'pit',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Organizational Design Intervention',
    'desc' => '',
    'id'   => 'odi',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'The Business of HPT',
    'desc' => '',
    'id'   => 'hpt',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Research to Practice',
    'desc' => '',
    'id'   => 'rtp',
    'type' => 'checkbox'
    ) );
		
	
    
}
add_action( 'cmb2_init', 'cmb2_speaker_metabox' );

// Step 3: Add Archive Settings option to Books CPT
add_post_type_support( 'speaker', 'genesis-cpt-archives-settings' );

/**
 * Register the form and fields for our front-end submission form
 */
function wds_frontend_form_register() {
	$cmb = new_cmb2_box( array(
		'id'           => 'front-end-post-form',
		'object_types' => array( 'post' ),
		'hookup'       => false,
		'save_fields'  => false,
	) );

      $cmb->add_field( array(
		'name' => __( 'Firstname', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'firstname',
		'type' => 'text',
        'attributes'  => array(
              'required'    => 'required',
        ),
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Lastname', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'lastname',
		'type' => 'text',
	) );
    
       $cmb->add_field( array(
    'name'    => 'Credentials',
    'desc'    => '',
    'id'      => 'credentials',
    'type'    => 'multicheck',
    'options' => array(
        'Ph.D.' => 'Ph.D.',
        'Ed.D.' => 'Ed.D',
        'CPT' => 'CPT',
        'SPHR' => 'SPHR',
        'PHR' => 'PHR',
        'PMP' => 'PMP',
        'CPLP' => 'CPLP',
        'MA' => 'MA',
        'MS' => 'MS',
        'M.Ed.' => 'M.Ed.',
        'MBA' => 'MBA',
        'CDR' => 'CDR',
        'LCDR' => 'LCDR',        
    )
    ) );
    
    $cmb->add_field( array(
		'name' => __( 'Other Credentials', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'othercredentials',
		'type' => 'text',
	) );
        
       
    $cmb->add_field( array(
		'name' => __( 'Title', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'title',
		'type' => 'text',
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Organization', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'organization',
		'type' => 'text',
	) );

	$cmb->add_field( array(
    'name'     => 'Test Taxonomy Multicheck',
    'desc'     => 'Description Goes Here',
    'id'       => 'taxonomy_multicheck',
    'taxonomy' => 'category', //Enter Taxonomy Slug
    'type'     => 'taxonomy_multicheck',
	 'options' => cmb2_get_term_options(),
	) );

	$cmb->add_field( array(
    'name' => 'Analysis',
    'desc' => '',
    'id'   => 'anl',
    'type' => 'checkbox'
    ) );
    
	$cmb->add_field( array(
    'name' => 'Measurement and Evaluation',
    'desc' => '',
    'id'   => 'mae',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Instructional Intervention',
    'desc' => '',
    'id'   => 'ini',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Process or Tool Intervention',
    'desc' => '',
    'id'   => 'pit',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Organizational Design Intervention',
    'desc' => '',
    'id'   => 'odi',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'The Business of HPT',
    'desc' => '',
    'id'   => 'hpt',
    'type' => 'checkbox'
    ) );
	
	$cmb->add_field( array(
    'name' => 'Research to Practice',
    'desc' => '',
    'id'   => 'rtp',
    'type' => 'checkbox'
    ) );
    
	$cmb->add_field( array(
		'name'    => __( 'Description', 'wds-post-submit' ),
		'id'      => 'submitted_post_content',
		'type'    => 'textarea',				
	) );
        
    $cmb->add_field( array(
		'name' => __( 'Address', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'cmb_address',
		'type' => 'address',
	) );
    
   
    $cmb->add_field( array(
    'name' => 'Email',
    'id'   => 'email',
    'type' => 'text_email',
    ) );
   
    $cmb->add_field( array(
    'name' => __( 'Website URL', 'cmb' ),
    'id'   => 'website',
    'type' => 'text_url',
    // 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'LinkedIn URL', 'cmb' ),
    'id'   => 'linkedin',
    'type' => 'text_url',
    // 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'Twitter URL', 'cmb' ),
    'id'   => 'twitter',
    'type' => 'text_url',
    // 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
    ) );
    
    $cmb->add_field( array(
		'name' => __( 'Phone Number', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'phonenumber',
		'type' => 'text',
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Other Languages', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'phonenumber',
		'type' => 'text',
	) );
    
   $cmb->add_field( array(
    'name' => 'International Travel',
    'desc' => __( 'Are you willing to travel international?', 'cmb' ),    
    'id'   => 'internationaltravel',
    'type' => 'checkbox'
   ) );
    
    $cmb->add_field( array(
    'name' => 'Webinar',
    'desc' => 'Are you willing to present your content in a Webinar format?',
    'id'   => 'webinar',
    'type' => 'checkbox'
    ) );
    
    $cmb->add_field( array(
    'name' => 'Honorarium',
    'desc' => 'Are you willing to present to chapters with no honorarium?',
    'id'   => 'honorarium',
    'type' => 'checkbox'
    ) );
    
      $cmb->add_field( array(
        'name'       => __( 'Speaker Photo', 'wds-post-submit' ),
        'id'         => 'submitted_post_thumbnail',
        'type'       => 'text',
        'attributes' => array(
            'type' => 'file', // Let's use a standard file upload field
        ),
    ) );
    
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 1 Full Name', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser1_fullname',
		'type' => 'text',
        'before_row'   => '<br /><p>Provide the name and details of two endorsers and a testomonial from each endorser. The endorsers email and phone number are not publsihed. They are for the vetting process only.</p>',
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 1 eMail', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser1_email',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 1 Organization', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser1_organization',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 1 Presentation Title', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser1_presentationtitle',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 1 Presentation Summary', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser1_presentationsummary',
		'type' => 'textarea'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 1 Date of Presentation', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser1_presentationdate',
		'type' => 'text'        
	) );
    
        
    $cmb->add_field( array(
		'name'    => __( 'Endorser 1 Testomonial Quote', 'cmb' ),
		'id'      => 'endorser1_testimonialquote',
		'type'    => 'textarea',				
	) );
        
    
    
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 2 Full Name', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser2_fullname',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 2 eMail', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser2_email',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 2 Organization', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser2_organization',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 2 Presentation Title', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser2_presentationtitle',
		'type' => 'text'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 2 Presentation Summary', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser2_presentationsummary',
		'type' => 'textarea'        
	) );
    
    $cmb->add_field( array(
		'name' => __( 'Endorser 2 Date of Presentation', 'cmb' ),
		'desc' => __( '', 'cmb' ),
		'id'   => 'endorser2_presentationdate',
		'type' => 'text'        
	) );
    
        
    $cmb->add_field( array(
		'name'    => __( 'Endorser 2 Testomonial Quote', 'cmb' ),
		'id'      => 'endorser2_testimonialquote',
		'type'    => 'textarea',				
	) );

    
    $cmb->add_field( array(
		'name'    => __( 'Title', 'wds-post-submit' ),
		'id'      => 'submitted_post_title',
		'type'    => 'hidden',
		'default' => __( 'name', 'wds-post-submit' )        
	) );
    
	$cmb->add_field( array(
		'name' => __( 'Your Name', 'wds-post-submit' ),
		'desc' => __( 'Please enter your name for author credit on the new post.', 'wds-post-submit' ),
		'id'   => 'submitted_author_name',
		'type' => 'hidden'
	) );


}

add_action( 'cmb2_init', 'wds_frontend_form_register' );

/**
 * Gets the front-end-post-form cmb instance
 *
 * @return CMB2 object
 */
function wds_frontend_cmb2_get() {
	// Use ID of metabox in wds_frontend_form_register
	$metabox_id = 'front-end-post-form';

	// Post/object ID is not applicable since we're using this form for submission
	$object_id  = 'fake-oject-id';

	// Get CMB2 metabox object
	return cmb2_get_metabox( $metabox_id, $object_id );
}

/**
 * Handle the cmb-frontend-form shortcode
 *
 * @param  array  $atts Array of shortcode attributes
 * @return string       Form html
 */
function wds_do_frontend_form_submission_shortcode( $atts = array() ) {

	// Get CMB2 metabox object
	$cmb = wds_frontend_cmb2_get();

	// Get $cmb object_types
	$post_types = $cmb->prop( 'object_types' );

	// Current user
	$user_id = get_current_user_id();

	// Parse attributes
	$atts = shortcode_atts( array(
		'post_author' => $user_id ? $user_id : 1, // Current user, or admin
		'post_status' => 'pending',
		'post_type'   => reset( $post_types ), // Only use first object_type in array
	), $atts, 'cmb-frontend-form' );

	/*
	 * Let's add these attributes as hidden fields to our cmb form
	 * so that they will be passed through to our form submission
	 */
	foreach ( $atts as $key => $value ) {
		$cmb->add_hidden_field( array(
			'field_args'  => array(
				'id'    => "atts[$key]",
				'type'  => 'hidden',
				'default' => $value,
			),
		) );
	}

	// Initiate our output variable
	$output = '';

	// Get any submission errors
	if ( ( $error = $cmb->prop( 'submission_error' ) ) && is_wp_error( $error ) ) {
		// If there was an error with the submission, add it to our ouput.
		$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'wds-post-submit' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</h3>';
	}

	// If the post was submitted successfully, notify the user.
	if ( isset( $_GET['post_submitted'] ) && ( $post = get_post( absint( $_GET['post_submitted'] ) ) ) ) {

		// Get submitter's name
		$name = get_post_meta( $post->ID, 'submitted_author_name', 1 );
		$name = $name ? ' '. $name : '';

		// Add notice of submission to our output
		$output .= '<h3>' . sprintf( __( 'Thank you%s, your new post has been submitted and is pending review by a site administrator.', 'wds-post-submit' ), esc_html( $name ) ) . '</h3>';
	}

	// Get our form
	$output .= cmb2_get_metabox_form( $cmb, 'fake-oject-id', array( 'save_button' => __( 'Submit Post', 'wds-post-submit' ) ) );

	return $output;
}
add_shortcode( 'cmb-frontend-form', 'wds_do_frontend_form_submission_shortcode' );

/**
 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
 *
 * @return void
 */
function wds_handle_frontend_new_post_form_submission() {

	// If no form submission, bail
	if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
		return false;
	}

	// Get CMB2 metabox object
	$cmb = wds_frontend_cmb2_get();

	$post_data = array();

	// Get our shortcode attributes and set them as our initial post_data args
	if ( isset( $_POST['atts'] ) ) {
		foreach ( (array) $_POST['atts'] as $key => $value ) {
			$post_data[ $key ] = sanitize_text_field( $value );
		}
		unset( $_POST['atts'] );
	}

	// Check security nonce
	if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
	}

	
    // Check title submitted
    
    
    
	if ( empty( $_POST['submitted_post_title'] ) ) {
	    return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'New post requires a title!!!.' ) ) );
        //$_POST['submitted_post_title'] = $sanitized_values['lastname'];    
    }
        
    // And that the title is not the default title
	if ( $cmb->get_field( 'submitted_post_title' )->default() == $_POST['submitted_post_title'] ) {
		//return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Please enter a new title.' ) ) );
	}
    
        
	/**
	 * Fetch sanitized values
	 */
	$sanitized_values = $cmb->get_sanitized_values( $_POST );

	// Set our post data arguments
    
    
    if ( $_POST['submitted_post_title'] == 'name') {
	    $post_data['post_title']   = $sanitized_values['lastname'] . ', ' . $sanitized_values['firstname'];
        $post_data['submitted_author_name']   = $sanitized_values['firstname'] . ' ' . $sanitized_values['lastname'];        	
    }
    else {
        $post_data['post_title']   = $sanitized_values['submitted_post_title'];
    }
		 
    
    unset( $sanitized_values['submitted_post_title'] );
	$post_data['post_content'] = $sanitized_values['submitted_post_content'];
	unset( $sanitized_values['submitted_post_content'] );

	
	// Create the new post
	$new_submission_id = wp_insert_post( $post_data, true );

	// An array of IDs of categories we to add to this post.
	// $cat_ids = array_map( 'intval', $cat_ids );
	// $cat_ids = array_unique( $cat_ids );
		
	$cat_ids = array( 1 );
	// Add these categories, note the last argument is true.
	$term_taxonomy_ids = wp_set_object_terms( $new_submission_id, $cat_ids, 'category', true );
	
	$cat_ids = array( 4,6 );
	$term_taxonomy_ids = wp_set_object_terms( $new_submission_id, $cat_ids, 'topics', true );
		
	// If we hit a snag, update the user
	if ( is_wp_error( $new_submission_id ) ) {
		return $cmb->prop( 'submission_error', $new_submission_id );
	}

	/**
	 * Other than post_type and post_status, we want
	 * our uploaded attachment post to have the same post-data
	 */
	unset( $post_data['post_type'] );
	unset( $post_data['post_status'] );
	
	// Try to upload the featured image
	$img_id = wds_frontend_form_photo_upload( $new_submission_id, $post_data );

	// If our photo upload was successful, set the featured image
	if ( $img_id && ! is_wp_error( $img_id ) ) {
		set_post_thumbnail( $new_submission_id, $img_id );
	}

	// Loop through remaining (sanitized) data, and save to post-meta
	foreach ( $sanitized_values as $key => $value ) {
		update_post_meta( $new_submission_id, $key, $value );
	}

    $multiple_recipients = array(
         $sanitized_values['email']
        );
        $subj = 'Thanks for your Speaker Submission';
        $body = 'Dear ' .$sanitized_values['firstname'] . ",\n\n" .  'Thanks for your submission.';
        wp_mail( $multiple_recipients, $subj, $body );
    
            
    $multiple_recipients = array(
        'oliver@oliverpincus.com',
        'oliver@xlearnlab.net'
        );
        $subj = 'The email subject';
        $body = 'This is the body of the email';
        wp_mail( $multiple_recipients, $subj, $body );
    
    
    
    
	/*
	 * Redirect back to the form page with a query variable with the new post ID.
	 * This will help double-submissions with browser refreshes
	 */
	wp_redirect( esc_url_raw( add_query_arg( 'post_submitted', $new_submission_id ) ) );
	exit;
}
add_action( 'cmb2_after_init', 'wds_handle_frontend_new_post_form_submission' );

/**
 * Handles uploading a file to a WordPress post
 *
 * @param  int   $post_id              Post ID to upload the photo to
 * @param  array $attachment_post_data Attachement post-data array
 */
function wds_frontend_form_photo_upload( $post_id, $attachment_post_data = array() ) {
	// Make sure the right files were submitted
	if (
		empty( $_FILES )
		|| ! isset( $_FILES['submitted_post_thumbnail'] )
		|| isset( $_FILES['submitted_post_thumbnail']['error'] ) && 0 !== $_FILES['submitted_post_thumbnail']['error']
	) {
		return;
	}

	// Filter out empty array values
	$files = array_filter( $_FILES['submitted_post_thumbnail'] );

	// Make sure files were submitted at all
	if ( empty( $files ) ) {
		return;
	}

	// Make sure to include the WordPress media uploader API if it's not (front-end)
	if ( ! function_exists( 'media_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
	}

	// Upload the file and send back the attachment post ID
	return media_handle_upload( 'submitted_post_thumbnail', $post_id, $attachment_post_data );
}

/*
 * Plugin Name: CMB2 Custom Field Type - Address
 * Description: Makes available an 'address' CMB2 Custom Field Type. Based on https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types#example-4-multiple-inputs-one-field-lets-create-an-address-field
 * Author: jtsternberg
 * Author URI: http://dsgnwrks.pro
 * Version: 0.1.0
 */

/**
 * Template tag for displaying an address from the CMB2 address field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'address' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function jt_cmb2_address_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_address_field( $metakey, $post_id );
}

/**
 * Template tag for returning an address from the CMB2 address field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'address' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function jt_cmb2_get_address_field( $metakey, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$address = get_post_meta( $post_id, $metakey, 1 );

	// Set default values for each address key
	$address = wp_parse_args( $address, array(
		'address-1' => '',
		'address-2' => '',
		'city'      => '',
		'state'     => '',
		'zip'       => '',
        'country'   => '',
	) );

	$address = '<div class="cmb2-address">';
	$address .= '<p><strongAddress:</strong> ' . esc_html( $address['address-1'] ) . '</p>';
	if ( $address['address-2'] ) {
		$address .= '<p>' . esc_html( $address['address-2'] ) . '</p>';
	}
	$address .= '<p><strong>City:</strong> ' . esc_html( $address['city'] ) . '</p>';
	$address .= '<p><strong>State:</strong> ' . esc_html( $address['state'] ) . '</p>';
	$address .= '<p><strong>Zip:</strong> ' . esc_html( $address['zip'] ) . '</p>';
    $address .= '<p><strong>Country:</strong> ' . esc_html( $address['country'] ) . '</p>';
	$address = '</div><!-- .cmb2-address -->';

	return apply_filters( 'jt_cmb2_get_address_field', $address );
}

/**
 * Render 'address' custom field type
 *
 * @since 0.1.0
 *
 * @param array  $field              The passed in `CMB2_Field` object
 * @param mixed  $value              The value of this field escaped.
 *                                   It defaults to `sanitize_text_field`.
 *                                   If you need the unescaped value, you can access it
 *                                   via `$field->value()`
 * @param int    $object_id          The ID of the current object
 * @param string $object_type        The type of object you are working with.
 *                                   Most commonly, `post` (this applies to all post-types),
 *                                   but could also be `comment`, `user` or `options-page`.
 * @param object $field_type_object  The `CMB2_Types` object
 */
function jt_cmb2_render_address_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	// can override via the field options param
	$select_text = esc_html( $field_type_object->_text( 'address_select_state_text', 'Select a State' ) );

	$state_list = array( ''=>$select_text,'AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming' );

    
    // can override via the field options param
	$select_text = esc_html( $field_type_object->_text( 'address_select_country_text', 'Select a country' ) );

	$country_list = array( ''=>$select_text,                         
      "US" => "United States",
      "GB" => "United Kingdom",
      "AF" => "Afghanistan",
      "AL" => "Albania",
      "DZ" => "Algeria",
      "AS" => "American Samoa",
      "AD" => "Andorra",
      "AO" => "Angola",
      "AI" => "Anguilla",
      "AQ" => "Antarctica",
      "AG" => "Antigua And Barbuda",
      "AR" => "Argentina",
      "AM" => "Armenia",
      "AW" => "Aruba",
      "AU" => "Australia",
      "AT" => "Austria",
      "AZ" => "Azerbaijan",
      "BS" => "Bahamas",
      "BH" => "Bahrain",
      "BD" => "Bangladesh",
      "BB" => "Barbados",
      "BY" => "Belarus",
      "BE" => "Belgium",
      "BZ" => "Belize",
      "BJ" => "Benin",
      "BM" => "Bermuda",
      "BT" => "Bhutan",
      "BO" => "Bolivia",
      "BA" => "Bosnia And Herzegowina",
      "BW" => "Botswana",
      "BV" => "Bouvet Island",
      "BR" => "Brazil",
      "IO" => "British Indian Ocean Territory",
      "BN" => "Brunei Darussalam",
      "BG" => "Bulgaria",
      "BF" => "Burkina Faso",
      "BI" => "Burundi",
      "KH" => "Cambodia",
      "CM" => "Cameroon",
      "CA" => "Canada",
      "CV" => "Cape Verde",
      "KY" => "Cayman Islands",
      "CF" => "Central African Republic",
      "TD" => "Chad",
      "CL" => "Chile",
      "CN" => "China",
      "CX" => "Christmas Island",
      "CC" => "Cocos (Keeling) Islands",
      "CO" => "Colombia",
      "KM" => "Comoros",
      "CG" => "Congo",
      "CD" => "Congo, The Democratic Republic Of The",
      "CK" => "Cook Islands",
      "CR" => "Costa Rica",
      "CI" => "Cote D'Ivoire",
      "HR" => "Croatia (Local Name: Hrvatska)",
      "CU" => "Cuba",
      "CY" => "Cyprus",
      "CZ" => "Czech Republic",
      "DK" => "Denmark",
      "DJ" => "Djibouti",
      "DM" => "Dominica",
      "DO" => "Dominican Republic",
      "TP" => "East Timor",
      "EC" => "Ecuador",
      "EG" => "Egypt",
      "SV" => "El Salvador",
      "GQ" => "Equatorial Guinea",
      "ER" => "Eritrea",
      "EE" => "Estonia",
      "ET" => "Ethiopia",
      "FK" => "Falkland Islands (Malvinas)",
      "FO" => "Faroe Islands",
      "FJ" => "Fiji",
      "FI" => "Finland",
      "FR" => "France",
      "FX" => "France, Metropolitan",
      "GF" => "French Guiana",
      "PF" => "French Polynesia",
      "TF" => "French Southern Territories",
      "GA" => "Gabon",
      "GM" => "Gambia",
      "GE" => "Georgia",
      "DE" => "Germany",
      "GH" => "Ghana",
      "GI" => "Gibraltar",
      "GR" => "Greece",
      "GL" => "Greenland",
      "GD" => "Grenada",
      "GP" => "Guadeloupe",
      "GU" => "Guam",
      "GT" => "Guatemala",
      "GN" => "Guinea",
      "GW" => "Guinea-Bissau",
      "GY" => "Guyana",
      "HT" => "Haiti",
      "HM" => "Heard And Mc Donald Islands",
      "VA" => "Holy See (Vatican City State)",
      "HN" => "Honduras",
      "HK" => "Hong Kong",
      "HU" => "Hungary",
      "IS" => "Iceland",
      "IN" => "India",
      "ID" => "Indonesia",
      "IR" => "Iran (Islamic Republic Of)",
      "IQ" => "Iraq",
      "IE" => "Ireland",
      "IL" => "Israel",
      "IT" => "Italy",
      "JM" => "Jamaica",
      "JP" => "Japan",
      "JO" => "Jordan",
      "KZ" => "Kazakhstan",
      "KE" => "Kenya",
      "KI" => "Kiribati",
      "KP" => "Korea, Democratic People's Republic Of",
      "KR" => "Korea, Republic Of",
      "KW" => "Kuwait",
      "KG" => "Kyrgyzstan",
      "LA" => "Lao People's Democratic Republic",
      "LV" => "Latvia",
      "LB" => "Lebanon",
      "LS" => "Lesotho",
      "LR" => "Liberia",
      "LY" => "Libyan Arab Jamahiriya",
      "LI" => "Liechtenstein",
      "LT" => "Lithuania",
      "LU" => "Luxembourg",
      "MO" => "Macau",
      "MK" => "Macedonia, Former Yugoslav Republic Of",
      "MG" => "Madagascar",
      "MW" => "Malawi",
      "MY" => "Malaysia",
      "MV" => "Maldives",
      "ML" => "Mali",
      "MT" => "Malta",
      "MH" => "Marshall Islands",
      "MQ" => "Martinique",
      "MR" => "Mauritania",
      "MU" => "Mauritius",
      "YT" => "Mayotte",
      "MX" => "Mexico",
      "FM" => "Micronesia, Federated States Of",
      "MD" => "Moldova, Republic Of",
      "MC" => "Monaco",
      "MN" => "Mongolia",
      "MS" => "Montserrat",
      "MA" => "Morocco",
      "MZ" => "Mozambique",
      "MM" => "Myanmar",
      "NA" => "Namibia",
      "NR" => "Nauru",
      "NP" => "Nepal",
      "NL" => "Netherlands",
      "AN" => "Netherlands Antilles",
      "NC" => "New Caledonia",
      "NZ" => "New Zealand",
      "NI" => "Nicaragua",
      "NE" => "Niger",
      "NG" => "Nigeria",
      "NU" => "Niue",
      "NF" => "Norfolk Island",
      "MP" => "Northern Mariana Islands",
      "NO" => "Norway",
      "OM" => "Oman",
      "PK" => "Pakistan",
      "PW" => "Palau",
      "PA" => "Panama",
      "PG" => "Papua New Guinea",
      "PY" => "Paraguay",
      "PE" => "Peru",
      "PH" => "Philippines",
      "PN" => "Pitcairn",
      "PL" => "Poland",
      "PT" => "Portugal",
      "PR" => "Puerto Rico",
      "QA" => "Qatar",
      "RE" => "Reunion",
      "RO" => "Romania",
      "RU" => "Russian Federation",
      "RW" => "Rwanda",
      "KN" => "Saint Kitts And Nevis",
      "LC" => "Saint Lucia",
      "VC" => "Saint Vincent And The Grenadines",
      "WS" => "Samoa",
      "SM" => "San Marino",
      "ST" => "Sao Tome And Principe",
      "SA" => "Saudi Arabia",
      "SN" => "Senegal",
      "SC" => "Seychelles",
      "SL" => "Sierra Leone",
      "SG" => "Singapore",
      "SK" => "Slovakia (Slovak Republic)",
      "SI" => "Slovenia",
      "SB" => "Solomon Islands",
      "SO" => "Somalia",
      "ZA" => "South Africa",
      "GS" => "South Georgia, South Sandwich Islands",
      "ES" => "Spain",
      "LK" => "Sri Lanka",
      "SH" => "St. Helena",
      "PM" => "St. Pierre And Miquelon",
      "SD" => "Sudan",
      "SR" => "Suriname",
      "SJ" => "Svalbard And Jan Mayen Islands",
      "SZ" => "Swaziland",
      "SE" => "Sweden",
      "CH" => "Switzerland",
      "SY" => "Syrian Arab Republic",
      "TW" => "Taiwan",
      "TJ" => "Tajikistan",
      "TZ" => "Tanzania, United Republic Of",
      "TH" => "Thailand",
      "TG" => "Togo",
      "TK" => "Tokelau",
      "TO" => "Tonga",
      "TT" => "Trinidad And Tobago",
      "TN" => "Tunisia",
      "TR" => "Turkey",
      "TM" => "Turkmenistan",
      "TC" => "Turks And Caicos Islands",
      "TV" => "Tuvalu",
      "UG" => "Uganda",
      "UA" => "Ukraine",
      "AE" => "United Arab Emirates",
      "UM" => "United States Minor Outlying Islands",
      "UY" => "Uruguay",
      "UZ" => "Uzbekistan",
      "VU" => "Vanuatu",
      "VE" => "Venezuela",
      "VN" => "Viet Nam",
      "VG" => "Virgin Islands (British)",
      "VI" => "Virgin Islands (U.S.)",
      "WF" => "Wallis And Futuna Islands",
      "EH" => "Western Sahara",
      "YE" => "Yemen",
      "YU" => "Yugoslavia",
      "ZM" => "Zambia",
      "ZW" => "Zimbabwe"                         
      );

    
	// make sure we specify each part of the value we need.
	$value = wp_parse_args( $value, array(
		'city'      => '',
		'state'     => '',
		'country'   => '',
	) );

	$state_options = '';
	foreach ( $state_list as $abrev => $state ) {
		$state_options .= '<option value="'. $abrev .'" '. selected( $value['state'], $abrev, false ) .'>'. $state .'</option>';
	}
    
    $country_options = '';
	foreach ( $country_list as $abrev => $country ) {
		$country_options .= '<option value="'. $abrev .'" '. selected( $value['country'], $abrev, false ) .'>'. $country .'</option>';
	}


	?>
	
	<div class="adr"><p><label for="<?php echo $field_type_object->_id( '_city' ); ?>'"><?php echo esc_html( $field_type_object->_text( 'address_city_text', 'City' ) ); ?></label></p>
		<?php echo $field_type_object->input( array(
			'class' => 'cmb_text_small',
			'name'  => $field_type_object->_name( '[city]' ),
			'id'    => $field_type_object->_id( '_city' ),
			'value' => $value['city'],
		) ); ?>
	</div>
	<div class="adr"><p><label for="<?php echo $field_type_object->_id( '_state' ); ?>'"><?php echo esc_html( $field_type_object->_text( 'address_state_text', 'State' ) ); ?></label></p>
		<?php echo $field_type_object->select( array(
			'name'    => $field_type_object->_name( '[state]' ),
			'id'      => $field_type_object->_id( '_state' ),
			'options' => $state_options,
		) ); ?>
	</div>
    
    <div class="adr"><p><label for="<?php echo $field_type_object->_id( '_country' ); ?>'"><?php echo esc_html( $field_type_object->_text( 'address_country_text', 'Country' ) ); ?></label></p>
		<?php echo $field_type_object->select( array(
			'name'    => $field_type_object->_name( '[country]' ),
			'id'      => $field_type_object->_id( '_country' ),
			'options' => $country_options,
		) ); ?>
	</div>
	<?php
	echo $field_type_object->_desc( true );

}
add_filter( 'cmb2_render_address', 'jt_cmb2_render_address_field_callback', 10, 5 );


/**
 * The following snippets are required for allowing the address field
 * to work as a repeatable field, or in a repeatable group
 */

function cmb2_sanitize_address_field( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {

	// if not repeatable, bail out.
	if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
		return $check;
	}

	foreach ( $meta_value as $key => $val ) {
		$meta_value[ $key ] = array_map( 'sanitize_text_field', $val );
	}

	return $meta_value;
}
add_filter( 'cmb2_sanitize_address', 'cmb2_sanitize_address_field', 10, 5 );

function cmb2_types_esc_address_field( $check, $meta_value, $field_args, $field_object ) {
	// if not repeatable, bail out.
	if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
		return $check;
	}

	foreach ( $meta_value as $key => $val ) {
		$meta_value[ $key ] = array_map( 'esc_attr', $val );
	}

	return $meta_value;
}
add_filter( 'cmb2_types_esc_address', 'cmb2_types_esc_address_field', 10, 4 );


add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );

    /**
     * Add stylesheet to the page
     */
    function safely_add_stylesheet() {
        wp_enqueue_style( 'prefix-style', plugins_url('style.css', __FILE__) );
    }	
