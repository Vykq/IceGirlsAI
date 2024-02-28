<?php
$terms = get_terms(
    array(
        'orderby' => 'none',
        'order' => 'ASC',
        'taxonomy' => 'types',
        'parent'   => 0
    )
);

$args3 = array(
    'post_type' => 'chars',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'DATE',
    'order' => 'ASC'
);

$chars = new WP_Query($args3);
$user = wp_get_current_user();
?>

<div class="backdrop models-modal-wrapper modals choose-char">
    <div class="main-modal unique">
        <div class="modal-wrapper">
            <div class="top">
                <p class="title" id="current-char">Default</p>
                <div class="close-modal">
                    <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
            </div>
            <?php if(!empty($terms)) : ?>
                <div class="filter-blocks">
                    <button class="single-filter secondary-button all" data-id="all">All</button>
                    <?php foreach($terms as $term) : ?>
                        <button class="single-filter secondary-button <?php echo $term -> slug; ?>" data-id="<?php echo $term -> slug; ?>"><?php echo $term->name; ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="content chars">
                <?php if($chars->have_posts()) :
                    $firstLoop = true;
                    ?>
                    <div class="actions">
                        <?php while($chars->have_posts()) : $chars->the_post();
                            $term = get_the_terms(get_the_id(), 'types');
                            ?>
                            <div class="single-char single-action <?php echo ($term) ? $term[0]->slug : ''; ?> <?php echo (get_the_title()) == 'None' ? 'default-char' : ''; ?> ">
                                <div class="wrapper">
                                    <?php if(get_field('logged')) : ?>
                                        <?php if(is_user_logged_in()) : ?>
                                            <div class="action-input">
                                                <input type="radio" name="char" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo checkIfChecked(get_the_title()); ?>/>
                                                <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                                <div class="action-image">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                </div>
                                                <div class="action-locked">
                                                    <div class="image">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 12C19.5 16.1421 16.1421 19.5 12 19.5C7.85786 19.5 4.5 16.1421 4.5 12C4.5 7.85786 7.85786 4.5 12 4.5C16.1421 4.5 19.5 7.85786 19.5 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM11.25 13.5V8.25H12.75V13.5H11.25ZM11.25 15.75V14.25H12.75V15.75H11.25Z" fill="#ff950d"></path> </g></svg>
                                                    </div>
                                                    <p class="gold">Not supported</p>
                                                    <p class="notify">Change style to use this option</p>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="action-input premium">
                                                <input disabled type="radio" name="char" id="premium-only<?php echo get_the_id(); ?>" value="" data-id="premium-only"/>
                                                <label for="premium-only<?php echo get_the_id(); ?>"><?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                                <div class="action-image">
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
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?php if(get_field('premium')) : ?>
                                            <?php if(in_array( 'premium', (array) $user->roles )) : ?>
                                                <div class="action-input">
                                                    <input type="radio" name="char" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo checkIfChecked(get_the_title()); ?>/>
                                                    <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                                    <div class="action-image">
                                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                    </div>
                                                    <div class="action-locked">
                                                        <div class="image">
                                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 12C19.5 16.1421 16.1421 19.5 12 19.5C7.85786 19.5 4.5 16.1421 4.5 12C4.5 7.85786 7.85786 4.5 12 4.5C16.1421 4.5 19.5 7.85786 19.5 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM11.25 13.5V8.25H12.75V13.5H11.25ZM11.25 15.75V14.25H12.75V15.75H11.25Z" fill="#ff950d"></path> </g></svg>
                                                        </div>
                                                        <p class="gold">Not supported</p>
                                                        <p class="notify">Change style to use this option</p>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="action-input premium">
                                                    <input disabled type="radio" name="char" id="premium-only<?php echo get_the_id(); ?>" value="" data-id="premium-only"/>
                                                    <label for="premium-only<?php echo get_the_id(); ?>"><?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                                    <div class="action-image">
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
                                            <?php endif;?>
                                        <?php else : ?>
                                            <div class="action-input">
                                                <input type="radio" name="char" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>"/>
                                                <label for="<?php echo createSlug(get_the_title()); ?>"> <?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                                <div class="action-image">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                </div>
                                                <div class="action-locked">
                                                    <div class="image">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 12C19.5 16.1421 16.1421 19.5 12 19.5C7.85786 19.5 4.5 16.1421 4.5 12C4.5 7.85786 7.85786 4.5 12 4.5C16.1421 4.5 19.5 7.85786 19.5 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM11.25 13.5V8.25H12.75V13.5H11.25ZM11.25 15.75V14.25H12.75V15.75H11.25Z" fill="#ff950d"></path> </g></svg>
                                                    </div>
                                                    <p class="gold">Not supported</p>
                                                    <p class="notify">Change style to use this option</p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <?php
                            $firstLoop = false;
                        endwhile; ?>
                        <a class="single-action discord-btn" href="<?php echo get_field('discord','api'); ?>" target="_blank">
                            <div class="icon">
                                <svg viewBox="0 -28.5 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#FFFFFF" fill-rule="nonzero"> </path> </g> </g></svg>
                            </div>
                            <p class="title">Suggest next style</p>
                            <p class="cta">Join Community</p>
                        </a>
                    </div>
                <?php else: ?>

                    <div class="actions">
                        <div class="single-action">
                            <div class="wrapper">
                                <div class="action-input">
                                    <input type="radio" name="char" id="<?php echo createSlug('none'); ?>" value="" data-id="" checked/>
                                    <label for="<?php echo createSlug('none'); ?>">None</label>
                                    <div class="action-image">
                                        <img src="<?php echo get_template_directory_uri() . '/assets/images/char-none.webp'; ?>" alt="None">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
