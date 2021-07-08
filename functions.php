add_action( 'woocommerce_product_options_pricing', 'codeithub_add_RRP_to_products' );      
  
function codeithub_add_RRP_to_products() {          
    woocommerce_wp_text_input( array( 
        'id' => 'rrp', 
        'class' => 'short wc_input_price', 
        'label' => __( 'RRP', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
        'data_type' => 'price', 
    ));      
}
  

add_action( 'save_post_product', 'codeithub_save_RRP' );
  
function codeithub_save_RRP( $product_id ) {
    global $pagenow, $typenow;
    if ( 'post.php' !== $pagenow || 'product' !== $typenow ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( isset( $_POST['rrp'] ) ) {
        update_post_meta( $product_id, 'rrp', $_POST['rrp'] );
    }
}
 
add_action( 'woocommerce_single_product_summary', 'codeithub_display_RRP', 9 );
  
function codeithub_display_RRP() {
    global $product;
    if ( $product->get_type() <> 'variable' && $rrp = get_post_meta( $product->get_id(), 'rrp', true ) ) {
        echo '<div class="woocommerce_rrp">';
        _e( 'RRP: ', 'woocommerce' );
        echo '<span>' . wc_price( $rrp ) . '</span>';
        echo '</div>';
    }
}
