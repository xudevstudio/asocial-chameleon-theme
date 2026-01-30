<?php
/**
 * The template for displaying search results pages
 *
 * @package Asocial_Chameleon
 */

get_header();
?>

<div class="container main-content-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'asocial-chameleon' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header>

            <div class="search-results-grid archive-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('search-item archive-item'); ?>>
                    <header class="entry-header">
                        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    </header>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
				<?php
			endwhile;
			?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination( array(
                    'prev_text' => __( 'Previous', 'asocial-chameleon' ),
                    'next_text' => __( 'Next', 'asocial-chameleon' ),
                ) );
                ?>
            </div>

		<?php else : ?>

			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'asocial-chameleon' ); ?></h1>
				</header>
				<div class="page-content">
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'asocial-chameleon' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</section>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
get_footer();
