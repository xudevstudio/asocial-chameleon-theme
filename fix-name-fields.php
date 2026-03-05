<?php
/**
 * TEMPORARY FIX - Upload this file to live site theme root
 * Visit: https://asocialchameleon.com/wp-content/themes/asocial-chameleon/fix-name-fields.php
 * Then DELETE this file after running once
 */

// Check if template file exists
$template_path = __DIR__ . '/woocommerce/myaccount/form-edit-account.php';
$template_exists = file_exists($template_path);

echo "<h1>Name Fields Fix - Diagnostic</h1>";
echo "<h2>Template File Status:</h2>";

if ($template_exists) {
    echo "<p style='color: green;'>✅ Template file EXISTS at: " . $template_path . "</p>";
    echo "<p>File size: " . filesize($template_path) . " bytes</p>";
    echo "<p>Last modified: " . date("Y-m-d H:i:s", filemtime($template_path)) . "</p>";
} else {
    echo "<p style='color: red;'>❌ Template file DOES NOT EXIST at: " . $template_path . "</p>";
    echo "<p><strong>Solution:</strong> Manually upload the file via FTP/cPanel</p>";
}

// Clear WooCommerce caches
if (function_exists('WC')) {
    echo "<h2>Clearing WooCommerce Caches:</h2>";
    
    // Clear transients
    delete_transient('wc_attribute_taxonomies');
    delete_transient('woocommerce_cache_excluded_uris');
    WC_Cache_Helper::get_transient_version('shipping', true);
    
    echo "<p style='color: green;'>✅ WooCommerce transients cleared</p>";
    
    // Clear template cache
    if (function_exists('wc_clear_template_cache')) {
        wc_clear_template_cache();
        echo "<p style='color: green;'>✅ Template cache cleared</p>";
    }
}

echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Hard refresh the page: Ctrl + Shift + R</li>";
echo "<li>Go to: <a href='https://asocialchameleon.com/my-account/edit-account/'>My Account</a></li>";
echo "<li>Try saving First Name and Last Name</li>";
echo "<li><strong>DELETE THIS FILE after testing!</strong></li>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Generated: " . date('Y-m-d H:i:s') . "</em></p>";
?>
