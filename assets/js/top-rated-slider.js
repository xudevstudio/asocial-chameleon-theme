/**
 * Top Rated Collection Slider
 * Swiper.js initialization for the product slider
 */

document.addEventListener('DOMContentLoaded', function () {
    // Check if Swiper is loaded and slider exists
    if (typeof Swiper !== 'undefined' && document.querySelector('.top-rated-swiper')) {
        const topRatedSwiper = new Swiper('.top-rated-swiper', {
            // Slides per view configuration
            slidesPerView: 1,
            spaceBetween: 20,

            // Auto-slide configuration - Continuous smooth scrolling
            autoplay: {
                delay: 2000, // Faster transitions for continuous feel
                disableOnInteraction: false,
                pauseOnMouseEnter: false, // Keep scrolling on desktop
            },

            // Loop for infinite sliding
            loop: true,

            // Speed of transition - Smooth and fast
            speed: 1200,

            // Pagination dots
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Responsive breakpoints
            breakpoints: {
                // Mobile (480px and up)
                480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                // Tablet (768px and up)
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                // Desktop (1024px and up) - 4 products
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                }
            },

            // Smooth animations
            effect: 'slide',

            // Grab cursor
            grabCursor: true,

            // Keyboard control
            keyboard: {
                enabled: true,
            },

            // Mouse wheel control
            mousewheel: {
                forceToAxis: true,
            },

            // Accessibility
            a11y: {
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide',
            },
        });

        // Optional: Log when slider is initialized
        console.log('Top Rated Collection Slider initialized');
    }
});
