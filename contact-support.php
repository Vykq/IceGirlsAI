<?php
/*
 * Template name: Contact support template
 */

get_header(); ?>

    <div class="form-page-template">
        <div class="container">
            <h1 class="title"><?php the_title(); ?></h1>
            <div class="form-area">
                <form class="contact-form contact-support">
                    <input type="hidden" name="page-title" value="<?php echo get_the_title(); ?>">
                    <div class="single-input">
                        <label for="form-email">Email</label>
                        <input type="text" id="form-email" name="email">
                    </div>
                    <div class="single-input">

                        <div class="select-field">
                            <div class="cc-custom-selector" id="reasons">
                                <select name="type" class="select-field">
                                    <option value="" disabled selected>Select Support type</option>
                                    <option value="Bug">Bug</option>
                                    <option value="Account issues">Account issues</option>
                                    <option value="General inquiries">General inquiries</option>
                                    <option value="Subscription">Subscription</option>
                                    <option value="Premium">I have questions about PREMIUM</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="single-input">
                        <label for="form-info">Question</label>
                        <textarea id="form-info" name="info"></textarea>
                    </div>
                    <p class="error-msg"></p>
                    <div class="button-area">
                        <button type="submit" class="send-form main-button">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
get_footer();