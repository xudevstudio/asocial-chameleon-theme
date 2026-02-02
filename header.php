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

                    <!-- Cart -->
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <div class="header-account-inline" style="margin-left: 15px;">
                        <a class="account-customlocation" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'asocial-chameleon' ); ?>">
                            <span class="account-icon">
                                <!-- Professional User Icon with Gradient -->
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="accountGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#9b59b6;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#00d2ff;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
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
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'nav-menu', // Class for styling
                        'container'      => false,
                        'fallback_cb'    => false, // Don't show pages if no menu fits
					)
				);
				?>
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

    /* 1. Related Products - Force 3 Columns & Fix Overflow */
    @media (min-width: 769px) {
        /* Target specifically to override theme's column classes */
        .related.products ul.products,
        .related.products ul.products.columns-4,
        .related.products ul.products.columns-3 {
            grid-template-columns: repeat(3, 1fr) !important;
            display: grid !important;
            width: 100% !important;
        }
        
        .related.products ul.products li.product {
            width: 100% !important;
            max-width: 100% !important;
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

    /* FIX: Ensure the viewport doesn't collapse */
    .woocommerce-product-gallery .flex-viewport {
        height: auto !important;
        overflow: hidden !important;
    }

    /* Force proper image display */
    .woocommerce-product-gallery .woocommerce-product-gallery__image {
        display: block !important; /* Ensure it's not flexed */
    }
    
    .woocommerce-product-gallery .woocommerce-product-gallery__image img {
        display: block !important;
        height: auto !important;
        width: 100% !important;
        margin: 0 auto !important;
    }

    /* Force thumbnails strip layout */
    .woocommerce-product-gallery .flex-control-nav.flex-control-thumbs {
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        margin: 20px 0 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: relative !important;
    }

    .woocommerce-product-gallery .flex-control-thumbs li {
        width: 20% !important; /* 5 per row max */
        float: none !important; /* Disable float which breaks flex */
        display: block !important;
        margin: 0 5px 5px !important;
        cursor: pointer !important;
    }

    .woocommerce-product-gallery .flex-control-thumbs li img {
        opacity: 0.5 !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 0 0 1px #eee !important;
    }

    .woocommerce-product-gallery .flex-control-thumbs li img.flex-active, 
    .woocommerce-product-gallery .flex-control-thumbs li img:hover {
        opacity: 1 !important;
        box-shadow: 0 0 0 2px #000 !important; /* Highlight active */
    }

    /* 5. Shop Page Price Visibility & Styling */
    /* Force ALL price elements to be black */
    .woocommerce ul.products li.product .price,
    .woocommerce ul.products li.product .price *,
    .woocommerce ul.products li.product .price span,
    .woocommerce ul.products li.product .price bdi,
    .price span.woocommerce-Price-amount,
    .price span.woocommerce-Price-currencySymbol {
        color: #000000 !important;
        opacity: 1 !important;
        visibility: visible !important;
        text-shadow: none !important;
    }
    
    .woocommerce ul.products li.product .price {
        display: block !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        margin-bottom: 10px !important;
        background: transparent !important; /* Ensure no white bg overlay */
    }

    /* 6. Responsive Related Products */
    .related.products ul.products {
        display: grid !important;
        grid-gap: 20px !important;
    }
    
    /* Desktop: 3 Columns */
    @media (min-width: 769px) {
        .related.products ul.products {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
    /* Tablet: 2 Columns */
    @media (min-width: 481px) and (max-width: 768px) {
        .related.products ul.products {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    /* Mobile: 1 Column */
    @media (max-width: 480px) {
        .related.products ul.products {
            grid-template-columns: 1fr !important;
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
