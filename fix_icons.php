<?php
$file = 'c:/Users/mohda/Local Sites/asocialchameleoncomu/app/public/wp-content/themes/asocial-chameleon/index.php';
$content = file_get_contents($file);

// Regex replacements to target the broken icon lines specifically
// We use dot matches all not needed for single line, but structural match is good.

// Free Shipping
$content = preg_replace(
    '/<div class="trust-icon">.*?<\/div>(\s*<div class="trust-text">\s*<h3><\?php esc_html_e\( \'Free Shipping\')/s',
    '<div class="trust-icon">&#x1F4E6;</div>$1',
    $content
);

// Eco-Friendly
$content = preg_replace(
    '/<div class="trust-icon">.*?<\/div>(\s*<div class="trust-text">\s*<h3><\?php esc_html_e\( \'Eco-Friendly\')/s',
    '<div class="trust-icon">&#x267B;&#xFE0F;</div>$1',
    $content
);

// Secure Payment
$content = preg_replace(
    '/<div class="trust-icon">.*?<\/div>(\s*<div class="trust-text">\s*<h3><\?php esc_html_e\( \'Secure Payment\')/s',
    '<div class="trust-icon">&#x1F512;</div>$1',
    $content
);

// Easy Returns
$content = preg_replace(
    '/<div class="trust-icon">.*?<\/div>(\s*<div class="trust-text">\s*<h3><\?php esc_html_e\( \'Easy Returns\')/s',
    '<div class="trust-icon">&#x21A9;&#xFE0F;</div>$1',
    $content
);

// Quote Icons in Testimonials (if any broken there too, e.g. "â€œ")
// Note: We used "💬" and "❝" in recent edits, but let's be safe for the first one if it wasn't replaced
$content = preg_replace(
    '/<div class="quote-icon">.*?<\/div>/s',
    '<div class="quote-icon">&#x1F4AC;</div>',
    $content
);

if (file_put_contents($file, $content)) {
    echo "Index.php icons updated successfully.";
} else {
    echo "Error writing file.";
}
?>
