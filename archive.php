<?php
/**
 * The template for displaying archive pages
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
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<div class="archive-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('archive-item'); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                        <?php the_post_thumbnail( 'medium' ); ?>
                    </a>
                    <?php endif; ?>
                    
                    <header class="entry-header">
                        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                        <div class="entry-meta">
                            <?php echo get_the_date(); ?>
                        </div>
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
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'asocial-chameleon' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</section>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
get_footer();
