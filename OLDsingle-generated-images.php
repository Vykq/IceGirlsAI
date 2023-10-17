<?php
get_header();
$post_id = get_the_id();
$prompt = get_field('prompt');
$pattern = '/<lora:([^:]+):([^>]+)>/';

preg_match_all($pattern, $prompt, $matches, PREG_SET_ORDER);



$loras = array();
$finalPrompt = preg_replace($pattern, '', $prompt);
$detailsValue = '';
foreach ($matches as $match) {
    $loras[] = array(
        'name' => $match[1],
        'value' => $match[2]
    );
}


foreach ($loras as $lora){
    if($lora['name'] == 'more_details'){
        $detailsValue = $lora['value'];
    }
}

$user = wp_get_current_user();
$isPremiumClass = "";
if ( in_array( 'premium', (array) $user->roles ) ) {
    $isPremiumClass = "no-watermark-image";
} else {
    $isPremiumClass = "watermarked-image";
}

$imageSize = "";
if(get_field('size') == "512x512"){
    $imageSize = "square";
} else if(get_field('size') == "960x512"){
    $imageSize = "horizontal";
} else {
    $imageSize = "normal";
}
?>
<div class="single-generated-image-page">
    <div class="container">
        <div class="left">
            <a class="go-back" href="javascript:history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" width="7.682" height="13.363" viewBox="0 0 7.682 13.363">
                    <path id="Path_406" data-name="Path 406" d="M-16980.41-20298.4l-5.268,5.266,5.268,5.27" transform="translate(16986.678 20299.816)" fill="none" stroke="#FFA702FF" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg> Go Back
            </a>

            <div class="image-info-block">
                <p class="top">
                    Image Details
                </p>
                <div class="list">
                    <p class="info-title prompt"><?php echo $finalPrompt; ?></p>
                    <p class="info-title">Size: <span class="info-ans"><?php echo get_field('size'); ?></span></p>
                    <p class="info-title">Model: <span class="info-ans">                <?php echo getModelName(get_field('Model')); ?></span></p>
                    <p class="info-title">Details: <span class="info-ans"><?php echo get_field('details'); ?></span></p>
                </div>
            </div>
            <div class="button-area">
                <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>
                        <a class="single-button" href="<?php echo get_the_post_thumbnail_url(); ?>" target="_blank">Full size image</a>
                <?php } else { ?>
                    <a class="single-button" href="<?php echo get_field('watermarked_image', get_the_id()); ?>" target="_blank">Full size image</a>
                <?php } ?>
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
            <div class="image-area <?php echo $imageSize; ?>">
                <div class="single-image <?php echo $imageSize; ?>">
                        <div class="single-wrapper">
                            <div class="post-image">
                                <img class="hub-single-image hide <?php echo $imageSize; ?>" data-id="<?php echo get_the_title(); ?>" src="<?php //echo $imageUrl; ?>" alt="IceGirls.AI generated image">
                            </div>
                        </div>
                    <div class="loaderis">
                        <div class="spinner">
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