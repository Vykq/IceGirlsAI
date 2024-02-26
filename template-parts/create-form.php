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

fixPrompt();

if (isset($_GET['prompt'])) {
        $promptArray = explode(", ", $_GET['prompt']);
        $allAnswers = array();
        $removedValues = array(); // Array to store removed values

        if ($tabs) {
            foreach ($tabs as $tab) {
                foreach ($tab['question'] as $question) {
                    foreach ($question['answers'] as $answer) {
                        array_push($allAnswers, trim($answer['input_value']));
                    }
                }
            }
        }

        $promptArray = array_map('trim', $promptArray);

        // Iterate over the elements and store removed values in $removedValues
        foreach ($promptArray as $value) {
            if (in_array($value, $allAnswers)) {
                $removedValues[] = $value;
            }
        }

        // Use array_diff to remove values from $promptArray that are also in $allAnswers
        $promptArray = array_diff($promptArray, $allAnswers);
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
                    <button class="open-modal choose-model secondary-button" data-id="choose-model">Style</button>
                </div>
                <div class="single-btn">
                    <button class="open-modal choose-scene secondary-button" data-id="choose-scene">Action</button>
                </div>
                <div class="single-btn">
                    <button class="open-modal choose-char secondary-button" data-id="choose-char">Characters</button>
                </div>
            </div>
            <div class="grid double">
                <div class="single-btn">
                    <button class="open-modal user-faces secondary-button" data-id="user-faces">Saved faces
                        <div class="icon">
                            <svg fill="#ff950d" viewBox="0 0 36 36" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#ff950d" stroke-width="0.00036"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>new-solid</title> <path class="clr-i-solid clr-i-solid-path-1" d="M34.11,24.49l-3.92-6.62,3.88-6.35A1,1,0,0,0,33.22,10H2a2,2,0,0,0-2,2V24a2,2,0,0,0,2,2H33.25A1,1,0,0,0,34.11,24.49Zm-23.6-3.31H9.39L6.13,16.84v4.35H5V15H6.13l3.27,4.35V15h1.12ZM16.84,16H13.31v1.49h3.2v1h-3.2v1.61h3.53v1H12.18V15h4.65Zm8.29,5.16H24l-1.55-4.59L20.9,21.18H19.78l-2-6.18H19l1.32,4.43L21.84,15h1.22l1.46,4.43L25.85,15h1.23Z"></path> <rect x="0" y="0" width="36" height="36" fill-opacity="0"></rect> </g></svg>
                        </div>
                    </button>
                </div>
                <div class="single-btn">
                    <button class="open-modal advanced-settings secondary-button" data-id="advanced-settings">Advanced settings</button>
                </div>
            </div>

        </div>



        <?php if(is_user_logged_in()) { ?>
            <div class="main-prompt prompt-preview-area show">
                <div class="whole-input">
                    <textarea name="prompt" id="positive-prompt-2" placeholder="Enter Your prompt"><?php echo (fixPrompt()) ? fixPrompt() : "" ;?></textarea>
                    <label for="positive-prompt">Prompt</label>
                    <div class="tooltip-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#ff950d" stroke-width="1.5"></circle> <path d="M12 17V11" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round"></path> <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#ff950d"></circle> </g></svg>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="main-prompt prompt-preview-area show">
                <div class="whole-input">
                    <textarea name="prompt" id="positive-prompt-2" placeholder="Enter Your prompt"><?php echo (fixPrompt()) ? fixPrompt() : "" ;?></textarea>
                    <label for="positive-prompt">Prompt</label>
                    <div class="tooltip-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#ff950d" stroke-width="1.5"></circle> <path d="M12 17V11" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round"></path> <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9)" fill="#ff950d"></circle> </g></svg>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="tooltip-modal">
            <div class="wrapper">
                <div class="text">
                    <div class="content"><?php echo get_field('prompt_tooltip','form'); ?></div>
                </div>
            </div>
        </div>

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
                                                                                <input <?php checkAnswer($answer['input_value']); ?> type="radio" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" data-lora="<?php echo $answer['lora']; ?>"/>
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
                                                                             <input <?php checkAnswer($answer['input_value']); ?> type="checkbox" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" data-lora="<?php echo $answer['lora']; ?>"/>
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
                                                                <input <?php checkAnswer($answer['input_value']); ?> class="premium" type="checkbox" name="<?php echo 'get-premium'; ?>" id="<?php echo 'get-premium-' . $answer['id']; ?>" value="<?php echo 'get-premium-' . $answer['input_value']; ?>" data-lora="<?php echo $answer['lora']; ?>"/>
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
                                            <input <?php checkAnswer($answer['input_value']); ?>  type="radio" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" data-lora="<?php echo $answer['lora']; ?>"/>
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
                                            <input <?php checkAnswer($answer['input_value']); ?> type="checkbox" name="<?php echo createSlug($question['question_title']); ?>" id="<?php echo $answer['id']; ?>" value="<?php echo $answer['input_value']; ?>" data-lora="<?php echo $answer['lora']; ?>"/>
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
            <button class="generate main-button gen-bottom" data-id="<?php echo $validate; ?>">Generate</button>
        </div>
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
                                        <?php if(get_field('logged')) : ?>
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
                                <div class="single-action <?php echo (get_the_title()) == 'Default' ? 'default-action' : ''; ?> ">
                                    <div class="wrapper">
                                        <?php if(get_field('logged')) : ?>
                                            <?php if(is_user_logged_in()) : ?>
                                                <div class="action-input">
                                                    <input type="radio" name="action" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> <?php echo checkIfChecked(get_the_title()); ?>/>
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
                                            <?php else: ?>
                                                <div class="action-input premium">
                                                    <input disabled type="radio" name="action" id="premium-only<?php echo get_the_id(); ?>" value="" data-id="premium-only"/>
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
                                        <?php else: ?>
                                        <?php if(get_field('premium')) : ?>
                                            <?php if(in_array( 'premium', (array) $user->roles )) : ?>
                                                <div class="action-input">
                                                    <input type="radio" name="action" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?> <?php echo checkIfChecked(get_the_title()); ?>/>
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
                                            <input disabled type="radio" name="action" id="premium-only<?php echo get_the_id(); ?>" value="" data-id="premium-only"/>
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
                                            <input type="radio" name="action" id="<?php echo createSlug(get_the_title()); ?>" value="<?php echo get_field('trigger_word'); ?>" data-id="<?php echo get_field('lora_name'); ?>" <?php echo ($firstLoop) ? 'checked' : ''; ?>/>
                                            <label for="<?php echo createSlug(get_the_title()); ?>"><?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                            <div class="action-image">
                                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                                            </div>
                                            <div class="action-locked hidden">
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <?php
    wp_reset_postdata();
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


<?php
$userFacesArgs = array(
    'post_type' => 'faces',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'DATE',
    'order' => 'ASC',
    'author' => $user->ID,
);

// Check if the user is logged in
if (is_user_logged_in()) {
    $uplaodedFaces = new WP_Query($userFacesArgs);
} else {
    $uplaodedFaces = new WP_Query(array());
}


$count = 1;
?>

    <div class="backdrop models-modal-wrapper modals user-faces">
        <div class="main-modal unique">
            <div class="modal-wrapper">
                <div class="top">
                    <p class="title" id="current-face">Default</p>
                    <div class="close-modal">
                        <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                </div>
                <div class="content">
                    <div class="actions">
                        <div class="single-action empty-face">
                            <div class="wrapper">
                                <div class="action-input">
                                    <input type="radio" name="face" id="<?php echo createSlug('none'); ?>" value="" data-id="" checked/>
                                    <label for="<?php echo createSlug('none'); ?>">None</label>
                                    <div class="action-image">
                                        <img src="<?php echo get_template_directory_uri() . '/assets/images/char-none.webp'; ?>" alt="None">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="single-action discord-btn upload-face open-modal" data-id="upload-face-modal">
                                <span class="upload-icon">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="arrow-upload" d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 22.0002H16C18.8284 22.0002 20.2426 22.0002 21.1213 21.1215C22 20.2429 22 18.8286 22 16.0002V15.0002C22 12.1718 22 10.7576 21.1213 9.8789C20.3529 9.11051 19.175 9.01406 17 9.00195M7 9.00195C4.82497 9.01406 3.64706 9.11051 2.87868 9.87889C2 10.7576 2 12.1718 2 15.0002L2 16.0002C2 18.8286 2 20.2429 2.87868 21.1215C3.17848 21.4213 3.54062 21.6188 4 21.749" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                                </span>
                                <span class="cta">Upload your face</span>
                            </span>
                        <?php
                        if($uplaodedFaces->have_posts()):
                        while($uplaodedFaces->have_posts()) : $uplaodedFaces->the_post(); ?>
                            <div class="saved-faces single-action user-face single-face" data-id="<?php echo get_the_id(); ?>">
                                <div class="wrapper">
                                    <div class="action-input">
                                        <input type="radio" name="face" data-uploaded="true" data-imgid="<?php echo 'Face - ' . $count; ?>" id="<?php echo get_the_id(); ?>"/>
                                        <label for="<?php echo get_the_id(); ?>"><?php echo substr(get_the_title(), 0, 13) .((strlen(get_the_title()) > 13) ? '...' : ''); ?></label>
                                        <div class="action-image face-image-wrap">
                                            <div class="spinner show">
                                                <img src="<?php echo 'data:image/jpeg;base64,' . get_field('base64_image',get_the_id()); ?>" data-id="<?php echo get_the_id(); ?>" class="user-face face-<?php echo $count; ?>" alt="<?php echo get_the_title(); ?>">
                                            </div>
                                        </div>
                                        <div class="delete-face" title="Delete face" data-id="<?php echo get_the_id(); ?>">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="handle" d="M12 2.75C11.0215 2.75 10.1871 3.37503 9.87787 4.24993C9.73983 4.64047 9.31134 4.84517 8.9208 4.70713C8.53026 4.56909 8.32557 4.1406 8.46361 3.75007C8.97804 2.29459 10.3661 1.25 12 1.25C13.634 1.25 15.022 2.29459 15.5365 3.75007C15.6745 4.1406 15.4698 4.56909 15.0793 4.70713C14.6887 4.84517 14.2602 4.64047 14.1222 4.24993C13.813 3.37503 12.9785 2.75 12 2.75Z" fill="#ff950d"></path> <path class="cover" d="M2.75 6C2.75 5.58579 3.08579 5.25 3.5 5.25H20.5001C20.9143 5.25 21.2501 5.58579 21.2501 6C21.2501 6.41421 20.9143 6.75 20.5001 6.75H3.5C3.08579 6.75 2.75 6.41421 2.75 6Z" fill="#ff950d"></path> <path d="M5.91508 8.45011C5.88753 8.03681 5.53015 7.72411 5.11686 7.75166C4.70356 7.77921 4.39085 8.13659 4.41841 8.54989L4.88186 15.5016C4.96735 16.7844 5.03641 17.8205 5.19838 18.6336C5.36678 19.4789 5.6532 20.185 6.2448 20.7384C6.83639 21.2919 7.55994 21.5307 8.41459 21.6425C9.23663 21.75 10.2751 21.75 11.5607 21.75H12.4395C13.7251 21.75 14.7635 21.75 15.5856 21.6425C16.4402 21.5307 17.1638 21.2919 17.7554 20.7384C18.347 20.185 18.6334 19.4789 18.8018 18.6336C18.9637 17.8205 19.0328 16.7844 19.1183 15.5016L19.5818 8.54989C19.6093 8.13659 19.2966 7.77921 18.8833 7.75166C18.47 7.72411 18.1126 8.03681 18.0851 8.45011L17.6251 15.3492C17.5353 16.6971 17.4712 17.6349 17.3307 18.3405C17.1943 19.025 17.004 19.3873 16.7306 19.6431C16.4572 19.8988 16.083 20.0647 15.391 20.1552C14.6776 20.2485 13.7376 20.25 12.3868 20.25H11.6134C10.2626 20.25 9.32255 20.2485 8.60915 20.1552C7.91715 20.0647 7.54299 19.8988 7.26957 19.6431C6.99616 19.3873 6.80583 19.025 6.66948 18.3405C6.52891 17.6349 6.46488 16.6971 6.37503 15.3492L5.91508 8.45011Z" fill="#ff950d"></path> <path d="M9.42546 10.2537C9.83762 10.2125 10.2051 10.5132 10.2464 10.9254L10.7464 15.9254C10.7876 16.3375 10.4869 16.7051 10.0747 16.7463C9.66256 16.7875 9.29502 16.4868 9.25381 16.0746L8.75381 11.0746C8.71259 10.6625 9.0133 10.2949 9.42546 10.2537Z" fill="#ff950d"></path> <path d="M15.2464 11.0746C15.2876 10.6625 14.9869 10.2949 14.5747 10.2537C14.1626 10.2125 13.795 10.5132 13.7538 10.9254L13.2538 15.9254C13.2126 16.3375 13.5133 16.7051 13.9255 16.7463C14.3376 16.7875 14.7051 16.4868 14.7464 16.0746L15.2464 11.0746Z" fill="#ff950d"></path> </g></svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                            $count++;
                        endwhile;
                        endif;
                        ?>

                            <a class="single-action discord-btn" href="<?php echo get_field('discord','api'); ?>" target="_blank">
                                <div class="icon">
                                    <svg viewBox="0 -28.5 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#FFFFFF" fill-rule="nonzero"> </path> </g> </g></svg>
                                </div>
                                <p class="title">Suggest next feature</p>
                                <p class="cta">Join Community</p>
                            </a>
                    </div>
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
                                                        <input type="radio" name="get-premium" id="aspect-16" value="16/9">
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


<div class="backdrop models-modal-wrapper modals upload-face-modal">
    <div class="main-modal unique">
        <div class="modal-wrapper">
            <div class="top">
                <p class="title">Upload your face</p>
                <div class="close-modal">
                    <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
            </div>
            <div class="content">
                <div class="wrapper">
                    <div class="left">
                        <form class="face-upload-form">
                            <div class="single-input">
                                <input type="text" name="face-title" placeholder="Face title">
                            </div>
                            <div class="single-input upload">
                                <label for="uploading-face"> <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="arrow-upload" d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 22.0002H16C18.8284 22.0002 20.2426 22.0002 21.1213 21.1215C22 20.2429 22 18.8286 22 16.0002V15.0002C22 12.1718 22 10.7576 21.1213 9.8789C20.3529 9.11051 19.175 9.01406 17 9.00195M7 9.00195C4.82497 9.01406 3.64706 9.11051 2.87868 9.87889C2 10.7576 2 12.1718 2 15.0002L2 16.0002C2 18.8286 2 20.2429 2.87868 21.1215C3.17848 21.4213 3.54062 21.6188 4 21.749" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round"></path> </g></svg><span id="input-msg">Click here to upload</span></label>
                                <input type="file" id="uploading-face" name="uploading-face">
                            </div>
                            <div class="form-bottom">
                                <p class="error-msg"></p>
                                <button type="submit" class="face-upload-btn main-button">Upload face</button>
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        <p class="title">Instructions</p>
                        <ul class="list">
                            <li><p>Image should be in .jpg or .jpeg format</p></li>
                            <li><p>Image maximum size is 1 mb.</p></li>
                            <li><p>To get the best results upload image with one face only</p></li>
                            <li><p>Make sure your face is high quality and objects are not obstructing or distracting from the main focus.</p></li>
                            <li><p>Avoid using heavily filtered or edited images, as they may affect the accuracy of the results.</p></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>