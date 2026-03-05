<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Asocial_Chameleon
 */

get_header();
?>

<div class="container main-content-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'asocial-chameleon' ); ?></h1>
				</header>

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'asocial-chameleon' ); ?></p>

					<?php get_search_form(); ?>

                    <div class="widget-area-404" style="margin-top: 40px;">
                        <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
                    </div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
get_footer();
