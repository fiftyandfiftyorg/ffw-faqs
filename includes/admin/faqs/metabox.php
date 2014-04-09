<?php
/**
 * Metabox Functions
 *
 * @package     Donately for WordPress
 * @subpackage  Admin/FAQs
 * @copyright   Copyright (c) 2013, Fifty and Fifty
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/** All Downloads *****************************************************************/

/**
 * Register all the meta boxes for the Download custom post type
 *
 * @since 1.0
 * @return void
 */
function ffw_faqs_add_meta_box() {
    // global $post;
    //     print_r($post);
    $post_types = apply_filters( 'ffw_faqs_metabox_post_types' , array( 'ffw_faqs' ) );

    foreach ( $post_types as $post_type ) {

        /** Download Configuration */
        //add_meta_box( 'campaigninfo', sprintf( __( '%1$s Information', 'ffw_faqs' ), ffw_faqs_get_label_singular(), ffw_faqs_get_label_plural() ),  'ffw_faq_render_meta_box', $post_type, 'normal', 'default' );
        add_meta_box( 'ffwfaqsinfo', sprintf( __( '%1$s Control', 'ffw_faqs' ), ffw_faqs_get_label_singular(), ffw_faqs_get_label_plural() ),  'ffw_faq_render_meta_box', $post_type, 'normal', 'default' );

    }
}
add_action( 'add_meta_boxes', 'ffw_faqs_add_meta_box' );


/**
 * Sabe post meta when the save_post action is called
 *
 * @since 1.0
 * @param int $post_id Download (Post) ID
 * @global array $post All the data of the the current post
 * @return void
 */
function ffw_faqs_meta_box_save( $post_id) {
    global $post, $ffw_faq_settings;

    if ( ! isset( $_POST['ffw_faqs_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['ffw_faqs_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) )
        return $post_id;

    if ( isset( $post->post_type ) && $post->post_type == 'revision' )
        return $post_id;


    // The default fields that get saved
    $fields = apply_filters( 'ffw_faq_metabox_fields_save', array(
            'ffw_faqs_display_excerpt'
        )
    );

        print_r($post);
    foreach ( $fields as $field ) {
        if ( ! empty( $_POST[ $field ] ) ) {
            $new = apply_filters( 'ffw_faq_save_' . $field, $_POST[ $field ] );
            update_post_meta( $post_id, $field, $new );
        } else {
            //delete_post_meta( $post_id, $field );
        }
    }

}
add_action( 'save_post', 'ffw_faqs_meta_box_save' );

function testing()
{
    global $post;

    print_r($post);
}
testing();



/** Campaign Configuration *****************************************************************/

/**
 * Campaign Metabox
 *
 * Extensions (as well as the core plugin) can add items to the main download
 * configuration metabox via the `ffw_faqs_meta_box_fields` action.
 *
 * @since 1.0
 * @return void
 */
function ffw_faq_render_meta_box() {
    global $post, $ffw_faq_settings;

    do_action( 'ffw_faq_meta_box_fields', $post->ID );
    wp_nonce_field( basename( __FILE__ ), 'ffw_faqs_meta_box_nonce' );
}



function ffw_faq_render_fields( $post )
{
    global $post, $ffw_faq_settings;

    $excerpt_option = get_post_meta( $post->ID, 'ffw_faqs_display_excerpt', true );


?>
    <label for="ffw_faqs_display_excerpt">
    <input type="checkbox" name="ffw_faqs_display_excerpt" id="ffw_faqs_display_excerpt" value="1" <?php echo checked( 1, $excerpt_option ); ?>> Check to display just the excerpt & link to a detail page.
    </label>
<?php

}
add_action( 'ffw_faq_meta_box_fields', 'ffw_faq_render_fields', 10 );



