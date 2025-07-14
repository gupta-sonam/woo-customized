<?php
add_action('product_cat_add_form_fields', 'product_cat_add_form_fields_cb'); 

function product_cat_add_form_fields_cb() {
    ?>
    <div class="form-field">
        <label for="product_code"><?php _e('Product Code'); ?></label>
        <input type="text" name="product_code" id="product_code">
    </div>
    <?php
}

add_action('product_cat_edit_form_fields', 'product_cat_edit_form_fields_cb'); 
function product_cat_edit_form_fields_cb($term) {
    $code = get_term_meta($term->term_id, 'product_code', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="product_code"><?php _e('Product Code'); ?></label></th>
        <td><input type="text" name="product_code" value="<?php echo esc_attr($code); ?>"></td>
    </tr>
    <?php
}

add_action('created_product_cat', 'save_product_cat_meta');
add_action('edited_product_cat', 'save_product_cat_meta');

function save_product_cat_meta($term_id) {
    if (isset($_POST['product_code'])) {
        update_term_meta($term_id, 'product_code', sanitize_text_field($_POST['product_code']));
    }
}
