<?php
/**
 * Post Type Functions
 *
 * @package     FFW
 * @subpackage  Functions
 * @copyright   Copyright (c) 2013, Fifty and Fifty
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers and sets up the Downloads custom post type
 *
 * @since 1.0
 * @return void
 */
function setup_ffw_faqs_post_types() {
	global $ffw_faqs_settings;
	
	$archives = defined( 'FFW_FAQS_DISABLE_ARCHIVE' ) && FFW_FAQS_DISABLE_ARCHIVE ? false : true;

	//Check to see if anything is set in the settings area.
	if( !empty( $ffw_faqs_settings['faq_slug'] ) ) {
	    $slug = defined( 'FFW_FAQS_SLUG' ) ? FFW_FAQS_SLUG : $ffw_faqs_settings['faq_slug'];
	} else {
	    $slug = defined( 'FFW_FAQS_SLUG' ) ? FFW_FAQS_SLUG : 'faqs';
	}
	
	$rewrite  = defined( 'FFW_FAQS_DISABLE_REWRITE' ) && FFW_FAQS_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$faq_labels =  apply_filters( 'ffw_faq_labels', array(
		'name' 				=> '%2$s',
		'singular_name' 	=> '%1$s',
		'add_new' 			=> __( 'Add New', 'ffw_faqs' ),
		'add_new_item' 		=> __( 'Add New %1$s', 'ffw_faqs' ),
		'edit_item' 		=> __( 'Edit %1$s', 'ffw_faqs' ),
		'new_item' 			=> __( 'New %1$s', 'ffw_faqs' ),
		'all_items' 		=> __( 'All %2$s', 'ffw_faqs' ),
		'view_item' 		=> __( 'View %1$s', 'ffw_faqs' ),
		'search_items' 		=> __( 'Search %2$s', 'ffw_faqs' ),
		'not_found' 		=> __( 'No %2$s found', 'ffw_faqs' ),
		'not_found_in_trash'=> __( 'No %2$s found in Trash', 'ffw_faqs' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( '%2$s', 'ffw_faqs' )
	) );

	foreach ( $faq_labels as $key => $value ) {
	   $faq_labels[ $key ] = sprintf( $value, ffw_faqs_get_label_singular(), ffw_faqs_get_label_plural() );
	}

	$faq_args = array(
		'labels' 			=> $faq_labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'menu_icon'         => 'dashicons-editor-help',
		'query_var' 		=> true,
		'rewrite' 			=> $rewrite,
		'map_meta_cap'      => true,
		'has_archive' 		=> $archives,
		'show_in_nav_menus'	=> true,
		'hierarchical' 		=> false,
		'supports' 			=> apply_filters( 'ffw_faqs_supports', array( 'title', 'editor', 'excerpt', 'thumbnail' ) ),
	);
	register_post_type( 'ffw_faqs', apply_filters( 'ffw_faqs_post_type_args', $faq_args ) );
	
}
add_action( 'init', 'setup_ffw_faqs_post_types', 1 );

/**
 * Get Default Labels
 *
 * @since 1.0.8.3
 * @return array $defaults Default labels
 */
function ffw_faqs_get_default_labels() {
	global $ffw_faqs_settings;

	if( !empty( $ffw_faqs_settings['faq_label_plural'] ) || !empty( $ffw_faqs_settings['faq_label_singular'] ) ) {
	    $defaults = array(
	       'singular' => $ffw_faqs_settings['faq_label_singular'],
	       'plural' => $ffw_faqs_settings['faq_label_plural']
	    );
	 } else {
		$defaults = array(
		   'singular' => __( 'FAQ', 'ffw_faqs' ),
		   'plural' => __( 'FAQs', 'ffw_faqs')
		);
	}
	
	return apply_filters( 'ffw_faqs_default_name', $defaults );

}

/**
 * Get Singular Label
 *
 * @since 1.0.8.3
 * @return string $defaults['singular'] Singular label
 */
function ffw_faqs_get_label_singular( $lowercase = false ) {
	$defaults = ffw_faqs_get_default_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0.8.3
 * @return string $defaults['plural'] Plural label
 */
function ffw_faqs_get_label_plural( $lowercase = false ) {
	$defaults = ffw_faqs_get_default_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

/**
 * Change default "Enter title here" input
 *
 * @since 1.4.0.2
 * @param string $title Default title placeholder text
 * @return string $title New placeholder text
 */
function ffw_faqs_change_default_title( $title ) {
     $screen = get_current_screen();

     if  ( 'ffw_faqs' == $screen->post_type ) {
     	$label = 'question';
        $title = sprintf( __( 'Enter %s here', 'ffw_faqs' ), $label );
     }

     return $title;
}
add_filter( 'enter_title_here', 'ffw_faqs_change_default_title' );

/**
 * Registers the custom taxonomies for the downloads custom post type
 *
 * @since 1.0
 * @return void
*/
function ffw_faqs_setup_taxonomies() {

	$slug     = defined( 'FFW_FAQS_SLUG' ) ? FFW_FAQS_SLUG : 'staff';

	/** Topics */
	$topic_labels = array(
		'name' 				=> sprintf( _x( '%s Topics', 'taxonomy general name', 'ffw_faqs' ), ffw_faqs_get_label_singular() ),
		'singular_name' 	=> _x( 'Topic', 'taxonomy singular name', 'ffw_faqs' ),
		'search_items' 		=> __( 'Search Topics', 'ffw_faqs'  ),
		'all_items' 		=> __( 'All Topics', 'ffw_faqs'  ),
		'parent_item' 		=> __( 'Parent Topic', 'ffw_faqs'  ),
		'parent_item_colon' => __( 'Parent Topic:', 'ffw_faqs'  ),
		'edit_item' 		=> __( 'Edit Topic', 'ffw_faqs'  ),
		'update_item' 		=> __( 'Update Topic', 'ffw_faqs'  ),
		'add_new_item' 		=> __( 'Add New Topic', 'ffw_faqs'  ),
		'new_item_name' 	=> __( 'New Topic Name', 'ffw_faqs'  ),
		'menu_name' 		=> __( 'Topics', 'ffw_faqs'  ),
	);

	$topic_args = apply_filters( 'topic_args', array(
			'hierarchical' 		=> true,
			'labels' 			=> apply_filters('ffw_faqs_topic_labels', $topic_labels),
			'show_ui' 			=> true,
			'query_var' 		=> 'faq_topics',
			'rewrite' 			=> array('slug' => $slug . '/topic', 'with_front' => false, 'hierarchical' => true ),
			'capabilities'  	=> array( 'manage_terms','edit_terms', 'assign_terms', 'delete_terms' ),
			'show_admin_column'	=> true
		)
	);
	register_taxonomy( 'faq_topics', array('ffw_faqs'), $topic_args );
	register_taxonomy_for_object_type( 'faq_topics', 'ffw_faqs' );

}
add_action( 'init', 'ffw_faqs_setup_taxonomies', 0 );



/**
 * Updated Messages
 *
 * Returns an array of with all updated messages.
 *
 * @since 1.0
 * @param array $messages Post updated message
 * @return array $messages New post updated messages
 */
function ffw_faqs_updated_messages( $messages ) {
	global $post, $post_ID;

	$url1 = '<a href="' . get_permalink( $post_ID ) . '">';
	$url2 = ffw_faqs_get_label_singular();
	$url3 = '</a>';

	$messages['ffw_faqs'] = array(
		1 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'ffw_faqs' ), $url1, $url2, $url3 ),
		4 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'ffw_faqs' ), $url1, $url2, $url3 ),
		6 => sprintf( __( '%2$s published. %1$sView %2$s%3$s.', 'ffw_faqs' ), $url1, $url2, $url3 ),
		7 => sprintf( __( '%2$s saved. %1$sView %2$s%3$s.', 'ffw_faqs' ), $url1, $url2, $url3 ),
		8 => sprintf( __( '%2$s submitted. %1$sView %2$s%3$s.', 'ffw_faqs' ), $url1, $url2, $url3 )
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'ffw_faqs_updated_messages' );


add_filter( 'default_content', 'ffw_default_ediotr_content', 10, 2 );

function ffw_default_ediotr_content( $content, $post ) {

    switch( $post->post_type ) {
        case 'ffw_faqs':
            $content = 'Enter answer here';
        break;
    }

    return $content;
}
