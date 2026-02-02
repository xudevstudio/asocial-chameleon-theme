document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================================
       1. Thumbnail Gallery Logic (FlexSlider / Theme Specific)
       ========================================================================== */
    // Used when theme uses FlexSlider for thumbnails
    const flexThumbnails = document.querySelectorAll('.flex-control-thumbs img');
    const mainImages = document.querySelectorAll('.woocommerce-product-gallery__image img'); // Usually one visible, key one first

    if (flexThumbnails.length > 0) {
        flexThumbnails.forEach(thumb => {
            thumb.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Get the high-res image source
                // Often FlexSlider puts the main image src in 'src' of the thumb or a data attribute
                // Inspection showed standard img tags. 
                // We'll try to find the 'data-large_image' or matching index behavior.

                // Strategy: Update the VISIBLE main image
                // The main gallery usually has multiple images if it's a slider.
                // But if it's a static main image + thumbs, we update the main img.

                const newSrc = this.getAttribute('src').replace('-100x100', ''); // Heuristic to remove thumb sizing if present
                // Or better, if the thumb is just a small version, use its base src
                // But standard WC thumbs might be different files.
                // Let's rely on standard WC attributes if available

                // Try to get the large version. If not, use src.
                const largeEnv = this.getAttribute('data-large_image') || this.src;

                // Find all potential main images and update them (in case of slider duplication)
                const mainImg = document.querySelector('.woocommerce-product-gallery__image.flex-active-slide img')
                    || document.querySelector('.woocommerce-product-gallery__image img')
                    || document.querySelector('.wp-post-image');

                if (mainImg) {
                    mainImg.style.opacity = 0.5;
                    mainImg.src = largeEnv;
                    // Try to set srcset to empty to force browser to use src, or update it if we knew it
                    mainImg.srcset = '';
                    mainImg.setAttribute('data-large_image', largeEnv);

                    // Update parent link if it exists (LightBox link)
                    const parentLink = mainImg.closest('a');
                    if (parentLink) {
                        parentLink.href = largeEnv;
                    }

                    // Visual feedback on thumbs
                    flexThumbnails.forEach(t => t.classList.remove('active-thumb', 'ring-2', 'ring-slate-900'));
                    this.classList.add('active-thumb', 'ring-2', 'ring-slate-900');

                    setTimeout(() => mainImg.style.opacity = 1, 200);
                }
            });
        });
    }

    // Fallback/Standard logic from previous attempt (kept just in case structure changes)
    const galleryWrapper = document.querySelector('.woocommerce-product-gallery__wrapper');
    const galleryImages = document.querySelectorAll('.woocommerce-product-gallery__image');

    if (galleryWrapper && galleryImages.length > 1) {
        // Assume first image is Main.
        const mainImageContainer = galleryImages[0];
        const mainImgTag = mainImageContainer.querySelector('img');

        // Loop through all images
        galleryImages.forEach((imageContainer, index) => {
            // Skip if it's the main image itself (index 0) - though clicking it might open lightbox (default WC behavior)
            if (index === 0) return;

            // Target the anchor tag if it exists, otherwise the image container
            const link = imageContainer.querySelector('a') || imageContainer;
            const imgTag = imageContainer.querySelector('img');

            if (!imgTag) return;

            // Make it clickable
            link.addEventListener('click', function (e) {
                // Prevent default behavior (like opening lightbox immediately if that's not desired, or following link)
                e.preventDefault(); // Stop link from opening
                e.stopPropagation();

                // Get source from the clicked thumbnail (it might be full size if using standard WC HTML)
                // WC usually puts the full size URL in 'data-large_image' or 'href' of anchor, and 'src' is also available.
                // We want to update the main image's src and srcset.

                const newSrc = imgTag.getAttribute('src');
                const newSrcSet = imgTag.getAttribute('srcset');
                // Use data-large_image if available for better quality, else src
                const newLargeImage = imgTag.getAttribute('data-large_image') || newSrc;

                if (mainImgTag && newSrc) {
                    mainImgTag.style.opacity = 0.5;

                    // Update main image attributes
                    mainImgTag.src = newLargeImage; // Use larger version for main view
                    if (newSrcSet) mainImgTag.srcset = newSrcSet;

                    // Update main image data attributes for lightbox/zoom if needed
                    mainImgTag.setAttribute('data-large_image', newLargeImage);
                    mainImgTag.setAttribute('data-src', newLargeImage);

                    if (mainImgTag.parentElement.tagName === 'A') {
                        mainImgTag.parentElement.href = newLargeImage;
                    }

                    // Add active state styling
                    galleryImages.forEach(g => {
                        const img = g.querySelector('img');
                        if (img) img.classList.remove('active-thumb', 'ring-2', 'ring-slate-900', 'border-blue-500');
                    });

                    imgTag.classList.add('active-thumb', 'ring-2', 'ring-slate-900', 'border-blue-500');

                    setTimeout(() => mainImgTag.style.opacity = 1, 200);
                }
            });
        });
    }

    /* ==========================================================================
       2. Quantity Selector Logic 
       ========================================================================== */
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('qty-decrease') || e.target.classList.contains('qty-increase')) {
            e.preventDefault();
            const button = e.target;
            const input = button.parentElement.querySelector('input.qty-input');

            if (input) {
                let value = parseInt(input.value) || 1;
                const min = parseInt(input.getAttribute('min')) || 1;
                const max = parseInt(input.getAttribute('max')) || 9999;

                if (button.classList.contains('qty-increase')) {
                    if (value < max) value++;
                } else {
                    if (value > min) value--;
                }

                input.value = value;
                input.dispatchEvent(new Event('change'));
            }
        }
    });

    /* ==========================================================================
       3. AJAX Add to Cart (Single Product)
       ========================================================================== */
    /* 
    // AJAX Add to Cart (Single Product) - DISABLED to allow standard redirect
    const addToCartBtn = document.querySelector('.single_add_to_cart_button');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function (e) {
             // ... existing logic disabled ...   
        });
    }
    */

    /* ==========================================================================
       4. Variation Swatches Generator
       ========================================================================== */
    const variationRows = document.querySelectorAll('.variation-row');

    variationRows.forEach(row => {
        const select = row.querySelector('select');
        const container = row.querySelector('.swatch-container');
        const labelDisplay = row.querySelector('.selected-value-label');
        const attributeName = row.dataset.attribute.toLowerCase();

        // Hide the original Select but keep it functional
        if (select && container) {
            select.style.display = 'none'; // Hide it

            // Helper to determine swatch type
            const isColor = attributeName.includes('color') || attributeName.includes('colour');

            // Iterate options (skip placeholder)
            Array.from(select.options).forEach(option => {
                if (option.value === '') return;

                const swatch = document.createElement('div');
                const value = option.value;
                const text = option.text;

                swatch.className = 'cursor-pointer transition-all border border-transparent';

                if (isColor) {
                    // Circle Color Swatch
                    swatch.classList.add('w-12', 'h-12', 'rounded-full', 'flex', 'items-center', 'justify-center', 'hover:scale-110');
                    swatch.style.backgroundColor = value.toLowerCase();
                    // Fallback to text title for accessibility
                    swatch.title = text;

                    // Add outline for white/light colors
                    if (['white', '#ffffff', '#fff'].includes(value.toLowerCase())) {
                        swatch.classList.add('border-slate-200');
                    }
                } else {
                    // Box Size/Text Swatch
                    swatch.classList.add('h-10', 'min-w-[48px]', 'px-4', 'flex', 'items-center', 'justify-center', 'border', 'border-slate-200', 'text-xs', 'font-bold', 'uppercase', 'tracking-widest', 'hover:border-black');
                    swatch.innerText = text;
                }

                // Handle Click
                swatch.addEventListener('click', () => {
                    // 1. Reset visual state of all swatches in this row
                    container.querySelectorAll('div').forEach(s => {
                        s.classList.remove('ring-2', 'ring-offset-2', 'ring-black', 'bg-black', 'text-white', 'border-black');
                        if (!isColor) s.classList.add('text-slate-900', 'bg-white', 'border-slate-200'); // Reset box styles
                    });

                    // 2. Set active state on clicked swatch
                    if (isColor) {
                        swatch.classList.add('ring-2', 'ring-offset-2', 'ring-black');
                    } else {
                        swatch.classList.remove('bg-white', 'text-slate-900', 'border-slate-200');
                        swatch.classList.add('bg-black', 'text-white', 'border-black');
                    }

                    // 3. Update real Select value
                    select.value = value;

                    // 4. Trigger Change event for WooCommerce & Validation
                    const event = new Event('change', { bubbles: true });
                    select.dispatchEvent(event);

                    // 5. Update Label Display
                    if (labelDisplay) {
                        labelDisplay.innerText = text;
                    }
                });

                container.appendChild(swatch);
            });
        }
    });

    // Listen for WooCommerce reset (when "Clear" is clicked)
    const form = document.querySelector('.variations_form');
    // Using jQuery here because WooCommerce uses jQuery events
    if (typeof jQuery !== 'undefined' && form) {
        jQuery(form).on('reset_data', function () {
            document.querySelectorAll('.swatch-container div').forEach(s => {
                s.classList.remove('ring-2', 'ring-offset-2', 'ring-black', 'bg-black', 'text-white', 'border-black');
                // Reset to default style based on type - checking class to deduce type
                if (!s.classList.contains('rounded-full')) {
                    s.classList.add('text-slate-900', 'bg-white', 'border-slate-200');
                }
            });
            document.querySelectorAll('.selected-value-label').forEach(l => l.innerText = '');
        });
    }

    /* ==========================================================================
       5. Buy Now Logic (Direct Checkout)
       ========================================================================== */
    // Use querySelectorAll to catch ALL buy now buttons (Related products, etc.)
    const buyNowButtons = document.querySelectorAll('.buy-now-button');

    buyNowButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            // For simple <a> tags that point directly to checkout, let the browser handle it
            if (this.tagName === 'A' && this.getAttribute('href').includes('checkout')) {
                return;
            }

            e.preventDefault();

            // Form Validation (For the main product form only if this button is part of it)
            const form = this.closest('form.cart') || document.querySelector('form.cart');
            if (form && form.classList.contains('variations_form')) {
                const variationInput = form.querySelector('input[name="variation_id"]');
                if (!variationInput || !variationInput.value || variationInput.value == '0') {
                    alert('Please select some product options first.');
                    return;
                }
            }

            // Visual Loading
            const originalText = this.innerText;
            this.innerText = 'Processing...';
            this.classList.add('opacity-75', 'cursor-not-allowed');

            let productId = this.value || this.getAttribute('data-product_id');
            const quantityInput = document.querySelector('input.qty-input');
            const quantity = quantityInput ? quantityInput.value : 1;

            // Use the localized checkout URL passed from PHP
            let baseCheckoutUrl = (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.checkout_url)
                ? wc_add_to_cart_params.checkout_url
                : '/checkout/';

            // Build redirection URL
            let finalUrl = new URL(baseCheckoutUrl, window.location.origin);
            finalUrl.searchParams.append('add-to-cart', productId);
            finalUrl.searchParams.append('quantity', quantity);
            finalUrl.searchParams.append('buy-now', '1'); // Force redirect on server too

            // Handle Variations specifically
            if (form && form.classList.contains('variations_form')) {
                const variationIdField = form.querySelector('input[name="variation_id"]');
                const variationId = variationIdField ? variationIdField.value : null;
                if (variationId) {
                    finalUrl.searchParams.set('add-to-cart', variationId);

                    // Add attributes to URL for extra robustness
                    const data = new FormData(form);
                    for (var pair of data.entries()) {
                        if (pair[0].startsWith('attribute_')) {
                            finalUrl.searchParams.append(pair[0], pair[1]);
                        }
                    }
                }
            }

            // Final Redirect
            window.location.href = finalUrl.toString();
        });
    });

});
