<?php
/*
 * Template name: Hub page template
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
<div class="hub-page-template">
    <div class="container">
        <?php if($images->have_posts()) : ?>
                <div class="generated-images-wrapper">
                    <?php while($images->have_posts()): $images->the_post(); ?>
                        <?php
    //                    $imageData = getImageFromAPI($image); // Get image data which includes status
    //                    if($imageData){
    //                        $status = $imageData['status'];
    //                        //$imageUrl = $imageData['image'];
    //                    }

                           if(get_field('size', get_the_id()) == "512x512"){
                                $imageSize = "square";
                            } else if(get_field('size', get_the_id()) == "960x512"){
                                $imageSize = "horizontal";
                            } else {
                                $imageSize = "normal";
                            } ?>

                        <div class="single-image <?php echo $imageSize; ?>">
                            <a href="<?php echo get_permalink(); ?>">
                                <div class="single-wrapper">
                                    <div class="post-image">
                                        <img class="hub-single-image hide <?php echo $imageSize; ?>" data-id="<?php echo get_the_title(); ?>" src="<?php //echo $imageUrl; ?>" alt="IceGirls.AI generated image">
                                        </div>
                                    <div class="hover-area">
                                        <div class="hover-con">
                                            <div class="wrapper">
                                                <div class="left">
                                                    <img loading="lazy" src="<?php echo get_theme_file_uri() . '/assets/images/like.svg';?>">
                                                </div>
                                                <div class="right">
                                                    <p><?php the_field('like_count', get_the_id()); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="loaderis">
                                <div class="spinner">
                                    <span class="loader"></span>
                                </div>
                            </div>
                        </div>


                <?php endwhile; ?>
                    <?php if(!in_array( 'premium', (array) $user->roles) && $images->post_count > 10) {
                        //wp_reset_query();
                        $args = array(
                            'post_type' => 'generated-images',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'paged' => $paged,
                            'meta_query' => array(
                                array(
                                    'key' => 'premium', // Replace 'premium' with your ACF field name
                                    'value' => true,
                                    'compare' => '='
                                )
                            )
                        );
                        $count = new WP_Query($args);
                    ?>
                    <div class="normal premium-notice">
                        <a href="/premium/">
                            <div class="single-wrapper premium-wrapper">
                                <div class="premium-area">
                                    <p class="offer">To view more images you need <span>Premium</span></p>
                                    <p class="note">You can see only 11/<span><?php echo $count->post_count; ?></span> images</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>


                </div>
        <?php
                if(in_array( 'premium', (array) $user->roles)) {?>
                    <div class="pagination">
                        <?php
                        echo paginate_links( array(
                            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                            'total'        => $images->max_num_pages,
                            'current'      => max( 1, get_query_var( 'paged' ) ),
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'plain',
                            'end_size'     => 2,
                            'mid_size'     => 1,
                            'prev_next'    => false,
                            'prev_text'    => false,
                            'next_text'    => false,
                            'add_args'     => false,
                            'add_fragment' => '',
                        ) );
                        ?>
                    </div>
                    <?php
                    wp_reset_postdata();
                    } ?>
            <?php endif; ?>
    </div>
</div>

<?php
get_footer();