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
                <img src="<?php echo get_field('homepage_hero_image'); ?>" alt="<?php echo get_field('title'); ?>">
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
//    $args = array(
//            'post_type' => 'generated-images',
//            'posts_per_page' => 20,
//            'order' => 'DATE',
//            'orderby' => 'ASC',
//    );
//    $images = new WP_Query($args);
//    if ($images->have_posts()): ?>
<!--        <div class="hub-area demo-7">-->
<!--            <div class="container">-->
<!--                <div class="images-grid">-->
<!--                    <div class="columns">-->
<!--                        --><?php
//                        $count = 0; // Initialize a counter
//                        while ($images->have_posts() && $count < 5) : // Limit to 4 columns
//                            $count++;
//                            ?>
<!--                            <div class="column">-->
<!--                                --><?php //for ($i = 0; $i < 4 && $images->have_posts(); $i++): ?>
<!--                                    --><?php //$images->the_post(); ?>
<!--                                    <figure class="column__item">-->
<!--                                        <div class="column__item-imgwrap">-->
<!--                                            <a href="--><?php //the_permalink(); ?><!--">-->
<!--                                            <div class="column__item-img" style="background-image:url(--><?php //echo get_the_post_thumbnail_url(); ?>/*)"></div>*/
/*                                            </a>*/
/*                                        </div>*/
/*                                    </figure>*/
/*                                */<?php //endfor; ?>
<!--                            </div>-->
<!--                        --><?php //endwhile; ?>
<!--                    </div>-->
<!--            </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    --><?php //endif; ?>


</div>

<?php
get_footer();