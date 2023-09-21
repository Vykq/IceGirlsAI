<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <?php
    $user = wp_get_current_user();
    ?>
    <div class="main-header">
        <div class="container">
            <div class="wrapper">
                <div class="logo">
                    <a href="<?php echo get_home_url(); ?>">
                        <div class="logo-image">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/icegirls.png'; ?>" alt="IceGirls.Ai">
                        </div>
                    </a>
                </div>

                <div class="menu-area">
                    <nav>
                        <ul class="header-nav">
                            <li>
                                <a href="<?php echo get_home_url(); ?>">Home</a>
                            </li>
                            <li>
                                <a href="/create/">Create</a>
                            </li>
                            <li>
                                <a href="/hub/">Hub</a>
                            </li>
                            <?php if ( !in_array( 'premium', (array) $user->roles ) ) { ?>
                                <li>
                                    <a href="/premium/">Premium</a>
                                </li>
                            <?php } ?>
                            <?php if(is_user_logged_in()) { ?>
                                <li>
                                    <a href="/account/">Account</a>
                                </li>
                            <?php } else {?>
                                <li>
                                    <span class="open-login-modal open-modal" data-id="login-modal">Log in</span>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <div class="menu-burger open-modal" data-id="mobile-menu">
                        <div class="line top"></div>
                        <div class="line mid"></div>
                        <div class="line bot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="mobile-menu-wrapper modals mobile-menu">
    <div class="mobile-container">
        <div class="close-mobile-menu close-modal">
            <svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Close</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Close"> <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24"> </rect> <line x1="16.9999" y1="7" x2="7.00001" y2="16.9999" id="Path" stroke="#FFA702FF" stroke-width="2" stroke-linecap="round"> </line> <line x1="7.00006" y1="7" x2="17" y2="16.9999" id="Path" stroke="#FFA702FF" stroke-width="2" stroke-linecap="round"> </line> </g> </g> </g></svg>
        </div>
        <div class="menu-area">
            <nav>
                <ul class="mobile-menu">
                    <li>
                        <a href="<?php echo get_home_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a href="/create/">Create</a>
                    </li>
                    <li>
                        <a href="/hub/">Hub</a>
                    </li>
                    <?php if ( !in_array( 'premium', (array) $user->roles ) ) { ?>
                        <li>
                            <a href="/premium/">Premium</a>
                        </li>
                    <?php } ?>
                    <?php if(is_user_logged_in()) { ?>
                        <li>
                            <a href="/account/">Account</a>
                        </li>
                    <?php } else {?>
                        <li>
                            <span class="open-login-modal open-modal" data-id="login-modal">Log in</span>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>


<?php if(!is_user_logged_in()) {?>
<div class="backdrop models-modal-wrapper modals login-modal">

    <div class="main-modal">
        <div class="modal-wrapper">
            <div class="top">
                <p class="title" id="current-scene">Log in / Register</p>
                <div class="close-modal">
                    <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
            </div>
            <div class="content">
                <div class="wrapper">
                    <div class="left login-block">
                        <div class="col-wrap">
                            <p class="col-title">Log in</p>
                            <div class="scroll-area">
                                <div class="login-form">
                                    <div class="wp-form"><?php echo do_shortcode('[theme-my-login]'); ?></div>
                                </div>
                                <span class="white" id="switch-to-register">Register</span>
                            </div>


                        </div>

                    </div>
                    <div class="right register-block hidden">
                        <div class="col-wrap">
                        <p class="col-title">Register</p>
                            <div class="scroll-area">
                            <div class="register-form login-form">
                                <div class="wp-form"><?php echo do_shortcode('[theme-my-login action="register" show_links="0"]');?></div>
                            </div>
                                <span class="white" id="switch-to-login">Log in</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
<main>


