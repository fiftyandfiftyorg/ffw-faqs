<?php
/**
 * Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_faqs_disable_link()
{
    global $ffw_faqs_settings;

   $ffw_faqs_disable = isset( $ffw_faqs_settings['faq_disable_link_to_single'] ) ? true : false;

   return $ffw_faqs_disable;
    
}