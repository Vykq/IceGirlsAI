<?php
$title = $args['title'];


if($args['style']){
    $style = $args['style'];
} else {
    $style = 1;
}
?>

<?php if ($style == 2){ ?>
<a class="whole-input" href="/premium/">
        <p class="step-title"><?php echo $title; ?></p>
        <div class="premium-area">
            <p class="offer">To use this option you need <span>Premium</span></p>
        </div>
</a>

<?php } else { ?>
    <div class="single-question">
        <a href="/premium/">
            <p class="question-title"><?php echo $title; ?></p>
            <div class="premium-area">
                <p class="offer">To use this option you need <span>Premium</span></p>
            </div>
        </a>
    </div>
<?php }
