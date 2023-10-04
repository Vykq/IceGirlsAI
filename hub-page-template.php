<?php
/*
 * Template name: Hub page template
 */

get_header();


$user = wp_get_current_user();
if(in_array( 'premium', (array) $user->roles)) {
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'post_type' => 'generated-images',
        'posts_per_page' => 12,
        'post_status' => 'publish',
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'watermarked_image', // Replace with your actual custom field name
                'compare' => 'EXISTS', // Check if the custom field exists
            ),
            array(
                'key' => '_thumbnail_id'
            ),
        ),

    );
} else {
    $args = array(
        'post_type' => 'generated-images',
        'posts_per_page' => 11,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'watermarked_image', // Replace with your actual custom field name
                'compare' => 'EXISTS', // Check if the custom field exists
            ),
            array(
                'key' => '_thumbnail_id'
            ),
        ),
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
                <?php while($images->have_posts()) : $images->the_post(); ?>
                        <?php if(get_field('size', get_the_id()) == "512x512"){
                            $imageSize = "square";
                        } else if(get_field('size') == "960x512"){
                            $imageSize = "horizontal";
                        } else {
                            $imageSize = "normal";
                        } ?>

                    <div class="single-image <?php echo $imageSize; ?>">
                        <a href="<?php echo get_permalink(); ?>">
                            <div class="single-wrapper">
                                <div class="post-image">
                                    <?php if ( in_array( 'premium', (array) $user->roles ) ) {
                                                the_post_thumbnail('hub-all', array('loading' => 'lazy', 'class' => 'lazy ' . $isPremiumClass));
                                    } else { ?>
                                        <img class="lazy watermarked-image" loading="lazy" src="<?php echo get_field('watermarked_image', get_the_id()); ?>" alt="<?php echo get_the_title(); ?>">
                                    <?php }?>
                                    </div>
                                <div class="hover-area">
                                    <div class="hover-con">
                                        <div class="wrapper">
                                            <div class="left">
                                                <img src="<?php echo get_theme_file_uri() . '/assets/images/like.svg';?>">
                                            </div>
                                            <div class="right">
                                                <p><?php the_field('like_count', get_the_id()); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php endwhile; ?>
                <?php if(!in_array( 'premium', (array) $user->roles)) {
                    wp_reset_query();
                    $counter = wp_count_posts('generated-images')->publish;
                    ?>
                    <div class="single-image normal premium-notice">
                        <a href="/premium/">
                            <div class="single-wrapper premium-wrapper">
                                <div class="premium-area">
                                    <p class="offer">To view more images you need <span>Premium</span></p>
                                    <p class="note">You can see only 11/<span><?php echo $counter; ?></span> images</p>
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