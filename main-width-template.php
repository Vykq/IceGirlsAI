<?php
/*
 * Template name: Main width template
 */

get_header(); ?>

<div class="main-width-template">
    <div class="container">
        <div class="content">
            <h1 class="title"><?php the_title(); ?></h1>
            <?php if(have_rows('text')) : ?>
                <div class="text-area">
                    <?php while(have_rows('text')) : the_row(); ?>
                        <div class="single-p">
                            <?php if(get_sub_field('title')) { ?>
                                <h3 class="para-text"><?php the_sub_field('title'); ?></h3>
                            <?php } ?>
                            <?php if(get_sub_field('text')) { ?>
                                <div class="paragraph"><?php the_sub_field('text'); ?></div>
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
