/**
 * File: assets/js/navigation.js
 * Handles toggling the navigation menu for small screens.
 */

(function () {
    // Get the menu toggle button
    var button = document.querySelector('.menu-toggle');
    var navigation = document.getElementById('site-navigation');
    var menu = navigation ? navigation.querySelector('ul') : null;

    if (!button || !navigation) {
        return;
    }

    // Toggle menu on button click
    button.addEventListener('click', function () {
        var isExpanded = button.getAttribute('aria-expanded') === 'true';

        if (isExpanded) {
            // Close menu
            button.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('toggled');
            if (menu) {
                menu.setAttribute('aria-expanded', 'false');
            }
        } else {
            // Open menu
            button.setAttribute('aria-expanded', 'true');
            navigation.classList.add('toggled');
            if (menu) {
                menu.setAttribute('aria-expanded', 'true');
            }
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
        var isClickInside = navigation.contains(event.target) || button.contains(event.target);

        if (!isClickInside && navigation.classList.contains('toggled')) {
            button.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('toggled');
            if (menu) {
                menu.setAttribute('aria-expanded', 'false');
            }
        }
    });
})();
