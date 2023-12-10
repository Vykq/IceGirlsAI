<?php
get_header();
?>
    <div style="background-color: white">
    <div class="all-loss-weight-wrapper">
        <p class="title">Weight loss booster</p>

        <div class="weight-loss-add-to-cart">
            <div class="top yellow">
                <div class="left">
                    <div class="arrow">
                        <svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M51.4749 28.4749C52.8417 27.108 52.8417 24.892 51.4749 23.5251L29.201 1.25126C27.8342 -0.115572 25.6181 -0.115572 24.2513 1.25126C22.8844 2.6181 22.8844 4.83418 24.2513 6.20101L44.0503 26L24.2513 45.799C22.8844 47.1658 22.8844 49.3819 24.2513 50.7487C25.6181 52.1156 27.8342 52.1156 29.201 50.7487L51.4749 28.4749ZM0 29.5L49 29.5V22.5L0 22.5L0 29.5Z" fill="#E70000"/>
                        </svg>
                    </div>
                </div>
                <div class="mid">
                    <label for="checkbox_weight_loss">
                        <input type="checkbox" class="input-checkbox" id="checkbox_weight_loss" name="checkbox_weight_loss"><?php echo __('YES, I want to lose weight', 'oxygn'); ?>
                    </label>
                </div>
                <div class="right">
                    <div class="regular-price price">$59.99</div>
                    <div class="sale-price price">$29.99</div>
                </div>
            </div>
            <div class="bottom">
                <div class="left">
                    <div class="image-area">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/icegirls.png'; ?>" alt="">
                    </div>
                </div>
                <div class="right">
                    <div class="description">
                        <b>One Time Offer:</b> By placing your order today, you can have a limited edition OXGN W-Loss drops with <b>50% OFF!</b> Special weight loss supplement with a proprietary blend of African mango, maca, l-glutamine, and others suited to help speed up metabolism, control appetite, and boost weight loss efforts:
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();