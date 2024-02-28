<?php

if(is_page(1113730)){
    if(get_page_by_title('Hentai', OBJECT, 'checkpoints')) {
        $hentai_post = get_page_by_title('Hentai', OBJECT, 'checkpoints');
        $hentai_post_obj = get_post($hentai_post);
    }
    if(get_page_by_title('Hentai', OBJECT, 'checkpoints')) {
        $hentai_post_id = $hentai_post->ID;
        $args = array(
            'post_type' => 'checkpoints',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'DATE',
            'order' => 'ASC',
            'post__not_in' => ($hentai_post_id) ? array($hentai_post_id) : '',
        );
    }
} else {
    $args = array(
        'post_type' => 'checkpoints',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'DATE',
        'order' => 'ASC',
    );
}


$user = wp_get_current_user();
$models = new WP_Query($args); ?>
<div class="backdrop models-modal-wrapper modals choose-model">
    <div class="main-modal unique">
        <div class="modal-wrapper">
            <div class="top">
                <p class="title" id="current-model">Hentai</p>
                <div class="close-modal">
                    <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
            </div>
            <div class="content">
                <?php if($models->have_posts()) :

                    // Prepend $hentai_post_obj to the beginning of the posts array
                        if(is_page(1113730)) {
                            if (get_page_by_title('Hentai', OBJECT, 'checkpoints')) {
                                $posts = $models->posts;
                                array_unshift($posts, $hentai_post_obj);
                                $models->posts = $posts;
                            }
                        }
                    $firstLoop = true;
                    ?>
                    <div class="checkpoints">
                        <?php while($models->have_posts()) : $models->the_post();
                            $suitableActions = get_field('actions');
                            $suitableChars = get_field('suitable_chars');
                            $actionsString = '';
                            $charsString = '';
                            if(is_array($suitableActions)){
                                foreach ($suitableActions as $suitableAction){
                                    $actionsString .= createSlug(get_the_title($suitableAction)) . ' ';
                                }
                            }
                            if(is_array($suitableChars)){
                                foreach ($suitableChars as $suitableChar){
                                    $charsString .= createSlug(get_the_title($suitableChar)) . ' ';
                                }
                            }
                            ?>
                            <div class="single-checkpoint">
                                <div class="wrapper">
                                    <?php if(get_field('logged',get_the_id())) : ?>
                                        <?php if(is_user_logged_in()) : ?>
                                            <div class="model-input">
                                                <input type="radio" name="checkpoint" id="<?php echo createSlug(get_the_title()); ?>" data-id="<?php echo get_field('sampler'); ?>" data-neg="<?php echo get_field('negative_prompt'); ?>" data-cfg="<?php echo get_field('cfg'); ?>" value="<?php echo get_field('real_checkpoint_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> <?php echo checkIfChecked(get_the_title()); ?> data-actions="<?php echo $actionsString; ?>" data-chars="<?php echo $charsString; ?>"/>
                                                <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo get_the_title(); ?></label>
                                                <div class="model-image">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="model-input premium">
                                                <input disabled type="radio" name="checkpoint" id="premium-only<?php echo get_the_id(); ?>" data-id="premium-only" data-neg="premium-only" data-cfg="premium-only" value=""/>
                                                <label for="premium-only<?php echo get_the_id(); ?>"><?php echo get_the_title(); ?></label>
                                                <div class="model-image">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                </div>
                                                <div class="premium-notify">
                                                    <div class="image">
                                                        <svg fill="#FFA702FF" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>unlock</title> <path d="M4 30.016v-14.016q0-0.832 0.576-1.408t1.44-0.576v-4q0-2.72 1.344-5.024t3.616-3.648 5.024-1.344q3.616 0 6.368 2.272t3.424 5.728h-4.16q-0.608-1.76-2.144-2.88t-3.488-1.12q-2.496 0-4.256 1.76t-1.728 4.256v4h16q0.8 0 1.408 0.576t0.576 1.408v14.016q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 28h16v-9.984h-16v9.984z"></path> </g></svg>
                                                    </div>
                                                    <p class="gold">Log in</p>
                                                    <p class="notify">Is required to use this option</p>
                                                </div>
                                            </div>
                                        <?php endif;?>
                                    <?php else : ?>
                                        <?php if(get_field('premium')) : ?>
                                            <?php if(in_array( 'premium', (array) $user->roles )) : ?>
                                                <div class="model-input">
                                                    <input type="radio" name="checkpoint" id="<?php echo createSlug(get_the_title()); ?>" data-id="<?php echo get_field('sampler'); ?>" data-neg="<?php echo get_field('negative_prompt'); ?>" data-cfg="<?php echo get_field('cfg'); ?>" value="<?php echo get_field('real_checkpoint_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> <?php echo checkIfChecked(get_the_title()); ?> data-actions="<?php echo $actionsString; ?>" data-chars="<?php echo $charsString; ?>"/>
                                                    <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo get_the_title(); ?></label>
                                                    <div class="model-image">
                                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="model-input premium">
                                                    <input disabled type="radio" name="checkpoint" id="premium-only<?php echo get_the_id(); ?>" data-id="premium-only" data-neg="premium-only" data-cfg="premium-only" value=""/>
                                                    <label for="premium-only<?php echo get_the_id(); ?>"><?php echo get_the_title(); ?></label>
                                                    <div class="model-image">
                                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                    </div>
                                                    <div class="premium-notify">
                                                        <div class="image">
                                                            <svg fill="#FFA702FF" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>unlock</title> <path d="M4 30.016v-14.016q0-0.832 0.576-1.408t1.44-0.576v-4q0-2.72 1.344-5.024t3.616-3.648 5.024-1.344q3.616 0 6.368 2.272t3.424 5.728h-4.16q-0.608-1.76-2.144-2.88t-3.488-1.12q-2.496 0-4.256 1.76t-1.728 4.256v4h16q0.8 0 1.408 0.576t0.576 1.408v14.016q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 28h16v-9.984h-16v9.984z"></path> </g></svg>
                                                        </div>
                                                        <p class="gold">Premium</p>
                                                        <p class="notify">Is required to use this option</p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="model-input">
                                                <input type="radio" name="checkpoint" id="<?php echo createSlug(get_the_title()); ?>" data-id="<?php echo get_field('sampler'); ?>" data-neg="<?php echo get_field('negative_prompt'); ?>" data-cfg="<?php echo get_field('cfg'); ?>" value="<?php echo get_field('real_checkpoint_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> data-actions="<?php echo $actionsString; ?>" data-chars="<?php echo $charsString; ?>"/>
                                                <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo get_the_title(); ?></label>
                                                <div class="model-image">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                </div>
                                            </div>
                                        <?php endif;?>
                                    <?php endif;?>

                                </div>
                            </div>
                            <?php
                            $firstLoop = false;
                        endwhile; ?>
                        <a class="single-checkpoint discord-btn" href="<?php echo get_field('discord','api'); ?>" target="_blank">
                            <div class="icon">
                                <svg viewBox="0 -28.5 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#FFFFFF" fill-rule="nonzero"> </path> </g> </g></svg>
                            </div>
                            <p class="title">Suggest next style</p>
                            <p class="cta">Join Community</p>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>