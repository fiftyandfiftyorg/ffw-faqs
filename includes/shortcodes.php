<?php
/**
 * Shortcodes
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function meg_test_something(){
    ob_start();
    ffw_faqs_get_template_part( 'test', 'me' );
    return ob_get_clean();
}
add_shortcode('testering', 'meg_test_something');