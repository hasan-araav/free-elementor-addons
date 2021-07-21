<?php
/**
 * Dashboard Class
 */

 namespace FreeElementorAddons\Classes;

 defined( 'ABSPATH' ) || die();

final class Dashboard {

    static  $menu_slug;

    public static function init() {
        add_action( 'admin_menu', [__CLASS__, 'add_menu'] );
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_scripts'] );
        add_action( 'in_admin_header', [__CLASS__, 'dnd_notices'] );
    }

    public static function dnd_notices() {
        if ( isset( $_GET['page'] ) && ( $_GET['page'] === 'free-addons' ) ) {
            remove_all_actions( 'admin_notices' );
            remove_all_actions( 'all_admin_notices' );
        }
    }

    public static function add_menu() {

        self::$menu_slug = add_menu_page( __( 'Free Elementor Addons', 'free-elementor-addons'), __( 'Free Addons', 'free-elementor-addons' ), 'manage_options', 'free-addons', [__CLASS__, 'dashboard'], '', '' );
    }
    
    public static function dashboard() {
        self::load_template( 'main' );
    }

    private static function load_template( $template ) {
        $file = FEA_DIR_PATH . 'app/templates/dashboard-' . $template . '.php';
        if ( is_readable( $file ) ) {
            include( $file );
        }
    }

    public static function enqueue_scripts( $hook ) {
        if( self::$menu_slug !== $hook || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        wp_enqueue_style( 'free-elementor-addons-dashboard', FEA_ASSETS . 'css/dashboard.css', array(), FEA_VERSION );

        wp_enqueue_script( 'free-elementor-addons-dashboard', FEA_ASSETS . 'js/dashboard.js', ['jquery'], FEA_VERSION, true );

        wp_enqueue_style(
            'google-nunito-font',
            'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;1,200;1,600&display=swap',
            null,
            FEA_VERSION
        );
    }

    public static function get_tabs() {
        $tabs = [
            'home' => [
                'title' => esc_html__( 'Home', 'free-elementor-addons' ),
                'template' => 'home',
            ],
            'widgets' => [
                'title' => esc_html__('Widgets', 'free-elementor-addons'),
                'template' => 'widgets',
            ],
            'contact' => [
                'title' => esc_html__('Contact', 'free-elementor-addons'),
                'template' => 'contact',
            ],
        ];

        return apply_filters( 'fea_admin_tabs', $tabs );
    }
}