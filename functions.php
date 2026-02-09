<?php
/**
 * Asocial Chameleon Theme Functions
 *
 * @package Asocial_Chameleon
 */

function asocial_chameleon_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Add support for WooCommerce.
    add_theme_support( 'woocommerce' );
    
    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // WooCommerce Product Gallery Support
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register Navigation Menu
    register_nav_menus( array(
        'menu-1' => esc_html__( 'Primary', 'asocial-chameleon' ),
        'footer-shop' => esc_html__( 'Footer Shop', 'asocial-chameleon' ),
        'footer-support' => esc_html__( 'Footer Support', 'asocial-chameleon' ),
    ) );
}
add_action( 'after_setup_theme', 'asocial_chameleon_setup' );

function asocial_chameleon_scripts() {
    wp_enqueue_style( 'asocial-chameleon-style', get_stylesheet_uri(), array(), time() );
    
    // Enqueue Custom CSS (Fixes & Overrides)
    wp_enqueue_style( 'asocial-chameleon-custom', get_template_directory_uri() . '/custom-css.css', array('asocial-chameleon-style'), time() );
    
    // Enqueue Single Product Page CSS
    if ( is_product() ) {
        wp_enqueue_style( 'single-product-fixes', get_template_directory_uri() . '/single-product-fixes.css', array(), time() );
        
        // Enqueue Gallery Fix JS
        wp_enqueue_script( 'gallery-fix', get_template_directory_uri() . '/assets/js/gallery-fix.js', array( 'jquery' ), '1.0.0', true );
    }
    
    // Swiper CSS (CDN)
    wp_enqueue_style( 
        'swiper-css', 
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );
    
    // Swiper JS (CDN)
    wp_enqueue_script( 
        'swiper-js', 
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );
    
    // Top Rated Slider Script (depends on Swiper)
    wp_enqueue_script( 
        'top-rated-slider', 
        get_template_directory_uri() . '/assets/js/top-rated-slider.js',
        array( 'swiper-js' ),
        '1.0.0',
        true
    );
    
    // Testimonials Slider Script (depends on Swiper)
    wp_enqueue_script( 
        'testimonials-slider', 
        get_template_directory_uri() . '/assets/js/testimonials-slider.js',
        array( 'swiper-js' ),
        '1.0.0',
        true
    );
    
    // Mobile Navigation Script
    wp_enqueue_script( 'asocial-chameleon-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0.0', true );
    
    // Enqueue Material Icons (Outlined)
    wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons+Outlined', array(), null );

    // Enqueue Premium Product JS only on single product pages
    // Enqueue Premium Product JS
    wp_enqueue_script( 'premium-product-js', get_template_directory_uri() . '/assets/js/premium-product.js', array( 'jquery' ), '1.0.2', true );
    
    // Pass AJAX URL and Checkout URL to script
    wp_localize_script( 'premium-product-js', 'asocial_ajax_obj', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'wc_ajax_url' => WC()->ajax_url(), 
        'checkout_url' => wc_get_checkout_url(),
        'cart_url' => wc_get_cart_url(),
        'nonce' => wp_create_nonce( 'asocial_add_to_cart_nonce' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'asocial_chameleon_scripts' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function asocial_chameleon_woocommerce_cart_link_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-customlocation" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'asocial-chameleon' ); ?>">
        <span class="cart-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="cartGradientAjax" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#9b59b6;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#00d2ff;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M9 20C9 21.1 8.1 22 7 22C5.9 22 5 21.1 5 20C5 18.9 5.9 18 7 18C8.1 18 9 18.9 9 20ZM17 18C15.9 18 15 18.9 15 20C15 21.1 15.9 22 17 22C18.1 22 19 21.1 19 20C19 18.9 18.1 18 17 18ZM7.17 14.75L7.2 14.63L8.1 13H15.55C16.3 13 16.96 12.59 17.3 11.97L21.16 4.96L19.42 4L15.55 11H8.53L8.4 10.73L6.16 6L5.21 4L4.27 2H1V4H3L6.6 11.59L5.25 14.03C5.09 14.32 5 14.65 5 15C5 16.1 5.9 17 7 17H19V15H7.42C7.29 15 7.17 14.89 7.17 14.75Z" fill="url(#cartGradientAjax)"/>
            </svg>
        </span>
        <div class="cart-contents">
            <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_total() ); ?></span>
            <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'asocial-chameleon' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
        </div>
    </a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'asocial_chameleon_woocommerce_cart_link_fragment' );

/**
 * Auto-Create Menu and Categories on Theme Activation/Init
 */
function asocial_chameleon_auto_setup_nav() {
    $menu_name = 'Asocial Header Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    // If menu doesn't exist, create it
    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        if ( is_wp_error( $menu_id ) ) {
            return;
        }

        // Define Categories to Create
        $categories = array(
            'T-Shirts',
            'Sweatshirts & Hoodies / Jumpers',
            'For your head',
            'Random Things'
        );

        foreach ( $categories as $cat_name ) {
            if ( ! term_exists( $cat_name, 'product_cat' ) ) {
                wp_insert_term( $cat_name, 'product_cat' );
            }
        }

        // Add Menu Items
        // 1. Home (Custom Link)
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  =>  __('Home', 'asocial-chameleon'),
            'menu-item-url'    => home_url( '/' ),
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
        ) );

        // 2. ASocialChameleon Home (Custom Link)
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  =>  __('ASocialChameleon Home', 'asocial-chameleon'),
            'menu-item-url'    => home_url( '/' ),
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
        ) );

        // 3. Categories
        foreach ( $categories as $cat_name ) {
            $term = get_term_by( 'name', $cat_name, 'product_cat' );
            if ( $term ) {
                wp_update_nav_menu_item( $menu_id, 0, array(
                    'menu-item-title'  => $cat_name,
                    'menu-item-object-id' => $term->term_id,
                    'menu-item-object' => 'product_cat',
                    'menu-item-type'   => 'taxonomy',
                    'menu-item-status' => 'publish',
                ) );
            }
        }

        // 4. Shop (Page)
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  =>  __('Shop', 'asocial-chameleon'),
                'menu-item-object-id' => $shop_page_id,
                'menu-item-object' => 'page',
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'post_type',
            ) );
        }

        // Assign to Primary Location
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['menu-1'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}


