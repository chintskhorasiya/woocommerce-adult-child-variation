<?php
/*
Plugin Name: Woocommerce Adult Child Variation
Description: You can select number of adult and number of child for your product and can define price per adult and price per child
Version: 1.0.0
Author: Chintan Khorasiya
Author URI: https://github.com/chintskhorasiya
*/

/**
 * Check if WooCommerce is active
 **/
if (!in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   return;
}

global $ADULT_CHILD_PRODUCT_CATEGORIES;
$ADULT_CHILD_PRODUCT_CATEGORIES = array('15');

// only copy the opening php tag if needed
// Change the shop / product prices if a unit_price is set
function sv_change_product_html( $price_html, $product ) {

	if(is_product()):

	//$unit_price = get_post_meta( $product->id, 'unit_price', true );
	$sale_price = get_post_meta( $product->id, '_price', true );
	$_price_per_adult = (float)get_post_meta( $product->id, '_price_per_adult', true );
	$_price_per_child = (float)get_post_meta( $product->id, '_price_per_child', true );
	$_price_motor_per_person = (float)get_post_meta( $product->id, '_price_motor_per_person', true );
	//var_dump($sale_price);var_dump($_price_per_adult );var_dump($_price_per_child );
    if ($_price_per_adult >= 1 && $_price_per_child >= 0 ) {
		//$price_html = '<input type="number" id="unit" name="unit" /><span class="amount">';
		//$price_html = '' . wc_price($sale_price). '';
		$price_html = '<span class="woocommerce-Price-amount amount">Please select options first</span>';
		$price_html .= '<input type="hidden" name="product_price_per_adult" id="product_price_per_adult" value="'.$_price_per_adult.'">';
		$price_html .= '<input type="hidden" name="product_price_per_child" id="product_price_per_child" value="'.$_price_per_child.'">';

		if($_price_motor_per_person > 0){
			$price_html .= '<input type="hidden" name="product_price_motor_per_person" id="product_price_motor_per_person" value="'.$_price_motor_per_person.'">';
		}

		$default_currency_symbol = get_woocommerce_currency_symbol();

		$price_html .= '<input type="hidden" id="default_currency_symbol" value="'.$default_currency_symbol.'">';

		$price_html .= '<div id="adult_child_fields">';
    	//$price_html .= 'Adult : <input type="number" min="1" max="25" value="" name="number_of_adult" id="number_of_adult" /><br><br>	';
		$price_html .= '<div class="adult-field">Adult(s) : <select name="number_of_adult" id="number_of_adult"><option value="">--Select Adult--</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option></select></div>';
		//$price_html .= 'Child : <input type="number" min="0" max="25" value="" name="number_of_child" id="number_of_child" />';
		$price_html .= '<div class="child-field">Child(s) : <select name="number_of_child" id="number_of_child"><option value="">--Select Child--</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option></select></div>	';

		if($_price_motor_per_person > 0)
		{
			$price_html .= '<div class="add-motor-coach"><input disabled="disabled" type="checkbox" name="need_motor_coach" id="need_motor_coach" value="1"> Add Motor Coach (Per Person '.$default_currency_symbol.$_price_motor_per_person.')</div>';
		}

		$price_html .= '<div class="additional-notes"><label>Additional Notes:<label><input type="text" name="additional_notes" id="additional_notes" placeholder="Mention your nearest hotel and additional notes"></div>';

		$price_html .= '</div>';	
		
	} else {
		$price_html = '' . wc_price($sale_price). '';		
	}
	else:


	endif;

	return $price_html;

}
add_filter( 'woocommerce_get_price_html', 'sv_change_product_html', 10, 2 );
//add_filter( 'woocommerce_cart_item_price', 'sv_change_product_html', 10, 2 );
// Change the cart prices if a unit_price is set
function sv_change_product_price_cart( $price, $cart_item, $cart_item_key ) {
	$unit_price = get_post_meta( $cart_item['product_id'], 'unit_price', true );
	//$unit_price = 444;
	if ( ! empty( $unit_price ) ) {
		//$price = wc_price( $unit_price ) . ' per kg';	
		$price = wc_price( $unit_price );	
	}
	return $price;
}

add_action( 'woocommerce_single_product_summary', 'return_policy', 10, 2 );

