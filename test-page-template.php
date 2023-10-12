<?php
/*
 * Template name: Test page template
 */

get_header();


$user = wp_get_current_user();

$url = $_SERVER['REQUEST_URI'];
$arrVals = explode("/", $url);
if (isset($arrVals[3])) {
    $pageNumber = $arrVals[3]; // This will give you the page number, e.g., "6"
} else {
    $pageNumber = 1;
}

$info = getHistoryFromApi($pageNumber);
$total = 0; // Initialize total to 0
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if(in_array( 'premium', (array) $user->roles)) {
    $args = array(
        'post_type' => 'generated-images',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'premium', // Replace 'premium' with your ACF field name
                'value' => true,
                'compare' => '='
            )
        )
    );
} else {
    $args = array(
        'post_type' => 'generated-images',
        'post_status' => 'publish',
        'posts_per_page' => 11,
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'premium', // Replace 'premium' with your ACF field name
                'value' => true,
                'compare' => '='
            )
        )
    );
}

$images = new WP_Query($args);

$isPremiumClass = "";
if ( in_array( 'premium', (array) $user->roles ) ) {
    $isPremiumClass = "no-watermark-image";
} else {
    $isPremiumClass = "watermarked-image";
}

?>
    <div class="testinis-page-template">
        <div class="container">

        </div>
    </div>

<?php
get_footer();