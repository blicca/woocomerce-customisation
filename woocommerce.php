<?php 
/**
 * Add Cart icon and count to header if WC is active
 */
function add_icon($items, $args) {
  if( $args->theme_location == 'menu-main' || $args->theme_location == 'menu-flyout' || $args->theme_location == 'menu-main-login' || $args->theme_location == 'menu-flyout-login' ){
    $items .= '<li class="menu-item tpr-shop-cart">';
    $count = WC()->cart->cart_contents_count;
    $items .= '<a class="cart-contents" href="'. wc_get_cart_url() .'" title="View your shopping cart"><span class="cart-header-icon"></span>';

    
       
        $items .= '<span class="cart-contents-count">'.$count.'</span>';
        
    
    $items .= '</a>';    
    $items .= '</li>';
}
return $items;
}

add_filter('wp_nav_menu_items', 'add_icon', 10, 2);


/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span class="cart-header-icon"></span><?php
   
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
    </a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );

/* WooCommerce Settings */
function remove_short_description() {
remove_meta_box( 'postexcerpt2', 'product', 'normal');
}
add_action('add_meta_boxes', 'remove_short_description', 999);


/***********************************/
/* Layout Codes for All Shop Pages */
/***********************************/
function disable_woo_commerce_sidebar() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 
}
add_action('init', 'disable_woo_commerce_sidebar');


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

add_action( 'woocommerce_before_main_content', 'custom_shop_before_main_content', 10);
add_action( 'woocommerce_before_shop_loop', 'custom_woocommerce_before_shop_loop', 10);
add_action( 'woocommerce_after_main_content', 'custom_shop_after_main_content', 10);
function custom_shop_before_main_content($location) {
global $post;
global $woocommerce;

?>
<div class="main-woo">
  <div class="default-page-bg">
      <div class="default-page-caption theme-row">
<?php			 
}

function custom_woocommerce_before_shop_loop($location) {
global $woocommerce;  
?>
	</div>
</div>
<div class="theme-row shop-loop-row">
<?php
}



function custom_shop_after_main_content($location) {
global $woocommerce;  
?>
	</div>
</div>
<?php
}

function woocommerce_product_category( $args = array() ) {
?>
<div class="thepilatesroom-woo-categories">
<a class="main-woo-category" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">All Products</a>	
<?php
the_widget( 'WC_Widget_Product_Categories', 'title=&dropdown=0&max_depth=1');
?>
<div class="gym-mobil-woo-categories">
<?php
the_widget( 'WC_Widget_Product_Categories', 'title=&dropdown=1&max_depth=1');
?>	
</div>
</div>
<?php
}
add_action( 'woocommerce_before_shop_loop', 'woocommerce_product_category', 100 );

/* Sale */
add_filter('woocommerce_sale_flash', 'lw_hide_sale_flash');
function lw_hide_sale_flash()
{
return false;
}

/**
* Remove related products output
*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Remove the product description Title
add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
function remove_product_description_heading() {
 return '';
}

// Remove the additional information title
function remove_additional_information_heading() {
	return '';
}
add_filter( 'woocommerce_product_additional_information_heading', 'remove_additional_information_heading' );


add_action('woocommerce_single_product_summary', 'customizing_single_product_summary_hooks', 2  );
function customizing_single_product_summary_hooks(){
/* move desc */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 5);

/* move price */
remove_action( 'woocommerce_single_product_summary ', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary ', 'woocommerce_template_single_price', 30 );
}
add_action( 'after_setup_theme', 'activello_theme_setup' );
function activello_theme_setup() {
  add_theme_support( 'wc-product-gallery-lightbox' );
}


