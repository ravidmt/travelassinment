<?php

namespace UltimatePostKit;

use  Elementor\Plugin ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Main class for element pack
 */
class Ultimate_Post_Kit_Loader
{
    /**
     * @var Ultimate_Post_Kit_Loader
     */
    private static  $_instance ;
    /**
     * @var Manager
     */
    private  $_modules_manager ;
    // private $classes_aliases = [
    // 	'UltimatePostKit\Modules\PanelPostsControl\Module'                       => 'UltimatePostKit\Modules\QueryControl\Module',
    // 	'UltimatePostKit\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'UltimatePostKit\Modules\QueryControl\Controls\Group_Control_Posts',
    // 	'UltimatePostKit\Modules\PanelPostsControl\Controls\Query'               => 'UltimatePostKit\Modules\QueryControl\Controls\Query',
    // ];
    public  $elements_data = array(
        'sections' => array(),
        'columns'  => array(),
        'widgets'  => array(),
    ) ;
    /**
     * @return string
     * @deprecated
     *
     */
    public function get_version()
    {
        return BDTUPK_VER;
    }
    
    /**
     * return active theme
     */
    public function get_theme()
    {
        return wp_get_theme();
    }
    
    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @return void
     * @since 1.0.0
     */
    public function __clone()
    {
        // Cloning instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'ultimate-post-kit' ), '1.6.0' );
    }
    
    /**
     * Disable unserializing of the class
     *
     * @return void
     * @since 1.0.0
     */
    public function __wakeup()
    {
        // Unserializing instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'ultimate-post-kit' ), '1.6.0' );
    }
    
    /**
     * @return Plugin
     */
    public static function elementor()
    {
        return Plugin::$instance;
    }
    
    /**
     * @return Ultimate_Post_Kit_Loader
     */
    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * we loaded module manager + admin php from here
     * @return [type] [description]
     */
    private function _includes()
    {
        $category_image = ultimate_post_kit_option( 'category_image', 'ultimate_post_kit_other_settings', 'off' );
        // Dynamic Select control
        require BDTUPK_INC_PATH . 'controls/select-input/dynamic-select-input-module.php';
        require BDTUPK_INC_PATH . 'controls/select-input/dynamic-select.php';
        // all widgets control from here
        require_once BDTUPK_PATH . 'traits/global-widget-controls.php';
        require_once BDTUPK_PATH . 'traits/global-swiper-functions.php';
        require_once BDTUPK_INC_PATH . 'modules-manager.php';
        if ( $category_image == 'on' ) {
            require BDTUPK_INC_PATH . 'ultimate-post-kit-category-image.php';
        }
        // if ($category_image == 'on') {
        require BDTUPK_INC_PATH . 'ultimate-post-kit-metabox.php';
        // }
    }
    
    /**
     * Autoloader function for all classes files
     *
     * @param  [type] class [description]
     *
     * @return [type]        [description]
     */
    public function autoload( $class )
    {
        if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
            return;
        }
        $has_class_alias = isset( $this->classes_aliases[$class] );
        // Backward Compatibility: Save old class name for set an alias after the new class is loaded
        
        if ( $has_class_alias ) {
            $class_alias_name = $this->classes_aliases[$class];
            $class_to_load = $class_alias_name;
        } else {
            $class_to_load = $class;
        }
        
        
        if ( !class_exists( $class_to_load ) ) {
            $filename = strtolower( preg_replace( [
                '/^' . __NAMESPACE__ . '\\\\/',
                '/([a-z])([A-Z])/',
                '/_/',
                '/\\\\/'
            ], [
                '',
                '$1-$2',
                '-',
                DIRECTORY_SEPARATOR
            ], $class_to_load ) );
            $filename = BDTUPK_PATH . $filename . '.php';
            if ( is_readable( $filename ) ) {
                include $filename;
            }
        }
        
