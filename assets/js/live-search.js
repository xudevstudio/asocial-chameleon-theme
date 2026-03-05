jQuery(document).ready(function ($) {
    // 1. Selector for the search input
    // Targeting both standard search and WooCommerce product search forms
    var searchInput = $('.woocommerce-product-search input[name="s"], .search-form input[name="s"]');
    var searchForm = searchInput.closest('form');

    // Create a container for results if not exists
    if ($('#asocial-live-search-results').length === 0) {
        $('body').append('<div id="asocial-live-search-results"></div>');
    }
    var resultsContainer = $('#asocial-live-search-results');

    // Debounce function to limit ajax calls
    function debounce(func, wait) {
        var timeout;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                func.apply(context, args);
            }, wait);
        };
    }

    searchInput.on('keyup', debounce(function () {
        var query = $(this).val();

        if (query.length < 3) {
            resultsContainer.hide();
            return;
        }

        $.ajax({
            url: asocial_live_search_params.ajax_url,
            type: 'post',
            data: {
                action: 'asocial_live_search',
                security: asocial_live_search_params.security,
                term: query
            },
            beforeSend: function () {
                searchInput.addClass('loading');
            },
            success: function (response) {
                searchInput.removeClass('loading');
                if (response.success && response.data.length > 0) {
                    var html = '<ul>';
                    $.each(response.data, function (index, product) {
                        html += '<li>';
                        html += '<a href="' + product.url + '" class="flex items-center p-2 hover:bg-gray-100 transition-colors">';
                        html += '<img src="' + product.image + '" class="w-10 h-10 object-cover rounded mr-3" alt="' + product.title + '">';
                        html += '<div>';
                        html += '<span class="block font-medium text-sm text-gray-900">' + product.title + '</span>';
                        if (product.price) {
                            html += '<span class="block text-xs text-gray-500">' + product.price + '</span>';
                        }
                        html += '</div>';
                        html += '</a>';
                        html += '</li>';
                    });
                    html += '</ul>';

                    // Position the dropdown below the input
                    var offset = searchInput.offset();
                    var width = searchInput.outerWidth();

                    resultsContainer.html(html).css({
                        'top': (offset.top + searchInput.outerHeight()) + 'px',
                        'left': offset.left + 'px',
                        'width': width + 'px',
                        'position': 'absolute',
                        'background': '#fff',
                        'z-index': '9999',
                        'box-shadow': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'border-radius': '0.5rem',
                        'border': '1px solid #e5e7eb',
                        'display': 'block',
                        'overflow': 'hidden'
                    }).show();
                } else {
                    resultsContainer.html('<div class="p-3 text-sm text-gray-500">No products found</div>').show();
                    // Position (same as above, duplicate code for safety)
                    var offset = searchInput.offset();
                    var width = searchInput.outerWidth();
                    resultsContainer.css({
                        'top': (offset.top + searchInput.outerHeight()) + 'px',
                        'left': offset.left + 'px',
                        'width': width + 'px',
                        'position': 'absolute',
                        'background': '#fff',
                        'z-index': '9999',
                        'box-shadow': '0 4px 6px rgba(0,0,0,0.1)',
                        'border-radius': '0 0 8px 8px',
                        'display': 'block'
                    });
                }
            }
        });
    }, 300));

    // Hide results when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#asocial-live-search-results').length && !$(e.target).closest(searchForm).length) {
            resultsContainer.hide();
        }
    });
});
