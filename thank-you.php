<?php
/*
 * Template name: Thank you Page
 */

$success = setPremiumForStripePurchase($_GET['id']);
if($success) {

    $user = wp_get_current_user();
    $user_id = $user->id;
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

        <?php
        get_footer();
} else {
    wp_die('Error');
}
