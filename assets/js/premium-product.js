document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================================
       1. Thumbnail Gallery Logic
       ========================================================================== */
    const mainImage = document.querySelector('.main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function () {
                // Remove active class from all
                thumbnails.forEach(t => t.classList.remove('active', 'ring-2', 'ring-slate-900'));

                // Add active class to clicked
                this.classList.add('active', 'ring-2', 'ring-slate-900');

                // Switch main image
                const newSrc = this.getAttribute('data-image');
                if (newSrc) {
                    mainImage.src = newSrc;
                    // Optional: Add simple fade effect
                    mainImage.style.opacity = 0.5;
                    setTimeout(() => mainImage.style.opacity = 1, 150);
                }
            });
        });

        // Set first thumbnail active by default
        thumbnails[0].classList.add('active', 'ring-2', 'ring-slate-900');
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
