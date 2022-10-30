<?php

use  UltimatePostKit\Notices ;
use  UltimatePostKit\Base\Ultimate_Post_Kit_Base ;
use  UltimatePostKit\Utils ;
/**
 * Ultimate Post Kit Admin Settings Class
 */
class UltimatePostKit_Admin_Settings
{
    const  PAGE_ID = 'ultimate_post_kit_options' ;
    private  $settings_api ;
    public  $responseObj ;
    public  $showMessage = false ;
    private  $is_activated = false ;
    function __construct()
    {
        $this->settings_api = new UltimatePostKit_Settings_API();
        
        if ( !defined( 'BDTUPK_HIDE' ) ) {
            add_action( 'admin_init', [ $this, 'admin_init' ] );
            add_action( 'admin_menu', [ $this, 'admin_menu' ], 201 );
        }
    
    }
    
    public static function get_url()
    {
        return admin_url( 'admin.php?page=' . self::PAGE_ID );
    }
    
    function admin_init()
    {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->ultimate_post_kit_admin_settings() );
        //initialize settings
        $this->settings_api->admin_init();
    }
    
    function admin_menu()
    {
        add_menu_page(
            BDTUPK_TITLE . ' ' . esc_html__( 'Dashboard', 'ultimate-post-kit' ),
            BDTUPK_TITLE,
            'manage_options',
            self::PAGE_ID,
            [ $this, 'plugin_page' ],
            $this->ultimate_post_kit_icon(),
            58.5
        );
        add_submenu_page(
            self::PAGE_ID,
            BDTUPK_TITLE,
            esc_html__( 'Core Widgets', 'ultimate-post-kit' ),
            'manage_options',
            self::PAGE_ID . '#ultimate_post_kit_active_modules',
            [ $this, 'display_page' ]
        );
        add_submenu_page(
            self::PAGE_ID,
            BDTUPK_TITLE,
            esc_html__( 'Extensions', 'ultimate-post-kit' ),
            'manage_options',
            self::PAGE_ID . '#ultimate_post_kit_elementor_extend',
            [ $this, 'display_page' ]
        );
        add_submenu_page(
            self::PAGE_ID,
            BDTUPK_TITLE,
            esc_html__( 'API Settings', 'ultimate-post-kit' ),
            'manage_options',
            self::PAGE_ID . '#ultimate_post_kit_api_settings',
            [ $this, 'display_page' ]
        );
        add_submenu_page(
            self::PAGE_ID,
            BDTUPK_TITLE,
            esc_html__( 'Other Settings', 'ultimate-post-kit' ),
            'manage_options',
            self::PAGE_ID . '#ultimate_post_kit_other_settings',
            [ $this, 'display_page' ]
        );
    }
    
    /**
     * Notice
     * Premeum Users need Core Plugin from the next version
     *
     * @access public
     */
    public function notice_require_core_plugin()
    {
        Notices::add_notice( [
            'id'               => 'require-core',
            'type'             => 'warning',
            'dismissible'      => true,
            'dismissible-time' => WEEK_IN_SECONDS,
            'message'          => __( 'Dear user, We hope you\'re enjoying your experience. From the next version onwards, you will need to install the free/core version as well as the pro plugin. We made the free version as a core and separate pro plugin in order to provide more value. Thank you for your understanding.', 'ultimate-post-kit' ),
        ] );
    }
    
    function ultimate_post_kit_icon()
    {
        return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCA5MDkuMyA4ODMuOCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgOTA5LjMgODgzLjg7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiNBN0FBQUQ7fQ0KPC9zdHlsZT4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04MTEuMiwyNzIuOUg2ODEuNnYxMjkuN2MwLDEzLjYtMTEsMjQuNy0yNC43LDI0LjdoLTEwNWMtMTMuNiwwLTI0LjctMTEtMjQuNy0yNC43YzAsMCwwLDAsMCwwdi0xMDUNCgljMC0xMy42LDExLTI0LjcsMjQuNi0yNC43YzAsMCwwLDAsMCwwaDEyOS43VjE0My4zYzAtMTMuNi0xMS0yNC43LTI0LjctMjQuN0gzOTcuNmMtMTMuNiwwLTI0LjcsMTEtMjQuNywyNC43YzAsMCwwLDAsMCwwdjQ3MS41DQoJYzAsMTMuNi0xMSwyNC42LTI0LjYsMjQuN2MwLDAsMCwwLDAsMGgtMTA1Yy0xMy42LDAtMjQuNy0xMS0yNC43LTI0Ljd2LTM3NWMwLTEzLjYtMTEtMjQuNy0yNC43LTI0LjdIODljLTEzLjYsMC0yNC43LDExLTI0LjcsMjQuNw0KCWMwLDAsMCwwLDAsMHY1MjkuNGMwLDEzLjYsMTEsMjQuNywyNC43LDI0LjdoNDEzLjZjMTMuNiwwLDI0LjctMTEuMSwyNC43LTI0LjdWNjA2LjJjMC0xMy42LDExLTI0LjcsMjQuNy0yNC43aDI1OS4zDQoJYzEzLjYsMCwyNC43LTExLDI0LjctMjQuN1YyOTcuNkM4MzUuOSwyODQsODI0LjksMjczLDgxMS4yLDI3Mi45QzgxMS4yLDI3Mi45LDgxMS4yLDI3Mi45LDgxMS4yLDI3Mi45eiIvPg0KPHJlY3QgeD0iNzMyIiB5PSI4Mi42IiBjbGFzcz0ic3QwIiB3aWR0aD0iMzQuOCIgaGVpZ2h0PSIzNC44Ii8+DQo8cmVjdCB4PSI3OTEiIHk9IjE0OS43IiBjbGFzcz0ic3QwIiB3aWR0aD0iMjMuOSIgaGVpZ2h0PSIyMy45Ii8+DQo8cmVjdCB4PSI4MDMiIHk9IjgyLjYiIGNsYXNzPSJzdDAiIHdpZHRoPSIxNy44IiBoZWlnaHQ9IjE3LjgiLz4NCjxyZWN0IHg9Ijg2Ni43IiB5PSIxNTUuOCIgY2xhc3M9InN0MCIgd2lkdGg9IjE3LjgiIGhlaWdodD0iMTcuOCIvPg0KPHJlY3QgeD0iODI4LjkiIHk9IjQ0LjMiIGNsYXNzPSJzdDAiIHdpZHRoPSI4LjkiIGhlaWdodD0iOC45Ii8+DQo8cmVjdCB4PSI4NzcuNCIgeT0iMzgiIGNsYXNzPSJzdDAiIHdpZHRoPSI3LjIiIGhlaWdodD0iNy4yIi8+DQo8cmVjdCB4PSI4NTIuNiIgeT0iODciIGNsYXNzPSJzdDAiIHdpZHRoPSI4LjkiIGhlaWdodD0iOC45Ii8+DQo8cmVjdCB4PSI3MzUuNCIgeT0iMTgyLjgiIGNsYXNzPSJzdDAiIHdpZHRoPSIxOS43IiBoZWlnaHQ9IjE5LjciLz4NCjxyZWN0IHg9IjgyNi4zIiB5PSIyMDQuNiIgY2xhc3M9InN0MCIgd2lkdGg9IjE0LjEiIGhlaWdodD0iMTQuMSIvPg0KPC9zdmc+DQo=';
    }
    
    function get_settings_sections()
    {
        $sections = [
            [
            'id'    => 'ultimate_post_kit_active_modules',
            'title' => esc_html__( 'Core Widgets', 'ultimate-post-kit' ),
        ],
            [
            'id'    => 'ultimate_post_kit_elementor_extend',
            'title' => esc_html__( 'Extensions', 'ultimate-post-kit' ),
        ],
            [
            'id'    => 'ultimate_post_kit_api_settings',
            'title' => esc_html__( 'API Settings', 'ultimate-post-kit' ),
        ],
            [
            'id'    => 'ultimate_post_kit_other_settings',
            'title' => esc_html__( 'Other Settings', 'ultimate-post-kit' ),
        ]
        ];
        return $sections;
    }
    
    protected function ultimate_post_kit_admin_settings()
    {
        if ( upk_is_alex_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'alex-grid',
                'label'        => esc_html__( 'Alex Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/alex-grid/',
                'video_url'    => 'https://youtu.be/criKI7Mm-5g',
            ];
        }
        if ( upk_is_alex_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'alex-carousel',
                'label'        => esc_html__( 'Alex Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/alex-carousel/',
                'video_url'    => 'https://youtu.be/nmMajegrTiM',
            ];
        }
        if ( upk_is_alice_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'alice-grid',
                'label'        => esc_html__( 'Alice Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/alice-grid/',
                'video_url'    => 'https://youtu.be/E7W5WSAvxbA',
            ];
        }
        if ( upk_is_alice_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'alice-carousel',
                'label'        => esc_html__( 'Alice Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/alice-carousel/',
                'video_url'    => 'https://youtu.be/I0i6q45j6Ps',
            ];
        }
        if ( upk_is_alter_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'alter-grid',
                'label'        => esc_html__( 'Alter Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/alter-grid/',
                'video_url'    => 'https://youtu.be/lJdoW-aPAe8',
            ];
        }
        if ( upk_is_alter_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'alter-carousel',
                'label'        => esc_html__( 'Alter Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/alter-carousel/',
                'video_url'    => 'https://youtu.be/KInlL05e_lk',
            ];
        }
        if ( upk_is_amox_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'amox-grid',
                'label'        => esc_html__( 'Amox Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/amox-grid/',
                'video_url'    => 'https://youtu.be/BeJ77OLErAk',
            ];
        }
        if ( upk_is_amox_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'amox-carousel',
                'label'        => esc_html__( 'Amox Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/amox-carousel/',
                'video_url'    => 'https://youtu.be/3FoLaHsyB0g',
            ];
        }
        if ( upk_is_atlas_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'atlas-slider',
                'label'        => esc_html__( 'Atlas Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/atlas-slider/',
                'video_url'    => 'https://youtu.be/kM1G84F5Pb4',
            ];
        }
        if ( upk_is_author_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'author',
                'label'        => esc_html__( 'Author', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/author/',
                'video_url'    => 'https://youtu.be/rW8rTtw62ko',
            ];
        }
        if ( upk_is_berlin_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'berlin-slider',
                'label'        => esc_html__( 'Berlin Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/berlin-slider/',
                'video_url'    => 'https://youtu.be/VErUARoiMKo',
            ];
        }
        if ( upk_is_buzz_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'buzz-list',
                'label'        => esc_html__( 'Buzz List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/buzz-list/',
                'video_url'    => 'https://youtu.be/fxjL-ugL_Ls',
            ];
        }
        if ( upk_is_buzz_list_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'buzz-list-carousel',
                'label'        => esc_html__( 'Buzz List Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/buzz-list-carousel/',
                'video_url'    => 'https://youtu.be/fxjL-ugL_Ls',
            ];
        }
        if ( upk_is_camux_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'camux-slider',
                'label'        => esc_html__( 'Camux Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/camux-slider/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_classic_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'classic-list',
                'label'        => esc_html__( 'Classic List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/classic-list/',
                'video_url'    => 'https://youtu.be/A6z4z_Ki1kw',
            ];
        }
        if ( upk_is_crystal_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'crystal-slider',
                'label'        => esc_html__( 'Crystal Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/crystal-slider/',
                'video_url'    => 'https://youtu.be/wZNw_prt-uI',
            ];
        }
        if ( upk_is_carbon_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'carbon-slider',
                'label'        => esc_html__( 'Carbon Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/carbon-slider/',
                'video_url'    => 'https://youtu.be/1NNnJRZxxpc',
            ];
        }
        if ( upk_is_elite_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'elite-grid',
                'label'        => esc_html__( 'Elite Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/elite-grid/',
                'video_url'    => 'https://youtu.be/J0AfZvRWClw',
            ];
        }
        if ( upk_is_elite_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'elite-carousel',
                'label'        => esc_html__( 'Elite Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/elite-carousel/',
                'video_url'    => 'https://youtu.be/iod230fVndQ',
            ];
        }
        if ( upk_is_exotic_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'exotic-list',
                'label'        => esc_html__( 'Exotic List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list new',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/exotic-list/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_fanel_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'fanel-list',
                'label'        => esc_html__( 'Fanel List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/fanel-list/',
                'video_url'    => 'https://youtu.be/nGAoLOoNYk4',
            ];
        }
        if ( upk_is_featured_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'featured-list',
                'label'        => esc_html__( 'Featured List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/featured-list/',
                'video_url'    => 'https://youtu.be/Q-Pm-6Kkmr4',
            ];
        }
        if ( upk_is_forbes_tabs_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'forbes-tabs',
                'label'        => esc_html__( 'Forbes Tabs', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'tabs',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/forbes-tabs/',
                'video_url'    => 'https://youtu.be/lc0WNMtjP_k',
            ];
        }
        if ( upk_is_foxico_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'foxico-slider',
                'label'        => esc_html__( 'Foxico Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/foxico-slider/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_snap_timeline_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'grove-timeline',
                'label'        => esc_html__( 'Grove Timeline', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'timeline',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/grove-timeline/',
                'video_url'    => 'https://youtu.be/FPkHDXCMrjk',
            ];
        }
        if ( upk_is_hansel_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'hansel-slider',
                'label'        => esc_html__( 'Hansel Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/hansel-slider/',
                'video_url'    => 'https://youtu.be/tC7WGeMQkSQ',
            ];
        }
        if ( upk_is_harold_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'harold-list',
                'label'        => esc_html__( 'Harold List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/harold-list/',
                'video_url'    => 'https://youtu.be/gmMpNuw4LD8',
            ];
        }
        if ( upk_is_harold_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'harold-carousel',
                'label'        => esc_html__( 'Harold List carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/harold-carousel/',
                'video_url'    => 'https://youtu.be/M9GruY3beAk',
            ];
        }
        if ( upk_is_hazel_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'hazel-grid',
                'label'        => esc_html__( 'Hazel Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/hazel-grid/',
                'video_url'    => 'https://youtu.be/Uy_rOg8lQJM',
            ];
        }
        if ( upk_is_hazel_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'hazel-carousel',
                'label'        => esc_html__( 'Hazel Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/hazel-carousel/',
                'video_url'    => 'https://youtu.be/N1f6AanD3gM',
            ];
        }
        if ( upk_is_holux_tabs_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'holux-tabs',
                'label'        => esc_html__( 'Holux Tabs', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'tabs',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/holux-tabs/',
                'video_url'    => 'https://youtu.be/P-y7v3RRP1M',
            ];
        }
        if ( upk_is_iconic_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'iconic-slider',
                'label'        => esc_html__( 'Iconic Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "off",
                'widget_type'  => 'pro',
                'content_type' => 'slider new',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/iconic-slider/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_kalon_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'kalon-grid',
                'label'        => esc_html__( 'Kalon Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/kalon-grid/',
                'video_url'    => 'https://youtu.be/sxePbXHbVdw',
            ];
        }
        if ( upk_is_kalon_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'kalon-carousel',
                'label'        => esc_html__( 'Kalon Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/kalon-carousel/',
                'video_url'    => 'https://youtu.be/zTS25x7KWTA',
            ];
        }
        if ( upk_is_maple_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'maple-grid',
                'label'        => esc_html__( 'Maple Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/maple-grid/',
                'video_url'    => 'https://youtu.be/teraPP36sgQ',
            ];
        }
        if ( upk_is_maple_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'maple-carousel',
                'label'        => esc_html__( 'Maple Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/maple-carousel/',
                'video_url'    => 'https://youtu.be/h9KTG-DIbm4',
            ];
        }
        if ( upk_is_news_ticker_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'news-ticker',
                'label'        => esc_html__( 'News Ticker', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/news-ticker/',
                'video_url'    => 'https://youtu.be/xiKwQActvwk',
            ];
        }
        if ( upk_is_newsletter_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'newsletter',
                'label'        => esc_html__( 'Newsletter', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/newsletter/',
                'video_url'    => 'https://youtu.be/8ZgQVoSPEyw',
            ];
        }
        if ( upk_is_noxe_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'noxe-slider',
                'label'        => esc_html__( 'Noxe Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/noxe-slider/',
                'video_url'    => 'https://youtu.be/CyhG4NK8_lo',
            ];
        }
        if ( upk_is_optick_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'optick-slider',
                'label'        => esc_html__( 'Optick Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/optick-slider/',
                'video_url'    => 'https://youtu.be/gqTNcaH7Qy4',
            ];
        }
        if ( upk_is_timeline_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'timeline',
                'label'        => esc_html__( 'Oras Timeline', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'timeline',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/timeline/',
                'video_url'    => 'https://youtu.be/kggB0k9WJ1U',
            ];
        }
        if ( upk_is_paradox_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'paradox-slider',
                'label'        => esc_html__( 'Paradox Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/paradox-slider/',
                'video_url'    => 'https://youtu.be/2ZYnLz__uA4',
            ];
        }
        if ( upk_is_pholox_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'pholox-slider',
                'label'        => esc_html__( 'Pholox Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/pholox-slider/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_pixina_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'pixina-grid',
                'label'        => esc_html__( 'Pixina Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/pixina-grid/',
                'video_url'    => 'https://youtu.be/oCPys6NyKDo',
            ];
        }
        if ( upk_is_pixina_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'pixina-carousel',
                'label'        => esc_html__( 'Pixina Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/pixina-carousel/',
                'video_url'    => 'https://youtu.be/ebSyK__cMhw',
            ];
        }
        if ( upk_is_post_accordion_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'post-accordion',
                'label'        => esc_html__( 'Accordion', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/post-accordion/',
                'video_url'    => 'https://youtu.be/lxGeTthE_lA',
            ];
        }
        if ( upk_is_calendar_post_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'post-calendar',
                'label'        => esc_html__( 'Post Calendar', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/post-calendar/',
                'video_url'    => 'https://youtu.be/_MhyGAgj8yw',
            ];
        }
        if ( upk_is_post_category_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'post-category',
                'label'        => esc_html__( 'Category', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/post-category/',
                'video_url'    => 'https://youtu.be/3S5hRqxTDTo',
            ];
        }
        if ( upk_is_category_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'category-carousel',
                'label'        => esc_html__( 'Category Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/category-carousel/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_ramble_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'ramble-grid',
                'label'        => esc_html__( 'Ramble Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/ramble-grid/',
                'video_url'    => 'https://youtu.be/mKdxqk3M2qI',
            ];
        }
        if ( upk_is_ramble_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'ramble-carousel',
                'label'        => esc_html__( 'Ramble Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/ramble-carousel/',
                'video_url'    => 'https://youtu.be/vv10IM0pCHA',
            ];
        }
        if ( upk_is_reading_progress_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'reading-progress',
                'label'        => esc_html__( 'Reading Progress Bar', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/reading-progress/',
                'video_url'    => 'https://youtu.be/9N_2WDXUjo0',
            ];
        }
        if ( upk_is_reading_progress_circle_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'reading-progress-circle',
                'label'        => esc_html__( 'Reading Progress Circle', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/reading-progress-circle/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_recent_comments_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'recent-comments',
                'label'        => esc_html__( 'Recent Comments', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/recent-comments/',
                'video_url'    => 'https://youtu.be/_RFwr9Lx7Gs',
            ];
        }
        if ( upk_is_scott_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'scott-list',
                'label'        => esc_html__( 'Scott List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/scott-list/',
                'video_url'    => 'https://youtu.be/twaysnvoWkM',
            ];
        }
        if ( upk_is_skide_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'skide-slider',
                'label'        => esc_html__( 'Skide Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/skide-slider/',
                'video_url'    => 'https://youtu.be/7-7PbdFi_Ks',
            ];
        }
        if ( upk_is_soft_timeline_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'soft-timeline',
                'label'        => esc_html__( 'Soft Timeline', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'timeline',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/soft-timeline/',
                'video_url'    => 'https://youtu.be/5scXg5bsGDc',
            ];
        }
        if ( upk_is_sline_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'sline-slider',
                'label'        => esc_html__( 'Sline Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'slider',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/sline-slider/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_snog_slider_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'snog-slider',
                'label'        => esc_html__( 'Snog Slider', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "off",
                'widget_type'  => 'free',
                'content_type' => 'slider new',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/snog-slider/',
                'video_url'    => '',
            ];
        }
        if ( upk_is_snap_timeline_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'snap-timeline',
                'label'        => esc_html__( 'Snap Timeline', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'timeline',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/snap-timeline/',
                'video_url'    => 'https://youtu.be/KCBjzS_1lE0',
            ];
        }
        if ( upk_is_static_social_count_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'static-social-count',
                'label'        => esc_html__( 'Social Count(Static)', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/static-social-count/',
                'video_url'    => 'https://youtu.be/MmbdYPee9qw',
            ];
        }
        if ( upk_is_social_share_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'social-share',
                'label'        => esc_html__( 'Social Share', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/social-share/',
                'video_url'    => 'https://youtu.be/77S087dzK3Q',
            ];
        }
        if ( upk_is_social_link_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'social-link',
                'label'        => esc_html__( 'Social Link', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/social-link/',
                'video_url'    => 'https://youtu.be/MCH3v8iwrTw',
            ];
        }
        if ( upk_is_tag_cloud_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'tag-cloud',
                'label'        => esc_html__( 'Tag Cloud', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'others',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/tag-cloud/',
                'video_url'    => 'https://youtu.be/DLl_bqh_E2M',
            ];
        }
        if ( upk_is_tiny_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'tiny-list',
                'label'        => esc_html__( 'Tiny List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/tiny-list/',
                'video_url'    => 'https://youtu.be/PZlXofIOy68',
            ];
        }
        if ( upk_is_wixer_grid_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'wixer-grid',
                'label'        => esc_html__( 'Wixer Grid', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'grid',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/wixer-grid/',
                'video_url'    => 'https://youtu.be/MeR0jXdpYc0',
            ];
        }
        if ( upk_is_wixer_carousel_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'wixer-carousel',
                'label'        => esc_html__( 'Wixer Carousel', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'carousel',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/wixer-carousel/',
                'video_url'    => 'https://youtu.be/NxelaRS-a9o',
            ];
        }
        if ( upk_is_welsh_list_enabled() ) {
            $settings_fields['ultimate_post_kit_active_modules'][] = [
                'name'         => 'welsh-list',
                'label'        => esc_html__( 'Welsh List', 'ultimate-post-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'pro',
                'content_type' => 'list',
                'demo_url'     => 'https://bdthemes.net/demo/wordpress/ultimate-post-kit/demo/welsh-list/',
                'video_url'    => '',
            ];
        }
        $settings_fields['ultimate_post_kit_elementor_extend'][] = [
            'name'         => 'animations',
            'label'        => esc_html__( 'Animations', 'ultimate-post-kit' ),
            'type'         => 'checkbox',
            'default'      => "on",
            'widget_type'  => 'free',
            'content_type' => 'new',
            'demo_url'     => '',
            'video_url'    => '',
        ];
        $settings_fields['ultimate_post_kit_api_settings'][] = [
            'name'  => 'mailchimp_group_start',
            'label' => esc_html__( 'Mailchimp Access', 'ultimate-post-kit' ),
            'desc'  => __( 'Go to your Mailchimp > Website > Domains > Extras > API Keys (<a href="http://prntscr.com/xqo78x" target="_blank">http://prntscr.com/xqo78x</a>) then create a key and paste here. You will get the audience ID here: <a href="http://prntscr.com/xqnt5z" target="_blank">http://prntscr.com/xqnt5z</a>', 'ultimate-post-kit' ),
            'type'  => 'start_group',
        ];
        $settings_fields['ultimate_post_kit_api_settings'][] = [
            'name'              => 'mailchimp_api_key',
            'label'             => esc_html__( 'Mailchimp API Key', 'ultimate-post-kit' ),
            'placeholder'       => '',
            'type'              => 'text',
            'sanitize_callback' => 'sanitize_text_field',
        ];
        $settings_fields['ultimate_post_kit_api_settings'][] = [
            'name'              => 'mailchimp_list_id',
            'label'             => esc_html__( 'Audience ID', 'ultimate-post-kit' ),
            'placeholder'       => '',
            'type'              => 'text',
            'sanitize_callback' => 'sanitize_text_field',
        ];
        $settings_fields['ultimate_post_kit_api_settings'][] = [
            'name' => 'mailchimp_group_end',
            'type' => 'end_group',
        ];
        $settings_fields['ultimate_post_kit_other_settings'][] = [
            'name'  => 'enable_category_image_group_start',
            'label' => esc_html__( 'Category Image', 'ultimate-post-kit' ),
            'desc'  => __( 'If you need to show category image in your editor so please enable this option.', 'ultimate-post-kit' ),
            'type'  => 'start_group',
        ];
        $settings_fields['ultimate_post_kit_other_settings'][] = [
            'name'    => 'category_image',
            'label'   => esc_html__( 'Category Image', 'ultimate-post-kit' ),
            'type'    => 'checkbox',
            'default' => "off",
        ];
        $settings_fields['ultimate_post_kit_other_settings'][] = [
            'name' => 'category_image_group_end',
            'type' => 'end_group',
        ];
        $settings_fields['ultimate_post_kit_other_settings'][] = [
            'name'         => 'enable_video_link_group_start',
            'label'        => esc_html__( 'Video Link Meta', 'ultimate-post-kit' ),
            'desc'         => __( 'If you need to display video features in your website so please enable this option.', 'ultimate-post-kit' ),
            'type'         => 'start_group',
            'content_type' => 'new',
        ];
        $settings_fields['ultimate_post_kit_other_settings'][] = [
            'name'    => 'video_link',
            'label'   => esc_html__( 'Video Link', 'ultimate-post-kit' ),
            'type'    => 'checkbox',
            'default' => "off",
        ];
        $settings_fields['ultimate_post_kit_other_settings'][] = [
            'name' => 'video_link_group_end',
            'type' => 'end_group',
        ];
        return $settings_fields;
    }
    
    function ultimate_post_kit_welcome()
    {
        $current_user = wp_get_current_user();
        
        if ( isset( $current_user->user_firstname ) or isset( $current_user->user_lastname ) ) {
            $user_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
        } else {
            $user_name = $current_user->display_name;
        }
        
        ?>

		<div class="bdt-dashboard-panel" bdt-scrollspy="target: > div > div > .bdt-card; cls: bdt-animation-slide-bottom-small; delay: 300">
			<div class="bdt-grid bdt-hidden@xl" bdt-grid bdt-height-match="target: > div > .bdt-card">
				<div class=" bdt-welcome-banner">
					<div class="bdt-welcome-content bdt-card bdt-card-body">
						<h1 class="bdt-feature-title">Welcome <?php 
        echo  esc_html( $user_name ) ;
        ?>!</h1>
						<p>Thanks for joining the Ultimate Post Kit family. You are in the right place to
							build your amazing site
							and lift it to the next level. Ultimate Post Kit makes everything easy for you. Its
							drag and drop options can
							create magic. If you feel any challenges visit our youtube channel, nock on our support
							system.
							Stay tuned and see you at the top of success.</p>

						<a class="bdt-button bdt-btn-red bdt-margin-small-top bdt-margin-small-right" target="_blank" rel="" href="https://bdthemes.com/knowledge-type/ultimate-post-kit/">Read
							Knowledge Base</a>
						<a class="bdt-button bdt-btn-blue bdt-margin-small-top" target="_blank" rel="" href="https://bdthemes.com/giveaway/">Participate The Giveaway</a>
					</div>
				</div>
			</div>


			<div class="bdt-grid bdt-visible@xl" bdt-grid bdt-height-match="target: > div > .bdt-card">
				<div class="bdt-width-1-2@l bdt-welcome-banner">
					<div class="bdt-welcome-content bdt-card bdt-card-body">
						<h1 class="bdt-feature-title">
							Welcome <?php 
        echo  esc_html( $current_user->user_firstname ) ;
        ?> <?php 
        echo  esc_html( $current_user->user_lastname ) ;
        ?>
							!</h1>
						<p>Thanks for joining the Ultimate Post Kit family. You are in the right place to
							build your amazing site
							and lift it to the next level. Ultimate Post Kit makes everything easy for you. Its
							drag and drop options can
							create magic. If you feel any challenges visit our youtube channel, nock on our support
							system.
							Stay tuned and see you at the top of success.</p>

					</div>
				</div>

				<div class="bdt-width-1-2@l">
					<div class="bdt-card bdt-card-body bdt-card-blue bdt-facebook-community">
						<h1 class="bdt-feature-title">Try Our Popular Addon - Element Pack</h1>
						<p style="max-width: 690px;">
							<b>Element Pack</b> for <b>Elementor</b> includes the most commonly used elements
							(called widgets) that help you easily manage your website content by simply using the
							drag and drop ability. There is absolutely no programming knowledge required, seriously!
						</p>
						<a class="bdt-button bdt-btn-blue bdt-margin-small-top" target="_blank" rel="" href="https://downloads.wordpress.org/plugin/bdthemes-element-pack-lite.zip">Free Download</a>
					</div>
				</div>
			</div>

			<div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">

				<div class="bdt-width-2-3@m">
					<div class="bdt-card bdt-card-red bdt-card-body">
						<h1 class="bdt-feature-title">Frequently Asked Questions</h1>

						<ul bdt-accordion="collapsible: false">
							<li>
								<a class="bdt-accordion-title" href="#">Is Ultimate Post Kit compatible my
									theme?</a>
								<div class="bdt-accordion-content">
									<p>
										Normally our plugin is compatible with most of theme and cross browser that
										we have tested. If
										happen very few change to your site looking, no problem our strong support
										team is dedicated for
										fixing your minor problem.
									</p>
									<p>
										Here some theme compatibility video example: <a href="https://youtu.be/5U6j7X5kA9A" target="_blank">Avada</a> ,<a href="https://youtu.be/HdZACDwrrdM" target="_blank">Astra</a>, <a href="https://youtu.be/kjqpQRsVyY0" target="_blank">OceanWP</a>
									</p>

								</div>
							</li>
							<li>
								<a class="bdt-accordion-title" href="#">How to resolve elementor stuck on loading
									screen error?</a>
								<div class="bdt-accordion-content">
									<p>First you need to edit the wp-config.php file on your WordPress site. It is
										located in your
										WordPress site’s root folder, and you will need to use an FTP client or file
										manager in your web
										hosting control panel. Next, you need to paste this code in wp-config.php
										file just before the
										line that says <br><em>That's all, stop editing! Happy blogging.</em></p>

									<pre class="bdt-background-muted bdt-padding-small">
define('WP_MEMORY_LIMIT', '350M');
set_time_limit(90);
</pre>

									<p>This code tells WordPress to increase the PHP memory limit to 350MB and
										execution time limit 90
										Seconds. Once you are done, you need to save your changes and upload your
										wp-config.php file back
										to your server. I hope those line can solve your loading widget panel
										problem. Don't forget to
										check your System Requirement box so you understand what you should need to
										do.</p>

								</div>
							</li>
							<!-- <li>
								  <a class="bdt-accordion-title" href="#">What is 3rd Party Widgets?</a>
								  <div class="bdt-accordion-content">
									<p>3rd Party widgets mean you should install that 3rd party plugin to use that widget. For example,
									  There have WC Carousel or WC Products. If you want to use those widgets so you must install
									  WooCommerce Plugin first. So you can access those widgets.
									</p>
								  </div>
								</li> -->
						</ul>
					</div>
				</div>

				<div class="bdt-width-1-3@m">
					<div class="bdt-video-tutorial bdt-card bdt-card-body bdt-card-green">
						<h1 class="bdt-feature-title">Video Tutorial</h1>

						<ul class="bdt-list bdt-list-divider" bdt-lightbox>
							<li>
								<a href="https://youtu.be/er0uGv1yjig">
									<h4 class="bdt-link-title">What's New in Version V1.0.0</h4>
								</a>
							</li>
							<li>
								<a href="https://youtu.be/criKI7Mm-5g">
									<h4 class="bdt-link-title">How to Use Alex Grid Widget</h4>
								</a>
							</li>
							<li>
								<a href="https://youtu.be/nmMajegrTiM">
									<h4 class="bdt-link-title">How to Use Alex Carousel Widget</h4>
								</a>
							</li>
							<li>
								<a href="https://youtu.be/Uy_rOg8lQJM">
									<h4 class="bdt-link-title">How to Use Hazel Grid Widget</h4>
								</a>
							</li>
							<li>
								<a href="https://youtu.be/teraPP36sgQ">
									<h4 class="bdt-link-title">How to Use Maple Grid Widget</h4>
								</a>
							</li>
						</ul>

						<a class="bdt-video-btn" target="_blank" href="https://www.youtube.com/playlist?list=PLP0S85GEw7DNBnZCb4RtJzlf38GCJ7z1b">View more
							videos <span class="dashicons dashicons-arrow-right"></span></a>
					</div>


				</div>

			</div>


			<div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">
				<div class="bdt-width-1-3@m bdt-support-section">
					<div class="bdt-support-content bdt-card bdt-card-green bdt-card-body">
						<h1 class="bdt-feature-title">Support And Feedback</h1>
						<p>Feeling like to consult with an expert? Take live Chat support immediately from <a href="https://bdthemes.com/portfolio-item/ultimate-post-kit" target="_blank" rel="">UltimatePostKit</a>. We are always ready to help
							you 24/7.</p>
						<p><strong>Or if you’re facing technical issues with our plugin, then please create a
								support
								ticket</strong></p>
						<a class="bdt-button bdt-btn-green bdt-margin-small-top bdt-margin-small-right" target="_blank" href="https://bdthemes.com/support/">Get Support</a>
						<a class="bdt-button bdt-btn-red bdt-margin-small-top" target="_blank" rel="" href="https://bdthemes.com/knowledge-type/ultimate-post-kit/">Go knowledge page</a>
					</div>
				</div>

				<div class="bdt-width-2-3@m">
					<div class="bdt-card bdt-card-body bdt-card-green bdt-system-requirement">
						<h1 class="bdt-feature-title bdt-margin-small-bottom">System Requirement</h1>
						<?php 
        $this->ultimate_post_kit_system_requirement();
        ?>
					</div>
				</div>
			</div>

			<div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">
				<div class="bdt-width-2-3@m bdt-support-section">
					<div class="bdt-card bdt-card-body bdt-card-red bdt-support-feedback">
						<h1 class="bdt-feature-title">Missing Any Feature?</h1>
						<p style="max-width: 800px;">Are you in need of a feature that’s not available in our
							plugin? Feel free to
							do a feature request from here,</p>
						<a class="bdt-button bdt-btn-red bdt-margin-small-top" target="_blank" rel="" href="https://bdthemes.com/make-a-suggestion/">Request Feature</a>
					</div>
				</div>

				<div class="bdt-width-1-3@m">
					<div class="bdt-newsletter-content bdt-card bdt-card-green bdt-card-body">
						<h1 class="bdt-feature-title">Newsletter Subscription</h1>
						<p>To get updated news, current offers, deals, and tips please subscribe to our
							Newsletters.</p>
						<a class="bdt-button bdt-btn-green bdt-margin-small-top" target="_blank" rel="" href="https://bdthemes.com/newsletter-form/">Subscribe Now</a>
					</div>
				</div>
			</div>

		</div>


	<?php 
    }
    
    function ultimate_post_kit_system_requirement()
    {
        $php_version = phpversion();
        $max_execution_time = ini_get( 'max_execution_time' );
        $memory_limit = ini_get( 'memory_limit' );
        $post_limit = ini_get( 'post_max_size' );
        $uploads = wp_upload_dir();
        $upload_path = $uploads['basedir'];
        $environment = Utils::get_environment_info();
        ?>
		<ul class="check-system-status bdt-grid bdt-child-width-1-2@m bdt-grid-small ">
			<li>
				<div>

					<span class="label1">PHP Version: </span>

					<?php 
        
        if ( version_compare( $php_version, '7.0.0', '<' ) ) {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $php_version ) . ' (Min: 7.0 Recommended)</span>' ;
        } else {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $php_version ) . '</span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Maximum execution time: </span>

					<?php 
        
        if ( $max_execution_time < '90' ) {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $max_execution_time ) . '(Min: 90 Recommended)</span>' ;
        } else {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $max_execution_time ) . '</span>' ;
        }
        
        ?>
				</div>
			</li>
			<li>
				<div>
					<span class="label1">Memory Limit: </span>

					<?php 
        
        if ( intval( $memory_limit ) < '256' ) {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $memory_limit ) . ' (Min: 256M Recommended)</span>' ;
        } else {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $memory_limit ) . '</span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Max Post Limit: </span>

					<?php 
        
        if ( intval( $post_limit ) < '32' ) {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $post_limit ) . ' (Min: 32M Recommended)</span>' ;
        } else {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
            echo  '<span class="label2">Currently: ' . esc_attr( $post_limit ) . '</span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Uploads folder writable: </span>

					<?php 
        
        if ( !is_writable( $upload_path ) ) {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
        } else {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">MultiSite: </span>

					<?php 
        
        if ( $environment['wp_multisite'] ) {
            echo  '<span class="label2">MultiSite</span>' ;
        } else {
            echo  '<span class="label2">No MultiSite </span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">GZip Enabled: </span>

					<?php 
        
        if ( $environment['gzip_enabled'] ) {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
        } else {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Debug Mode: </span>
					<?php 
        
        if ( $environment['wp_debug_mode'] ) {
            echo  '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>' ;
            echo  '<span class="label2">Currently Turned On</span>' ;
        } else {
            echo  '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>' ;
            echo  '<span class="label2">Currently Turned Off</span>' ;
        }
        
        ?>
				</div>
			</li>

		</ul>

		<div class="bdt-admin-alert">
			<strong>Note:</strong> If you have multiple addons like <b>Ultimate Post Kit</b> so you need some
			more requirement some
			cases so make sure you added more memory for others addon too.
		</div>
	<?php 
    }
    
    function plugin_page()
    {
        echo  '<div class="wrap ultimate-post-kit-dashboard">' ;
        echo  '<h1>' . BDTUPK_TITLE . ' Settings</h1>' ;
        $this->settings_api->show_navigation();
        ?>

		<div class="bdt-switcher">
			<div id="ultimate_post_kit_welcome_page" class="bdt-option-page group">
				<?php 
        $this->ultimate_post_kit_welcome();
        ?>
			</div>

			<?php 
        $this->settings_api->show_forms();
        ?>

		</div>

		</div>

		<?php 
        if ( !defined( 'BDTUPK_WL' ) ) {
            $this->footer_info();
        }
        ?>

		<?php 
        $this->script();
        ?>

		<?php 
    }
    
    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script()
    {
        ?>
		<script>
			jQuery(document).ready(function() {
				jQuery('.upk-no-result').removeClass('bdt-animation-shake');
			});

			function filterSearch(e) {
				var parentID = '#' + jQuery(e).data('id');
				var search = jQuery(parentID).find('.bdt-search-input').val().toLowerCase();
				if (!search) {
					jQuery(parentID).find('.bdt-search-input').attr('bdt-filter-control', "");
					jQuery(parentID).find('.bdt-widget-all').trigger('click');
				} else {
					jQuery(parentID).find('.bdt-search-input').attr('bdt-filter-control', "filter: [data-widget-name*='" + search + "']");
					jQuery(parentID).find('.bdt-search-input').removeClass('bdt-active'); // Thanks to Bar-Rabbas
					jQuery(parentID).find('.bdt-search-input').trigger('click');
				}
			}



			jQuery('.upk-options-parent').each(function(e, item) {
				var eachItem = '#' + jQuery(item).attr('id');

				jQuery(eachItem).on("beforeFilter", function() {
					jQuery(eachItem).find('.upk-no-result').removeClass('bdt-animation-shake');
				});

				jQuery(eachItem).on("afterFilter", function() {

					var isElementVisible = false;
					var i = 0;

					while (!isElementVisible && i < jQuery(eachItem).find(".bdt-option-item").length) {
						if (jQuery(eachItem).find(".bdt-option-item").eq(i).is(":visible")) {
							isElementVisible = true;
						}
						i++;
					}

					if (isElementVisible === false) {
						jQuery(eachItem).find('.upk-no-result').addClass('bdt-animation-shake');
					}
				});


			});


			jQuery('.upk-widget-filter-nav li a').on('click', function(e) {
				jQuery(this).closest('.bdt-widget-filter-wrapper').find('.bdt-search-input').val('');
				jQuery(this).closest('.bdt-widget-filter-wrapper').find('.bdt-search-input').val('').attr('bdt-filter-control', '');
			});

			jQuery(document).ready(function($) {
				'use strict';

				function hashHandler() {
					var $tab = jQuery('.ultimate-post-kit-dashboard .bdt-tab');
					if (window.location.hash) {
						var hash = window.location.hash.substring(1);
						bdtUIkit.tab($tab).show(jQuery('#bdt-' + hash).data('tab-index'));
					}
				}

				jQuery(window).on('load', function() {
					hashHandler();
				});

				window.addEventListener("hashchange", hashHandler, true);

				jQuery('.toplevel_page_ultimate_post_kit_options > ul > li > a ').on('click', function(event) {
					jQuery(this).parent().siblings().removeClass('current');
					jQuery(this).parent().addClass('current');
				});

				jQuery('#ultimate_post_kit_active_modules_page a.bdt-active-all-widget').click(function() {

					<?php 
        ?>

						jQuery('#ultimate_post_kit_active_modules_page .bdt-widget-free .checkbox:visible').each(function() {
							jQuery(this).attr('checked', 'checked').prop("checked", true);
						});

					<?php 
        ?>

					jQuery(this).addClass('bdt-active');
					jQuery('a.bdt-deactive-all-widget').removeClass('bdt-active');
				});

				jQuery('#ultimate_post_kit_active_modules_page a.bdt-deactive-all-widget').click(function() {

					jQuery('#ultimate_post_kit_active_modules_page .checkbox:visible').each(function() {
						jQuery(this).removeAttr('checked');
					});

					jQuery(this).addClass('bdt-active');
					jQuery('a.bdt-active-all-widget').removeClass('bdt-active');
				});

				jQuery('#ultimate_post_kit_elementor_extend a.bdt-active-all-widget').click(function() {

					jQuery('#ultimate_post_kit_elementor_extend .checkbox:visible').each(function() {
						jQuery(this).attr('checked', 'checked').prop("checked", true);
					});

					jQuery(this).addClass('bdt-active');
					jQuery('a.bdt-deactive-all-widget').removeClass('bdt-active');
				});

				jQuery('#ultimate_post_kit_elementor_extend a.bdt-deactive-all-widget').click(function() {

					jQuery('#ultimate_post_kit_elementor_extend .checkbox:visible').each(function() {
						jQuery(this).removeAttr('checked');
					});

					jQuery(this).addClass('bdt-active');
					jQuery('a.bdt-active-all-widget').removeClass('bdt-active');
				});

				jQuery('form.settings-save').submit(function(event) {
					event.preventDefault();

					bdtUIkit.notification({
						message: '<div bdt-spinner></div> <?php 
        esc_html_e( 'Please wait, Saving settings...', 'ultimate-post-kit' );
        ?>',
						timeout: false
					});

					jQuery(this).ajaxSubmit({
						success: function() {
							bdtUIkit.notification.closeAll();
							bdtUIkit.notification({
								message: '<span class="dashicons dashicons-yes"></span> <?php 
        esc_html_e( 'Settings Saved Successfully.', 'ultimate-post-kit' );
        ?>',
								status: 'primary'
							});
						},
						error: function(data) {
							bdtUIkit.notification.closeAll();
							bdtUIkit.notification({
								message: '<span bdt-icon=\'icon: warning\'></span> <?php 
        esc_html_e( 'Unknown error, make sure access is correct!', 'ultimate-post-kit' );
        ?>',
								status: 'warning'
							});
						}
					});

					return false;
				});

			});
		</script>
		<?php 
    }
    
    function footer_info()
    {
        ?>
		<div class="ultimate-post-kit-footer-info">
			<p>Ultimate Post Kit Addon made with love by <a target="_blank" href="https://bdthemes.com">BdThemes</a> Team. 
			<br>All rights reserved by BdThemes.</p>
		</div>
		<?php 
    }
    
    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages()
    {
        $pages = get_pages();
        $pages_options = [];
        if ( $pages ) {
            foreach ( $pages as $page ) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }

}
new UltimatePostKit_Admin_Settings();