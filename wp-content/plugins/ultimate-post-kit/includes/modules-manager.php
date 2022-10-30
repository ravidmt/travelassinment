<?php

namespace UltimatePostKit;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
if ( !function_exists( 'is_plugin_active' ) ) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
final class Manager
{
    private  $_modules = array() ;
    private function is_module_active( $module_id )
    {
        $module_data = $this->get_module_data( $module_id );
        $options = get_option( 'ultimate_post_kit_active_modules', [] );
        
        if ( !isset( $options[$module_id] ) ) {
            return $module_data['default_activation'];
        } else {
            
            if ( $options[$module_id] == "on" ) {
                return true;
            } else {
                return false;
            }
        
        }
    
    }
    
    private function has_module_style( $module_id )
    {
        $module_data = $this->get_module_data( $module_id );
        
        if ( isset( $module_data['has_style'] ) ) {
            return $module_data['has_style'];
        } else {
            return false;
        }
    
    }
    
    private function has_module_script( $module_id )
    {
        $module_data = $this->get_module_data( $module_id );
        
        if ( isset( $module_data['has_script'] ) ) {
            return $module_data['has_script'];
        } else {
            return false;
        }
    
    }
    
    private function get_module_data( $module_id )
    {
        return ( isset( $this->_modules[$module_id] ) ? $this->_modules[$module_id] : false );
    }
    
    public function __construct()
    {
        $modules = [];
        // $modules[] = 'query-control';
        if ( upk_is_alex_grid_enabled() ) {
            $modules[] = 'alex-grid';
        }
        if ( upk_is_alex_carousel_enabled() ) {
            $modules[] = 'alex-carousel';
        }
        if ( upk_is_alice_grid_enabled() ) {
            $modules[] = 'alice-grid';
        }
        if ( upk_is_alice_carousel_enabled() ) {
            $modules[] = 'alice-carousel';
        }
        if ( upk_is_alter_grid_enabled() ) {
            $modules[] = 'alter-grid';
        }
        if ( upk_is_alter_carousel_enabled() ) {
            $modules[] = 'alter-carousel';
        }
        if ( upk_is_amox_grid_enabled() ) {
            $modules[] = 'amox-grid';
        }
        if ( upk_is_amox_carousel_enabled() ) {
            $modules[] = 'amox-carousel';
        }
        if ( upk_is_author_enabled() ) {
            $modules[] = 'author';
        }
        if ( upk_is_buzz_list_enabled() ) {
            $modules[] = 'buzz-list';
        }
        if ( upk_is_buzz_list_carousel_enabled() ) {
            $modules[] = 'buzz-list-carousel';
        }
        if ( upk_is_camux_slider_enabled() ) {
            $modules[] = 'camux-slider';
        }
        if ( upk_is_carbon_slider_enabled() ) {
            $modules[] = 'carbon-slider';
        }
        if ( upk_is_category_carousel_enabled() ) {
            $modules[] = 'category-carousel';
        }
        if ( upk_is_crystal_slider_enabled() ) {
            $modules[] = 'crystal-slider';
        }
        if ( upk_is_elite_grid_enabled() ) {
            $modules[] = 'elite-grid';
        }
        if ( upk_is_elite_carousel_enabled() ) {
            $modules[] = 'elite-carousel';
        }
        if ( upk_is_exotic_list_enabled() ) {
            $modules[] = 'exotic-list';
        }
        if ( upk_is_fanel_list_enabled() ) {
            $modules[] = 'fanel-list';
        }
        if ( upk_is_featured_list_enabled() ) {
            $modules[] = 'featured-list';
        }
        if ( upk_is_harold_list_enabled() ) {
            $modules[] = 'harold-list';
        }
        if ( upk_is_harold_carousel_enabled() ) {
            $modules[] = 'harold-carousel';
        }
        if ( upk_is_hazel_grid_enabled() ) {
            $modules[] = 'hazel-grid';
        }
        if ( upk_is_hazel_carousel_enabled() ) {
            $modules[] = 'hazel-carousel';
        }
        if ( upk_is_maple_grid_enabled() ) {
            $modules[] = 'maple-grid';
        }
        if ( upk_is_maple_carousel_enabled() ) {
            $modules[] = 'maple-carousel';
        }
        if ( upk_is_news_ticker_enabled() ) {
            $modules[] = 'news-ticker';
        }
        if ( upk_is_newsletter_enabled() ) {
            $modules[] = 'newsletter';
        }
        if ( upk_is_noxe_slider_enabled() ) {
            $modules[] = 'noxe-slider';
        }
        if ( upk_is_timeline_enabled() ) {
            $modules[] = 'timeline';
        }
        if ( upk_is_paradox_slider_enabled() ) {
            $modules[] = 'paradox-slider';
        }
        if ( upk_is_pholox_slider_enabled() ) {
            $modules[] = 'pholox-slider';
        }
        if ( upk_is_post_accordion_enabled() ) {
            $modules[] = 'post-accordion';
        }
        if ( upk_is_post_category_enabled() ) {
            $modules[] = 'post-category';
        }
        if ( upk_is_ramble_grid_enabled() ) {
            $modules[] = 'ramble-grid';
        }
        if ( upk_is_ramble_carousel_enabled() ) {
            $modules[] = 'ramble-carousel';
        }
        if ( upk_is_reading_progress_enabled() ) {
            $modules[] = 'reading-progress';
        }
        if ( upk_is_recent_comments_enabled() ) {
            $modules[] = 'recent-comments';
        }
        if ( upk_is_scott_list_enabled() ) {
            $modules[] = 'scott-list';
        }
        if ( upk_is_skide_slider_enabled() ) {
            $modules[] = 'skide-slider';
        }
        if ( upk_is_snog_slider_enabled() ) {
            $modules[] = 'snog-slider';
        }
        if ( upk_is_social_share_enabled() ) {
            $modules[] = 'social-share';
        }
        if ( upk_is_static_social_count_enabled() ) {
            $modules[] = 'static-social-count';
        }
        if ( upk_is_tag_cloud_enabled() ) {
            $modules[] = 'tag-cloud';
        }
        if ( upk_is_tiny_list_enabled() ) {
            $modules[] = 'tiny-list';
        }
        
        if ( upk_is_animations_enabled() ) {
            $animations = ultimate_post_kit_option( 'animations', 'ultimate_post_kit_elementor_extend', 'on' );
            if ( 'on' === $animations ) {
                $modules[] = 'animations';
            }
        }
        
        // Fetch all modules data
        foreach ( $modules as $module ) {
            $this->_modules[$module] = (require BDTUPK_MODULES_PATH . $module . '/module.info.php');
        }
        $direction = ( is_rtl() ? '.rtl' : '' );
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        foreach ( $this->_modules as $module_id => $module_data ) {
            if ( !$this->is_module_active( $module_id ) ) {
                continue;
            }
            $class_name = str_replace( '-', ' ', $module_id );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\\Module';
            // register widgets css
            if ( $this->has_module_style( $module_id ) ) {
                wp_register_style(
                    'upk-' . $module_id,
                    BDTUPK_URL . 'assets/css/upk-' . $module_id . $direction . '.css',
                    [],
                    BDTUPK_VER
                );
            }
            if ( $this->has_module_script( $module_id ) ) {
                wp_register_script(
                    'upk-' . $module_id,
                    BDTUPK_URL . 'assets/js/widgets/upk-' . $module_id . $suffix . '.js',
                    [ 'jquery' ],
                    BDTUPK_VER
                );
            }
            $class_name::instance();
            // error_log( $class_name );
            // error_log( ep_memory_usage_check() );
        }
    }

}