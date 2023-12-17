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