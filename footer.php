	</div><!-- .container -->

	<footer id="colophon" class="site-footer">
		<div class="footer-container container">
            
            <!-- Footer Widgets Grid -->
            <div class="footer-grid">
                
                <!-- Column 1: About / Brand -->
                <div class="footer-col footer-about">
                    <h3 class="footer-heading"><?php esc_html_e( 'Asocial Chameleon', 'asocial-chameleon' ); ?></h3>
                    <p><?php esc_html_e( 'Blending in with the shadows, standing out in the light. Premium streetwear for the unseen.', 'asocial-chameleon' ); ?></p>
                    <div class="footer-socials">
                        <a href="https://www.facebook.com/asocialchameleonclub" target="_blank" class="social-icon" title="Facebook">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social/facebook.png" alt="Facebook">
                        </a>
                        <a href="https://uk.pinterest.com/asocialchameleonclub/" target="_blank" class="social-icon" title="Pinterest">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social/pinterest-icon.png" alt="Pinterest">
                        </a>
                        <a href="https://www.instagram.com/asocialchameleonclub" target="_blank" class="social-icon" title="Instagram">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social/instagram-icon.png" alt="Instagram">
                        </a>
                        <a href="https://www.youtube.com/@AsocialChameleonclub" target="_blank" class="social-icon" title="YouTube">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social/youtube-icon.png" alt="YouTube">
                        </a>
                    </div>
                </div>

                <!-- Column 2: Shop Links -->
                <div class="footer-col footer-links">
                    <h3 class="footer-heading"><?php esc_html_e( 'Shop', 'asocial-chameleon' ); ?></h3>
                    <ul class="footer-menu">
                        <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"><?php esc_html_e( 'All Products', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/product-category/t-shirts' ) ); ?>"><?php esc_html_e( 'T-Shirts', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/product-category/sweatshirts-hoodies-jumpers' ) ); ?>"><?php esc_html_e( 'Hoodies & Jumpers', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/product-category/hats' ) ); ?>"><?php esc_html_e( 'For your head', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/cart' ) ); ?>"><?php esc_html_e( 'Cart', 'asocial-chameleon' ); ?></a></li>
                    </ul>
                </div>

                <!-- Column 3: Support Links -->
                <div class="footer-col footer-help">
                    <h3 class="footer-heading"><?php esc_html_e( 'Support', 'asocial-chameleon' ); ?></h3>
                    <ul class="footer-menu">
                        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/shipping-returns' ) ); ?>"><?php esc_html_e( 'Shipping & Returns', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/size-guide' ) ); ?>"><?php esc_html_e( 'Size Guide', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/track-order' ) ); ?>"><?php esc_html_e( 'Track My Order', 'asocial-chameleon' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'asocial-chameleon' ); ?></a></li>
                    </ul>
                </div>

                <!-- Column 4: Newsletter -->
                <div class="footer-col footer-newsletter">
                    <h3 class="footer-heading"><?php esc_html_e( 'Stay Hidden', 'asocial-chameleon' ); ?></h3>
                    <p><?php esc_html_e( 'Join the shadows. Get exclusive drops and updates.', 'asocial-chameleon' ); ?></p>
                    <form class="footer-subscribe">
                        <input type="email" placeholder="Your email..." required>
                        <button type="submit">→</button>
                    </form>
                </div>

            </div><!-- .footer-grid -->

            <!-- Copyright Bar -->
			<div class="site-info copyright-bar">
                <p>&copy; <?php echo date( 'Y' ); ?> Asocial Chameleon. All rights reserved.</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
