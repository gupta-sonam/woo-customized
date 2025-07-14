=== Woo Customized ===
Contributors: Sonam Gupta
Requires PHP: 7.4
Require Plugins: WooCommerce


A WooCommerce extension that allows global and per-product custom "Add to Cart" button text, product category-level product code, and a custom frontend product listing shortcode.

== Description ==

**Woo Customized** extends WooCommerce with flexible features including:

- Custom "Add to Cart" button text (global or per-product)
- Add custom Product Code field to product categories
- Display Product Code in cart meta
- Send order data to remote API after order is placed
- Shortcode `[woo_cust_pdts]` for listing products with:
  - AJAX add to cart
  - Live quantity price update
  - "Show Details" popup
  - Pagination
  - Optional image toggle and dynamic controls

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/woo-customized` directory, or install via the WordPress plugin dashboard.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to **WooCommerce > Woo Customized Settings** to configure global options.

== Usage ==

Use this shortcode anywhere to display a dynamic product list:

[woo_cust_pdts image="yes" pagination="yes" per_page="6"]

**Shortcode Attributes:**
- `image="yes"` — Show/hide product image
- `pagination="yes"` — Enable/disable pagination
- `per_page="6"` — Number of products per page

== Requirements ==

- WooCommerce must be installed and activated.
- PHP 7.4+ recommended

== Frequently Asked Questions ==

= Does this plugin work with variable products? =
Currently supports simple products only. Extension for variable products can be added.

= How do I set the Product Code? =
Go to Products > Categories > Edit Category > Fill in "Product Code".

= Can I override the cart button text per product? =
Yes. Enable it in the global settings and edit individual product settings.

== Changelog ==

= 1.0.0 =
* Initial release
* Global & per-product Add to Cart customization
* Product code field at category level
* AJAX add-to-cart in frontend shortcode
* Order data sent to external API on purchase

== Upgrade Notice ==

= 1.0.0 =
First release of Woo Customized.



