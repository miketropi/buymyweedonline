<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {
    echo $wrap_before;
    $breadcrumb_count = count( $breadcrumb );
    foreach ( $breadcrumb as $key => $crumb ) {
        if ( $key === $breadcrumb_count - 1 ) {
            // Skip the last breadcrumb item (product name)
            continue;
        }
        echo $before;
        if ( ! empty( $crumb[1] ) && $breadcrumb_count !== $key + 1 ) {
            echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
        } else {
            echo esc_html( $crumb[0] );
        }
        echo $after;
        if ( $breadcrumb_count !== $key + 1 && $key !== $breadcrumb_count - 2 ) {
            echo $delimiter;
        }
    }
    echo $wrap_after;
}