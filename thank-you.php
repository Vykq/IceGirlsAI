<?php
/*
 * Template name: Thank you Page
 */


if($_GET){
    $success = setPremiumForStripePurchase($_GET['id']);
    $success = true;
if($success) {

    $user = wp_get_current_user();
    $user_id = $user->id;
    update_field('tokkens_set', 1, 'user_' . $user_id);
    update_field('tokens', 9999, 'user_' . $user_id);
    ?>
    <script type="text/javascript">
        var goaffproOrder = {
            number : <?php echo $user_id; ?>,
            total: 15
        }
        goaffproTrackConversion(goaffproOrder);
    </script>
    <?php
        get_header();

        ?>
        <div class="thank-you-page">
            <div class="container">
                <div class="content">
                    <h1>Thank you, your subscription is now active!</h1>
                    <p>From now you can use all the premium features</p>
                    <a href="/create/" class="main-button">Create</a>
                </div>

            </div>
        </div>
        <img src='https://ck.juicyads.com/ilikeitjuicy_px.php?c=s4332434v234u444&z=0' border='0'>
        <img src="//tsyndicate.com/api/v2/cpa/114375/pixel.gif" />
        <?php
        thankYouEvent($user_id);
        get_footer();
} else {
    wp_die('Error with the ID');
}
} else {
    wp_die('Did you came from STRIPE?');
}
