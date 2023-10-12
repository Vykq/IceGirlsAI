<?php
/*
 * Template name: Main Page Template
 */

get_header();?>
<?php
$user_id = get_current_user_id();
$user_info = get_user_meta($user_id);
?>
<div class="homepage-template">
    <section class="homepage-hero">
        <div class="hero-wrapper">
            <div class="image">
                <img src="<?php echo get_field('homepage_hero_image'); ?>" class="desktop" alt="<?php echo get_field('title'); ?>">
                <img src="<?php echo get_field('homepage_hero_image_mobile'); ?>" class="mobile" alt="<?php echo get_field('title'); ?>">
            </div>
            <div class="content-area">
                <div class="content-wrapper">
                    <h1 class="title"><?php echo get_field('title'); ?></h1>
                    <p class="subtitle"><?php echo get_field('subtitle'); ?></p>
                    <div class="button-wrapper">
                        <a href="<?php echo get_field('button_url'); ?>"><?php echo get_field('button_text'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(have_rows('column')) : ?>
        <div class="grid-info-block">
            <div class="container">
                <div class="grid-area">
                <?php while(have_rows('column')) : the_row(); ?>
                    <div class="single-column">
                        <div class="column-wrapper">
                            <div class="image-area">
                                <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>">
                            </div>
                            <p class="title"><?php the_sub_field('title'); ?></p>
                            <div class="content">
                                <?php the_sub_field('content'); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if(get_field('hub_title')): ?>
    <div class="about-hub-block">
        <div class="container">
            <div class="wrapper">
                <div class="title">
                    <?php the_field('hub_title'); ?>
                </div>
                <div class="button-wrapper">
                    <a href="/hub/"><?php echo get_field('hub_button_text'); ?></a>
                </div>
                <p class="note"><?php the_field('hub_note'); ?></p>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <?php
    $args = array(
            'post_type' => 'faq',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'DATE',
            'order' => 'ASC'
    );

    $faqs = new WP_Query($args);

    if($faqs->have_posts()) : ?>
    <div class="faqs-block">
        <div class="container">
            <div class="faqs-area">
            <?php while($faqs->have_posts()) : ?>
                <?php $faqs->the_post(); ?>
                <div class="single-faq">
                    <div class="faq-title-block">
                        <p class="faq-title"><?php echo get_the_title(); ?></p>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#FFA702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 9L12 15L18 9" stroke="#FFA702" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                    <div class="faq-answer-block">
                        <div class="faq-answer">
                            <?php the_field('answer'); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <?php
    $top = array(
                'post_type' => 'generated-images',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'meta_key' => 'like_count', // Specify the custom field name
                'orderby' => 'meta_value_num', // Order by the numerical value of the custom field
                'order' => 'DESC', // Ascending order
    );
    $topPosts = new WP_Query($top);

    $user = wp_get_current_user();
    $isPremiumClass = "";
    if ( in_array( 'premium', (array) $user->roles ) ) {
        $isPremiumClass = "no-watermark-image";
    } else {
        $isPremiumClass = "watermarked-image";
    }
    ?>
<div class="top-hub-area">
    <div class="container">
        <h6>Top Liked Posts</h6>
        <?php if($topPosts->have_posts()) : ?>
            <div class="generated-images-wrapper">
                <?php while($topPosts->have_posts()) : $topPosts->the_post(); ?>
                    <?php
                    if(get_field('size', get_the_id()) == "512x512"){
                        $imageSize = "square";
                    } else if(get_field('size') == "960x512"){
                        $imageSize = "horizontal";
                    } else {
                        $imageSize = "normal";
                    }
                    ?>
                    <div class="single-image <?php echo $imageSize; ?>">
                        <a href="<?php echo get_permalink(); ?>">
                            <div class="single-wrapper">
                                <div class="post-image">
                                    <?php if ( in_array( 'premium', (array) $user->roles ) ) {
                                         the_post_thumbnail('hub-all', array( 'loading' => 'lazy', 'class' => 'lazy ' . $isPremiumClass ));
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
            </div>
            </div>
</div>

    <?php endif; ?>
</div>



<?php
get_footer();