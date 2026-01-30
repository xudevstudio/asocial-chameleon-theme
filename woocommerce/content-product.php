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
        <!-- Category - HIDDEN -->
        <?php /* 
        <div class="product-category-hint" style="display: block !important; visibility: visible !important; opacity: 1 !important; font-size: 11px; color: #9b59b6; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">
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

        <!-- Price -->
        <div class="product-price" style="display: block !important; visibility: visible !important; opacity: 1 !important; font-size: 18px !important; font-weight: 700 !important; margin: 10px 0 !important; color: #000 !important;">
            <?php 
            $price_html = $product->get_price_html();
            // Force all price text to black by wrapping in styled span
            if (!empty($price_html)) {
                echo '<span style="color: #000 !important;">' . $price_html . '</span>';
            } else {
                // Fallback
                $price = $product->get_price();
                if ($price) {
                    echo '<span style="color: #000 !important;"><bdi><span style="color: #000 !important;">$</span>' . esc_html($price) . '</bdi></span>';
                }
            }
            ?>
        </div>
        
        <style>
        /* ========================================
           SHOP PAGE - RESPONSIVE PRODUCT CARDS
           ======================================== */
        
        /* Product Card Base */
        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        
        /* Product Content Area */
        .product-card .product-content {
            padding: 15px !important;
            text-align: center !important;
        }
        
        /* Category */
        .product-category-hint,
        .product-category-hint a {
            display: block !important;
            font-size: 11px !important;
            color: #9b59b6 !important;
            text-transform: uppercase !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            margin-bottom: 8px !important;
            text-decoration: none !important;
        }
        
        /* Title */
        .product-title {
            font-size: 15px !important;
            font-weight: 600 !important;
            line-height: 1.4 !important;
            margin: 8px 0 12px 0 !important;
            min-height: 40px !important;
        }
        
        .product-title a {
            color: #333 !important;
            text-decoration: none !important;
        }
        
        .product-title a:hover {
            color: #9b59b6 !important;
        }
        
        /* Price - Centered with spacing */
        .product-price,
        .product-price *,
        .product-price span,
        .product-price .price,
        .product-price .woocommerce-Price-amount,
        .product-price bdi,
        .product-price .woocommerce-Price-currencySymbol {
            color: #000 !important;
            text-align: center !important;
        }
        
        .product-price {
            display: block !important;
            font-size: 20px !important;
            font-weight: 700 !important;
            margin: 15px 0 !important;
            text-align: center !important;
        }
        
        /* Desktop - 4 columns */
        @media (min-width: 769px) {
            .woocommerce ul.products {
                display: grid !important;
                grid-template-columns: repeat(4, 1fr) !important;
                gap: 25px !important;
            }
            
            .product-title {
                font-size: 16px !important;
            }
            
            .product-price {
                font-size: 22px !important;
            }
        }
        
        /* Tablet - 3 columns */
        @media (min-width: 481px) and (max-width: 768px) {
            .woocommerce ul.products {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 20px !important;
            }
            
            .product-title {
                font-size: 14px !important;
                min-height: 35px !important;
            }
            
            .product-price {
                font-size: 18px !important;
            }
            
            .product-category-hint {
                font-size: 10px !important;
            }
        }
        
        /* Mobile - 2 columns */
        @media (max-width: 480px) {
            .woocommerce ul.products {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 15px !important;
            }
            
            .product-card .product-content {
                padding: 10px !important;
            }
            
            .product-title {
                font-size: 13px !important;
                min-height: 32px !important;
                margin: 6px 0 10px 0 !important;
            }
            
            .product-price {
                font-size: 16px !important;
                margin: 10px 0 !important;
            }
            
            .product-category-hint {
                font-size: 9px !important;
                margin-bottom: 6px !important;
            }
        }
        </style>
        
        <!-- Action Buttons -->
        <?php 
        if ( function_exists( 'asocial_chameleon_add_product_buttons' ) ) {
            asocial_chameleon_add_product_buttons();
        }
        ?>
    </div>
</div>
