document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================================
       1. Thumbnail Gallery Logic
       ========================================================================== */
    const flexThumbnails = document.querySelectorAll('.flex-control-thumbs img');
    if (flexThumbnails.length > 0) {
        flexThumbnails.forEach(thumb => {
            thumb.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const largeEnv = this.getAttribute('data-large_image') || this.src;
                const mainImg = document.querySelector('.woocommerce-product-gallery__image.flex-active-slide img')
                    || document.querySelector('.woocommerce-product-gallery__image img')
                    || document.querySelector('.wp-post-image');

                if (mainImg) {
                    mainImg.style.opacity = 0.5;
                    mainImg.src = largeEnv;
                    mainImg.srcset = '';
                    mainImg.setAttribute('data-large_image', largeEnv);
                    const parentLink = mainImg.closest('a');
                    if (parentLink) parentLink.href = largeEnv;
                    flexThumbnails.forEach(t => t.classList.remove('active-thumb', 'ring-2', 'ring-slate-900'));
                    this.classList.add('active-thumb', 'ring-2', 'ring-slate-900');
                    setTimeout(() => mainImg.style.opacity = 1, 200);
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
       3. Variation Swatches Logic
       ========================================================================== */
    const variationRows = document.querySelectorAll('.variation-row');
    variationRows.forEach(row => {
        const select = row.querySelector('select');
        const container = row.querySelector('.swatch-container');
        const labelDisplay = row.querySelector('.selected-value-label');
        const attributeName = row.dataset.attribute.toLowerCase();

        if (select && container) {
            select.style.display = 'none';
            const isColor = attributeName.includes('color') || attributeName.includes('colour');
            Array.from(select.options).forEach(option => {
                if (option.value === '') return;
                const swatch = document.createElement('div');
                const value = option.value;
                const text = option.text;
                swatch.className = 'cursor-pointer transition-all border border-transparent';
                if (isColor) {
                    swatch.classList.add('w-12', 'h-12', 'rounded-full', 'flex', 'items-center', 'justify-center', 'hover:scale-110');
                    swatch.style.backgroundColor = value.toLowerCase();
                    swatch.title = text;
                    if (['white', '#ffffff', '#fff'].includes(value.toLowerCase())) swatch.classList.add('border-slate-200');
                } else {
                    swatch.classList.add('h-10', 'min-w-[48px]', 'px-4', 'flex', 'items-center', 'justify-center', 'border', 'border-slate-200', 'text-xs', 'font-bold', 'uppercase', 'tracking-widest', 'hover:border-black');
                    swatch.innerText = text;
                }
                swatch.addEventListener('click', () => {
                    container.querySelectorAll('div').forEach(s => {
                        s.classList.remove('ring-2', 'ring-offset-2', 'ring-black', 'bg-black', 'text-white', 'border-black');
                        if (!isColor) s.classList.add('text-slate-900', 'bg-white', 'border-slate-200');
                    });
                    if (isColor) swatch.classList.add('ring-2', 'ring-offset-2', 'ring-black');
                    else {
                        swatch.classList.remove('bg-white', 'text-slate-900', 'border-slate-200');
                        swatch.classList.add('bg-black', 'text-white', 'border-black');
                    }
                    select.value = value;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    if (labelDisplay) labelDisplay.innerText = text;
                });
                container.appendChild(swatch);
            });
        }
    });

    const vForms = document.querySelectorAll('.variations_form');
    if (typeof jQuery !== 'undefined' && vForms.length > 0) {
        vForms.forEach(vf => {
            jQuery(vf).on('reset_data', function () {
                document.querySelectorAll('.swatch-container div').forEach(s => {
                    s.classList.remove('ring-2', 'ring-offset-2', 'ring-black', 'bg-black', 'text-white', 'border-black');
                    if (!s.classList.contains('rounded-full')) {
                        s.classList.add('text-slate-900', 'bg-white', 'border-slate-200');
                    }
                });
                document.querySelectorAll('.selected-value-label').forEach(l => l.innerText = '');
            });
        });
    }

    /* ==========================================================================
       4. Variable Selection Popup (Shop Loop)
       ========================================================================== */
    const selectionTriggers = document.querySelectorAll('.variable-selection-trigger');
    let selectionModal = document.getElementById('asocial-selection-modal');
    if (!selectionModal) {
        selectionModal = document.createElement('div');
        selectionModal.id = 'asocial-selection-modal';
        selectionModal.className = 'asocial-modal';
        selectionModal.innerHTML = `
            <div class="asocial-modal-overlay"></div>
            <div class="asocial-modal-container">
                <button class="asocial-modal-close">&times;</button>
                <div class="asocial-modal-content-wrapper">
                    <div class="asocial-modal-loader"><div class="spinner"></div></div>
                    <div id="asocial-modal-dynamic-content"></div>
                </div>
            </div>
        `;
        document.body.appendChild(selectionModal);
        selectionModal.querySelector('.asocial-modal-close').addEventListener('click', closeModal);
        selectionModal.querySelector('.asocial-modal-overlay').addEventListener('click', closeModal);
    }

    function closeModal() {
        selectionModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openModal() {
        selectionModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        document.getElementById('asocial-modal-dynamic-content').innerHTML = '';
        selectionModal.querySelector('.asocial-modal-loader').style.display = 'flex';
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'asocial-toast';
        toast.textContent = message;
        toast.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#2ecc71;color:#fff;padding:12px 24px;border-radius:30px;z-index:11000;box-shadow:0 5px 15px rgba(0,0,0,0.2);font-weight:bold;';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    selectionTriggers.forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product_id');
            const action = this.getAttribute('data-action');

            openModal();

            jQuery.ajax({
                url: typeof asocial_ajax_obj !== 'undefined' ? asocial_ajax_obj.ajax_url : '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: { action: 'asocial_get_product_variations', product_id: productId },
                success: function (response) {
                    selectionModal.querySelector('.asocial-modal-loader').style.display = 'none';
                    if (response.success) {
                        const contentContainer = document.getElementById('asocial-modal-dynamic-content');
                        contentContainer.innerHTML = response.data.html;

                        const form = jQuery(contentContainer).find('.variations_form');
                        form.wc_variation_form();

                        const submitBtn = form.find('.premium-popup-submit');
                        if (action === 'buy-now') submitBtn.text('Buy Now');

                        form.on('submit', function (formEvent) {
                            formEvent.preventDefault();
                            const variationId = form.find('input[name="variation_id"]').val();

                            if (!variationId || variationId == '0') {
                                alert('Please select all options first.');
                                return;
                            }

                            submitBtn.text('Processing...').prop('disabled', true);

                            if (action === 'buy-now') {
                                // For Buy Now: Add hidden input and submit form to add to cart, then redirect
                                // Remove any existing buy-now input
                                form.find('input[name="buy-now"]').remove();

                                // Add buy-now flag
                                const buyNowInput = jQuery('<input>').attr({
                                    type: 'hidden',
                                    name: 'buy-now',
                                    value: '1'
                                });
                                form.append(buyNowInput);

                                // Ensure add-to-cart is present
                                if (form.find('input[name="add-to-cart"]').length === 0) {
                                    const addToCartInput = jQuery('<input>').attr({
                                        type: 'hidden',
                                        name: 'add-to-cart',
                                        value: productId
                                    });
                                    form.append(addToCartInput);
                                }

                                // Submit the form - WooCommerce will handle adding to cart and our redirect filter will send to checkout
                                form[0].submit();
                            } else {
                                // For Add to Cart: Use AJAX to add and show success message
                                const formData = form.serialize();

                                jQuery.post(window.location.href, formData + '&add-to-cart=' + productId, function (response) {
                                    // Trigger cart update
                                    jQuery(document.body).trigger('wc_fragment_refresh');
                                    closeModal();
                                    showToast('Product added to cart!');
                                }).fail(function () {
                                    alert('Error adding to cart. Please try again.');
                                    submitBtn.text('Confirm Selection').prop('disabled', false);
                                });
                            }
                        });
                    }
                }
            });
        });
    });

    /* ==========================================================================
       5. Buy Now Logic (Single Product Page)
       ========================================================================== */
    const buyNowButtons = document.querySelectorAll('.buy-now-button');
    buyNowButtons.forEach(button => {
        if (button.closest('#asocial-selection-modal')) return;

        button.addEventListener('click', function (e) {
            // Try to find the form - first check if button is inside form, then check siblings
            let form = this.closest('form.cart');
            if (!form) {
                // Button is outside form, look for form in the same wrapper
                const wrapper = this.closest('.product-add-to-cart-wrapper') || this.closest('.product') || this.closest('.summary');
                if (wrapper) {
                    form = wrapper.querySelector('form.cart');
                }
            }

            // Last resort: search if we are on a single product page for any cart form
            if (!form && document.body.classList.contains('single-product')) {
                form = document.querySelector('form.cart') || document.querySelector('.variations_form');
            }

            if (!form) {
                // No form found, likely a loop page (Home/Shop/Category). 
                // Let the normal <a> link navigation happen.
                return;
            }

            // Form found, we are on a product page or have a form to submit.
            // Prevent default link/button action and submit form.
            e.preventDefault();

            if (form.classList.contains('variations_form')) {
                const vId = form.querySelector('input[name="variation_id"]');
                if (!vId || !vId.value || vId.value == '0') {
                    variantUnselectedError(form);
                    return;
                }
            }

            this.innerHTML = '<span class="button-text">Redirecting...</span>';
            this.style.pointerEvents = 'none';

            // Ensure buy-now flag is present
            if (!form.querySelector('input[name="buy-now"]')) {
                const bni = document.createElement('input'); bni.type = 'hidden'; bni.name = 'buy-now'; bni.value = '1';
                form.appendChild(bni);
            }

            // CRITICAL: Ensure add-to-cart is present as a HIDDEN field if we call form.submit()
            // because the original submit button (which usually carries the name 'add-to-cart')
            // will not be sent in the POST data.
            let atcInput = form.querySelector('input[name="add-to-cart"]');
            const productId = atcInput ? atcInput.value : (form.querySelector('input[name="product_id"]')?.value || this.getAttribute('data-product_id'));

            // If the existing 'add-to-cart' is not a hidden input, create/ensure one exists
            if (!atcInput || atcInput.tagName !== 'INPUT') {
                if (atcInput) atcInput.setAttribute('name', 'add-to-cart-dummy'); // Rename old if it was a button
                const newAtc = document.createElement('input');
                newAtc.type = 'hidden';
                newAtc.name = 'add-to-cart';
                newAtc.value = productId;
                form.appendChild(newAtc);
            }

            setTimeout(() => { form.submit(); }, 100);
        });
    });

    function variantUnselectedError(form) {
        const top = form.getBoundingClientRect().top + window.pageYOffset - 150;
        window.scrollTo({ top: top, behavior: 'smooth' });
        const vt = form.querySelector('table.variations');
        if (vt) {
            vt.style.outline = '2px solid #ff4d4d';
            vt.style.borderRadius = '5px';
            setTimeout(() => vt.style.outline = 'none', 2000);
        }
        alert('Please select all options before buying.');
    }
});
