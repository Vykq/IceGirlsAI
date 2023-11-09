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
                <?php if(get_field('button_text') && get_field('button_url')): ?>
                    <div class="button-area">
                        <a class="main-button" href="<?php the_field('button_url'); ?>"><?php the_field('button_text'); ?></a>
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