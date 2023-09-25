<?php
/*
 * Template name: Premium Page
 */

get_header();
?>

<div class="premium-page-template">
    <div class="container">
        <div class="grid">
            <div class="left">
                <div class="inner-col-wrapper">
                    <p class="col-title"><?php the_field('free_title'); ?></p>
                    <div class="whole-price">
                    <p class="price"> <span class="dollar">$</span><?php the_field('free_price'); ?></p>
                    <p class="subprice">per month</p>
                    </div>
                    <div class="button-area">
                        <a class="main-button" href="<?php the_field('free_button_url'); ?>"><?php the_field('free_button_text'); ?></a>
                    </div>


                    <?php if(have_rows('free_freatures')) : ?>
                            <ul class="benefits">
                                <?php while(have_rows('free_freatures')) : the_row(); ?>
                                    <li>
                                        <span><?php the_sub_field('feature'); ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                    <?php endif; ?>
                </div>

            </div>
            <div class="right">
                <div class="inner-col-wrapper premium">
                    <p class="col-title"><?php the_field('premium_title'); ?></p>
                    <div class="whole-price">
                        <p class="price"> <span class="dollar">$</span><?php the_field('premium_price'); ?></p>
                        <p class="subprice">per month</p>
                    </div>
                    <div class="button-area">
                    <a class="main-button" target="_blank" href="<?php the_field('premium_button_url'); ?>"><?php the_field('premium_button_text'); ?></a>
                    </div>
                    <?php if(have_rows('premium_freatures')) : ?>
                        <ul class="benefits">
                            <?php while(have_rows('premium_freatures')) : the_row(); ?>
                                <li>
                                    <span><?php the_sub_field('freature'); ?></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="note-area">
                        <p class="note"><?php the_field('premium_note'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();