/**
 * Add "Add to Cart" and "View Product" Buttons to Shop Loop
 */
function asocial_chameleon_add_product_buttons() {
    global $product;
    
    // Start button group wrapper
    echo '<div class="product-buttons-group premium-loop-actions">';
    
    // Check if product is variable (has variations like size, color, etc.)
    $is_variable = $product->is_type('variable');
    
    // Get the first available variation ID for variable products
    $variation_id = null;
    if ($is_variable) {
        $available_variations = $product->get_available_variations();
        if (!empty($available_variations)) {
            // Get the first available variation
            $variation_id = $available_variations[0]['variation_id'];
        }
    }
    
    // Add to Cart Button
    if ($is_variable) {
        // For variable products: Open Selection Popup
        echo '<a href="' . esc_url( get_permalink() ) . '" 
                 class="button add-to-cart-button premium-action-btn variable-selection-trigger" 
                 data-product_id="' . esc_attr( $product->get_id() ) . '" 
                 data-action="add-to-cart"
                 aria-label="' . esc_attr__( 'Select options', 'asocial-chameleon' ) . '" 
                 rel="nofollow">';
        echo '<span class="button-icon">🛒</span>';
        echo '<span class="button-text">' . esc_html__( 'Add to Cart', 'asocial-chameleon' ) . '</span>';
        echo '</a>';
    } else {
        // For simple products: Direct add to cart
        echo '<a href="?add-to-cart=' . esc_attr( $product->get_id() ) . '" 
                 data-quantity="1" 
                 class="button add-to-cart-button premium-action-btn" 
                 data-product_id="' . esc_attr( $product->get_id() ) . '" 
                 data-product_sku="' . esc_attr( $product->get_sku() ) . '" 
                 aria-label="' . esc_attr__( 'Add to cart', 'asocial-chameleon' ) . '" 
                 rel="nofollow">';
        echo '<span class="button-icon">🛒</span>';
        echo '<span class="button-text">' . esc_html__( 'Add to Cart', 'asocial-chameleon' ) . '</span>';
        echo '</a>';
    }
    
    // Buy Now Button (Direct Checkout Premium)
    if ($is_variable) {
        // For variable products: Open Selection Popup
        echo '<a href="' . esc_url( get_permalink() ) . '" 
                 class="button buy-now-button premium-action-btn variable-selection-trigger" 
                 data-product_id="' . esc_attr( $product->get_id() ) . '" 
                 data-action="buy-now"
                 rel="nofollow">';
        echo '<span class="button-icon">⚡</span>';
        echo '<span class="button-text">' . esc_html__( 'Buy Now', 'asocial-chameleon' ) . '</span>';
        echo '</a>';
    } else {
        // For simple products: Direct buy now
        $checkout_url = wc_get_checkout_url();
        $buy_now_url = add_query_arg( array(
            'add-to-cart' => $product->get_id(),
            'buy-now'     => '1'
        ), $checkout_url );
        
        echo '<a href="' . esc_url( $buy_now_url ) . '" class="button buy-now-button premium-action-btn" data-product_id="' . esc_attr( $product->get_id() ) . '" rel="nofollow">';
        echo '<span class="button-icon">⚡</span>';
        echo '<span class="button-text">' . esc_html__( 'Buy Now', 'asocial-chameleon' ) . '</span>';
        echo '</a>';
    }

    // End button group wrapper
    echo '</div>';
}
// Remove default Add to Cart button to prevent duplicates
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'asocial_chameleon_add_product_buttons', 15 );

