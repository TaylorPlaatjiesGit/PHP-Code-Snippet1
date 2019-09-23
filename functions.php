add_filter('wc_add_to_cart_message', 'change_continue_shopping_destination');
function change_continue_shopping_destination() {
  global $woocommerce;
	
	$return_to  = get_permalink(woocommerce_get_page_id('shop'));
	
	$items = $woocommerce->cart->get_cart();
	$last_product = null;
	
	foreach($items as $item => $values) { 
		$product = get_page_by_title($values['data']->get_title(), OBJECT, 'product');
		$last_product = $product;
	} 
	
	if($last_product) {
		$terms = get_the_terms($last_product->ID, 'product_cat');
		$product_cat = null;
		foreach ($terms as $term) {
			$product_cat = $term;
			break;
		}
		
		if($product_cat) {
			$return_to  = get_option('home') . '/product-category/' . $product_cat->slug;
		}
	}
	
  $message    = sprintf('<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', $return_to, __('Continue Shopping', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
	
  return $message;
}
