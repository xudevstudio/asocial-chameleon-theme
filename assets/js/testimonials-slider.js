/**
 * Testimonials Slider
 * Swiper.js initialization for testimonials carousel
 */

document.addEventListener('DOMContentLoaded', function () {
    // Check if Swiper is loaded and testimonials slider exists
    if (typeof Swiper !== 'undefined' && document.querySelector('.testimonials-swiper')) {
        const testimonialsSwiper = new Swiper('.testimonials-swiper', {
            // Slides per view
            slidesPerView: 1,
            spaceBetween: 30,

            // Auto-slide
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            // Loop
            loop: true,

            // Speed
            speed: 600,

            // Pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },

            // Navigation
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Responsive breakpoints
            breakpoints: {
                // Mobile
                480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                // Tablet
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                // Desktop
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            },

            // Effect
            effect: 'slide',

            // Grab cursor
            grabCursor: true,
        });

        console.log('Testimonials Slider initialized');
    }
});
