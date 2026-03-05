<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @package Asocial_Chameleon
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'premium-single-product', $product ); ?>>

    <div class="product-container">
        
        <!-- Product Images Section -->
        <div class="product-images-section">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>

        <!-- Product Details Section -->
        <div class="product-details-section">
            <div class="product-summary entry-summary">
                
                <!-- Stock Status -->
                <?php if ( $product->is_in_stock() ) : ?>
                    <div class="stock-status in-stock">
                        <span class="stock-icon">✓</span>
                        <span class="stock-text"><?php esc_html_e( 'In Stock', 'asocial-chameleon' ); ?></span>
                    </div>
                <?php else : ?>
                    <div class="stock-status out-of-stock">
                        <span class="stock-icon">✗</span>
                        <span class="stock-text"><?php esc_html_e( 'Out of Stock', 'asocial-chameleon' ); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Product Title -->
                <?php woocommerce_template_single_title(); ?>

                <!-- Rating -->
                <div class="product-rating-wrapper">
                    <?php woocommerce_template_single_rating(); ?>
                </div>

                <!-- Size Guide Link -->
                <div class="size-guide-link">
                    <a href="#size-guide" class="size-guide-trigger">
                        <span class="icon">📏</span>
                        <span class="text"><?php esc_html_e( 'Size Guide', 'asocial-chameleon' ); ?></span>
                    </a>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <?php woocommerce_template_single_excerpt(); ?>
                </div>

                <!-- Price -->
                <div class="product-price-wrapper">
                    <?php 
                    // Display price with discount percentage if on sale
                    if ( $product->is_on_sale() ) {
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        
                        if ( $regular_price && $sale_price ) {
                            $discount_percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                            
                            echo '<div class="price-container">';
                            echo '<span class="regular-price"><del>' . wc_price( $regular_price ) . '</del></span>';
                            echo '<span class="sale-price">' . wc_price( $sale_price ) . '</span>';
                            echo '<span class="discount-badge">' . $discount_percentage . '% OFF</span>';
                            echo '</div>';
                        } else {
                            woocommerce_template_single_price();
                        }
                    } else {
                        woocommerce_template_single_price();
                    }
                    ?>
                </div>

                <!-- Add to Cart Form (includes variations, quantity, etc.) -->
                <div class="product-add-to-cart-wrapper">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                    
                    <!-- Buy Now Button -->
                    <?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
                        <button type="button" class="button buy-now-button premium-action-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                            <span class="button-icon">⚡</span>
                            <span class="button-text"><?php esc_html_e( 'Buy Now', 'asocial-chameleon' ); ?></span>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Product Meta (SKU, Categories, Tags) -->
                <div class="product-meta-wrapper">
                    <?php woocommerce_template_single_meta(); ?>
                </div>

                <!-- Sharing -->
                <div class="product-sharing-wrapper">
                    <?php woocommerce_template_single_sharing(); ?>
                </div>

            </div><!-- .summary -->
        </div><!-- .product-details-section -->

    </div><!-- .product-container -->

    <!-- Product Tabs (Description, Additional Info, Reviews) -->
    <div class="product-tabs-wrapper">
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
