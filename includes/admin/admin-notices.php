<?php
/**
 * Admin Notices
 *
 * @package     FFW Staff
 * @subpackage  Admin/Notices
 * @copyright   Copyright (c) 2013, Bryan Monzon
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Admin Messages
 *
 * @since 1.0
 * @global $edd_options Array of all the EDD Options
 * @return void
 */
function ffw_faqs_admin_messages() {
    global $ffw_faqs_settings;

    settings_errors( 'ffw_faqs-notices' );
}
add_action( 'admin_notices', 'ffw_faqs_admin_messages' );


/**
 * Dismisses admin notices when Dismiss links are clicked
 *
 * @since 1.8
 * @return void
*/
function ffw_faqs_dismiss_notices() {

    $notice = isset( $_GET['ffw_faqs_notice'] ) ? $_GET['ffw_faqs_notice'] : false;

    if( ! $notice )
        return; // No notice, so get out of here

    update_user_meta( get_current_user_id(), '_ffw_faqs_' . $notice . '_dismissed', 1 );

    wp_redirect( remove_query_arg( array( 'ffw_faqs_action', 'ffw_faqs_notice' ) ) ); exit;

}
add_action( 'ffw_faqs_dismiss_notices', 'ffw_faqs_dismiss_notices' );
