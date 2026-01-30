<?php
/**
 * The template for displaying product content within loops
 *
 * @package Asocial_Chameleon
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<div <?php wc_product_class( 'product-card premium-card', $product ); ?>>
    
    <!-- Image Section -->
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-image-link">
        <?php 
        $image_size = 'woocommerce_thumbnail';
        if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail( $product->get_id(), $image_size );
        } elseif ( wc_placeholder_img_src() ) {
            echo wc_placeholder_img( $image_size );
        }
        ?>
        <?php if ( $product->is_on_sale() ) : ?>
            <span class="sale-badge">Sale</span>
        <?php endif; ?>
    </a>

    <!-- Content Section -->
    <div class="product-content">
        <!-- Category -->
        <div class="product-category-hint">
            <?php echo wc_get_product_category_list( $product->get_id(), ', ', '', '' ); ?>
        </div>

        <!-- Title -->
        <h3 class="product-title">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Rating -->
        <div class="product-rating">
            <?php woocommerce_template_loop_rating(); ?>
        </div>

        <!-- Price -->
        <div class="product-price">
            <?php echo $product->get_price_html(); ?>
        </div>
        
        <!-- Action Buttons -->
        <?php 
        if ( function_exists( 'asocial_chameleon_add_product_buttons' ) ) {
            asocial_chameleon_add_product_buttons();
        }
        ?>
    </div>
</div>
