<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @package ASocialChameleon
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<div id="primary" class="content-area single-product-page">
	<main id="main" class="site-main">

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