function return_policy() {

	//echo '<p id="rtrn">30-day return policy offered. See Terms and Conditions for details.</p>';


    //echo '<div id="adult_child_fields">';
    //echo 'Adult : <input type="number" min="1" max="25" value="" name="number_of_adult" id="number_of_adult" /><br><br>	';
	//echo 'Child : <input type="number" min="0" max="25" value="" name="number_of_child" id="number_of_child" />';
	//echo '</div>';
	echo "<script type=\"text/javascript\">
		    jQuery(document).ready(function(){
		        var product_price_per_adult = parseFloat(jQuery('#product_price_per_adult').val());
		        var product_price_per_child = parseFloat(jQuery('#product_price_per_child').val());
		        var product_price_motor_per_person = parseFloat(jQuery('#product_price_motor_per_person').val());
		        var default_currency_symbol = jQuery('#default_currency_symbol').val();

		        if(product_price_per_adult > 0 && product_price_per_adult > 0){

		        	jQuery('.quantity input[type=\"number\"]').hide();
					jQuery('.quantity input[type=\"button\"]').hide();
			        jQuery('.single_add_to_cart_button').attr('disabled', 'disabled');
			        //jQuery('.woocommerce-Price-amount').text('Please select options first');

			        function checkAdultAndChild(){
			        	var adultVal = parseInt(jQuery('#number_of_adult').val());
			        	var childVal = parseInt(jQuery('#number_of_child').val());

			        	console.log(adultVal);
			        	console.log(childVal);

			        	if(adultVal >= 1 && childVal >= 0){
			        		console.log('it will change now');
			        		jQuery('.single_add_to_cart_button').attr('disabled', false);
			        		if(jQuery('#need_motor_coach').prop('checked')) {
			        			var totalPerson = adultVal + childVal;
			        			var totalPrice = (product_price_per_adult * adultVal) + (product_price_per_child * childVal) + (product_price_motor_per_person * totalPerson);
			        		} else {
			        			var totalPrice = (product_price_per_adult * adultVal) + (product_price_per_child * childVal);
			        		}
			        		jQuery('.woocommerce-Price-amount').html('<span class=\"woocommerce-Price-currencySymbol\">'+default_currency_symbol+'</span>'+totalPrice);
			        		jQuery('#need_motor_coach').removeAttr('disabled');
			        	} else {
			        		console.log('it will change now');
			        		jQuery('#need_motor_coach').attr('disabled', 'disabled');
			        		jQuery('.single_add_to_cart_button').attr('disabled', 'disabled');
			        		jQuery('.woocommerce-Price-amount').text('Please select options first');
			        	}
			        }

			        jQuery('#number_of_adult').change(function(){
			        	checkAdultAndChild();
			        });

			        jQuery('#number_of_child').change(function(){
			        	checkAdultAndChild();
			        });

			        function addMotorPrice(){
			        	var adultVal = parseInt(jQuery('#number_of_adult').val());
			        	var childVal = parseInt(jQuery('#number_of_child').val());

			        	var totalPerson = adultVal + childVal;
			        	var totalPrice = (product_price_per_adult * adultVal) + (product_price_per_child * childVal) + (product_price_motor_per_person * totalPerson);
			        	jQuery('.woocommerce-Price-amount').html('<span class=\"woocommerce-Price-currencySymbol\">'+default_currency_symbol+'</span>'+totalPrice);
			        }

			        function removeMotorPrice(){
			        	var adultVal = parseInt(jQuery('#number_of_adult').val());
			        	var childVal = parseInt(jQuery('#number_of_child').val());

			        	var totalPerson = adultVal + childVal;
			        	var totalPrice = (product_price_per_adult * adultVal) + (product_price_per_child * childVal);
			        	jQuery('.woocommerce-Price-amount').html('<span class=\"woocommerce-Price-currencySymbol\">'+default_currency_symbol+'</span>'+totalPrice);
			        }

			        jQuery('#need_motor_coach').click(function(){
			        	var motorChecked = jQuery(this).prop('checked');
			        	if(motorChecked){
			        		addMotorPrice();
			        	} else {
			        		removeMotorPrice();
			        	}
			        })


			        jQuery('.single_add_to_cart_button').click(function(){
			            //code to add validation, if any
			            //If all values are proper, then send AJAX request
			            console.log('sending ajax request');
			            var number_of_adult = jQuery('#number_of_adult').val();
			            var number_of_child = jQuery('#number_of_child').val();
			            
			            var motorChecked = jQuery('#need_motor_coach').prop('checked');
			            var product_price_motor_per_person = 0;
			            if(motorChecked){
			            	product_price_motor_per_person = jQuery('#product_price_motor_per_person').val();
			            }

			            var additional_notes = jQuery('#additional_notes').val();
			            //alert('product_price_motor_per_person:'+product_price_motor_per_person);
			            //var custom_data_3 = 'custom_data_3';
			            //var custom_data_4 = 'custom_data_4';
			            //var custom_data_5 = 'custom_data_5';
			            var ajaxurl = '".admin_url('admin-ajax.php')."';
			            jQuery.ajax({
			                url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
			                type: 'POST',
			                data: {
			                    //action name
			                    action:'wdm_add_user_custom_data_options',
			                    number_of_adult : number_of_adult,
			                    number_of_child : number_of_child,
			                    motor_price : product_price_motor_per_person,
			                    additional_notes : additional_notes,
			                    //custom_data_3 : custom_data_3,
			                    //custom_data_4 : custom_data_4,
			                    //custom_data_5 : custom_data_5
			                },
			                async : false,
			                success: function(data){
			                    //Code, that need to be executed when data arrives after
			                    // successful AJAX request execution
			                    console.log('ajax response received');
			                }
			            });
			        });

		        } else {

		        	jQuery('#adult_child_fields').hide();

		        }
		    });
		</script>";
}


