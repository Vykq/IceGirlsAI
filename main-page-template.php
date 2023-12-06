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
                        <a class="button-black" href="<?php echo get_field('button_url_2'); ?>"><?php echo get_field('button_text_2'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="featured-block">
        <div class="container">
            <div class="wrapper">
                <div class="left">
                    <p class="title"><?php the_field('featured_title'); ?></p>
                </div>
                <div class="right">
                    <?php if(have_rows('logotypes')) : ?>
                        <section class="splide logo-slider" aria-label="IceGirls.Ai featured on">
                            <div class="splide__arrows">
                                <button class="splide__arrow splide__arrow--prev">
                                    <svg fill="#FF950D" height="200px" width="200px" version="1.1" id="XMLID_287_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="next"> <g> <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 "></polygon> </g> </g> </g></svg>
                                </button>
                                <button class="splide__arrow splide__arrow--next">
                                    <svg fill="#FF950D" height="200px" width="200px" version="1.1" id="XMLID_287_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="next"> <g> <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 "></polygon> </g> </g> </g></svg>
                                </button>
                            </div>
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <?php while(have_rows('logotypes')) : the_row(); ?>
                                            <li class="splide__slide">
                                                <a target="_blank" href="<?php echo get_sub_field('url'); ?>" class="slide">
                                                    <div class="image-wrapper">
                                                        <?php echo wp_get_attachment_image(get_sub_field('logo'),'full'); ?>
                                                    </div>
                                                </a>
                                            </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

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
                            <h2 class="title"><?php the_sub_field('title'); ?></h2>
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
                <div class="left">
                    <div class="title">
                        <?php the_field('hub_title'); ?>
                    </div>
                    <div class="button-wrapper">
                        <a href="/hub/"><?php echo get_field('hub_button_text'); ?></a>
                    </div>
                    <p class="note"><?php the_field('hub_note'); ?></p>
                </div>
                <div class="right">
                    <div class="inner-wrapper">
                        <div class="col">
                            <div class="icon">
                                <svg viewBox="0 -28.5 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#FFFFFF" fill-rule="nonzero"> </path> </g> </g></svg>
                            </div>
                        </div>
                        <div class="col">
                            <div class="title">
                                <?php the_field('discord_title'); ?>
                            </div>
                            <div class="button-wrapper">
                                <a href="<?php echo get_field('discord','api'); ?>"><?php echo get_field('discord_button_text'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <div class="premium-text-image">
        <div class="container">
            <div class="wrapper">
                <div class="left">
                    <?php if (get_field('text_title')) : ?>
                        <h2 class="title"><?php echo get_field('text_title'); ?></h2>
                    <?php endif; ?>
                    <?php if (get_field('text_content')) : ?>
                        <div class="content">
                            <?php echo get_field('text_content'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(get_field('text_button_text') && get_field('text_button_url')): ?>
                        <div class="button-area">
                            <a class="main-button" href="<?php the_field('text_button_url'); ?>"><?php the_field('text_button_text'); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="right <?php echo (get_field('image_on_right')) ? 'first' : ''; ?>">
                    <div class="image-area">
                        <img src="<?php echo get_field('text_image'); ?>" alt="<?php echo get_field('text_title'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-page-template">
        <div class="container">
            <div class="grid">
                <div class="left">
                    <div class="inner-col-wrapper">
                        <p class="col-title"><?php the_field('free_title','701'); ?></p>
                        <div class="whole-price">
                            <p class="price"> <span class="dollar">$</span><?php the_field('free_price','701'); ?></p>
                            <p class="subprice">per month</p>
                        </div>
                        <div class="button-area">
                            <a class="main-button" href="<?php the_field('free_button_url','701'); ?>"><?php the_field('free_button_text','701'); ?></a>
                        </div>


                        <?php if(have_rows('free_freatures','701')) : ?>
                            <ul class="benefits">
                                <?php while(have_rows('free_freatures','701')) : the_row(); ?>
                                    <li>
                                        <span><?php the_sub_field('feature','701'); ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="right">
                    <div class="inner-col-wrapper premium">
                        <p class="col-title"><?php the_field('premium_title','701'); ?></p>
                        <?php if(get_field('premium_subtitle','701')) { ?>
                            <p class="subtitle"><?php the_field('premium_subtitle','701'); ?></p>
                        <?php } ?>
                        <div class="whole-price">
                            <div class="row">
                                <?php if(get_field('premium_price','701') < get_field('premium_old_price','701')) { ?>
                                    <p class="price"> <span class="dollar">$</span><?php the_field('premium_price','701'); ?></p>
                                    <p class="old-price"> <span class="dollar">$</span><?php the_field('premium_old_price'); ?></p>
                                <?php } else { ?>
                                    <p class="price"> <span class="dollar">$</span><?php the_field('premium_price','701'); ?></p>
                                <?php } ?>

                            </div>

                            <p class="subprice">per month</p>
                        </div>
                        <div class="button-area">
                            <a class="main-button" target="_blank" href="<?php the_field('premium_button_url','701'); ?>"><?php the_field('premium_button_text','701'); ?></a>
                            <?php
                            $currentPatrons = getPremiumUserCount();
                            if($currentPatrons < 20){
                                $currentPatrons = $currentPatrons + 70;
                            } else if ($currentPatrons < 30) {
                                $currentPatrons = $currentPatrons + 60;
                            } else if ($currentPatrons < 40) {
                                $currentPatrons = $currentPatrons + 50;
                            } else if ($currentPatrons < 50) {
                                $currentPatrons = $currentPatrons + 40;
                            } else if ($currentPatrons < 60) {
                                $currentPatrons = $currentPatrons + 30;
                            } else if ($currentPatrons < 70) {
                                $currentPatrons = $currentPatrons + 20;
                            } else if ($currentPatrons < 80) {
                                $currentPatrons = $currentPatrons + 10;
                            } else if ($currentPatrons > 80 && $currentPatrons < 100) {

                            }
                            ?>
                            <p class="spots-left"><?php echo $currentPatrons; ?> users took the deal.</p>
                        </div>
                        <?php if(have_rows('premium_freatures','701')) : ?>
                            <ul class="benefits">
                                <?php while(have_rows('premium_freatures','701')) : the_row(); ?>
                                    <li>
                                        <span><?php the_sub_field('freature','701'); ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="note-area">
                            <p class="note"><?php the_field('premium_note','701'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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

</div>


<?php
get_footer();