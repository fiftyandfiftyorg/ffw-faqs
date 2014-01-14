<?php
/**
 * Shortcodes
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_faqs_list_shortcode( $post ){

    global $post;

    ob_start(); 
    
    ffw_faqs_get_template_part( 'faq', 'list' );

    $faq_list = ob_get_clean();

    return $faq_list;
}
add_shortcode('faq_list', 'ffw_faqs_list_shortcode');



function ffw_faqs_search_shortcode( $post ) 
{
    global $post, $ffw_faqs_settings;

    ob_start();

    ffw_faqs_get_template_part( 'faq', 'search' );

    $faq_search = ob_get_clean();

    return $faq_search;


}
add_shortcode('faq_search', 'ffw_faqs_search_shortcode');