/**
 * Global Redirect to Cart (Default) or Checkout (Buy Now)
 */
/**
 * Global Redirect Configuration
 * Handle Buy Now redirects to checkout
 */
add_filter( 'woocommerce_add_to_cart_redirect', 'asocial_chameleon_custom_add_to_cart_redirect', 999 );
function asocial_chameleon_custom_add_to_cart_redirect( $url ) {
    // If it's a Buy Now action, go directly to Checkout
    if ( isset( $_REQUEST['buy-now'] ) || isset( $_POST['buy-now'] ) ) {
        return wc_get_checkout_url();
    }
    
    // Otherwise, redirect to Cart
    return wc_get_cart_url();
}

// Force redirect to checkout on template load if buy-now is set
add_action( 'template_redirect', 'asocial_chameleon_force_buy_now_checkout', 5 );
function asocial_chameleon_force_buy_now_checkout() {
    // If buy-now parameter exists and we're on cart page, redirect to checkout
    if ( isset( $_GET['buy-now'] ) && is_cart() ) {
        wp_safe_redirect( wc_get_checkout_url() );
        exit;
    }
}

/**
 * Force Redirect to Cart if ?add-to-cart is present in URL
 * This acts as a fallback if the standard WooCommerce option fails.
 */
add_action( 'template_redirect', 'asocial_chameleon_force_add_to_cart_redirect', 20 );
function asocial_chameleon_force_add_to_cart_redirect() {
    // If 'add-to-cart' is in URL and it's NOT a 'buy-now' action
    if ( isset( $_GET['add-to-cart'] ) && ! isset( $_GET['buy-now'] ) ) {
        wp_safe_redirect( wc_get_cart_url() );
        exit;
    }
}

/**
 * Redirect "Continue Shopping" button to Homepage
 */
