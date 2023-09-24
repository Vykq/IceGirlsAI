<?php
$tabs= get_field('tab','form');

$user = wp_get_current_user();

$args = array(
    'post_type' => 'checkpoints',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'DATE',
    'order' => 'ASC'
);

$args2 = array(
    'post_type' => 'actions',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'DATE',
    'order' => 'ASC'
);

$models = new WP_Query($args);

if(in_array( 'premium', (array) $user->roles)){
    $validate = 'premium';
} else {
    $validate = '';

}
?>
<form action="" class="creation-form">
    <div class="form-area">
        <div class="top">
            <div class="single-btn">
                <?php wp_nonce_field( 'generate', 'generation' ); ?>
                <input type="hidden" name="premium" value="<?php echo ( in_array( 'premium', (array) $user->roles ) ) ? '1' : ''; ?>">
                <button class="generate main-button" data-id="<?php echo $validate; ?>">Generate</button>
                <button class="stop-generate main-button hidden" data-id="<?php echo $validate; ?>">Stop</button>
            </div>
            <div class="grid">
                <div class="single-btn">
                    <button class="open-modal choose-model secondary-button" data-id="choose-model">Model</button>
                </div>
                <div class="single-btn">
                    <button class="open-modal choose-scene secondary-button" data-id="choose-scene">Action</button>
                </div>
            </div>
            <div class="single-btn">
                <button class="open-modal advanced-settings secondary-button" data-id="advanced-settings">Advanced settings</button>
            </div>
        </div>



        <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>
        <div class="main-prompt prompt-preview-area show">
                    <div class="whole-input">
                        <textarea name="prompt" id="positive-prompt-2" placeholder="Enter Your prompt"></textarea>
                        <label for="positive-prompt">Prompt</label>
                    </div>
        </div>
        <?php } else { ?>
            <div class="single-input positive-prompt">
                <div class="whole-input single-input premium prompt">
                    <a href="/premium">
                        <div class="input-wrapper premium">
                            <textarea name="get-premium-prompt" id="positive-prompt" placeholder="Enter Your prompt"></textarea>
                            <label for="positive-prompt">Prompt</label>
                        </div>
                        <div class="premium-area">
                            <p class="offer">To use this option you need <span>Premium</span></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if($tabs) : ?>
            <div class="form-inputs">
                <div class="tabs">
                    <div class="tab-header">
                        <?php foreach ($tabs as $tab) : ?>
                            <div class="single-tab-btn">
                                <button class="form-tab-button secondary-button" data-id="<?php echo createSlug($tab['tab_title']); ?>"><?php echo $tab['tab_title']; ?></button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="tabs-container">
                        <?php foreach ($tabs as $tab) : ?>
                            <div class="single-tab-container <?php echo createSlug($tab['tab_title']); ?>">
                                <?php foreach ($tab['question'] as $question) : ?>
                                    <?php if($question['premium'] == "yes"){ ?>
                                                <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>

                                                             <?php if($question['question_type'] == 'radio'){ ?>
                                                              <div class="single-question">
                                                                <p class="question-title"><?php echo $question['question_title']; ?></p>
                                                                  <span class="clear-question <?php echo createSlug($question['question_title']); ?>" data-clear="<?php echo createSlug($question['question_title']); ?>">Clear</span>
                                                                    <div class="radio-buttons-area">
                                                                        <?php foreach ($question['answers'] as $answer) : ?>
                                                                            <div class="single-radio-button">
                                                                                <input type="radio" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" />
                                                                                <label for="<?php echo $answer['id']; ?>"><?php echo $answer['input_text']; ?></label>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                         <?php    } else { ?>
                                                            <div class="single-question">
                                                                <p class="question-title"><?php echo $question['question_title']; ?></p>
                                                                <span class="clear-question <?php echo createSlug($question['question_title']); ?>" data-clear="<?php echo createSlug($question['question_title']); ?>">Clear</span>
                                                                <div class="checkbox-buttons-area">
                                                                     <?php foreach ($question['answers'] as $answer) : ?>
                                                                         <div class="single-checkbox-button">
                                                                             <input type="checkbox" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" />
                                                                             <label for="<?php echo $answer['id']; ?>"><?php echo $answer['input_text']; ?></label>
                                                                         </div>
                                                                     <?php endforeach; ?>
                                                                 </div>
                                                            </div>
                                                             <?php } ?>
                                                <?php } else { ?>
<!--                                                            echo get_template_part('template-parts/upgrade-premium','', array('title' => $question['question_title'], 'style' => '1'));-->

                                            <?php if($question['question_type'] == 'radio'){ ?>
                                                <div class="single-question premium">
                                                    <a href="/premium">
                                                        <p class="question-title"><?php echo $question['question_title']; ?></p>
                                                        <div class="radio-buttons-area">
                                                            <?php foreach ($question['answers'] as $answer) : ?>
                                                                <div class="single-radio-button">
                                                                    <input class="premium" type="radio" name="get-premium" id="<?php echo 'get-premium-' . $answer['id']; ?>" value="<?php echo 'get-premium-' . $answer['input_value']; ?>" />
                                                                    <label for="<?php echo 'get-premium-' . $answer['id']; ?>"><?php echo $answer['input_text']; ?></label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="premium-area">
                                                            <p class="offer">To use this option you need <span>Premium</span></p>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php    } else { ?>
                                                <div class="single-question premium">
                                                    <a href="/premium">
                                                    <p class="question-title"><?php echo $question['question_title']; ?></p>
                                                    <div class="checkbox-buttons-area">
                                                        <?php foreach ($question['answers'] as $answer) : ?>
                                                            <div class="single-checkbox-button">
                                                                <input class="premium" type="checkbox" name="<?php echo 'get-premium'; ?>" id="<?php echo 'get-premium-' . $answer['id']; ?>" value="<?php echo 'get-premium-' . $answer['input_value']; ?>" />
                                                                <label for="<?php echo 'get-premium-' . $answer['id']; ?>"><?php echo $answer['input_text']; ?></label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                        <div class="premium-area">
                                                            <p class="offer">To use this option you need <span>Premium</span></p>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                                        <?php } ?>
                                    <?php } else { ?>
                                <?php if($question['question_type'] == 'radio'){ ?>
                                <div class="single-question">
                                    <p class="question-title"><?php echo $question['question_title']; ?></p>
                                    <span class="clear-question <?php echo createSlug($question['question_title']); ?>" data-clear="<?php echo createSlug($question['question_title']); ?>">Clear</span>
                                    <div class="radio-buttons-area">
                                    <?php foreach ($question['answers'] as $answer) : ?>
                                        <div class="single-radio-button">
                                            <input type="radio" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" />
                                            <label for="<?php echo $answer['id']; ?>"><?php echo $answer['input_text']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                                <?php    } else { ?>
                                <div class="single-question">
                                    <p class="question-title"><?php echo $question['question_title']; ?></p>
                                    <span class="clear-question <?php echo createSlug($question['question_title']); ?>" data-clear="<?php echo createSlug($question['question_title']); ?>">Clear</span>
                                    <div class="checkbox-buttons-area">
                                    <?php foreach ($question['answers'] as $answer) : ?>
                                        <div class="single-checkbox-button">
                                            <input type="checkbox" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" />
                                            <label for="<?php echo $answer['id']; ?>"><?php echo $answer['input_text']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                                <?php } ?>
                                  <?php  } ?>

                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="single-btn">
            <button class="clear secondary-button"><svg fill="#FFA702" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style> .cls-1 { fill: none; } </style> </defs> <title>clean</title> <rect x="20" y="18" width="6" height="2" transform="translate(46 38) rotate(-180)"></rect> <rect x="24" y="26" width="6" height="2" transform="translate(54 54) rotate(-180)"></rect> <rect x="22" y="22" width="6" height="2" transform="translate(50 46) rotate(-180)"></rect> <path d="M17.0029,20a4.8952,4.8952,0,0,0-2.4044-4.1729L22,3,20.2691,2,12.6933,15.126A5.6988,5.6988,0,0,0,7.45,16.6289C3.7064,20.24,3.9963,28.6821,4.01,29.04a1,1,0,0,0,1,.96H20.0012a1,1,0,0,0,.6-1.8C17.0615,25.5439,17.0029,20.0537,17.0029,20ZM11.93,16.9971A3.11,3.11,0,0,1,15.0041,20c0,.0381.0019.208.0168.4688L9.1215,17.8452A3.8,3.8,0,0,1,11.93,16.9971ZM15.4494,28A5.2,5.2,0,0,1,14,25H12a6.4993,6.4993,0,0,0,.9684,3H10.7451A16.6166,16.6166,0,0,1,10,24H8a17.3424,17.3424,0,0,0,.6652,4H6c.031-1.8364.29-5.8921,1.8027-8.5527l7.533,3.35A13.0253,13.0253,0,0,0,17.5968,28Z"></path> <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1" width="32" height="32"></rect> </g></svg>Clear filters</button>
        </div>

    </div>

    <div class="backdrop models-modal-wrapper modals choose-model">
        <div class="main-modal unique">
            <div class="modal-wrapper">
                <div class="top">
                    <p class="title" id="current-model">Realistic</p>
                    <div class="close-modal">
                        <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                </div>
                <div class="content">
                    <?php if($models->have_posts()) :
                        $firstLoop = true;
                        ?>
                        <div class="checkpoints">
                            <?php while($models->have_posts()) : $models->the_post(); ?>
                                <div class="single-checkpoint">
                                    <div class="wrapper">
                                        <?php if(get_field('premium')) : ?>
                                            <?php if(in_array( 'premium', (array) $user->roles )) : ?>
                                                <div class="model-input">
                                                    <input type="radio" name="checkpoint" id="<?php echo createSlug(get_the_title()); ?>" data-id="<?php echo get_field('sampler'); ?>" data-neg="<?php echo get_field('negative_prompt'); ?>" data-cfg="<?php echo get_field('cfg'); ?>" value="<?php echo get_field('real_checkpoint_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> />
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
                                            <input type="radio" name="checkpoint" id="<?php echo createSlug(get_the_title()); ?>" data-id="<?php echo get_field('sampler'); ?>" data-neg="<?php echo get_field('negative_prompt'); ?>" data-cfg="<?php echo get_field('cfg'); ?>" value="<?php echo get_field('real_checkpoint_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> />
                                            <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo get_the_title(); ?></label>
                                            <div class="model-image">
                                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                            </div>
                                        </div>
                                        <?php endif;?>

                                    </div>
                                </div>
                            <?php
                            $firstLoop = false;
                            endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php
wp_reset_postdata();
$actions = new WP_Query($args2);
?>
    <div class="backdrop models-modal-wrapper modals choose-scene">
        <div class="main-modal unique">
            <div class="modal-wrapper">
                <div class="top">
                    <p class="title" id="current-scene">Default</p>
                    <div class="close-modal">
                        <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                </div>
                <div class="content">
                    <?php if($actions->have_posts()) :
                        $firstLoop = true;
                        ?>
                        <div class="actions">
                            <?php while($actions->have_posts()) : $actions->the_post(); ?>
                                <div class="single-action">
                                    <div class="wrapper">

                                        <?php if(get_field('premium')) : ?>
                                            <?php if(in_array( 'premium', (array) $user->roles )) : ?>
                                                <div class="action-input">
                                                    <input type="radio" name="action" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?>/>
                                                    <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo get_the_title(); ?></label>
                                                    <div class="action-image">
                                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                                    </div>
                                                </div>
                                        <?php else : ?>
                                        <div class="action-input premium">
                                            <input disabled type="radio" name="action" id="premium-only<?php echo get_the_id(); ?>" value="" data-id="premium-only"/>
                                            <label for="premium-only<?php echo get_the_id(); ?>"><?php echo get_the_title(); ?></label>
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
                                            <input type="radio" name="action" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?>/>
                                            <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo get_the_title(); ?></label>
                                            <div class="action-image">
                                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php
                                $firstLoop = false;
                            endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



    <div class="backdrop models-modal-wrapper modals advanced-settings">
        <div class="main-modal">
            <div class="modal-wrapper">
                <div class="top">
                    <p class="title" id="advanced-settings-title">Advanced Settings</p>
                    <div class="close-modal button-close">
                        <span class="save-btn">Save</span>
                    </div>
                </div>
                <div class="content">
                        <div class="grid">
                            <div class="left">
                                <div class="single-input details-slider">
                                    <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>
                                        <div class="whole-input">
                                            <div class="input-wrapper">
                                                <label class="step-title">Add details</label>
                                                <input name="details" type="range" min="0" max="1" step="0.1" value="0.5">
                                                <span id="details-value">0.5</span>
                                            </div>

                                        </div>
                                    <?php } else {?>

                                        <div class="whole-input single-input premium">
                                            <a href="/premium">
                                                <div class="input-wrapper">
                                                    <label class="step-title">Add details</label>
                                                    <input type="range" min="0" max="1" step="0.1" value="0.5">
                                                    <span id="details-value">0.5</span>
                                                </div>
                                                <div class="premium-area">
                                                    <p class="offer">To use this option you need <span>Premium</span></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>



                                <div class="single-input aspect-ratio">
                                    <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>
                                        <div class="whole-input">
                                            <div class="input-wrapper">
                                                <p class="step-title">Aspect Ratio</p>
                                                <div class="radio-buttons-area">
                                                    <div class="single-radio-button">
                                                        <input type="radio" name="aspect-ratio" id="aspect-9" value="9/16" checked>
                                                        <label for="aspect-9">9/16</label>
                                                    </div>
                                                    <div class="single-radio-button">
                                                        <input type="radio" name="aspect-ratio" id="aspect-1" value="1/1">
                                                        <label for="aspect-1">1/1</label>
                                                    </div>
                                                    <div class="single-radio-button">
                                                        <input type="radio" name="aspect-ratio" id="aspect-16" value="16/9">
                                                        <label for="aspect-16">16/9</label>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>

                                        <div class="whole-input single-input premium">
                                            <a href="/premium">
                                                <div class="input-wrapper">
                                                    <label class="step-title">Aspect Ratio</label>
                                                    <div class="radio-buttons-area">
                                                        <div class="single-radio-button">
                                                            <input type="radio" name="get-premium" id="aspect-9" value="9/16">
                                                            <label for="aspect-9">9/16</label>
                                                        </div>
                                                        <div class="single-radio-button">
                                                            <input type="radio" name="get-premium" id="aspect-1" value="1/1">
                                                            <label for="aspect-1">1/1</label>
                                                        </div>
                                                    <div class="single-radio-button">
                                                        <input type="radio" name="get-premium" id="aspect-16" value="16/9>
                                                        <label for="aspect-16">16/9</label>
                                                    </div>


                                                </div>
                                                </div>
                                                <div class="premium-area">
                                                    <p class="offer">To use this option you need <span>Premium</span></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="right">


                                <div class="single-input quality-slider">
                                    <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>
                                    <div class="whole-input">
                                        <div class="input-wrapper">
                                            <p class="step-title">Image Quality</p>
                                            <input name="steps" type="range" min="5" max="30" step="5" value="20">
                                            <span id="quality-value">20</span>
                                        </div>
                                    </div>
                                    <?php } else { ?>

                                    <div class="whole-input single-input premium">
                                        <a href="/premium">
                                            <div class="input-wrapper">
                                                <label class="step-title">Image Quality</label>
                                                <input name="get-premium" type="range" min="10" max="30" step="5" value="20">
                                                <span id="quality-value">20</span>
                                            </div>
                                            <div class="premium-area">
                                                <p class="offer">To use this option you need <span>Premium</span></p>
                                            </div>
                                        </a>
                                    </div>
                                        <?php  } ?>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
</form>