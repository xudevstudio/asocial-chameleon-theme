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

    /**
     * Buy Now Button Functionality
     * NOTE: This has been moved to premium-product.js for better integration
     * Removing duplicate handler to prevent conflicts and 403 errors
     */


    // Hide empty product description to fix spacing
    var $productDesc = $('.product-description');
    if ($productDesc.length) {
        var descText = $productDesc.text().trim();
        if (descText === '' || descText.length === 0) {
            $productDesc.hide();
        }
    }
});
