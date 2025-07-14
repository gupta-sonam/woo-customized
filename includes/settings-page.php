<?php
add_action('admin_menu', function() {
    add_submenu_page(
        'woocommerce',
        'Woo Customized Settings',
        'Woo Customized',
        'manage_options',
        'woo-customized',
        'woo_customized_settings_callback'
    );
});

function woo_customized_settings_callback() {
    ?>
    <form method="post" action="options.php">
        <?php
        settings_fields('woo_customized_group');
        do_settings_sections('woo-customized');
        submit_button();
        ?>
    </form>
    <?php
}

add_action('admin_init', function() {
    register_setting('woo_customized_group', 'woo_customized_enabled');
    register_setting('woo_customized_group', 'woo_customized_cart_text');

    add_settings_section('main_section', 'Main Settings', null, 'woo-customized');

    add_settings_field(
        'enable_custom_text',
        'Enable Custom Add to Cart Text',
        function() {
            echo '<input type="checkbox" name="woo_customized_enabled" value="1" ' . checked(1, get_option('woo_customized_enabled'), false) . ' />';
        },
        'woo-customized',
        'main_section'
    );

    add_settings_field(
        'custom_text_value',
        'Custom Add to Cart Text',
        function() {
            echo '<input type="text" name="woo_customized_cart_text" value="' . esc_attr(get_option('woo_customized_cart_text')) . '" />';
        },
        'woo-customized',
        'main_section'
    );
});