// Change the line total price
add_filter( 'woocommerce_get_discounted_price', 'calculate_discounted_price', 10, 2 );
// Display the line total price
add_filter( 'woocommerce_cart_item_subtotal', 'display_discounted_price', 10, 2 );
add_filter( 'woocommerce_cart_subtotal', 'display_discounted_subprice', 10, 3 );

function calculate_discounted_price( $price, $cart_item ) {

	$sale_price = (int)get_post_meta( $cart_item['product_id'], '_price', true );
	$adult_price = (float)get_post_meta( $cart_item['product_id'], '_price_per_adult', true );
	$child_price = (float)get_post_meta( $cart_item['product_id'], '_price_per_child', true );
	$number_of_adult = (int)$cart_item['number_of_adult'];
	//echo '<pre>';print_r($cart_item);echo '</pre>';
	$number_of_child = (int)$cart_item['number_of_child'];
	$motor_price = (float)$cart_item['motor_price'];
	$additional_notes = $cart_item['additional_notes'];
	if($number_of_adult >= 1  && $number_of_child >= 0 && !empty($adult_price) && !empty($child_price)){
		$price = ($adult_price * $number_of_adult) + ($child_price * $number_of_child);
		if($motor_price > 0){
			$price = $price + ($motor_price * ($number_of_child+$number_of_adult));
		}
	} else {
		$price = $price;
	}
	
    return $price;
}

// wc_price => format the price with your own currency
function display_discounted_price( $values, $item ) {
    return wc_price( $item[ 'line_total' ] );
}

// wc_price => format the price with your own currency
function display_discounted_subprice( $values, $param2, $param3 ) {
//echo '<pre>';print_r($param3->cart_contents);echo '</pre>';
/*$cart_contents = $param3->cart_contents;
foreach($cart_contents as $cc_key => $cc_value){
	echo '<pre>';print_r($cart_contents[$cc_key]);echo '</pre>';
	$cart_data = $cart_contents[$cc_key];
$total = $cart_data['line_total'];
$cate_ids = $cart_data['line_total']['data']->category_ids;
var_dump($cate_ids);
break;
}*/
	global $woocommerce;
	$subt = $woocommerce->cart->subtotal;
	$total = $woocommerce->cart->total;
	$amount = wc_price($total);
    return $amount ;
}

#######################################################################################################################


// To add custom data above add to cart button in woocommerce

// step 1

add_action('wp_ajax_wdm_add_user_custom_data_options', 'wdm_add_user_custom_data_options_callback');
add_action('wp_ajax_nopriv_wdm_add_user_custom_data_options', 'wdm_add_user_custom_data_options_callback');

function wdm_add_user_custom_data_options_callback()
{
    //Custom data - Sent Via AJAX post method
    $product_id = $_POST['id']; //This is product ID
    $number_of_adult = $_POST['number_of_adult']; //This is User custom value sent via AJAX
    $number_of_child = $_POST['number_of_child'];
    $motor_price = $_POST['motor_price'];
    $additional_notes = $_POST['additional_notes'];

    session_start();
    $_SESSION['number_of_adult'] = $number_of_adult;
    $_SESSION['number_of_child'] = $number_of_child;
    $_SESSION['motor_price'] = $motor_price;
    $_SESSION['additional_notes'] = $additional_notes;
    die();
}

// step 2

add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,2);

