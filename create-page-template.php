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