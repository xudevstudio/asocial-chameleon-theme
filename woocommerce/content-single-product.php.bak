<?php
/**
 * The template for displaying product content in the single-product.php template
 * Ultra Premium Modern UI/UX Design v2.0
 *
 * @package ASocialChameleon
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'premium-single-product font-sans text-slate-900 bg-white', $product ); ?>>

	<!-- Full Width Container -->
	<main class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10 py-4 lg:py-8">
		
		<!-- Breadcrumb -->
		<nav class="flex mb-4 lg:mb-6 text-xs font-bold uppercase tracking-[0.2em] text-slate-400">
			<?php
			$terms = get_the_terms( $product->get_id(), 'product_cat' );
			?>
			<a class="hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="mx-3 text-slate-300">/</span>
			<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
				<a class="hover:text-primary transition-colors" href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
				<span class="mx-3 text-slate-300">/</span>
			<?php endif; ?>
			<span class="text-slate-900 line-clamp-1"><?php the_title(); ?></span>
		</nav>

		<!-- Main Layout Grid -->
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 relative">
			
			<!-- Left: Product Gallery (Takes 7 cols on LG) -->
			<div class="lg:col-span-7 space-y-4">
				<?php
				$attachment_ids = $product->get_gallery_image_ids();
				$main_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				?>
				
				<!-- Main Image Container with ultra-premium rounded corners & shadow -->
				<div class="aspect-square lg:aspect-[4/5] xl:aspect-[1/1] bg-slate-50 rounded-[2rem] overflow-hidden relative group shadow-2xl shadow-slate-200/50">
					<?php if ( $main_image ) : ?>
						<img alt="<?php the_title(); ?>" class="w-full h-full object-cover main-product-image transition-transform duration-700 group-hover:scale-105" src="<?php echo esc_url( $main_image[0] ); ?>"/>
					<?php else : ?>
						<img alt="<?php the_title(); ?>" class="w-full h-full object-cover" src="<?php echo esc_url( wc_placeholder_img_src() ); ?>"/>
					<?php endif; ?>
					
					<!-- Zoom Badge -->
					<div class="absolute bottom-6 right-6 bg-white/90 backdrop-blur text-slate-900 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
						Zoom Image
					</div>
				</div>

				<!-- Thumbnails (Slider on Mobile, Grid on Desktop) -->
				<?php if ( $attachment_ids ) : ?>
				<div class="flex lg:grid lg:grid-cols-6 gap-4 overflow-x-auto lg:overflow-visible pb-4 lg:pb-0 scrollbar-hide snap-x px-1 lg:px-0">
					<?php
					// Main image as first thumbnail
					if ( $main_image ) :
					?>
						<div class="aspect-square bg-slate-50 rounded-xl overflow-hidden cursor-pointer ring-2 ring-transparent hover:ring-slate-900 transition-all duration-300 thumbnail-item active shrink-0 w-20 lg:w-auto snap-start shadow-sm" data-image="<?php echo esc_url( $main_image[0] ); ?>">
							<img alt="Thumbnail" class="w-full h-full object-cover" src="<?php echo esc_url( $main_image[0] ); ?>"/>
						</div>
					<?php endif; ?>

					<?php foreach ( $attachment_ids as $attachment_id ) : 
						$image_url = wp_get_attachment_image_src( $attachment_id, 'full' );
					?>
						<div class="aspect-square bg-slate-50 rounded-xl overflow-hidden cursor-pointer ring-2 ring-transparent hover:ring-slate-900 transition-all duration-300 thumbnail-item shrink-0 w-20 lg:w-auto snap-start opacity-70 hover:opacity-100 shadow-sm" data-image="<?php echo esc_url( $image_url[0] ); ?>">
							<img alt="Thumbnail" class="w-full h-full object-cover" src="<?php echo esc_url( $image_url[0] ); ?>"/>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>

			<!-- Right: Product Details (Sticky, Takes 5 cols) -->
			<div class="lg:col-span-5 relative">
				<div class="lg:sticky lg:top-20 space-y-4">
					
					<!-- Header Info -->
					<div class="space-y-2">
						<div class="flex items-center justify-between">
							<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
								<span class="text-xs font-bold text-primary uppercase tracking-widest bg-purple-50 px-3 py-1 rounded-full">
									SKU: <?php echo ( $sku = $product->get_sku() ) ? $sku : 'N/A'; ?>
								</span>
							<?php endif; ?>
							
							<!-- Review Stars -->
							<?php if ( wc_review_ratings_enabled() ) : 
								$rating_count = $product->get_rating_count();
								$review_count = $product->get_review_count();
								$average = $product->get_average_rating();
							?>
							<div class="flex items-center space-x-1">
								<span class="text-yellow-400 material-icons-outlined text-sm">star</span>
								<span class="text-sm font-bold text-slate-900"><?php echo esc_html( $average ); ?></span>
								<span class="text-xs text-slate-400 border-b border-slate-300 ml-1"><?php echo esc_html( $review_count ); ?> Reviews</span>
							</div>
							<?php endif; ?>
						</div>

						<h1 class="text-3xl lg:text-5xl font-black leading-[1.1] tracking-tight text-slate-900 mb-2">
							<?php the_title(); ?>
						</h1>
						
						<div class="flex items-baseline space-x-4 mb-2">
							<div class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">
								<?php echo $product->get_price_html(); ?>
							</div>
							<?php if ( $product->is_on_sale() ) : ?>
								<span class="text-xs font-bold text-white bg-red-500 px-3 py-1 rounded-full uppercase tracking-wider shadow-red-200 shadow-lg">Sale</span>
							<?php endif; ?>
						</div>
						
						<div class="text-slate-600 text-sm leading-relaxed border-l-4 border-slate-900 pl-4 bg-slate-50 py-2 pr-2 rounded-r-lg italic">
							<?php echo wp_trim_words( $product->get_short_description(), 30 ); ?>
						</div>
					</div>

					<!-- Actions Form -->
					<?php if ( $product->is_type( 'variable' ) ) : ?>
						<form class="variations_form cart space-y-4" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $product->get_available_variations() ) ) ?>">
							<?php do_action( 'woocommerce_before_variations_form' ); ?>

							<?php if ( empty( $product->get_available_variations() ) && false !== $product->get_available_variations() ) : ?>
								<p class="stock out-of-stock text-red-500"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
							<?php else : ?>
								<div class="variations-wrapper space-y-4">
									<?php foreach ( $product->get_variation_attributes() as $attribute_name => $options ) : 
										$attr_label = wc_attribute_label( $attribute_name );
									?>
										<div class="variation-row" data-attribute="<?php echo esc_attr($attribute_name); ?>">
											<div class="flex justify-between items-center mb-2">
												<label class="text-xs font-black uppercase tracking-[0.15em] text-slate-900">
													Select <?php echo esc_html($attr_label); ?>
												</label>
												<span class="text-xs font-medium text-slate-400 selected-value-label"></span>
											</div>
											
											<!-- Hidden Select -->
											<?php
											wc_dropdown_variation_attribute_options( array(
												'options'   => $options,
												'attribute' => $attribute_name,
												'product'   => $product,
												'class'     => 'hidden', 
											) );
											?>
											<!-- Swatches -->
											<div class="swatch-container flex flex-wrap gap-2"></div>
										</div>
									<?php endforeach; ?>
								</div>
								
								<div class="single_variation_wrap mt-4">
									<?php do_action( 'woocommerce_single_variation' ); ?>
								</div>
							<?php endif; ?>

							<?php do_action( 'woocommerce_after_variations_form' ); ?>
						</form>
					<?php else: ?>
						<!-- Simple Product Form -->
						<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
							<div class="flex flex-col gap-4">
								<!-- Quantity -->
								<div>
									<label class="text-xs font-black uppercase tracking-[0.15em] text-slate-900 mb-2 block">Quantity</label>
									<div class="flex items-center border border-slate-200 rounded-2xl h-[50px] w-[140px] bg-slate-50 overflow-hidden shadow-sm">
										<button type="button" class="w-12 h-full flex items-center justify-center text-slate-500 hover:text-black hover:bg-white transition-colors qty-decrease text-xl font-medium">-</button>
										<input type="number" name="quantity" value="1" min="1" class="w-full h-full text-center border-0 bg-transparent p-0 text-lg font-bold text-slate-900 qty-input footer-cart-qty focus:ring-0" />
										<button type="button" class="w-12 h-full flex items-center justify-center text-slate-500 hover:text-black hover:bg-white transition-colors qty-increase text-xl font-medium">+</button>
									</div>
								</div>
								
								<!-- Buttons (Premium Actions Integration) -->
								<div class="grid grid-cols-2 gap-3 w-full pt-2">
									<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button premium-action-btn">
										<span class="button-icon">🛒</span>
										<span class="button-text">Add to Cart</span>
									</button>
									<button type="button" name="buy_now" value="<?php echo esc_attr( $product->get_id() ); ?>" class="buy-now-button premium-action-btn">
										<span class="button-icon">⚡</span>
										<span class="button-text">Buy Now</span>
									</button>
								</div>
							</div>
						</form>
					<?php endif; ?>

					<!-- Trust Signals -->
					<div class="grid grid-cols-2 gap-4 pt-6">
						<div class="flex items-start space-x-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
							<div class="bg-white p-2 rounded-full shadow-sm text-primary">
								<span class="material-icons-outlined">local_shipping</span>
							</div>
							<div>
								<h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Free Shipping</h4>
								<p class="text-[11px] text-slate-500 leading-tight mt-1">On orders over $150. Global tracking included.</p>
							</div>
						</div>
						<div class="flex items-start space-x-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
							<div class="bg-white p-2 rounded-full shadow-sm text-primary">
								<span class="material-icons-outlined">verified_user</span>
							</div>
							<div>
								<h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Secure Checkout</h4>
								<p class="text-[11px] text-slate-500 leading-tight mt-1">100% encrypted payment processing.</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Product Tabs -->
		<section class="mt-12 lg:mt-20 border-t border-slate-200 pt-12 lg:pt-16">
			<div class="max-w-4xl mx-auto">
				<?php woocommerce_output_product_data_tabs(); ?>
			</div>
		</section>

		<!-- Related Products -->
		<section class="mt-12 lg:mt-16">
			<h3 class="text-2xl lg:text-3xl font-black text-center mb-8 lg:mb-12 uppercase">You May Also Like</h3>
			<?php woocommerce_output_related_products(); ?>
		</section>

	</main>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
