<?php
/**
 * Scripts
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Register Scripts
 *
 * @since  1.0
 * @author  Bryan Monzon <[email]>
 * @return [type] [description]
 */
function ffw_faqs_load_plugin_scripts() {
 
 
    wp_enqueue_script('jquery');
    
    wp_register_script('ffw-faq-accordion', FFW_FAQS_PLUGIN_URL . 'assets/js/ffw-faqs-accordion.js', array( 'jquery', 'jquery-ui-accordion' ), FFW_FAQS_VERSION, true );
    wp_enqueue_script( 'ffw-faq-accordion' );

    wp_enqueue_style('ffw_faqs_shortcode_styles', FFW_FAQS_PLUGIN_URL . 'assets/css/ffw-faq-styles.css');

}
add_action('wp_enqueue_scripts', 'ffw_faqs_load_plugin_scripts');