<?php
get_header();?>
<div class="single-post">
    <div class="container">
        <div class="grid">
            <div class="left">
                <div class="image">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                </div>
            </div>
            <div class="right">
                <h1 class="title"><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();

?>
