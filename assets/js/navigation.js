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
            closeMenu();
        } else {
            // Open menu
            openMenu();
        }
    });

    function openMenu() {
        button.setAttribute('aria-expanded', 'true');
        navigation.classList.add('toggled');
        document.body.classList.add('mobile-menu-open');
        if (menu) {
            menu.setAttribute('aria-expanded', 'true');
        }
    }

    function closeMenu() {
        button.setAttribute('aria-expanded', 'false');
        navigation.classList.remove('toggled');
        document.body.classList.remove('mobile-menu-open');
        if (menu) {
            menu.setAttribute('aria-expanded', 'false');
        }
    }

    // Handle close button if it exists (X icon inside menu)
    document.addEventListener('click', function (event) {
        if (event.target.closest('.menu-close')) {
            closeMenu();
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
        var isClickInside = navigation.contains(event.target) || button.contains(event.target);

        if (!isClickInside && navigation.classList.contains('toggled')) {
            closeMenu();
        }
    });
})();
