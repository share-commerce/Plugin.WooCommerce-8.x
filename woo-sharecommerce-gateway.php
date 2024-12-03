<?php
/**
 * Plugin Name: Share Commerce Gateway 
 * Plugin URI: https://www.share-commerce.com/
 * Description: Share Commerce Gateway Plugin for WooCommerce.
 * Version: 1.0.9
 *
 * Author: Share Commerce
 * Author URI: https://www.share-commerce.com/
 *
 * Text Domain: woocommerce-gateway-sharecommerce
 * Domain Path: /i18n/languages/
 *
 * Requires at least: 4.0
 * Tested up to: 6.5.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC ShareCommerce Payment gateway plugin class.
 *
 * @class WC_ShareCommerce_Payments
 */
class WC_ShareCommerce_Payments {

	/**
	 * Plugin bootstrapping.
	 */
	public static function init() {

		// Share Commerce Payments gateway class.
		add_action( 'plugins_loaded', array( __CLASS__, 'includes' ), 0 );

		// Make the Share Commerce Payments gateway available to WC.
		add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'add_gateway' ) );

		// Registers WooCommerce Blocks integration.
		add_action( 'woocommerce_blocks_loaded', array( __CLASS__, 'sharecommerce_gateway_block_support' ) );

	}


	

	/**
	 * Add the Share Commerce Payment gateway to the list of available gateways.
	 *
	 * @param array
	 */
	public static function add_gateway( $gateways ) {

		$gateways[] = 'WC_Gateway_ShareCommerce';
		return $gateways;
	}

	/**
	 * Plugin includes.
	 */
	public static function includes() {

		// Make the WC_Gateway_ShareCommerce class available.
		if ( class_exists( 'WC_Payment_Gateway' ) ) {
			require_once 'includes/class-wc-gateway-sharecommerce.php';
		}
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_abspath() {
		return trailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Registers WooCommerce Blocks integration.
	 *
	 */
	public static function sharecommerce_gateway_block_support() {
		if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			require_once 'includes/blocks/class-wc-sharecommerce-payments-blocks.php';
			add_action(
				'woocommerce_blocks_payment_method_type_registration',
				function( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
					$payment_method_registry->register( new WC_Gateway_ShareCommerce_Blocks_Support() );
				}
			);
		}
	}
}

WC_ShareCommerce_Payments::init();


add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sharecommerce_woo_plugin_links');

function sharecommerce_woo_plugin_links($links)
{
	$plugin_links = array(
		'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=sharecommerce' ) . '">' . __( 'Settings', 'woocommerce-gateway-sharecommerce' ) . '</a>',
	);

	# Merge our new link with the default ones
	return array_merge($links, $plugin_links);
	// return $plugin_links;
}


# redirect 
add_action( 'init', 'sharecommerce_gateway_redirect', 15 );

function sharecommerce_gateway_redirect() {
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
		return;
	}

	include_once( 'includes/class-wc-gateway-sharecommerce.php' );

	$func = new WC_Gateway_ShareCommerce();
	$func->sharecommerce_gateway_redirect();
}



# callback 
add_action( 'init', 'sharecommerce_gateway_callback', 15 );

function sharecommerce_gateway_callback() {
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
		return;
	}

	include_once( 'includes/class-wc-gateway-sharecommerce.php' );

	$func = new WC_Gateway_ShareCommerce();
	$func->sharecommerce_gateway_callback();
}




function sharecommerce_hash_error_msg( $content ) {
	return '<div class="woocommerce-error">The data that we received is invalid. Thank you.</div>' . $content;
}

function sharecommerce_payment_declined_msg( $content ) {
	return '<div class="woocommerce-error">The payment was declined. Please check with your bank. Thank you.</div>' . $content;
}

function sharecommerce_success_msg( $content ) {
	return '<div class="woocommerce-info">The payment was successful. Thank you.</div>' . $content;
}