add_filter( 'woocommerce_return_to_shop_redirect', 'asocial_chameleon_continue_shopping_redirect' );
function asocial_chameleon_continue_shopping_redirect() {
    return home_url();
}

/**
 * Add Continue Shopping Button to Checkout Page
 */
add_action( 'woocommerce_before_checkout_form', 'asocial_chameleon_checkout_continue_shopping_button', 5 );
function asocial_chameleon_checkout_continue_shopping_button() {
    echo '<div style="margin-top: 40px; margin-bottom: 30px; text-align: center;">';
    echo '<a href="' . esc_url( home_url() ) . '" class="button premium-continue-shopping-btn" style="
        display: inline-block;
        padding: 18px 50px;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
    " onmouseover="this.style.transform=\'translateY(-3px)\'; this.style.boxShadow=\'0 15px 40px rgba(102, 126, 234, 0.5)\';" onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 10px 30px rgba(102, 126, 234, 0.4)\';">';
    echo '<span style="margin-right: 10px;">🛍️</span>';
    echo esc_html__( 'Continue Shopping', 'asocial-chameleon' );
    echo '</a>';
    echo '</div>';
}

/**
 * Add Product Short Description to Shop Loop
 */
function asocial_chameleon_add_product_description() {
    global $product;
    $short_description = $product->get_short_description();
    
    if ( ! empty( $short_description ) ) {
        echo '<div class="woocommerce-loop-product__description">' . wp_kses_post( $short_description ) . '</div>';
    }
}
add_action( 'woocommerce_after_shop_loop_item_title', 'asocial_chameleon_add_product_description', 15 );


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Force Custom Shop Template (Overrides ShopEngine)
 */
add_filter( 'template_include', 'asocial_chameleon_force_shop_template', 1000 );
function asocial_chameleon_force_shop_template( $template ) {
    if ( is_shop() || is_product_taxonomy() ) {
        $custom_template = locate_template( 'woocommerce/archive-product.php' );
        if ( $custom_template ) {
            return $custom_template;
        }
    }
    return $template;
}

/**
 * Disable ShopEngine Single Product Template Override
 * Force our custom template to load
 */
add_filter( 'template_include', 'asocial_chameleon_force_single_product_template', 9999 );
function asocial_chameleon_force_single_product_template( $template ) {
    if ( is_product() ) {
        // Remove ShopEngine filters
        remove_all_filters( 'wc_get_template_part' );
        
        // Force our custom template
        $custom_template = locate_template( 'woocommerce/content-single-product.php' );
        if ( $custom_template ) {
            // Use WooCommerce default single-product.php wrapper
            $wrapper_template = locate_template( 'woocommerce/single-product.php' );
            if ( $wrapper_template ) {
                return $wrapper_template;
            }
        }
    }
    return $template;
}

/**
 * Disable ShopEngine template parts for single products
 */
add_filter( 'shopengine/template/get_template_part', '__return_false', 9999 );

/**
 * Remove ShopEngine hooks that duplicate the add-to-cart form
 */
add_action( 'wp', 'asocial_chameleon_remove_shopengine_hooks', 999 );
function asocial_chameleon_remove_shopengine_hooks() {
    if ( is_product() ) {
        // Remove all ShopEngine actions from single product hooks
        remove_all_actions( 'woocommerce_single_product_summary' );
        remove_all_actions( 'woocommerce_before_single_product_summary' );
        
        // Re-add only the core WooCommerce hooks we need
        // Re-add only the core WooCommerce hooks we need
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

        // Restore Product Images and Sale Flash (Fix for missing gallery)
        add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
        add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    }
}

/**
 * Enable WooCommerce Product Gallery Features
 */
add_action( 'after_setup_theme', 'asocial_chameleon_enable_gallery_features', 20 );
function asocial_chameleon_enable_gallery_features() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}


/**
 * Change Single Product Add to Cart Text to 'Cart'
 */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'asocial_chameleon_custom_single_add_to_cart_text' );
