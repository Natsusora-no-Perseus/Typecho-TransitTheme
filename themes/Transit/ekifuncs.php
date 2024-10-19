<?php
/* Helper functions for Transit theme
 * @Author natsumeai
 * @Version 0.1
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function getHeadingsOrExcerpt($content, $excerptLength = 32) {
    // Returns headings or an excerpt of a post
    // Create a new DOMDocument instance
    if (empty($content)){
        return '';
    }
    $content = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . $content;
    $dom = new DOMDocument('1.0', 'UTF-8');

    // Suppress warnings due to invalid HTML structure
    libxml_use_internal_errors(true);

    // Load the content into the DOMDocument
    $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    // Restore error handling
    libxml_clear_errors();

    // Get all heading tags (h1, h2, h3, h4, h5, h6)
    $headings = '';
    for ($i = 1; $i <= 6; $i++) {
        foreach ($dom->getElementsByTagName("h$i") as $heading) {
            // Append the outerHTML of the heading to the result
            $headings .= '| ' . $heading->textContent . ' ';
        }
    }

    // If no headings are found, return an excerpt of the content
    if (empty(trim($headings))) {
        // Strip HTML tags from the content
        $plainText = strip_tags($content);
        
        // Return the first $excerptLength characters of the plain text
        return mb_substr($plainText, 0, $excerptLength, 'UTF-8') . '...';
    }

    $headings .= '|';
    // Return the headings if they exist
    return trim($headings);
}

function drawColoredCategory ($categories) {
    foreach ($categories as $category) {
        // Get the category ID (mid)
        $categoryId = $category['mid'];

        // Query the database to get the color assigned to this category
        $db = Typecho_Db::get();
        $color = $db->fetchObject($db->select('category_color')
            ->from('table.metas')
            ->where('mid = ?', $categoryId))->category_color;

        // Use the assigned color if it exists, otherwise fallback to #123456
        $color = $color ? $color : '#999';
        $link = $category['permalink'];

        // Output the category name with the assigned or default color
        echo '<li style="background-color:' . $color . '"><a href="' . $link . '">'. htmlspecialchars($category['name']) . ' ↗</a></li>' . "\xA";
    }
}
// print_r($category);
?>
