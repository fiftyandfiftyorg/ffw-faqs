<?php 
/**
 * Plugin Name: Fifty Framework FAQs
 * Plugin URI: http://fiftyandfifty.org
 * Description: Build FAQs pages for your site
 * Version: 1.0
 * Author: Fifty and Fifty
 * Author URI: http://labs.fiftyandfifty.org
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'FFW_FAQS' ) ) :


/**
 * Main FFW_FAQS Class
 *
 * @since 1.0 */
final class FFW_FAQS {

  /**
   * @var FFW_FAQS Instance
   * @since 1.0
   */
  private static $instance;


  /**
   * FFW_FAQS Instance / Constructor
   *
   * Insures only one instance of FFW_FAQS exists in memory at any one
   * time & prevents needing to define globals all over the place. 
   * Inspired by and credit to FFW_FAQS.
   *
   * @since 1.0
   * @static
   * @uses FFW_FAQS::setup_globals() Setup the globals needed
   * @uses FFW_FAQS::includes() Include the required files
   * @uses FFW_FAQS::setup_actions() Setup the hooks and actions
   * @see FFW_FAQS()
   * @return void
   */
  public static function instance() {
    if ( ! isset( self::$instance ) && ! ( self::$instance instanceof FFW_FAQS ) ) {
      self::$instance = new FFW_FAQS;
      self::$instance->setup_constants();
      self::$instance->includes();
      // self::$instance->load_textdomain();
      // use @examples from public vars defined above upon implementation
    }
    return self::$instance;
  }



  /**
   * Setup plugin constants
   * @access private
   * @since 1.0 
   * @return void
   */
  private function setup_constants() {
    // Plugin version
    if ( ! defined( 'FFW_FAQS_VERSION' ) )
      define( 'FFW_FAQS_VERSION', '1.1' );

    // Plugin Folder Path
    if ( ! defined( 'FFW_FAQS_PLUGIN_DIR' ) )
      define( 'FFW_FAQS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

    // Plugin Folder URL
    if ( ! defined( 'FFW_FAQS_PLUGIN_URL' ) )
      define( 'FFW_FAQS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

    // Plugin Root File
    if ( ! defined( 'FFW_FAQS_PLUGIN_FILE' ) )
      define( 'FFW_FAQS_PLUGIN_FILE', __FILE__ );

    if ( ! defined( 'FFW_FAQS_DEBUG' ) )
      define ( 'FFW_FAQS_DEBUG', true );
  }



  /**
   * Include required files
   * @access private
   * @since 1.0
   * @return void
   */
  private function includes() {
    global $ffw_faqs_settings, $wp_version;

    require_once FFW_FAQS_PLUGIN_DIR . '/includes/admin/settings/register-settings.php';
    $ffw_faqs_settings = ffw_faqs_get_settings();

    // Required Plugin Files
    require_once FFW_FAQS_PLUGIN_DIR . '/includes/functions.php';
    require_once FFW_FAQS_PLUGIN_DIR . '/includes/posttypes.php';
    require_once FFW_FAQS_PLUGIN_DIR . '/includes/scripts.php';
    require_once FFW_FAQS_PLUGIN_DIR . '/includes/shortcodes.php';
    require_once FFW_FAQS_PLUGIN_DIR . '/includes/template-functions.php';

    if( is_admin() ){
        //Admin Required Plugin Files
        require_once FFW_FAQS_PLUGIN_DIR . '/includes/admin/admin-pages.php';
        require_once FFW_FAQS_PLUGIN_DIR . '/includes/admin/admin-notices.php';
        require_once FFW_FAQS_PLUGIN_DIR . '/includes/admin/faqs/metabox.php';
        require_once FFW_FAQS_PLUGIN_DIR . '/includes/admin/settings/display-settings.php';

    }


  }

} /* end FFW_FAQS class */
endif; // End if class_exists check


/**
 * Main function for returning FFW_FAQS Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $sqcash = FFW_FAQS(); ?>
 *
 * @since 1.0
 * @return object The one true FFW_FAQS Instance
 */
function FFW_FAQS() {
  return FFW_FAQS::instance();
}


/**
 * Initiate
 * Run the FFW_FAQS() function, which runs the instance of the FFW_FAQS class.
 */
FFW_FAQS();



/**
 * Debugging
 * @since 1.0
 */
if ( FFW_FAQS_DEBUG ) {
  ini_set('display_errors','On');
  error_reporting(E_ALL);
}