function asocial_chameleon_custom_single_add_to_cart_text(  ) {
    return __( 'Cart', 'asocial-chameleon' );
}


/**
 * Live Search Functionality
 */
function asocial_chameleon_live_search_scripts() {
    wp_enqueue_script( 'asocial-live-search', get_template_directory_uri() . '/assets/js/live-search.js', array( 'jquery' ), '1.0', true );

    wp_localize_script( 'asocial-live-search', 'asocial_live_search_params', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'asocial_live_search_nonce' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'asocial_chameleon_live_search_scripts' );

add_action( 'wp_ajax_asocial_live_search', 'asocial_chameleon_live_search_handler' );
add_action( 'wp_ajax_nopriv_asocial_live_search', 'asocial_chameleon_live_search_handler' );

function asocial_chameleon_live_search_handler() {
    check_ajax_referer( 'asocial_live_search_nonce', 'security' );

    $term = sanitize_text_field( $_POST['term'] );
    if ( empty( $term ) ) {
        wp_send_json_error();
    }

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        's'              => $term,
    );

    $query = new WP_Query( $args );
    $products = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            $products[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'image' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ?: wc_placeholder_img_src(),
                'price' => $product ? $product->get_price_html() : ''
            );
        }
        wp_reset_postdata();
        wp_send_json_success( $products );
    } else {
        wp_send_json_error();
    }
}

/**
 * NOTE: Redirect to Cart Page is handled by asocial_chameleon_custom_add_to_cart_redirect (line 310)
 * which properly handles both regular add-to-cart (redirect to cart) and buy-now (redirect to checkout)
 * This duplicate filter has been removed to prevent conflicts.
 */

/**
 * Disable AJAX add to cart on shop loop to force reload and redirect
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'asocial_chameleon_remove_ajax_add_to_cart', 10, 2 );
function asocial_chameleon_remove_ajax_add_to_cart( $html, $product ) {
    // Remove ajax_add_to_cart class to disable AJAX
    return str_replace( 'ajax_add_to_cart', '', $html );
}

/**
 * Hide Free Shipping from Cart and Checkout
 */
add_filter( 'woocommerce_package_rates', 'asocial_chameleon_hide_free_shipping', 100, 2 );
function asocial_chameleon_hide_free_shipping( $rates, $package ) {
    // Remove free shipping from available shipping methods
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            unset( $rates[ $rate_id ] );
        }
    }
    return $rates;
}

/**
 * Redirect Add to Cart button to Cart page
 * Redirect Buy Now button to Checkout page
 */
// Duplicate redirect removed


// Buy Now functionality - handled by JavaScript in premium-product.js
// The Buy Now button already redirects to checkout via AJAX


/**
 * Enable WooCommerce default First Name and Last Name fields
 * Remove custom duplicate fields
 */
add_filter( 'woocommerce_save_account_details_required_fields', 'asocial_chameleon_enable_name_fields' );
function asocial_chameleon_enable_name_fields( $required_fields ) {
    // Add first_name and last_name to required fields
    $required_fields['account_first_name'] = __( 'First name', 'woocommerce' );
    $required_fields['account_last_name'] = __( 'Last name', 'woocommerce' );
    return $required_fields;
}

/**
 * Rescue Missing Product Components for ShopEngine Template
 * Outputs standard WC templates into a hidden container to be moved via JS
 * DISABLED: This was causing duplicate forms
 */
