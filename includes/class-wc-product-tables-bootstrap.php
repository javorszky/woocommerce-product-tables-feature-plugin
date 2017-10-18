<?php
/**
 * Bootstrap file.
 *
 * Loads everything needed for the plugin to function.
 *
 * @package WooCommerce Product Tables Feature Plugin
 * @author Automattic
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * WC_Product_Tables_Bootstrap
 */
class WC_Product_Tables_Bootstrap {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->includes();
		add_filter( 'woocommerce_data_stores', array( $this, 'replace_core_data_stores' ) );
	}

	/**
	 * Include classes
	 */
	public function includes() {
		require_once 'class-wc-product-tables-backwards-compatibility.php';
		require_once 'class-wc-product-tables-install.php';
		require_once 'class-wc-product-tables-migrate-data.php';

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			require_once 'class-wc-product-tables-cli.php';
		}
	}

	/**
	 * Replace the core data store for products.
	 *
	 * @param array $stores List of data stores.
	 * @return array
	 */
	public function replace_core_data_stores( $stores ) {
		include_once dirname( __FILE__ ) . '/data-stores/class-wc-product-data-store-custom-table.php';
		include_once dirname( __FILE__ ) . '/data-stores/class-wc-product-grouped-data-store-custom-table.php';
		include_once dirname( __FILE__ ) . '/data-stores/class-wc-product-variable-data-store-custom-table.php';
		include_once dirname( __FILE__ ) . '/data-stores/class-wc-product-variation-data-store-custom-table.php';

		$stores['product']   = 'WC_Product_Data_Store_Custom_Table';
		$stores['grouped']   = 'WC_Product_Grouped_Data_Store_Custom_Table';
		$stores['variable']  = 'WC_Product_Variable_Data_Store_Custom_Table';
		$stores['variation'] = 'WC_Product_Variation_Data_Store_Custom_Table';

		return $stores;
	}
}

new WC_Product_Tables_Bootstrap();
