<?php 	

	/*
		WooCommerce Hooks: Actions and filters
		URL: https://docs.woocommerce.com/document/introduction-to-hooks-actions-and-filters/
		Hook Reference : https://woocommerce.github.io/code-reference/hooks/hooks.html
	*/

	add_action('woocommerce_after_checkout_billing_form', 'woocommerce_after_checkout_billing_form_function');

	function woocommerce_after_checkout_billing_form_function(){
		echo "woocommerce_after_checkout_billing_form_function";
	}


	//add_action( 'woocommerce_review_order_after_submit', 'approved_trust_badges' );
	function approved_trust_badges() 
	{
		echo '<div class="trust-badges">Add trust badges here</div> <div class="trust-badge-message">I added the trust badges above with a WooCommerce hook: Webprocenter</div>';
	}

	add_action('woocommerce_account_content' , 'woocommerce_account_content_function');

	function woocommerce_account_content_function(){
		woocommerce_account_content();
	}

	// add shipping fields if user selects local pickup on checkout
	add_action('woocommerce_after_shipping_rate', function( $method ) {
		
		if($method->label == 'Local pickup') {
			if ( isset($_POST['shipping_method']) && $_POST['shipping_method'][0] === 'local_pickup:12'  ){
	?>
				<style>
					.shipping_location_box { margin: 15px 15px 10px 15px; }
					.shipping_location_box p { margin: 0 0 10px 20px; }
				</style>
				<div class="shipping_location_box">
					<p>Choose your prefered pickup location</p>					
					<select><option value="">Select</option></select>
				</div>
	<?php 
			} // if post
		} // if local pickup
	});


	//add_filter( 'woocommerce_checkout_fields' , 'misha_print_all_fields' );
	 
	function misha_print_all_fields( $fields ) {
	 
		//if( !current_user_can( 'manage_options' ) )
		//	return; // in case your website is live
	 
		echo '<pre>';
		print_r( $fields ); // wrap results in pre html tag to make it clearer
		echo '</pre>';
		//exit;
	 
	}


	add_action('woocommerce_checkout_update_order_meta', function( $orderid, $data ) {
		if ( isset( $_POST['pickup_location'] ) && $_POST['pickup_location'] != 'none') {
			update_post_meta($orderid, 'pickup_location', htmlspecialchars($_POST['pickup_location']));
		}else{
	// need help here showing the error on checkout
	// this order still goes through when this field is empty
	// on the thank you page, this notice runs
	// id like this checkout process to throw and error and display this notice on the checkout page
			wc_add_notice( __( 'Please select a pickup location.' ), 'error' );
			// exit();
		}
	}, 10, 2);

 ?>
