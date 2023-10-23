<?php
get_header(); ?>

    <div class="new-single-generated-image-page single-image-id">
        <div class="container">
            <div class="left">
                <a class="go-back" href="javascript:history.back()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="7.682" height="13.363" viewBox="0 0 7.682 13.363">
                        <path id="Path_406" data-name="Path 406" d="M-16980.41-20298.4l-5.268,5.266,5.268,5.27" transform="translate(16986.678 20299.816)" fill="none" stroke="#FFA702FF" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg> Go Back
                </a>

                <div class="image-info-block" id="taskid" data-id="<?php echo get_field('task_id'); ?>">
                    <p class="top">
                        Image Details
                    </p>
                    <div class="list" id="infolist">
                        <div class="loaderis">
                            <div class="spinner show">
                                <span class="loader"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-area">
                    <!--                    <a class="single-button" href="--><?php //echo get_the_post_thumbnail_url(); ?><!--" target="_blank">Full size image</a> KAZKA SU SITUO PADARYT-->

                    <button class="upscale-single-image single-button" data-id="<?php echo get_field('task_id'); ?>">Upscale & download</button>

                    <?php if(in_array(get_the_id(), favorite_id_array())){ ?>
                        <div class="single-button fv_<?php echo get_the_id(); ?> remove-from-favorites" data-id="<?php echo get_the_id(); ?>" title="Unlike" ><img src="<?php echo get_theme_file_uri() . '/assets/images/liked.svg';?>" > <?php the_field('like_count'); ?></div>
                    <?php } else { ?>
                        <div class="single-button fv_<?php echo get_the_id(); ?> add-to-favorites" data-id="<?php echo get_the_id(); ?>">
                            <div class="like" title="Like Image">
                                <img src="<?php echo get_theme_file_uri() . '/assets/images/like.svg';?>"> <?php the_field('like_count'); ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <div class="right">
                <div class="image-area"> <!-- prideti class per JS pagal ft dydi -->
                    <div class="single-image" id="singleImage">
                        <!-- JS content -->
                        <div class="loaderis">
                            <div class="spinner show">
                                <span class="loader"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
get_footer();