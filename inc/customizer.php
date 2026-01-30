<?php
/**
 * Asocial Chameleon Customizer Functionality
 *
 * @package Asocial_Chameleon
 */

function asocial_chameleon_customize_register( $wp_customize ) {
    // Section: Hero Banner Settings
    $wp_customize->add_section( 'asocial_chameleon_hero_section', array(
        'title'    => __( 'Hero Banner Settings', 'asocial-chameleon' ),
        'priority' => 30,
    ) );

    // Setting: Hero Height
    $wp_customize->add_setting( 'hero_banner_height', array(
        'default'           => 600,
        'transport'         => 'postMessage',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'hero_banner_height', array(
        'label'       => __( 'Banner Height (px)', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 300,
            'max'  => 1200,
            'step' => 10,
        ),
    ) );

    // Setting: Vertical Position
    $wp_customize->add_setting( 'hero_banner_bg_pos_y', array(
        'default'           => 60,
        'transport'         => 'postMessage',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'hero_banner_bg_pos_y', array(
        'label'       => __( 'Image Vertical Position (%)', 'asocial-chameleon' ),
        'description' => __( '0% = Top, 50% = Center, 100% = Bottom', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ) );

    // Setting: Banner Width
    $wp_customize->add_setting( 'hero_banner_width', array(
        'default'           => 100, /* Default to 100% as requested */
        'transport'         => 'postMessage',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'hero_banner_width', array(
        'label'       => __( 'Banner Width (%)', 'asocial-chameleon' ),
        'description' => __( 'Adjust the width of the banner container', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 100,
            'step' => 1,
        ),
    ) );

    // Setting: Background Size
    $wp_customize->add_setting( 'hero_banner_bg_size', array(
        'default'           => 'cover',
        'transport'         => 'postMessage', // Changed to postMessage for JS updates if we had them, referencing style block below
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'hero_banner_bg_size', array(
        'label'       => __( 'Background Size Mode', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'select',
        'choices'     => array(
            'cover'   => __( 'Cover (Fill Area)', 'asocial-chameleon' ),
            'contain' => __( 'Contain (Show Full Image)', 'asocial-chameleon' ),
        ),
    ) );

    // --- NEW: Hero Content & Images ---

    // 1. Hero Image Desktop
    $wp_customize->add_setting( 'hero_image_desktop', array(
        'default'   => get_template_directory_uri() . '/assets/images/hero-desktop.png',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image_desktop', array(
        'label'    => __( 'Desktop Hero Image', 'asocial-chameleon' ),
        'section'  => 'asocial_chameleon_hero_section',
        'settings' => 'hero_image_desktop',
    ) ) );

    // 2. Hero Image Mobile
    $wp_customize->add_setting( 'hero_image_mobile', array(
        'default'   => get_template_directory_uri() . '/assets/images/hero-mobile.png',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image_mobile', array(
        'label'    => __( 'Mobile Hero Image', 'asocial-chameleon' ),
        'section'  => 'asocial_chameleon_hero_section',
        'settings' => 'hero_image_mobile',
    ) ) );

    // 3. Hero Title
    $wp_customize->add_setting( 'hero_title_text', array(
        'default'           => 'Stand Out Without Trying',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_title_text', array(
        'label'       => __( 'Hero Title', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'text',
    ) );

    // 4. Hero Subtitle
    $wp_customize->add_setting( 'hero_subtitle_text', array(
        'default'           => 'Find your new conversation starter!',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_subtitle_text', array(
        'label'       => __( 'Hero Subtitle', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'textarea',
    ) );

    // 5. Hero Button Text
    $wp_customize->add_setting( 'hero_btn_text', array(
        'default'           => 'View Collection',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_btn_text', array(
        'label'       => __( 'Button Text', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'text',
    ) );

    // 6. Hero Button URL
    $wp_customize->add_setting( 'hero_btn_url', array(
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'hero_btn_url', array(
        'label'       => __( 'Button URL (Empty = Shop Page)', 'asocial-chameleon' ),
        'section'     => 'asocial_chameleon_hero_section',
        'type'        => 'url',
    ) );
    // --- Header & Logo Settings ---
    $wp_customize->add_section( 'asocial_header_settings', array(
        'title'    => __( 'Header & Logo Settings', 'asocial-chameleon' ),
        'priority' => 20,
    ) );

    // 1. Desktop Logo
    $wp_customize->add_setting( 'custom_logo_desktop', array(
        'default'   => '',
        'transport' => 'refresh', // Refresh to update src
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo_desktop', array(
        'label'    => __( 'Desktop Logo', 'asocial-chameleon' ),
        'section'  => 'asocial_header_settings',
        'settings' => 'custom_logo_desktop',
    ) ) );

    // 2. Desktop Logo Width
    $wp_customize->add_setting( 'logo_width_desktop', array(
        'default'           => 150,
        'transport'         => 'postMessage',
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'logo_width_desktop', array(
        'label'       => __( 'Desktop Logo Width (px)', 'asocial-chameleon' ),
        'section'     => 'asocial_header_settings',
        'type'        => 'range',
        'input_attrs' => array( 'min' => 50, 'max' => 400, 'step' => 5 ),
    ) );

    // 3. Mobile Logo (Optional)
    $wp_customize->add_setting( 'custom_logo_mobile', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo_mobile', array(
        'label'    => __( 'Mobile Logo (Optional)', 'asocial-chameleon' ),
        'description' => __( 'Upload a separate logo for mobile if needed.', 'asocial-chameleon' ),
        'section'  => 'asocial_header_settings',
        'settings' => 'custom_logo_mobile',
    ) ) );

    // 4. Mobile Logo Width
    $wp_customize->add_setting( 'logo_width_mobile', array(
        'default'           => 100,
        'transport'         => 'postMessage',
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'logo_width_mobile', array(
        'label'       => __( 'Mobile Logo Width (px)', 'asocial-chameleon' ),
        'section'     => 'asocial_header_settings',
        'type'        => 'range',
        'input_attrs' => array( 'min' => 20, 'max' => 200, 'step' => 5 ),
    ) );
    
    // 5. Favicon
    $wp_customize->add_setting( 'site_favicon', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_favicon', array(
        'label'    => __( 'Site Favicon', 'asocial-chameleon' ),
        'description' => __( 'Upload a favicon (e.g. 32x32 px png/ico).', 'asocial-chameleon' ),
        'section'  => 'asocial_header_settings',
        'settings' => 'site_favicon',
    ) ) );
}
add_action( 'customize_register', 'asocial_chameleon_customize_register' );

/**
 * Output Customizer CSS
 */
function asocial_chameleon_customizer_css() {
    ?>
    <style type="text/css">
        body .hero-banner {
            height: <?php echo get_theme_mod( 'hero_banner_height', 600 ); ?>px;
            width: <?php echo get_theme_mod( 'hero_banner_width', 100 ); ?>%;
        }
        body .hero-bg-animated {
            background-position: center <?php echo get_theme_mod( 'hero_banner_bg_pos_y', 60 ); ?>%;
            background-size: <?php echo get_theme_mod( 'hero_banner_bg_size', 'cover' ); ?>;
            background-image: url('<?php echo esc_url( get_theme_mod( 'hero_image_desktop', get_template_directory_uri() . '/assets/images/hero-desktop.png' ) ); ?>');
        }

        @media (max-width: 768px) {
            body .hero-bg-animated {
                background-image: url('<?php echo esc_url( get_theme_mod( 'hero_image_mobile', get_template_directory_uri() . '/assets/images/hero-mobile.png' ) ); ?>') !important;
            }
        }

        /* Logo Sizing */
        .logo-image {
            width: <?php echo get_theme_mod( 'logo_width_desktop', 150 ); ?>px;
            max-height: none; /* Override default constraint */
        }
        
        @media (max-width: 768px) {
            .logo-image {
                width: <?php echo get_theme_mod( 'logo_width_mobile', 100 ); ?>px;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'asocial_chameleon_customizer_css' );

/**
 * Enqueue Customizer Live Preview JS
 */
function asocial_chameleon_customize_preview_js() {
    wp_enqueue_script( 'asocial-chameleon-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'asocial_chameleon_customize_preview_js' );
