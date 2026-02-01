/**
 * Single Product Page Gallery and Buy Now Fix
 */
jQuery(document).ready(function ($) {

    // Gallery Image Click - Change Main Image Instead of Opening New Tab
    $('.woocommerce-product-gallery__image a').on('click', function (e) {
        e.preventDefault(); // Prevent default link behavior

        var imageUrl = $(this).attr('href');
        var $mainImage = $('.woocommerce-product-gallery__image:first img');

        // Update main image
        if ($mainImage.length) {
            $mainImage.attr('src', imageUrl);
            $mainImage.attr('srcset', imageUrl);
        }

        // Add active class to clicked thumbnail
        $('.woocommerce-product-gallery__image').removeClass('active');
        $(this).parent().addClass('active');

        return false;
    });

    // Buy Now Button Functionality
    $('.buy-now-button').on('click', function (e) {
        e.preventDefault();

        var $button = $(this);
        var productId = $button.data('product-id');
        var $form = $button.closest('.product').find('form.cart');

        // Get variation data if it's a variable product
        var variationId = $form.find('input[name="variation_id"]').val();
        var quantity = $form.find('input[name="quantity"]').val() || 1;

        // Check if variations are selected for variable products
        if ($form.find('.variations_form').length && !variationId) {
            alert('Please select product options');
            return;
        }

        // Add to cart via AJAX
        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: productId,
            quantity: quantity
        };

        if (variationId) {
            data.variation_id = variationId;
        }

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.wc_ajax_url,
            data: data,
            success: function (response) {
                if (response.error) {
                    alert(response.error_message);
                } else {
                    // Redirect to checkout
                    window.location.href = wc_add_to_cart_params.checkout_url;
                }
            },
            error: function () {
                alert('Error adding product to cart');
            }
        });
    });

    // Hide empty product description to fix spacing
    var $productDesc = $('.product-description');
    if ($productDesc.length) {
        var descText = $productDesc.text().trim();
        if (descText === '' || descText.length === 0) {
            $productDesc.hide();
        }
    }
});
