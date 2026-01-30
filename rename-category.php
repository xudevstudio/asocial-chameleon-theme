<?php
/**
 * Rename "Hats" category to "For your head"
 * Upload this file to: wp-content/themes/asocial-chameleon/
 * Then visit: http://asocialchameleon.local/wp-content/themes/asocial-chameleon/rename-category.php
 */

// Load WordPress
require_once('../../../wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

// Find the "Hats" category
$hats_category = get_term_by('name', 'Hats', 'product_cat');

if ($hats_category) {
    // Rename to "For your head"
    $result = wp_update_term(
        $hats_category->term_id,
        'product_cat',
        array(
            'name' => 'For your head',
            'slug' => 'for-your-head'
        )
    );
    
    if (is_wp_error($result)) {
        echo '<h1>Error!</h1>';
        echo '<p>' . $result->get_error_message() . '</p>';
    } else {
        echo '<h1>Success!</h1>';
        echo '<p>Category "Hats" has been renamed to "For your head"</p>';
        echo '<p>Old slug: ' . $hats_category->slug . '</p>';
        echo '<p>New slug: for-your-head</p>';
        echo '<p><a href="' . admin_url('edit-tags.php?taxonomy=product_cat&post_type=product') . '">View Categories</a></p>';
    }
} else {
    echo '<h1>Category Not Found</h1>';
    echo '<p>The "Hats" category does not exist. It may have already been renamed.</p>';
    
    // Check if "For your head" already exists
    $new_category = get_term_by('name', 'For your head', 'product_cat');
    if ($new_category) {
        echo '<p>✅ "For your head" category already exists!</p>';
        echo '<p><a href="' . admin_url('edit-tags.php?taxonomy=product_cat&post_type=product') . '">View Categories</a></p>';
    }
}

// Delete this file after running
echo '<hr>';
echo '<p><strong>Important:</strong> Delete this file after running: wp-content/themes/asocial-chameleon/rename-category.php</p>';
?>
