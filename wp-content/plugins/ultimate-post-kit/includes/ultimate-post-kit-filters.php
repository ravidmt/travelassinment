<?php

/**
 * Ultimate Post Kit widget filters
 * @since 5.7.4
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Settings Filters
if (!function_exists('upk_is_dashboard_enabled')) {
    function upk_is_dashboard_enabled() {
        return apply_filters('ultimatepostkit/settings/dashboard', true);
    }
}

if (!function_exists('upk_is_alex_grid_enabled')) {
    function upk_is_alex_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/alex-grid', true);
    }
}

if (!function_exists('upk_is_alex_carousel_enabled')) {
    function upk_is_alex_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/alex-carousel', true);
    }
}

if (!function_exists('upk_is_alice_grid_enabled')) {
    function upk_is_alice_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/alice-grid', true);
    }
}

if (!function_exists('upk_is_alice_carousel_enabled')) {
    function upk_is_alice_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/alice-carousel', true);
    }
}

if (!function_exists('upk_is_alter_grid_enabled')) {
    function upk_is_alter_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/alter-grid', true);
    }
}

if (!function_exists('upk_is_alter_carousel_enabled')) {
    function upk_is_alter_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/alter-carousel', true);
    }
}

if (!function_exists('upk_is_amox_grid_enabled')) {
    function upk_is_amox_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/amox-grid', true);
    }
}

if (!function_exists('upk_is_amox_carousel_enabled')) {
    function upk_is_amox_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/amox-carousel', true);
    }
}

if (!function_exists('upk_is_elite_grid_enabled')) {
    function upk_is_elite_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/elite-grid', true);
    }
}

if (!function_exists('upk_is_elite_carousel_enabled')) {
    function upk_is_elite_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/elite-carousel', true);
    }
}

if (!function_exists('upk_is_hazel_grid_enabled')) {
    function upk_is_hazel_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/hazel-grid', true);
    }
}

if (!function_exists('upk_is_hazel_carousel_enabled')) {
    function upk_is_hazel_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/hazel-carousel', true);
    }
}

if (!function_exists('upk_is_kalon_grid_enabled')) {
    function upk_is_kalon_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/kalon-grid', true);
    }
}

if (!function_exists('upk_is_kalon_carousel_enabled')) {
    function upk_is_kalon_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/kalon-carousel', true);
    }
}

if (!function_exists('upk_is_maple_grid_enabled')) {
    function upk_is_maple_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/maple-grid', true);
    }
}

if (!function_exists('upk_is_maple_carousel_enabled')) {
    function upk_is_maple_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/maple-carousel', true);
    }
}

if (!function_exists('upk_is_ramble_grid_enabled')) {
    function upk_is_ramble_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/ramble-grid', true);
    }
}

if (!function_exists('upk_is_ramble_carousel_enabled')) {
    function upk_is_ramble_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/ramble-carousel', true);
    }
}

if (!function_exists('upk_is_recent_comments_enabled')) {
    function upk_is_recent_comments_enabled() {
        return apply_filters('ultimatepostkit/widget/recent-comments', true);
    }
}

if (!function_exists('upk_is_harold_list_enabled')) {
    function upk_is_harold_list_enabled() {
        return apply_filters('ultimatepostkit/widget/harold-list', true);
    }
}

if (!function_exists('upk_is_harold_carousel_enabled')) {
    function upk_is_harold_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/harold-carousel', true);
    }
}

if (!function_exists('upk_is_paradox_slider_enabled')) {
    function upk_is_paradox_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/paradox-slider', true);
    }
}

if (!function_exists('upk_is_carbon_slider_enabled')) {
    function upk_is_carbon_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/carbon-slider', true);
    }
}

if (!function_exists('upk_is_pholox_slider_enabled')) {
    function upk_is_pholox_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/pholox-slider', true);
    }
}

if (!function_exists('upk_is_news_ticker_enabled')) {
    function upk_is_news_ticker_enabled() {
        return apply_filters('ultimatepostkit/widget/news-ticker', true);
    }
}

if (!function_exists('upk_is_post_accordion_enabled')) {
    function upk_is_post_accordion_enabled() {
        return apply_filters('ultimatepostkit/widget/post-accordion', true);
    }
}

if (!function_exists('upk_is_post_category_enabled')) {
    function upk_is_post_category_enabled() {
        return apply_filters('ultimatepostkit/widget/post-category', true);
    }
}
if (!function_exists('upk_is_category_carousel_enabled')) {
    function upk_is_category_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/category-carousel', true);
    }
}

if (!function_exists('upk_is_tag_cloud_enabled')) {
    function upk_is_tag_cloud_enabled() {
        return apply_filters('ultimatepostkit/widget/tag-cloud', true);
    }
}

if (!function_exists('upk_is_timeline_enabled')) {
    function upk_is_timeline_enabled() {
        return apply_filters('ultimatepostkit/widget/timeline', true);
    }
}

if (!function_exists('upk_is_featured_list_enabled')) {
    function upk_is_featured_list_enabled() {
        return apply_filters('ultimatepostkit/widget/featured-list', true);
    }
}

if (!function_exists('upk_is_fanel_list_enabled')) {
    function upk_is_fanel_list_enabled() {
        return apply_filters('ultimatepostkit/widget/fanel-list', true);
    }
}

if (!function_exists('upk_is_author_enabled')) {
    function upk_is_author_enabled() {
        return apply_filters('ultimatepostkit/widget/author', true);
    }
}

if (!function_exists('upk_is_berlin_slider_enabled')) {
    function upk_is_berlin_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/berlin-slider', true);
    }
}

if (!function_exists('upk_is_tiny_list_enabled')) {
    function upk_is_tiny_list_enabled() {
        return apply_filters('ultimatepostkit/widget/tiny-list', true);
    }
}

if (!function_exists('upk_is_social_share_enabled')) {
    function upk_is_social_share_enabled() {
        return apply_filters('ultimatepostkit/widget/social-share', true);
    }
}

if (!function_exists('upk_is_social_link_enabled')) {
    function upk_is_social_link_enabled() {
        return apply_filters('ultimatepostkit/widget/social-link', true);
    }
}
if (!function_exists('upk_is_static_social_count_enabled')) {
    function upk_is_static_social_count_enabled() {
        return apply_filters('ultimatepostkit/widget/static-social-count', true);
    }
}

if (!function_exists('upk_is_newsletter_enabled')) {
    function upk_is_newsletter_enabled() {
        return apply_filters('ultimatepostkit/widget/newsletter', true);
    }
}

if (!function_exists('upk_is_buzz_list_enabled')) {
    function upk_is_buzz_list_enabled() {
        return apply_filters('ultimatepostkit/widget/buzz-list', true);
    }
}

if (!function_exists('upk_is_buzz_list_carousel_enabled')) {
    function upk_is_buzz_list_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/buzz-list-carousel', true);
    }
}

if (!function_exists('upk_is_scott_list_enabled')) {
    function upk_is_scott_list_enabled() {
        return apply_filters('ultimatepostkit/widget/scott-list', true);
    }
}

if (!function_exists('upk_is_reading_progress_enabled')) {
    function upk_is_reading_progress_enabled() {
        return apply_filters('ultimatepostkit/widget/reading-progress', true);
    }
}

if (!function_exists('upk_is_reading_progress_circle_enabled')) {
    function upk_is_reading_progress_circle_enabled() {
        return apply_filters('ultimatepostkit/widget/reading-progress-circle', true);
    }
}

if (!function_exists('upk_is_optick_slider_enabled')) {
    function upk_is_optick_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/optick-slider', true);
    }
}

if (!function_exists('upk_is_holux_tabs_enabled')) {
    function upk_is_holux_tabs_enabled() {
        return apply_filters('ultimatepostkit/widget/holux-tabs', true);
    }
}

if (!function_exists('upk_is_forbes_tabs_enabled')) {
    function upk_is_forbes_tabs_enabled() {
        return apply_filters('ultimatepostkit/widget/forbes-tabs', true);
    }
}

if (!function_exists('upk_is_sline_slider_enabled')) {
    function upk_is_sline_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/sline-slider', true);
    }
}

if (!function_exists('upk_is_foxico_slider_enabled')) {
    function upk_is_foxico_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/foxico-slider', true);
    }
}

if (!function_exists('upk_is_iconic_slider_enabled')) {
    function upk_is_iconic_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/iconic-slider', true);
    }
}

if (!function_exists('upk_is_snog_slider_enabled')) {
    function upk_is_snog_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/snog-slider', true);
    }
}

if (!function_exists('upk_is_snap_timeline_enabled')) {
    function upk_is_snap_timeline_enabled() {
        return apply_filters('ultimatepostkit/widget/snap-timeline', true);
    }
}

if (!function_exists('upk_is_hansel_slider_enabled')) {
    function upk_is_hansel_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/hansel-slider', true);
    }
}

if (!function_exists('upk_is_atlas_slider_enabled')) {
    function upk_is_atlas_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/atlas-slider', true);
    }
}

if (!function_exists('upk_is_soft_timeline_enabled')) {
    function upk_is_soft_timeline_enabled() {
        return apply_filters('ultimatepostkit/widget/soft-timeline', true);
    }
}

if (!function_exists('upk_is_pixina_grid_enabled')) {
    function upk_is_pixina_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/pixina-grid', true);
    }
}

if (!function_exists('upk_is_pixina_carousel_enabled')) {
    function upk_is_pixina_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/pixina-carousel', true);
    }
}

if (!function_exists('upk_is_wixer_grid_enabled')) {
    function upk_is_wixer_grid_enabled() {
        return apply_filters('ultimatepostkit/widget/wixer-grid', true);
    }
}

if (!function_exists('upk_is_wixer_carousel_enabled')) {
    function upk_is_wixer_carousel_enabled() {
        return apply_filters('ultimatepostkit/widget/wixer-carousel', true);
    }
}

if (!function_exists('upk_is_calendar_post_enabled')) {
    function upk_is_calendar_post_enabled() {
        return apply_filters('ultimatepostkit/widget/calendar-post', true);
    }
}

if (!function_exists('upk_is_post_calendar_enabled')) {
    function upk_is_post_calendar_enabled() {
        return apply_filters('ultimatepostkit/widget/post-calendar', true);
    }
}

if (!function_exists('upk_is_grove_timeline_enabled')) {
    function upk_is_grove_timeline_enabled() {
        return apply_filters('ultimatepostkit/widget/grove-timeline', true);
    }
}

if (!function_exists('upk_is_noxe_slider_enabled')) {
    function upk_is_noxe_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/noxe-slider', true);
    }
}

if (!function_exists('upk_is_classic_list_enabled')) {
    function upk_is_classic_list_enabled() {
        return apply_filters('ultimatepostkit/widget/classic-list', true);
    }
}

if (!function_exists('upk_is_welsh_list_enabled')) {
    function upk_is_welsh_list_enabled() {
        return apply_filters('ultimatepostkit/widget/welsh-list', true);
    }
}

if (!function_exists('upk_is_exotic_list_enabled')) {
    function upk_is_exotic_list_enabled() {
        return apply_filters('ultimatepostkit/widget/exotic-list', true);
    }
}

if (!function_exists('upk_is_single_author')) {
    function upk_is_single_author() {
        return apply_filters('ultimatepostkit/widget/single-author', true);
    }
}
if (!function_exists('upk_is_single_category')) {
    function upk_is_single_category() {
        return apply_filters('ultimatepostkit/widget/single-category', true);
    }
}

if (!function_exists('upk_is_single_comments')) {
    function upk_is_single_comments() {
        return apply_filters('ultimatepostkit/widget/single-comments', true);
    }
}
if (!function_exists('upk_is_single_date')) {
    function upk_is_single_date() {
        return apply_filters('ultimatepostkit/widget/single-date', true);
    }
}

if (!function_exists('upk_is_single_title')) {
    function upk_is_single_title() {
        return apply_filters('ultimatepostkit/widget/single-title', true);
    }
}

if (!function_exists('upk_is_skide_slider_enabled')) {
    function upk_is_skide_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/skide-slider', true);
    }
}

if (!function_exists('upk_is_camux_slider_enabled')) {
    function upk_is_camux_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/camux-slider', true);
    }
}

if (!function_exists('upk_is_crystal_slider_enabled')) {
    function upk_is_crystal_slider_enabled() {
        return apply_filters('ultimatepostkit/widget/crystal-slider', true);
    }
}

//Extensions
if (!function_exists('upk_is_animations_enabled')) {
    function upk_is_animations_enabled() {
        return apply_filters('ultimatepostkit/extend/animations', true);
    }
}

// Others
if ( !function_exists( 'upk_is_giveaway_notice_enabled' ) ) {
	function upk_is_giveaway_notice_enabled() {
		return apply_filters( 'ultimatepostkit/settings/giveaway_notice', true );
	}
}