if(!function_exists('wdm_add_item_data'))
{
    function wdm_add_item_data($cart_item_data,$product_id)
    {
        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
        global $woocommerce;
        session_start();
        
        global $ADULT_CHILD_PRODUCT_CATEGORIES;
    	
    	$terms = get_the_terms($product_id, 'product_cat' );
		
	if(!empty($terms) && count($terms) > 0){

		foreach ($terms as $term) {
		    $product_cat_id = $term->term_id;
		    break;
		}

		if(in_array($product_cat_id, $ADULT_CHILD_PRODUCT_CATEGORIES)){

		        $new_value = array();
		
		
		        if (isset($_SESSION['number_of_adult'])) {
		            $option1 = $_SESSION['number_of_adult'];
		            $new_value['number_of_adult'] =  $option1;
		        }
		        if (isset($_SESSION['number_of_child'])) {
		            $option2 = $_SESSION['number_of_child'];
		            $new_value['number_of_child'] =  $option2;
		        }
		        if (isset($_SESSION['motor_price'])) {
		            $option3 = $_SESSION['motor_price'];
		            $new_value['motor_price'] =  $option3;
		        }
		        if (isset($_SESSION['additional_notes'])) {
		            $option4 = $_SESSION['additional_notes'];
		            $new_value['additional_notes'] =  $option4;
		        }
		
		        if( empty($option1) && empty($option2) && empty($option3) && empty($option4) /*&& empty($option5)*/  )
		            return $cart_item_data;
		        else
		        {
		            if(empty($cart_item_data))
		                return $new_value;
		            else
		                return array_merge($cart_item_data,$new_value);
		        }
		
		
		//        vardump($new_value);
		//        die();
		
		
		        unset($_SESSION['number_of_adult']);
		        unset($_SESSION['number_of_child']);
		        unset($_SESSION['motor_price']);
		        unset($_SESSION['additional_notes']);
		        
		        //Unset our custom session variable, as it is no longer needed.
		}
	}
    }
}

// step 3

add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3 );
if(!function_exists('wdm_get_cart_items_from_session'))
{
    function wdm_get_cart_items_from_session($item,$values,$key)
    {

        if (array_key_exists( 'number_of_adult', $values ) )
        {
            $item['number_of_adult'] = $values['number_of_adult'];
        }

        if (array_key_exists( 'number_of_child', $values ) )
        {
            $item['number_of_child'] = $values['number_of_child'];
        }

        if (array_key_exists( 'motor_price', $values ) )
        {
            $item['motor_price'] = $values['motor_price'];
        }

        if (array_key_exists( 'additional_notes', $values ) )
        {
            $item['additional_notes'] = $values['additional_notes'];
        }

        return $item;
    }
}


// step 4

add_filter('woocommerce_checkout_cart_item_quantity','wdm_add_user_custom_option_from_session_into_cart',1,3);
add_filter('woocommerce_cart_item_price','wdm_add_user_custom_option_from_session_into_cart',1,3);

if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
    function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
    	global $ADULT_CHILD_PRODUCT_CATEGORIES;
    	
    	$terms = get_the_terms( $values['product_id'], 'product_cat' );
		
	if(!empty($terms) && count($terms) > 0){

		foreach ($terms as $term) {
		    $product_cat_id = $term->term_id;
		    break;
		}

		if(in_array($product_cat_id, $ADULT_CHILD_PRODUCT_CATEGORIES)){

		    	/*code to add custom data on Cart & checkout Page*/
		        if(count($values['number_of_adult']) > 0)
		        {
		            $adult_price = (float)get_post_meta( $values['product_id'], '_price_per_adult', true );
			    $child_price = (float)get_post_meta( $values['product_id'], '_price_per_child', true );
		            $return_string = $product_name . "</a><dl class='variation'>";
		            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
		            $return_string .= "<tr><td> Adult(s) : " . $values['number_of_adult'] . " × ".$adult_price ."</td></tr>";
		            $return_string .= "<tr><td> Child(s) : " . $values['number_of_child'] . " × ".$child_price."</td></tr>";
		            if($values['motor_price'] > 0){
		            	$return_string .= "<tr><td> Motor Coach Price (Per Person ".$values['motor_price'].") : " . ($values['number_of_adult']+$values['number_of_child']) . " × ".$values['motor_price']."</td></tr>";
		            }
		            if(strlen($values['additional_notes']) > 0){
		            	$return_string .= "<tr><td> Additional Notes : " .$values['additional_notes']."</td></tr>";
		            }
		            $return_string .= "</table></dl>";
		
		            return $return_string;
		        }
		        else
		        {
		            return $product_name;
		        }
		}
		else
	        {
	            return $product_name;
	        }
	}
	else
        {
            return $product_name;
        }
    }
}


// step 5

