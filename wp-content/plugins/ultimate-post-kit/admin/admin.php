<?php

namespace UltimatePostKit;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Admin {

	public function __construct() {

		// Admin settings controller
		require(BDTUPK_ADM_PATH . 'class-settings-api.php');

		// Ultimate Post Kit admin settings here
		require(BDTUPK_ADM_PATH . 'admin-settings.php');

		// Ultimate Post Kit product feeds loaded here
		require_once BDTUPK_ADM_PATH . 'admin-feeds.php';

		// Embed the Script on our Plugin's Option Page Only
		if (isset($_GET['page']) && $_GET['page'] == 'ultimate_post_kit_options') {
			add_action('admin_init', [$this, 'admin_script']);
			add_action('admin_enqueue_scripts', [$this, 'enqueue_styles']);
		}

		add_filter('plugin_row_meta', [$this, 'plugin_row_meta'], 10, 2);
		add_filter('plugin_action_links_' . BDTUPK_PBNAME, [$this, 'plugin_action_meta']);
	}

	public function enqueue_styles() {

		$direction_suffix = is_rtl() ? '.rtl' : '';
		$suffix           = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style('bdt-uikit', BDTUPK_ADM_ASSETS_URL . 'css/bdt-uikit' . $direction_suffix . '.css', [], BDTUPK_VER);
		wp_enqueue_script('bdt-uikit', BDTUPK_ADM_ASSETS_URL . 'js/bdt-uikit' . $suffix . '.js', ['jquery'], BDTUPK_VER);
		wp_enqueue_style('ultimate-post-kit-font', BDTUPK_ASSETS_URL . 'css/ultimate-post-kit-font' . $direction_suffix . '.css', [], BDTUPK_VER);

		wp_enqueue_style('ultimate-post-kit-editor', BDTUPK_ASSETS_URL . 'css/ultimate-post-kit-editor' . $direction_suffix . '.css', [], BDTUPK_VER);
		wp_enqueue_style('ultimate-post-kit-admin', BDTUPK_ADM_ASSETS_URL . 'css/admin' . $direction_suffix . '.css', [], BDTUPK_VER);
	}


	public function plugin_row_meta($plugin_meta, $plugin_file) {
		if (BDTUPK_PBNAME === $plugin_file) {
			$row_meta = [
				'docs'  => '<a href="https://bdthemes.com/contact/" aria-label="' . esc_attr(__('Go for Get Support', 'ultimate-post-kit')) . '" target="_blank">' . __('Get Support', 'ultimate-post-kit') . '</a>',
				'video' => '<a href="https://www.youtube.com/c/bdthemes" aria-label="' . esc_attr(__('View Ultimate Post Kit Video Tutorials', 'ultimate-post-kit')) . '" target="_blank">' . __('Video Tutorials', 'ultimate-post-kit') . '</a>',
			];

			$plugin_meta = array_merge($plugin_meta, $row_meta);
		}

		return $plugin_meta;
	}

	public function plugin_action_meta($links) {

		$links = array_merge([sprintf('<a href="%s">%s</a>', ultimate_post_kit_dashboard_link('#ultimate_post_kit_welcome'), esc_html__('Settings', 'ultimate-post-kit'))], $links);

		return $links;
	}

	/**
	 * register admin script
	 */
	public function admin_script() {
		if (is_admin()) { // for Admin Dashboard Only
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-form');
		}
	}
}

// Load admin class for admin related content process
if (is_admin()) {
	if (!defined('BDTUPK_CH')) {
		new Admin();
	}
}
