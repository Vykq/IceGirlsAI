<?php
get_header();
?>
    <a class="single-product" href="https://google.lt/">
        <div class="wrapper">
            <div class="left">
                <div class="image-area">
                    <img src="https://evitamify.com/wp-content/uploads/2023/12/Vox_Crazydick_9-1.jpg" alt="Crazy dick">
                </div>
            </div>
            <div class="right">
                <h3 class="title">Crazy dick</h3>
                    <div class="description">
                        <p>A formula of herbal extracts and zinc…</p>
                    </div>
                <?php $rating = 5; ?>
                <div class="stars">
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <div class="single-star">
                            <img src="https://evitamify.com/wp-content/uploads/2024/01/star.png" <?php echo ($i >= $rating) ? 'class="opacity"' : ''; ?>>
                        </div>
                    <?php } ?>
                    <p class="rating">5</p>
                </div>
                <div class="prices">
                    <div class="price">
                        <p class="sale">27.60 €</p>
                    </div>
                    <div class="price">
                        <p class="regular">10,55 €</p>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php
get_footer();