/*
add_action( 'wp_footer', 'asocial_chameleon_rescue_product_components' );
function asocial_chameleon_rescue_product_components() {
    if ( ! is_product() ) return;
    
    global $product;
    if ( ! $product ) return;
    
    echo '<div id="rescue-product-data" style="display:none;">';
    
    // 1. Rating
    echo '<div id="rescue-rating">';
    woocommerce_template_single_rating();
    echo '</div>';
    
    // 2. Short Description
    echo '<div id="rescue-excerpt">';
    woocommerce_template_single_excerpt();
    echo '</div>';
    
    // 3. Add to Cart Form (Variations etc)
    echo '<div id="rescue-add-to-cart">';
    woocommerce_template_single_add_to_cart();
    echo '</div>';
    
    // 4. Meta (SKU, Categories, Tags)
    echo '<div id="rescue-meta">';
    woocommerce_template_single_meta();
    echo '</div>';
    
    // 5. Sharing (Standard)
    echo '<div id="rescue-sharing">';
    woocommerce_template_single_sharing();
    echo '</div>';

    echo '</div>';
}
*/


/**
 * AJAX Handler to Fetch Product Variations for Shop Loop Popup
 */
add_action( 'wp_ajax_asocial_get_product_variations', 'asocial_chameleon_get_product_variations' );
add_action( 'wp_ajax_nopriv_asocial_get_product_variations', 'asocial_chameleon_get_product_variations' );

/**
 * Enqueue variation scripts on shop page for modal functionality
 */
function asocial_chameleon_enqueue_variation_scripts() {
    if ( is_shop() || is_product_category() || is_product_tag() || is_front_page() ) {
        wp_enqueue_script( 'wc-add-to-cart-variation' );
    }
}
add_action( 'wp_enqueue_scripts', 'asocial_chameleon_enqueue_variation_scripts' );

function asocial_chameleon_get_product_variations() {
    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    
    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => 'Invalid Product ID' ) );
    }

    $product = wc_get_product( $product_id );

    if ( ! $product || ! $product->is_type( 'variable' ) ) {
        wp_send_json_error( array( 'message' => 'Product not found or not variable' ) );
    }

    // Get available variations
    $available_variations = $product->get_available_variations();
    $attributes = $product->get_variation_attributes();
    
    // Get attribute labels
    $attribute_labels = array();
    foreach ( $attributes as $name => $options ) {
        $attribute_labels[$name] = wc_attribute_label( $name );
    }

    ob_start();
    ?>
    <div class="product-selection-modal-content" data-product_id="<?php echo esc_attr( $product_id ); ?>">
        <div class="modal-header">
            <h3><?php echo esc_html( $product->get_name() ); ?></h3>
            <p class="modal-price"><?php echo $product->get_price_html(); ?></p>
        </div>
        
        <div class="modal-body">
            <form class="variations_form selection-popup-form cart" method="post" enctype="multipart/form-data" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_variations="<?php echo esc_attr( wp_json_encode( $available_variations ) ); ?>">
                <table class="variations" cellspacing="0">
                    <tbody>
                        <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                            <tr>
                                <td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo esc_html( $attribute_labels[$attribute_name] ); ?></label></td>
                                <td class="value">
                                    <?php
                                        wc_dropdown_variation_attribute_options( array(
                                            'options'   => $options,
                                            'attribute' => $attribute_name,
                                            'product'   => $product,
                                        ) );
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="single_variation_wrap">
                    <div class="woocommerce-variation single_variation"></div>
                    <div class="woocommerce-variation-add-to-cart variations_button">
                        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product_id ); ?>" />
                        <input type="hidden" name="product_id" value="<?php echo absint( $product_id ); ?>" />
                        <input type="hidden" name="variation_id" class="variation_id" value="0" />
                        <button type="submit" class="single_add_to_cart_button button alt premium-popup-submit"><?php echo esc_html__( 'Confirm Selection', 'asocial-chameleon' ); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    wp_send_json_success( array(
        'html' => $html,
        'variations' => $available_variations
    ) );
}

/**
 * Limit Related Products to 4
 * Ensures strictly one row of 4 products.
 */
add_filter( 'woocommerce_output_related_products_args', 'asocial_chameleon_related_products_limit', 20 );
function asocial_chameleon_related_products_limit( $args ) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}
