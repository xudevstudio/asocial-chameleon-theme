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

<div <?php wc_product_class( 'product-card premium-card', $product ); ?> style="display: flex; flex-direction: column; height: 100%;">
    
    <!-- Image Section -->
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-image-link" style="position: relative; overflow: hidden; display: block;">
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
        
        <!-- Hover Overlay for Quick Actions (Desktop) -->
        <div class="product-hover-overlay"></div>
    </a>

    <!-- Content Section -->
    <div class="product-content" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; padding: 15px;">
        
        <div class="product-info-top">
            <!-- Category - HIDDEN -->
            <?php /* 
            <div class="product-category-hint">
                <?php echo wc_get_product_category_list( $product->get_id(), ', ', '', '' ); ?>
            </div>
            */ ?>

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
            
            <!-- Short Description (for related products) -->
            <?php 
            if ( method_exists( $product, 'get_short_description' ) && $product->get_short_description() ) {
                echo '<div class="product-short-description" style="font-size: 13px; color: #666; margin-bottom: 10px; line-height: 1.4;">' . wp_trim_words( $product->get_short_description(), 10 ) . '</div>';
            }
            ?>
        </div>

        <div class="product-info-bottom">
            <!-- Price -->
            <div class="product-price">
                <?php 
                $price_html = $product->get_price_html();
                // Force all price text to black by wrapping in styled span
                if (!empty($price_html)) {
                    echo '<span class="price-text">' . $price_html . '</span>';
                } else {
                    // Fallback
                    $price = $product->get_price();
                    if ($price) {
                        echo '<span class="price-text"><bdi><span class="currency-symbol">$</span>' . esc_html($price) . '</bdi></span>';
                    }
                }
                ?>
            </div>
            
            <!-- Action Buttons -->
            <?php 
            if ( function_exists( 'asocial_chameleon_add_product_buttons' ) ) {
                asocial_chameleon_add_product_buttons();
            }
            ?>
        </div>
    </div>
</div>
