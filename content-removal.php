<?php
/*
 * Template name: Content removal template
 */

get_header(); ?>

<div class="form-page-template">
    <div class="container">
        <h1 class="title"><?php the_title(); ?></h1>
        <div class="form-area">
            <form class="contact-form content-removal">
                <input type="hidden" name="page-title" value="<?php echo get_the_title(); ?>">
                <div class="single-input">
                    <label for="form-email">Email</label>
                    <input type="text" id="form-email" name="email">
                </div>
                <div class="single-input">
                    <label for="form-url">URLs of the content you are reporting</label>
                    <input type="text" id="form-url" name="url">
                </div>
                <div class="single-input">
                    <label for="form-info">Additional Information</label>
                    <textarea id="form-info" name="info"></textarea>
                </div>
                <p class="error-msg"></p>
                <div class="button-area">
                    <button type="submit" class="send-form main-button">Send</button>
                    <div class="divider">
                        <div class="line"></div>
                        <div class="or"><p>OR</p></div>
                        <div class="line"></div>
                    </div>
                    <a href="/contact/" class="link">Contact support</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
get_footer();