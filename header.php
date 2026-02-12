<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Fonts: Outfit (Modern Sans) & Playfair Display (Luxury Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Dev Mode via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        primary: '#9b59b6',
                        secondary: '#8e44ad',
                        dark: '#0d0d0d',
                        light: '#f8f9fa',
                    }
                }
            }
        }
    </script>

    <?php 
    $favicon_url = get_theme_mod( 'site_favicon' );
    if ( ! $favicon_url ) {
        $favicon_url = get_template_directory_uri() . '/assets/images/favicon.png';
    }
    ?>
    <link rel="icon" type="image/png" href="<?php echo esc_url( $favicon_url ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="header-container container">
            
            <!-- Top Row: Search | Logo & Cart -->
            <div class="header-top-row">
                <!-- Mobile Menu Toggle (Left on Mobile) -->
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                </button>

                <!-- Left: Branding -->
                <div class="site-branding">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo-link">
                        <?php 
                        $desktop_logo = get_theme_mod( 'custom_logo_desktop' );
                        $mobile_logo  = get_theme_mod( 'custom_logo_mobile' );
                        
                        // Default fallback
                        $logo_src = get_template_directory_uri() . '/assets/images/logo.png';
                        
                        if ( $desktop_logo ) {
                            $logo_src = $desktop_logo;
                        }
                        ?>
                        
                        <!-- Desktop Logo -->
                        <img src="<?php echo esc_url( $logo_src ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo-image desktop-logo">
                        
                        <!-- ShopEngine Fix: Hydrate Missing Components -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.body.classList.contains('single-product')) return;

            console.log('ShopEngine Fix: Hydrating components...');

            // Helper to insert after
            function insertAfter(newNode, referenceNode) {
                if (referenceNode && referenceNode.parentNode) {
                    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
                }
            }

            // 1. Locate Targets in ShopEngine Template
            const title = document.querySelector('.product_title, .shopengine-product-title');
            const price = document.querySelector('.price, .shopengine-product-price');
            
            // 2. Hydrate Rating & Excerpt (Below Title)
            const rescueRating = document.getElementById('rescue-rating');
            const rescueExcerpt = document.getElementById('rescue-excerpt');
            
            if (title) {
                if (rescueExcerpt && rescueExcerpt.innerHTML.trim() !== '') {
                    rescueExcerpt.style.display = 'block';
                    rescueExcerpt.style.marginTop = '10px';
                    rescueExcerpt.style.marginBottom = '15px';
                    insertAfter(rescueExcerpt, title);
                }
                if (rescueRating && rescueRating.innerHTML.trim() !== '') {
                    rescueRating.style.display = 'block';
                    rescueRating.style.marginBottom = '5px';
                    insertAfter(rescueRating, title);
                }
            }

            // 3. Hydrate Add to Cart Form (Below Price)
            const rescueCart = document.getElementById('rescue-add-to-cart');
            
            if (price && rescueCart) {
                // Remove existing broken buttons if any
                const existingBtn = document.querySelector('.shopengine-fix-buttons');
                if (existingBtn) existingBtn.remove();

                rescueCart.style.display = 'block';
                rescueCart.style.marginTop = '20px';
                insertAfter(rescueCart, price);
            }

            // 4. Hydrate Meta (Below Add to Cart)
            const rescueMeta = document.getElementById('rescue-meta');
            if (rescueCart && rescueMeta) {
                rescueMeta.style.display = 'block';
                rescueMeta.style.marginTop = '20px';
                rescueMeta.style.borderTop = '1px solid #eee';
                rescueMeta.style.paddingTop = '10px';
                insertAfter(rescueMeta, rescueCart);
            } else if (price && rescueMeta) {
                insertAfter(rescueMeta, price);
            }

            // 5. Fix In Stock Icon Styling
            const stockElements = document.querySelectorAll('.stock.in-stock');
            stockElements.forEach(function(stock) {
                if (!stock.innerHTML.includes('fa-check')) {
                    // Prepend icon if missing
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-check-circle';
                    icon.style.marginRight = '8px';
                    icon.style.color = '#27ae60';
                    stock.insertBefore(icon, stock.firstChild);
                }
                stock.style.color = '#27ae60';
                stock.style.fontWeight = 'bold';
                stock.style.display = 'inline-flex';
                stock.style.alignItems = 'center';
            });
            
            // 6. Force Variations Form to Show
            const variationsForm = document.querySelector('.variations_form');
            if (variationsForm) {
                variationsForm.style.display = 'block';
            }
        });
    </script>
                        <?php if ( $mobile_logo ) : ?>
                            <!-- Mobile Logo (if set) -->
                            <img src="<?php echo esc_url( $mobile_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo-image mobile-logo" style="display: none;">
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Right: Search & Cart -->
                <div class="header-actions">
                    <!-- Search -->
                    <div class="header-search">
                        <?php 
                        if ( class_exists( 'WooCommerce' ) ) {
                            get_product_search_form();
                        } else {
                            get_search_form();
                        }
                        ?>
                    </div>

                    <!-- Cart Icon Button -->
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <div class="header-cart-inline" style="margin-left: 15px;">
                        <a class="cart-customlocation" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'asocial-chameleon' ); ?>">
                            <span class="cart-icon" style="position: relative; display: inline-block;">
                                <!-- Shopping Cart Icon with Gradient -->
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="accountGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#9b59b6;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#00d2ff;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M7 18C5.9 18 5.01 18.9 5.01 20C5.01 21.1 5.9 22 7 22C8.1 22 9 21.1 9 20C9 18.9 8.1 18 7 18ZM1 2V4H3L6.6 11.59L5.25 14.04C5.09 14.32 5 14.65 5 15C5 16.1 5.9 17 7 17H19V15H7.42C7.29 15 7.17 14.89 7.17 14.75L7.2 14.63L8.1 13H15.55C16.3 13 16.96 12.59 17.3 11.97L21.16 4.96C21.25 4.8 21.3 4.62 21.3 4.43C21.3 4.19 21.1 4 20.85 4H5.21L4.27 2H1ZM17 18C15.9 18 15.01 18.9 15.01 20C15.01 21.1 15.9 22 17 22C18.1 22 19 21.1 19 20C19 18.9 18.1 18 17 18Z" fill="url(#accountGradient)"/>
                                </svg>
                                <?php 
                                $count = WC()->cart->get_cart_contents_count(); 
                                if ( $count > 0 ) : ?>
                                    <span class="cart-count">
                                        <?php echo esc_html( $count ); ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <div class="header-account-inline" style="margin-left: 15px;">
                        <a class="account-customlocation" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'asocial-chameleon' ); ?>">
                            <span class="account-icon">
                                <!-- Professional User Icon with Gradient -->
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="url(#accountGradient)"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Bottom Row: Navigation -->
			<nav id="site-navigation" class="main-navigation">
                <div class="mobile-menu-header">
                    <button class="menu-close" aria-label="Close menu">
                        <span class="close-icon">&times;</span>
                    </button>
                </div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'nav-menu', // Class for styling
                        'container'      => 'div',
                        'container_class' => 'mobile-menu-container',
                        'fallback_cb'    => false, // Don't show pages if no menu fits
					)
				);
				?>
                <div class="mobile-menu-account desktop-hide" style="margin-top: auto; padding: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" style="display: flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; font-weight: 700; text-transform: uppercase; font-size: 14px;">
                            <span class="material-icons-outlined">account_circle</span>
                            <?php esc_html_e( 'My Account', 'asocial-chameleon' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="mobile-menu-footer">
                    <div class="mobile-social-links">
                        <?php 
                        // You can add social icons here later if requested
                        ?>
                    </div>
                    <?php // Removed redundant My Account link - now handled in wp_nav_menu_items via functions.php ?>
                </div>
			</nav>


		</div>
	</header><!-- #masthead -->

    <style>
    /* Shop Page - Category, Price & Responsive Fixes */
    .woocommerce ul.products li.product .product-category-hint,
    .woocommerce ul.products li.product .product-category-hint a {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-size: 12px !important;
        color: #9b59b6 !important;
        text-transform: uppercase !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        margin-bottom: 8px !important;
        text-decoration: none !important;
    }

    .woocommerce ul.products li.product .product-price,
    .woocommerce ul.products li.product .product-price .price {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #000 !important;
        margin: 12px 0 !important;
    }

    .woocommerce ul.products li.product .product-title,
    .woocommerce ul.products li.product .product-title a {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        color: #333 !important;
        line-height: 1.4 !important;
        margin: 8px 0 !important;
        text-decoration: none !important;
    }

    /* Responsive Grid */
    @media (max-width: 768px) {
        .woocommerce ul.products {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 15px !important;
        }

        .woocommerce ul.products li.product .product-title {
            font-size: 14px !important;
        }

        .woocommerce ul.products li.product .product-price {
            font-size: 16px !important;
        }

        .woocommerce ul.products li.product .product-category-hint {
            font-size: 10px !important;
        }
    }

    @media (min-width: 769px) {
        .woocommerce ul.products {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 25px !important;
        }
    }

    /* --- Single Product Page Fixes --- */

    /* 1. Related Products - Force 4 Columns & Fix Overflow */
    @media (min-width: 769px) {
        /* NUCLEAR FIX: Force 4 columns with high specificity */
        body.single-product .related.products ul.products,
        body.single-product .related.products ul.products.columns-4,
        body.single-product section.related.products ul.products {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            display: grid !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            grid-gap: 20px !important;
            justify-content: center !important;
            box-sizing: border-box !important;
        }
        
        /* Reset items to ensure they fit */
        body.single-product .related.products ul.products li.product {
            width: auto !important; /* Let Grid control width */
            max-width: 100% !important;
            min-width: 0 !important; /* Allow shrinking */
            margin: 0 !important;
            padding: 0 !important;
            float: none !important;
        }
    }

    /* 2. Hide Specific Icons (Compare, Wishlist/Favorite) - Target Containers */
    body .shopengine-wishlist,
    body .shopengine-comparison,
    body .shopengine-icon-product_compare_1,
    body .shopengine-wishlist-btn,
    body .yith-wcwl-add-to-wishlist,
    body .favorites-icon,
    body .wpc-compare-button,
    /* Broad attribute selectors for stubborn icons */
    [class*="shopengine-wishlist"],
    [class*="shopengine-compare"],
    [class*="shopengine-comparison"],
    a[href*="wishlist"],
    a[href*="compare"],
    .shopengine-actions,
    .shopengine-wishlist,
    .shopengine-comparison { 
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
        pointer-events: none !important; 
    }

    /* 3. Center Tabs & Description with Margins */
    .product-tabs-wrapper, 
    .woocommerce-tabs {
        max-width: 1100px !important;
        margin: 50px auto !important; /* Increased margin */
        padding: 0 20px !important;    /* Increased padding */
        float: none !important;
        width: 100% !important;
    }
    
    .woocommerce-tabs ul.tabs {
        justify-content: center !important;
        display: flex !important;
        margin: 0 0 30px !important;
        padding: 0 !important;
        border-bottom: 2px solid #eee !important;
    }
    
    .woocommerce-tabs ul.tabs li {
        border: none !important;
        background: transparent !important;
        margin: 0 25px !important;
    }

    .woocommerce-tabs ul.tabs li a {
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #555 !important;
        padding-bottom: 12px !important;
    }

    .woocommerce-tabs ul.tabs li.active a {
        color: #000 !important;
        border-bottom: 2px solid #000 !important;
    }

    /* 4. Fix Gallery Images (Thumbnails were hidden) */
    /* Restore standard relative positioning for the gallery */
    .woocommerce-product-gallery {
        position: relative !important;
        opacity: 1 !important;
        display: block !important;
    }

    /* FIX: Ensure the viewport doesn't collapse but let JS handle overflow */
    .woocommerce-product-gallery .flex-viewport {
        height: auto !important;
    }

    /* REMOVED: display: block !important on images. This broke the slider. */
    /* Only ensure images fill their container */
    .woocommerce-product-gallery .woocommerce-product-gallery__image img {
        width: 100% !important;
        height: auto !important;
    }
    
    /* CRITICAL FIX: Ensure active slide is always visible */
    .woocommerce-product-gallery .woocommerce-product-gallery__image.flex-active-slide {
        opacity: 1 !important;
        z-index: 10 !important;
        display: block !important;
    }
    
    .woocommerce-product-gallery .woocommerce-product-gallery__image.flex-active-slide img {
        opacity: 1 !important;
        display: block !important;
    }

    /* Force thumbnails strip layout - SINGLE ROW SLIDER */
    .woocommerce-product-gallery .flex-control-nav.flex-control-thumbs {
        display: flex !important;
        flex-wrap: nowrap !important; /* Prevent wrapping */
        overflow-x: auto !important;  /* Allow scrolling */
        justify-content: flex-start !important;
        margin: 20px 0 0 !important;
        padding: 0 0 10px 0 !important; /* Space for scrollbar */
        width: 100% !important;
        position: relative !important;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Custom Scrollbar for Thumbnails */
    .woocommerce-product-gallery .flex-control-thumbs::-webkit-scrollbar {
        height: 6px;
    }
    .woocommerce-product-gallery .flex-control-thumbs::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }
    .woocommerce-product-gallery .flex-control-thumbs::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .woocommerce-product-gallery .flex-control-thumbs li {
        flex: 0 0 80px !important; /* Fixed width */
        width: 80px !important;
        min-width: 80px !important;
        float: none !important;
        display: block !important;
        margin: 0 10px 0 0 !important;
        cursor: pointer !important;
    }

    .woocommerce-product-gallery .flex-control-thumbs li img {
        opacity: 0.5 !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 0 0 1px #eee !important;
        height: auto !important;
        width: 100% !important;
    }

    .woocommerce-product-gallery .flex-control-thumbs li img.flex-active, 
    .woocommerce-product-gallery .flex-control-thumbs li img:hover {
        opacity: 1 !important;
        box-shadow: 0 0 0 2px #000 !important; /* Highlight active */
    }

    /* MAIN SLIDER ARROWS - Force Visible */
    .woocommerce-product-gallery .flex-direction-nav {
        display: block !important;
        visibility: visible !important;
        position: absolute;
        top: 50%;
        width: 100%;
        transform: translateY(-50%);
        z-index: 20;
        pointer-events: none; /* Let clicks pass through container but not links */
    }

    .woocommerce-product-gallery .flex-direction-nav a {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 40px !important;
        height: 40px !important;
        line-height: 40px !important;
        text-align: center !important;
        background: rgba(255,255,255,0.9) !important;
        color: #000 !important;
        border-radius: 50% !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
        margin: -20px 0 0 !important;
        position: absolute !important;
        top: 50% !important;
        pointer-events: auto !important; /* Re-enable clicks */
    }

    .woocommerce-product-gallery .flex-direction-nav a.flex-prev {
        left: 10px !important;
    }
    .woocommerce-product-gallery .flex-direction-nav a.flex-next {
        right: 10px !important;
    }

    /* 5. Shop Page Price Visibility & Styling */
    /* Force ALL price elements to be black using body scope to win specificity wars */
    body.woocommerce-shop .price,
    body.woocommerce-shop .amount,
    body.archive .price,
    body.archive .amount,
    .woocommerce ul.products li.product .price,
    .woocommerce ul.products li.product .price * {
        color: #000000 !important;
        visibility: visible !important;
        opacity: 1 !important; 
    }
    
    .woocommerce ul.products li.product .price {
        display: block !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        margin-bottom: 10px !important;
    }

    /* 6. Responsive Related Products & Top Rated */
    .related.products ul.products,
    .up-sells ul.products {
        display: grid !important;
        grid-gap: 20px !important;
        width: 100% !important;
        margin-top: 20px !important;
    }
    
    /* Desktop: 4 Columns Stiff Enforcement */
    @media (min-width: 769px) {
        .related.products ul.products,
        .related.products ul.products.columns-3,
        .related.products ul.products.columns-4,
        .up-sells ul.products {
            grid-template-columns: repeat(4, 1fr) !important;
        }
        
        /* Ensure product items take full width of their grid cell */
        .related.products ul.products li.product,
        .up-sells ul.products li.product {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
        }
    }
    
    /* Mobile/Tablet Responsive */
    @media (max-width: 768px) {
        .related.products ul.products,
        .up-sells ul.products {
            grid-template-columns: repeat(2, 1fr) !important; /* 2 cols on tablet/mobile for better density */
        }
    }
    
    @media (max-width: 480px) {
        .related.products ul.products,
        .up-sells ul.products {
            grid-template-columns: repeat(2, 1fr) !important; /* Keep 2 cols on mobile as requested for "best adjust" */
        }
    }

    /* 7. Gallery Lightbox Trigger Visibility */
    .woocommerce-product-gallery__trigger {
        z-index: 100 !important;
        background: #fff !important;
        border-radius: 50% !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
        right: 15px !important;
        top: 15px !important;
        display: block !important;
    }
    
    /* 8. Mobile Menu Text Color - White */
    @media (max-width: 768px) {
        .main-navigation ul li a,
        .main-navigation .menu-item a,
        .main-navigation a {
            color: #ffffff !important;
        }
    }
    /* Mobile Responsiveness Fix for Brand Story Stats */
    @media (max-width: 991px) {
        body .our-story-section div.brand-stats {
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 30px auto !important;
        }
        body .our-story-section div.brand-stats .stat-item {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 0 15px 0 !important;
            box-sizing: border-box !important;
            display: block !important;
        }
    }

    /* Mobile Fix for "Our Newest Arrivals" Buttons - Nuclear Option */
    @media (max-width: 767px) {
        body .newest-arrivals-section ul.products,
        body .newest-arrivals-section .products {
            grid-template-columns: 1fr !important;
            display: grid !important;
        }

        body .newest-arrivals-section .product-buttons-group .button {
            width: 100% !important;
            max-width: none !important;
            min-width: 0 !important;
            display: block !important;
            margin-bottom: 8px !important;
            padding: 12px 15px !important;
            text-align: center !important;
        }
        
        body .newest-arrivals-section .product-buttons-group {
            width: 100% !important;
            display: block !important;
        }
    }
    </style>

    <script>
    // JS Fallback to force hide icons if CSS fails
    document.addEventListener('DOMContentLoaded', function() {
        var hideIcons = function() {
            // Select indiscriminately
            var icons = document.querySelectorAll('.shopengine-wishlist, .shopengine-comparison, .shopengine-wishlist-btn, .shopengine-compare-btn, [class*="shopengine-wishlist"], [class*="shopengine-compare"]');
            
            icons.forEach(function(icon) {
                // Use setProperty to set !important inline
                icon.style.setProperty('display', 'none', 'important');
                icon.style.setProperty('visibility', 'hidden', 'important');
                icon.style.setProperty('opacity', '0', 'important');
                icon.style.setProperty('width', '0', 'important');
                icon.style.setProperty('height', '0', 'important');
                icon.style.setProperty('margin', '0', 'important');
                icon.style.setProperty('padding', '0', 'important');
            });
        };
        
        hideIcons();
        // Retry for dynamic content
        setTimeout(hideIcons, 500);
        setTimeout(hideIcons, 1000);
        setTimeout(hideIcons, 3000);
    });
    </script>
