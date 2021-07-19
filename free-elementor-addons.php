<?php
/**
 * Plugin Name: Free Elementor Addons
 * Description: 3000+ Free Elementor Widgets. All free for lifetime.
 * Plugin URI:  https://free-elementor-addons.com/
 * Version:     1.0.0
 * Author:      MD HASAN UJ JAMAN
 * Author URI:  https://jaman.dev/
 * Text Domain: free-elementor-addons
 */

require __DIR__ . '/vendor/autoload.php';

defined( 'ABSPATH' ) || die();

define( 'FEA_VERSION', '1.0.0' );
define( 'FEA__FILE__', __FILE__ );
define( 'FEA_DIR_PATH', plugin_dir_path( FEA__FILE__ ) );
define( 'FEA_DIR_URL', plugin_dir_url( FEA__FILE__ ) );
define( 'FEA_ASSETS', trailingslashit( FEA_DIR_URL . 'app/assets' ) );

define( 'FEA_MINIMUM_ELEMENTOR_VERSION', '2.0.0' );
define( 'FEA_MINIMUM_PHP_VERSION', '5.4' );

/**
 * Free Elementor Addons
 * 
 * @since 1.0.0
 */
final class FreeElementorAddons {
    
    /**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var FreeElementorAddons The single instance of the class.
	 */
	private static $_instance = null;

    /**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return FreeElementorAddons An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

    /**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );

	}

    /**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'free-elementor-addons' );

	}

    /**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If all checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

    /**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, FEA_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, FEA_MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

    /**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
        
        // Load text domain.
		$this->i18n();

        // Initialize neccesary classes to run the plugin.
		$this->init_classes();

		// Register custom category
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

		// Register custom controls
        // Later this can be moved to custom control class.
        // This can be moved to init_classes
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

		// Init tracking
        // Later this can be move to tracking class
        // this can be moved to init_classes
		$this->init_tracking();

		do_action( 'fea_loaded' );

	}

    /**
	 * Init plugin tracking
	 */
	public function init_tracking() {

		// Load and call tracking library here

	}

    /**	
	 * Register Custom Controls
	 */
	public function register_controls() {

	}

    /**
	 * Add custom category.
	 *
	 * @param $elements_manager
	 */
	public function add_category( Elements_Manager $elements_manager ) {
		$elements_manager->add_category(
			'fea_category',
			[
				'title' => __( 'Freee Elementor Addons', 'free-elementor-addons' ),
				'icon' => 'fa fa-smile-o',
			]
		);
	}

    /**	
	 * Include assets files
	 * 
	 * Load the files required to run the plugin.
	 */
	public function init_classes() {
		// we don't need to include files because we are using composer. we just init the classes here or create another class and init that class and inside that class use 'use' keywork.
		// Init Icon Manager
		// Init Widget Manager
		// Init Control Manager
		// If Admin. Init Admin Dashboard
		if( is_admin() ) {
			FreeElementorAddons\Classes\Dashboard::init();
		}
	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'free-elementor-addons' ),
			'<strong>' . esc_html__( 'Free Elementor Addons', 'free-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'free-elementor-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'free-elementor-addons' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'free-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'free-elementor-addons' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'free-elementor-addons' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'free-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'free-elementor-addons' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
}

// Run
FreeElementorAddons::instance();