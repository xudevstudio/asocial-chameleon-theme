<?php
/**
 * The main template file
 *
 * @package Asocial_Chameleon
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-banner">
    <div class="hero-bg-animated"></div> <!-- New Background Wrapper for Animation -->
    <div class="hero-content">
        <h2 class="hero-title"><?php echo esc_html( get_theme_mod( 'hero_title_text', 'Stand Out Without Trying' ) ); ?></h2>
        <p class="hero-subtitle"><?php echo esc_html( get_theme_mod( 'hero_subtitle_text', 'Find your new conversation starter!' ) ); ?></p>
        <?php 
        $btn_text = get_theme_mod( 'hero_btn_text', 'View Collection' );
        if ( $btn_text ) :
            $btn_url = get_theme_mod( 'hero_btn_url' );
            if ( empty( $btn_url ) ) {
                $btn_url = function_exists('wc_get_page_id') ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
            }
        ?>
        <a href="<?php echo esc_url( $btn_url ); ?>" class="hero-button"><?php echo esc_html( $btn_text ); ?></a>
        <?php endif; ?>
    </div>
</section>



<!-- Trust Signals / Features Section -->
<section class="trust-signals-section">
    <div class="container">
        <div class="trust-grid">
            <!-- Free Shipping -->
            <div class="trust-item">
                <div class="trust-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#fff;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div class="trust-text">
                    <h3><?php esc_html_e( 'Free Shipping', 'asocial-chameleon' ); ?></h3>
                    <p><?php esc_html_e( 'On all orders over $50', 'asocial-chameleon' ); ?></p>
                </div>
            </div>
            <!-- Eco-Friendly -->
            <div class="trust-item">
                <div class="trust-icon">
                     <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#fff;"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.77 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path></svg>
                </div>
                <div class="trust-text">
                    <h3><?php esc_html_e( 'Eco-Friendly', 'asocial-chameleon' ); ?></h3>
                    <p><?php esc_html_e( 'Sustainable materials', 'asocial-chameleon' ); ?></p>
                </div>
            </div>
            <!-- Secure Payment -->
            <div class="trust-item">
                <div class="trust-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#fff;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
                <div class="trust-text">
                    <h3><?php esc_html_e( 'Secure Payment', 'asocial-chameleon' ); ?></h3>
                    <p><?php esc_html_e( '100% secure checkout', 'asocial-chameleon' ); ?></p>
                </div>
            </div>
            <!-- Easy Returns -->
            <div class="trust-item">
                <div class="trust-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#fff;"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                </div>
                <div class="trust-text">
                    <h3><?php esc_html_e( 'Easy Returns', 'asocial-chameleon' ); ?></h3>
                    <p><?php esc_html_e( '30-day return policy', 'asocial-chameleon' ); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top Rated Collection Slider -->
<section class="top-rated-collection">
    <h2 class="section-title"><?php esc_html_e( 'Our Top Rated Collection', 'asocial-chameleon' ); ?></h2>
    <?php 
    $displayed_product_ids = array(); // Initialize exclusion array

    if ( class_exists( 'WooCommerce' ) ) {
        // Custom query for top rated products - 15 products for auto-scroll slider
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 15,
            'meta_key' => '_wc_average_rating',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
        $loop = new WP_Query( $args );
        
        if ( $loop->have_posts() ) {
            ?>
            <div class="top-rated-slider-wrapper">
                <!-- Swiper Container -->
                <div class="swiper top-rated-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        while ( $loop->have_posts() ) : $loop->the_post();
                            global $product;
                            $displayed_product_ids[] = get_the_ID(); // Add to exclusion list
                            ?>
                            <div class="swiper-slide">
                                <div <?php wc_product_class( 'product-card', $product ); ?>>
                                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-image-link">
                                        <?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
                                    </a>
                                    <div class="product-content">
                                        <h3 class="product-title">
                                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                                                <?php echo esc_html( $product->get_name() ); ?>
                                            </a>
                                        </h3>
                                        <?php 
                                        // Add short description
                                        $short_description = $product->get_short_description();
                                        if ( ! empty( $short_description ) ) {
                                            echo '<div class="product-description">' . wp_kses_post( wp_trim_words( $short_description, 15 ) ) . '</div>';
                                        }
                                        ?>
                                        <?php if ( $product->get_rating_count() > 0 ) : ?>
                                            <div class="product-rating">
                                                <?php woocommerce_template_loop_rating(); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="product-price">
                                            <?php woocommerce_template_loop_price(); ?>
                                        </div>
                                        <?php 
                                        // Use the modern button group function defined in functions.php
                                        if ( function_exists( 'asocial_chameleon_add_product_buttons' ) ) {
                                            asocial_chameleon_add_product_buttons();
                                        } else {
                                            ?>
                                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-button">
                                                <?php esc_html_e( 'View Product', 'asocial-chameleon' ); ?>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                    
                    <!-- Navigation Arrows -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    
                    <!-- Pagination Dots -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <?php
            wp_reset_postdata();
        }
    }
    ?>
</section>

<!-- Brand Story Section -->
<section class="brand-story-section">
    <div class="brand-story-container container">
        <h2 class="section-title"><?php esc_html_e( 'Our Story', 'asocial-chameleon' ); ?></h2>
        <div class="brand-story-grid">
            <div class="brand-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brand-story.png" alt="Asocial Chameleon Brand Story">
            </div>
            <div class="brand-content">
                <h3 class="brand-title"><?php esc_html_e( 'BLENDING IN IS SO BORING!', 'asocial-chameleon' ); ?></h3>
                <div class="brand-text">
                    <p><?php esc_html_e( 'We started The Asocial Chameleon for those who’d rather stand out without trying too hard. Our tees don’t whisper; they smirk. Designed for rule-breakers, overthinkers, and people allergic to fake small talk, each piece is a wearable eye-roll at the ordinary. Life’s too short for basic T-shirts.', 'asocial-chameleon' ); ?></p>
                </div>
                <div class="brand-stats">
                    <div class="stat-item">
                        <span class="stat-value">100%</span>
                        <span class="stat-label"><?php esc_html_e( 'Eco-friendly packaging', 'asocial-chameleon' ); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">75%</span>
                        <span class="stat-label"><?php esc_html_e( 'Recycled materials', 'asocial-chameleon' ); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">80%</span>
                        <span class="stat-label"><?php esc_html_e( 'Less water usage', 'asocial-chameleon' ); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">100%</span>
                        <span class="stat-label"><?php esc_html_e( 'Organic cotton', 'asocial-chameleon' ); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Newest Arrivals Section -->
<section class="newest-arrivals-section">
    <h2 class="section-title"><?php esc_html_e( 'Our Newest Arrivals', 'asocial-chameleon' ); ?></h2>
    <?php 
    if ( class_exists( 'WooCommerce' ) ) {
        // Custom Query to exclude already shown products
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post__not_in'   => $displayed_product_ids, // Exclude Top Rated
        );
        $newest_loop = new WP_Query( $args );

        // FALLBACK: If no new products found (or all excluded), show RANDOM products
        if ( ! $newest_loop->have_posts() ) {
            $args['orderby'] = 'rand';
            $args['post__not_in'] = array(); // Remove exclusions for fallback
            $newest_loop = new WP_Query( $args );
        }

        if ( $newest_loop->have_posts() ) {
            echo '<ul class="products columns-4">';
            while ( $newest_loop->have_posts() ) : $newest_loop->the_post();
                global $product;
                $displayed_product_ids[] = get_the_ID(); // Add to exclusion list
                ?>
                <li <?php wc_product_class( '', $product ); ?>>
                    <?php 
                    /**
                     * Hook: woocommerce_before_shop_loop_item.
                     *
                     * @hooked woocommerce_template_loop_product_link_open - 10
                     */
                    do_action( 'woocommerce_before_shop_loop_item' );
        
                    /**
                     * Hook: woocommerce_before_shop_loop_item_title.
                     *
                     * @hooked woocommerce_show_product_loop_sale_flash - 10
                     * @hooked woocommerce_template_loop_product_thumbnail - 10
                     */
                    do_action( 'woocommerce_before_shop_loop_item_title' );
        
                    echo '<div class="product-content-wrap">';
                    
                    /**
                     * Hook: woocommerce_shop_loop_item_title.
                     *
                     * @hooked woocommerce_template_loop_product_title - 10
                     */
                    do_action( 'woocommerce_shop_loop_item_title' );
        
                    /**
                     * Hook: woocommerce_after_shop_loop_item_title.
                     *
                     * @hooked woocommerce_template_loop_rating - 5
                     * @hooked woocommerce_template_loop_price - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item_title' );
                    
                    echo '</div>'; // Close product-content-wrap
                    
                    /**
                     * Hook: woocommerce_after_shop_loop_item.
                     *
                     * @hooked woocommerce_template_loop_product_link_close - 5
                     * @hooked woocommerce_template_loop_add_to_cart - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item' );
                    ?>
                </li>
                <?php
            endwhile;
            echo '</ul>';
        }
        wp_reset_postdata();
    }
    ?>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'Real Talk From Real Misfits', 'asocial-chameleon' ); ?></h2>
        
        <!-- Swiper Slider -->
        <div class="swiper testimonials-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-card modern-card">
                        <div class="card-header">
                            <div class="user-avatar purple-bg">A</div>
                            <div class="user-info">
                                <cite>Alex R.</cite>
                                <div class="rating">⭐⭐⭐⭐⭐</div>
                            </div>
                            <div class="quote-icon-small">❝</div>
                        </div>
                        <p class="review-text"><?php esc_html_e( 'Finally, clothes that speak my mind so I don\'t have to. The quality is insane too.', 'asocial-chameleon' ); ?></p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card modern-card">
                        <div class="card-header">
                            <div class="user-avatar blue-bg">J</div>
                            <div class="user-info">
                                <cite>Jamie L.</cite>
                                <div class="rating">⭐⭐⭐⭐⭐</div>
                            </div>
                            <div class="quote-icon-small">❝</div>
                        </div>
                        <p class="review-text"><?php esc_html_e( 'I wore the "Socially Selective" hoodie to a party and didn\'t have to talk to anyone. 10/10.', 'asocial-chameleon' ); ?></p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card modern-card">
                        <div class="card-header">
                            <div class="user-avatar green-bg">J</div>
                            <div class="user-info">
                                <cite>Jordan K.</cite>
                                <div class="rating">⭐⭐⭐⭐⭐</div>
                            </div>
                            <div class="quote-icon-small">❝</div>
                        </div>
                        <p class="review-text"><?php esc_html_e( 'Sustainable AND sarcastic? It\'s like you people actually get me.', 'asocial-chameleon' ); ?></p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card modern-card">
                        <div class="card-header">
                            <div class="user-avatar orange-bg">S</div>
                            <div class="user-info">
                                <cite>Sam T.</cite>
                                <div class="rating">⭐⭐⭐⭐⭐</div>
                            </div>
                            <div class="quote-icon-small">❝</div>
                        </div>
                        <p class="review-text"><?php esc_html_e( 'Best purchase ever! These tees are conversation starters without me having to start conversations.', 'asocial-chameleon' ); ?></p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card modern-card">
                        <div class="card-header">
                            <div class="user-avatar pink-bg">C</div>
                            <div class="user-info">
                                <cite>Casey M.</cite>
                                <div class="rating">⭐⭐⭐⭐⭐</div>
                            </div>
                            <div class="quote-icon-small">❝</div>
                        </div>
                        <p class="review-text"><?php esc_html_e( 'Perfect for introverts who want to make a statement. Love the eco-friendly approach too!', 'asocial-chameleon' ); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- Top Categories Section -->
<section class="top-categories-section">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'Top Categories', 'asocial-chameleon' ); ?></h2>
        <div class="categories-grid">
            <?php
            if ( class_exists( 'WooCommerce' ) ) {
                $uncat_term = get_term_by( 'slug', 'uncategorized', 'product_cat' );
                $exclude_ids = array();
                if ( $uncat_term ) {
                    $exclude_ids[] = $uncat_term->term_id;
                }

                $product_categories = get_terms( array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'number' => 4,
                    'exclude' => $exclude_ids,
                    'orderby' => 'count',
                    'order' => 'DESC',
                ) );
                
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                    foreach ( $product_categories as $category ) {
                        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                        $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : wc_placeholder_img_src();
                        $category_link = get_term_link( $category );
                        ?>
                        <a href="<?php echo esc_url( $category_link ); ?>" class="category-card">
                            <div class="category-image">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
                            </div>
                            <div class="category-content">
                                <h3 class="category-name"><?php echo esc_html( $category->name ); ?></h3>
                                <span class="category-count"><?php echo esc_html( $category->count ); ?> <?php esc_html_e( 'Products', 'asocial-chameleon' ); ?></span>
                            </div>
                        </a>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Popular Products Section -->
<section class="popular-products-section">
    <h2 class="section-title"><?php esc_html_e( 'This Week\'s Popular Products', 'asocial-chameleon' ); ?></h2>
    <?php 
    if ( class_exists( 'WooCommerce' ) ) {
        // Attempt 1: Popular products, excluding displayed products
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'orderby'        => 'popularity',
            'post__not_in'   => $displayed_product_ids,
        );
        $popular_loop = new WP_Query( $args );

        // Attempt 2: If no popular products found, try RANDOM products (still excluding displayed)
        if ( ! $popular_loop->have_posts() ) {
            $args['orderby'] = 'rand';
            $popular_loop = new WP_Query( $args );
        }

        // Attempt 3: FINAL FALLBACK - If still empty, show ANY random products (no exclusions)
        if ( ! $popular_loop->have_posts() ) {
            $args['post__not_in'] = array(); // Remove all exclusions
            $popular_loop = new WP_Query( $args );
        }
        
        if ( $popular_loop->have_posts() ) {
            echo '<ul class="products columns-4">';
            while ( $popular_loop->have_posts() ) : $popular_loop->the_post();
                global $product;
                ?>
                <li <?php wc_product_class( '', $product ); ?>>
                    <?php 
                    do_action( 'woocommerce_before_shop_loop_item' );
                    do_action( 'woocommerce_before_shop_loop_item_title' );
                    echo '<div class="product-content-wrap">';
                    do_action( 'woocommerce_shop_loop_item_title' );
                    do_action( 'woocommerce_after_shop_loop_item_title' );

                    echo '</div>'; // Close product-content-wrap
                    do_action( 'woocommerce_after_shop_loop_item' );
                    ?>
                </li>
                <?php
            endwhile;
            echo '</ul>';
        }
        wp_reset_postdata();
    }
    ?>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
         <h2 class="section-title"><?php esc_html_e( 'Frequently Imagined Questions', 'asocial-chameleon' ); ?></h2>
         <div class="faq-grid">
            <details class="faq-item">
                <summary><?php esc_html_e( 'Is the packaging actually eco-friendly?', 'asocial-chameleon' ); ?></summary>
                <p><?php esc_html_e( 'Yes. We use 100% compostable mailers and zero plastic. Even our tape is paper-based.', 'asocial-chameleon' ); ?></p>
            </details>
            <details class="faq-item">
                <summary><?php esc_html_e( 'How do I find my size?', 'asocial-chameleon' ); ?></summary>
                <p><?php esc_html_e( 'Check our size guide on every product page. We recommend sizing up for that oversized streetwear look.', 'asocial-chameleon' ); ?></p>
            </details>
            <details class="faq-item">
                <summary><?php esc_html_e( 'Do you ship internationally?', 'asocial-chameleon' ); ?></summary>
                <p><?php esc_html_e( 'We ship to most planets. If you reside on Earth, we definitely ship to you.', 'asocial-chameleon' ); ?></p>
            </details>
            <details class="faq-item">
                <summary><?php esc_html_e( 'Can I return if I don\'t like it?', 'asocial-chameleon' ); ?></summary>
                <p><?php esc_html_e( 'Sure. 30 days, no questions asked. Unless you wore it to a mud wrestling championship.', 'asocial-chameleon' ); ?></p>
            </details>
         </div>
    </div>
</section>




<?php
get_footer();
?>
