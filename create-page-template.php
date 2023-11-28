<?php
/*
 * Template name: Create page template
 */

get_header();
?>
<div class="create-page-template">
<div class="creation">
    <div class="container">
    <div class="grid">
        <div class="left">
            <?php // FORM, to edit form template-parts/create-form.php ?>
            <?php echo get_template_part('template-parts/create-form'); ?>
        </div>
        <div class="right">
            <div class="col-wrapper">
                <div class="image">
                    <img class="generated-image" src="" alt="Your generated image">
                </div>
                <div class="notifier">
                    <p class="notify">
                        Choose filters and click <span>generate</span>
                    </p>
                </div>
                <div class="spinner">
                    <div class="premium-info">
                    <p><span id="steps-all">0%</span></p>
                    <p><span id="current-step"></span></p>
                    </div>
                    <span class="loader"></span>
                    <p id="premium-queue">Queue: <span id="yourpos">Calculating...</span></p>
                    <a href="<?php echo get_field('discord','api'); ?>" class="discord" target="_blank">
                        <div class="logo">
                            <div class="icon">
                                <svg viewBox="0 -28.5 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#FFFFFF" fill-rule="nonzero"> </path> </g> </g></svg>
                            </div>
                        </div>
                        <div class="text">
                            <p>Join our discord.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="button-area-premium">
                <?php
                $user = wp_get_current_user();
                if ( !in_array( 'premium', (array) $user->roles ) ) { ?>
                    <a href="/premium/" target="_blank" class="main-button">Get premium</a>
                <?php } ?>
            </div>
            <div class="button-area">
                <button class="upscale main-button hidden">Upscale & download!</button>
                <p class="hidden text upscale-text">Enhance image's quality to 4k</p>
            </div>

            <div class="seed-button hidden">
                <?php if ( in_array( 'premium', (array) $user->roles ) ) { ?>
                <div class="single-checkbox">
                    <input type="checkbox" id="seed" name="imageseed" value="">
                    <label for="seed">Get similar results</label><br>
                </div>
                <?php } else { ?>
                    <div class="single-button">
                        <a href="/premium/" target="_blank" class="main-button">Get similar results</a>
                    </div>
               <?php } ?>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<div class="saved-notify">
    <div class="notify-wrapper">
        <div class="grid">
            <div class="left">
                <div class="img">
                    <svg fill="#FFA702FF" height="200px" width="200px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="save-filled"> <path d="M19,0H1C0.448,0,0,0.448,0,1v22c0,0.552,0.448,1,1,1h22c0.552,0,1-0.448,1-1V5L19,0z M6,3c0-0.552,0.448-1,1-1h10 c0.552,0,1,0.448,1,1v6c0,0.552-0.448,1-1,1H7c-0.552,0-1-0.448-1-1V3z M20,22H4v-7c0-0.552,0.448-1,1-1h14c0.552,0,1,0.448,1,1V22 z"></path> <path d="M16,9h-4V3h4V9z"></path> </g> </g></svg>
                </div>
            </div>
            <div class="right">
                <p class="white">Saved</p>
                <p class="gray">Your option has been saved!</p>
            </div>

        </div>
    </div>
</div>


    <div class="error-notify">
        <div class="notify-wrapper">
            <div class="grid">
                <div class="left">
                    <div class="img">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm-1.5-5.009c0-.867.659-1.491 1.491-1.491.85 0 1.509.624 1.509 1.491 0 .867-.659 1.509-1.509 1.509-.832 0-1.491-.642-1.491-1.509zM11.172 6a.5.5 0 0 0-.499.522l.306 7a.5.5 0 0 0 .5.478h1.043a.5.5 0 0 0 .5-.478l.305-7a.5.5 0 0 0-.5-.522h-1.655z" fill="#FFA702FF"></path></g></svg>
                    </div>
                </div>
                <div class="right">
                    <p class="white">Error!</p>
                    <p class="gray">You cannot use this keyword (-s) - <span id="keyword"></span></p>
                </div>

            </div>
        </div>
    </div>
<?php
get_footer();