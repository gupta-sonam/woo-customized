<?php
/**
 * Plugin Name: Woo Customized
 * Description: Custom WooCommerce Add-on for product button text, category metadata, and frontend display.
 * Version: 1.0
 * Author: Sonam Gupta
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * Text Domain: woo-customized
 */

if (!defined('ABSPATH')) {
    exit; 
}

define('WOO_CUSTOMIZED_VERSION', '1.0');
define('WOO_CUSTOMIZED_URL', plugin_dir_url(__FILE__));
// define('WOO_CURL_URL', 'https://3e3b255b-6f5f-4d5a-bcea-bc4993ee24de-00-1kbkahjgz4alw.picard.replit.dev/api/echo');
define('WOO_CURL_URL', 'https://dummyjson.com/carts/add');
add_action('plugins_loaded', 'woo_customized_plugin_init');

function woo_customized_plugin_init() {
    // check woocommerce condition
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'woo_customized_wc_required_notice');
        return;
    }
    // include require files
    require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';
    require_once plugin_dir_path(__FILE__) . 'includes/product-meta-tab.php';
    require_once plugin_dir_path(__FILE__) . 'includes/category-meta.php';
    require_once plugin_dir_path(__FILE__) . 'includes/cart-functions.php';
    require_once plugin_dir_path(__FILE__) . 'includes/order-api.php';
    require_once plugin_dir_path(__FILE__) . 'includes/shortcode-display.php';

    // Enqueue scripts and styles
    add_action('wp_enqueue_scripts', 'woo_cus_load_plugin_script_and_styles');
    function woo_cus_load_plugin_script_and_styles() {
        wp_enqueue_style( 'woo-customized-custom', WOO_CUSTOMIZED_URL . 'assets/css/custom.css', array(), WOO_CUSTOMIZED_VERSION, false);
        wp_enqueue_script( 'woo-customized-custom', WOO_CUSTOMIZED_URL . 'assets/js/custom.js', array('jquery'), WOO_CUSTOMIZED_VERSION, true);
        wp_localize_script('woo-customized-custom', 'ajax_obj', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('woo_cust_nonce')
        ]);
    };

    add_action('wp_footer', 'woo_custom_add_popup_html');
function woo_custom_add_popup_html() {
    // Only load on pages that use the shortcode
    if (!is_singular() && !is_shop() && !is_product_category()) return;

    ?>
    <!-- Woo Custom Popup -->
    <div id="woo-popup-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9998;"></div>

    <div id="woo-popup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:#fff; padding:20px; max-width:400px; width:90%; box-shadow:0 5px 15px rgba(0,0,0,0.3); z-index:9999; border-radius:8px;">
      <button id="woo-close-popup" style="position:absolute; top:8px; right:12px; font-size:18px; background:none; border:none; cursor:pointer;">×</button>
      <div id="woo-popup-content" style="margin-top:20px;"></div>
    </div>
    <?php
}

}

function woo_customized_wc_required_notice() {
    echo '<div class="notice notice-error"><p><strong>Woo Customized:</strong> This plugin requires <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> to be installed and active.</p></div>';
}