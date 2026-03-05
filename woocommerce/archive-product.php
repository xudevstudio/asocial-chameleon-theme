<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @package Asocial_Chameleon
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>

<div class="shop-page-wrapper bg-gray-50 min-h-screen pb-20">
    
    <!-- Hero / Title Section -->
    <div class="shop-hero relative bg-white overflow-hidden shadow-sm mb-10">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-blue-500/10 z-0"></div>
        <div class="container mx-auto px-4 py-12 md:py-16 relative z-10 text-center">
             <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <h1 class="woocommerce-products-header__title page-title text-4xl md:text-6xl font-display font-bold text-gray-900 mb-4 tracking-tight">
                    <?php woocommerce_page_title(); ?>
                </h1>
            <?php endif; ?>
            
            <div class="max-w-2xl mx-auto text-gray-600">
                <?php do_action( 'woocommerce_archive_description' ); ?>
            </div>
        </div>
    </div>

    <!-- Main Content - Full Width Flow -->
    <div class="container mx-auto px-4 md:px-8 max-w-[1600px]">
        
        <!-- Toolbar / Filter Bar -->
        <div class="shop-toolbar bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            
             <!-- Left: Count & Filter Toggle (Optional) -->
             <div class="flex items-center gap-4">
                 <div class="result-count text-gray-500 text-sm font-medium whitespace-nowrap">
                    <?php woocommerce_result_count(); ?>
                 </div>
                 <!-- Optional: Add a filter toggle button here if we implement off-canvas filters -->
             </div>

             <!-- Right: Sorting -->
             <div class="sort-dropdown w-full sm:w-auto">
                <?php woocommerce_catalog_ordering(); ?>
             </div>
        </div>

        <?php
        if ( woocommerce_product_loop() ) {
            ?>
            
            <!-- Product Grid: Full Width, 2 Cols Mobile, 4 Cols Desktop -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
                <?php
                while ( have_posts() ) {
                    the_post(); // Initialize the post info
                    
                    // Load the custom content-product template
                    wc_get_template_part( 'content', 'product' );
                }
                ?>
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                <?php
                $args = array(
                    'total'   => $wp_query->max_num_pages,
                    'current' => max( 1, get_query_var( 'paged' ) ),
                    'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
                    'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                    'type'      => 'array',
                    'end_size'  => 3,
                    'mid_size'  => 3,
                );
                $paginate_links = paginate_links( $args );

                if ( $paginate_links ) {
                   echo '<nav class="flex gap-2">';
                   foreach ( $paginate_links as $link ) {
                       // Add Tailwind classes to pagination links
                       $link = str_replace( 'page-numbers', 'flex items-center justify-center w-10 h-10 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-purple-50 hover:border-purple-200 hover:text-purple-600 transition-all font-medium', $link );
                       $link = str_replace( 'current', '!bg-purple-600 !text-white !border-purple-600 shadow-md', $link );
                       echo $link;
                   }
                   echo '</nav>';
                }
                ?>
            </div>

            <?php
        } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
        }
        ?>
    </div>
</div>

<?php
get_footer( 'shop' );
