<?php
get_header();

$args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'DATE',
    'order' => 'ASC'
);
$posts = new WP_Query($args);
?>
    <div class="post-archive-page">
        <div class="container">
            <?php if($posts->have_posts()) : ?>
                <div class="posts-area">
                    <?php while($posts->have_posts()) : ?>
                        <?php $posts->the_post(); ?>
                        <article class="single-post">
                            <a href="<?php echo get_the_permalink(); ?>">
                                <div class="image-area">
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                </div>
                                <div class="post-info">
                                    <p class="date"><?php echo get_the_date('Y-m-j'); ?></p>
                                    <p class="title"><?php echo get_the_title(); ?></p>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer();

