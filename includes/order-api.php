<?php
add_action('woocommerce_thankyou', 'woo_custom_send_order_to_api', 10, 1);
function woo_custom_send_order_to_api($order_id) {
    if (!$order_id) return;

    $order = wc_get_order($order_id);
    if (!$order) return;

    $items = array();

    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;

        $items[] = [
            'productId' => $product->get_sku() ?: 'no-sku-' . $product->get_id(),
            'name'      => $item->get_name(),
            'quantity'  => $item->get_quantity(),
            'price'     => floatval($order->get_item_total($item, false))
        ];
    }

    $payload = [
        'userId' => $order->get_user_id() ?: $order->get_billing_email(),
        'cart' => [
            'items'    => $items,
            'currency' => $order->get_currency(),
            'total'    => floatval($order->get_total())
        ]
    ];

    $response = wp_remote_post( WOO_CURL_URL, [
        'method'      => 'POST',
        'headers'     => [
            'Content-Type' => 'application/json',
        ],
        'body'        => wp_json_encode($payload),
        'data_format' => 'body',
        'timeout'     => 15,
    ]);

    // Optional: log response for debug
    if (is_wp_error($response)) {
        error_log('Order API call failed: ' . $response->get_error_message());
    } else {
        error_log('Order API success: ' . wp_remote_retrieve_body($response));
    }
}
