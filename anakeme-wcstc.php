<?php

/**
 * Plugin Name: Sales Tax Calculator for WooCommerce
 * Plugin URI: https://anake.me/plugins/wcstc
 * Author: Anake.me
 * Author URI: https://anake.me/contact
 * Description: Adds a module in your "Orders" page to assist in calculating product tax.
 * Version: 1.0.0
 */

use Automattic\WooCommerce\Admin\Features\Navigation\Menu;
use Automattic\WooCommerce\Admin\Features\Navigation\Screen;

if( ! defined( 'ABSPATH' ) ) {
    die;
}
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

if ( ! class_exists( 'WCSTC_init' ) ) {

    class WCSTC_init {

        public static function init() {

            // Defined
            define( 'WCSTC_FILE', __FILE__ );
            define( 'WCSTC_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WCSTC_URL', plugin_dir_url( __FILE__ ) );

            // Include
            include( WCSTC_PATH . 'includes/enqueue.php' );

            // Actions
            add_action( 'add_meta_boxes', 'wcstc_shop_order_meta_box' );
            if( class_exists( '\Automattic\WooCommerce\Admin\Features\Navigation\Menu' ) || class_exists( '\Automattic\WooCommerce\Admin\Features\Navigation\Screen' ) ) {
                add_action( 'admin_menu', 'wcstc_admin_menu_register' );
            }

            // Functions
            function wcstc_shop_order_meta_box() {
                add_meta_box( 'wcstc_box', 'Sales Tax Calculator', 'wcstc_box_content', 'shop_order', 'high' );
            }
            function wcstc_box_content() { ?>
                <div id="wcstc_form">
                    <div class="col">
                        <label for="inputPrice">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="inputPrice" placeholder="184.99">
                        </div>
                        <div class="small mb-1"><em>Input price inclusive of tax.</em></div>
                        <label for="inputTaxRate">Tax Rate</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="inputTaxRate" placeholder="18">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="small mb-1"><em>Input tax rate.</em></div>
                        <button type="button" class="button" id="calculateButton">Calculate</button>
                    </div>

                    <div class="col" id="results">
                        <!-- RESULTS GO HERE -->
                    </div>
                </div>
            <?php }

            if( class_exists( '\Automattic\WooCommerce\Admin\Features\Navigation\Menu' ) || class_exists( '\Automattic\WooCommerce\Admin\Features\Navigation\Screen' ) ) {

                function wcstc_admin_menu_register() {

                    if( ! class_exists( '\Automattic\WooCommerce\Admin\Features\Navigation\Menu' ) || ! class_exists( '\Automattic\WooCommerce\Admin\Features\Navigation\Screen' ) ) {
                        return;
                    } else {
                        
                        function wcstc_admin_menu_page_content() {
                            include( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );
                        }

                        add_menu_page( 'Sales Tax Calculator', 'Sales Tax Calculator', 'manage_woocommerce', 'wcstc', 'wcstc_admin_menu_page_content' );

                        Menu::add_plugin_category(
                            array(
                                'id'         => 'hmwce',
                                'title'      => __( 'Hosting Mate', 'hmwce' ),
                                'parent' => 'woocommerce',
                            )
                        );

                        Menu::add_plugin_item(
                            array(
                                'id' => 'wcstc',
                                'title' => __( 'Sales Tax Calculator', 'wcstc' ),
                                'capability' => 'manage_woocommerce',
                                'url' => 'wcstc',
                                'parent' => 'hmwce'
                            )
                        );

                    }

                }
            
            }
            
        }
    
    }

    WCSTC_init::init();

}