        if ( $has_class_alias ) {
            class_alias( $class_alias_name, $class );
        }
    }
    
    public function register_site_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_register_style(
            'upk-all-styles',
            BDTUPK_ASSETS_URL . 'css/upk-all-styles' . $direction_suffix . '.css',
            [],
            BDTUPK_VER
        );
        wp_register_style(
            'ultimate-post-kit-font',
            BDTUPK_ASSETS_URL . 'css/ultimate-post-kit-font' . $direction_suffix . '.css',
            [],
            BDTUPK_VER
        );
    }
    
    public function register_site_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_register_script(
            'goodshare',
            BDTUPK_ASSETS_URL . 'vendor/js/goodshare' . $suffix . '.js',
            [ 'jquery' ],
            '4.1.2',
            true
        );
        wp_register_script(
            'scrolline',
            BDTUPK_ASSETS_URL . 'vendor/js/jquery.scrolline' . $suffix . '.js',
            [ 'jquery' ],
            '4.1.2',
            true
        );
        wp_register_script(
            'news-ticker-js',
            BDTUPK_ASSETS_URL . 'vendor/js/newsticker' . $suffix . '.js',
            [ 'jquery' ],
            '',
            true
        );
        wp_register_script(
            'upk-animations',
            BDTUPK_ASSETS_URL . 'js/extensions/upk-animations' . $suffix . '.js',
            [ 'jquery' ],
            '',
            true
        );
        wp_register_script(
            'upk-all-scripts',
            BDTUPK_ASSETS_URL . 'js/upk-all-scripts' . $suffix . '.js',
            [ 'jquery', 'elementor-frontend', 'scrolline' ],
            BDTUPK_VER,
            true
        );
    }
    
    /**
     * Loading site related style from here.
     * @return [type] [description]
     */
    public function enqueue_site_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_enqueue_style(
            'ultimate-post-kit-site',
            BDTUPK_ASSETS_URL . 'css/ultimate-post-kit-site' . $direction_suffix . '.css',
            [],
            BDTUPK_VER
        );
    }
    
    /**
     * Loading site related script that needs all time such as uikit.
     * @return [type] [description]
     */
    public function enqueue_site_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_script(
            'ultimate-post-kit-site',
            BDTUPK_ASSETS_URL . 'js/ultimate-post-kit-site' . $suffix . '.js',
            [ 'jquery', 'elementor-frontend' ],
            BDTUPK_VER,
            true
        );
        // tooltip file should be separate
        $script_config = [
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'nonce'         => wp_create_nonce( 'ultimate-post-kit-site' ),
            'mailchimp'     => [
            'subscribing' => esc_html_x( 'Subscribing you please wait...', 'Mailchimp String', 'ultimate-post-kit' ),
        ],
            'elements_data' => $this->elements_data,
        ];
        $script_config = apply_filters( 'ultimate_post_kit/frontend/localize_settings', $script_config );
        // TODO for editor script
        wp_localize_script( 'ultimate-post-kit-site', 'UltimatePostKitConfig', $script_config );
    }
    
    public function enqueue_editor_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_script(
            'ultimate-post-kit',
            BDTUPK_ASSETS_URL . 'js/ultimate-post-kit-editor' . $suffix . '.js',
            [ 'backbone-marionette', 'elementor-common-modules', 'elementor-editor-modules' ],
            BDTUPK_VER,
            true
        );
    }
    
    public function enqueue_admin_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_script(
            'ultimate-post-kit-admin',
            BDTUPK_ASSETS_URL . 'js/ultimate-post-kit-admin' . $suffix . '.js',
            [ 'jquery' ],
            BDTUPK_VER,
            true
        );
        wp_enqueue_script(
            'upk-notice-js',
            BDTUPK_ADM_ASSETS_URL . 'js/upk-notice.js',
            [ 'jquery' ],
            BDTUPK_VER,
            true
        );
    }
    
    /**
     * Load editor editor related style from here
     * @return [type] [description]
     */
    public function enqueue_preview_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_enqueue_style(
            'ultimate-post-kit-preview',
            BDTUPK_ASSETS_URL . 'css/ultimate-post-kit-preview' . $direction_suffix . '.css',
            '',
            BDTUPK_VER
        );
    }
    
    public function enqueue_editor_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_enqueue_style(
            'ultimate-post-kit-editor',
            BDTUPK_ASSETS_URL . 'css/ultimate-post-kit-editor' . $direction_suffix . '.css',
            '',
            BDTUPK_VER
        );
        wp_enqueue_style(
            'ultimate-post-kit-font',
            BDTUPK_URL . 'assets/css/ultimate-post-kit-font' . $direction_suffix . '.css',
            [],
            BDTUPK_VER
        );
    }
    
    /**
     * initialize the category
     * @return [type] [description]
     */
    public function ultimate_post_kit_init()
    {
        $this->_modules_manager = new Manager();
        do_action( 'bdthemes_ultimate_post_kit/init' );
    }
    
    /**
     * initialize the category
     * @return [type] [description]
     */
    public function ultimate_post_kit_category_register()
    {
        $elementor = Plugin::$instance;
        // Add element category in panel
        $elementor->elements_manager->add_category( 'ultimate-post-kit', [
            'title' => esc_html__( 'Ultimate Post Kit', 'ultimate-post-kit' ),
            'icon'  => 'font',
        ] );
    }
    
    private function setup_hooks()
    {
        add_action( 'elementor/elements/categories_registered', [ $this, 'ultimate_post_kit_category_register' ] );
        add_action( 'elementor/init', [ $this, 'ultimate_post_kit_init' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
        add_action( 'elementor/frontend/before_register_styles', [ $this, 'register_site_styles' ] );
        add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_site_scripts' ] );
        add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_site_styles' ] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_site_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
    }
    
    /**
     * Ultimate_Post_Kit_Loader constructor.
     */
    private function __construct()
    {
        // Register class automatically
        spl_autoload_register( [ $this, 'autoload' ] );
        // Include some backend files
        $this->_includes();
        // Finally hooked up all things here
        $this->setup_hooks();
    }

}
if ( !defined( 'BDTUPK_TESTS' ) ) {
    // In tests we run the instance manually.
    Ultimate_Post_Kit_Loader::instance();
}
// handy fundtion for push data
function ultimate_post_kit_config()
{
    return Ultimate_Post_Kit_Loader::instance();
}