add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
    function wdm_add_values_to_order_item_meta($item_id, $values)
    {
        global $woocommerce,$wpdb;


        $user_custom_values = $values['wdm_user_custom_data_value'];

        if(!empty($user_custom_values))
        {
            wc_add_order_item_meta($item_id,'wdm_user_custom_data',$user_custom_values);
        }
        
        $number_of_adult = $values['number_of_adult'];

        if(!empty($number_of_adult))
        {
            wc_add_order_item_meta($item_id,'number_of_adult',$number_of_adult);
        }

        $number_of_child = $values['number_of_child'];

        if(!empty($number_of_child))
        {
            wc_add_order_item_meta($item_id,'number_of_child',$number_of_child);
        }

        $motor_price = $values['motor_price'];

        if(!empty($motor_price))
        {
            wc_add_order_item_meta($item_id,'motor_price',$motor_price);
        }

    }
}


// step 6

add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('wdm_remove_user_custom_data_options_from_cart'))
{
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
            if ( $values['wdm_user_custom_data_value'] == $cart_item_key )
                unset( $woocommerce->cart->cart_contents[ $key ] );
        }
    }
}

// Display Fields using WooCommerce Action Hook
add_action( 'woocommerce_product_options_general_product_data', 'woocom_general_product_data_custom_field' );

function woocom_general_product_data_custom_field() {

	global $ADULT_CHILD_PRODUCT_CATEGORIES;

	if(!empty($_GET['post'])){
		
		$terms = get_the_terms( $_GET['post'], 'product_cat' );
		
		if(!empty($terms) && count($terms) > 0){

			foreach ($terms as $term) {
			    $product_cat_id = $term->term_id;
			    break;
			}

			if(in_array($product_cat_id, $ADULT_CHILD_PRODUCT_CATEGORIES)){
				// Create a custom text field

				// Number Field
				  woocommerce_wp_text_input( 
				    array( 
				      'id' => '_price_per_adult', 
				      'label' => __( 'Price per adult', 'woocommerce' ), 
				      'placeholder' => '', 
				      'description' => __( 'Enter the price per adult.', 'woocommerce' ),
				      'type' => 'number', 
				      'custom_attributes' => array(
				         'min' => '1',
						 'step'=> '0.01'
				      ) 
				    )
				  );

				  // Number Field
				  woocommerce_wp_text_input( 
				    array( 
				      'id' => '_price_per_child', 
				      'label' => __( 'Price per child', 'woocommerce' ), 
				      'placeholder' => '', 
				      'description' => __( 'Enter the price per child.', 'woocommerce' ),
				      'type' => 'number', 
				      'custom_attributes' => array(
				         'min' => '1',
						 'step'=> '0.01'
				      ) 
				    )
				  );

				  // Number Field
				  woocommerce_wp_text_input( 
				    array( 
				      'id' => '_price_motor_per_person', 
				      'label' => __( 'Price of Motor Coach per person(adult/child)', 'woocommerce' ), 
				      'placeholder' => '', 
				      'description' => __( 'Enter the Price of motor coach.', 'woocommerce' ),
				      'type' => 'number', 
				      'custom_attributes' => array(
				         'min' => '1',
						 'step'=> '0.01'
				      ) 
				    )
				  );
			}
		}
	}

}

// Hook to save the data value from the custom fields
add_action( 'woocommerce_process_product_meta', 'woocom_save_general_proddata_custom_field' );

/** Hook callback function to save custom fields information */
function woocom_save_general_proddata_custom_field( $post_id ) {

	//print_r($_POST);exit;
	//var_dump($post_id);exit;
 
  // Save Number Field
  $_price_per_adult = $_POST['_price_per_adult'];
  if( ! empty( $_price_per_adult ) ) {
     update_post_meta( $post_id, '_price_per_adult', esc_attr( $_price_per_adult ) );
  } else {
  	update_post_meta( $post_id, '_price_per_adult', 0 );
  }

  $_price_per_child = $_POST['_price_per_child'];
  if( ! empty( $_price_per_child ) ) {
     update_post_meta( $post_id, '_price_per_child', esc_attr( $_price_per_child ) );
  } else {
  	update_post_meta( $post_id, '_price_per_child', 0 );
  }

  $_price_motor_per_person = $_POST['_price_motor_per_person'];
  if( ! empty( $_price_motor_per_person ) ) {
     update_post_meta( $post_id, '_price_motor_per_person', esc_attr( $_price_motor_per_person ) );
  } else {
  	update_post_meta( $post_id, '_price_motor_per_person', 0 );
  }
  
}

?>