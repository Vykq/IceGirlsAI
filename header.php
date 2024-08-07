<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DR6P4VB37J"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-DR6P4VB37J');
    </script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php wp_head(); ?>
    <script type="text/javascript" src="https://api.goaffpro.com/loader.js?shop=vu7ivg8d7m"></script>
</head>
<body <?php body_class(); ?>>
<div class="site-loader hide">
    <div class="logo-image">
        <img width="140px" height="27px" src="<?php echo get_template_directory_uri() . '/assets/images/icegirls.png'; ?>" alt="IceGirls.Ai">
    </div>
</div>
<header>
<!--        --><?php //if(!is_front_page() && !is_page('ai-celebrity-nudes') && !is_page('anime-porn') && !is_page('ai-nudes')) { ?>
<!--            <h1 style="opacity: 0; visibility: hidden; font-size: 1px;">--><?php //echo get_the_title(); ?><!--</h1>-->
<!--        --><?php //} ?>
    <?php
    if(is_page('create') || is_page('hub') || is_page('blog') || is_page('premium')){ ?>
        <h1 style="opacity: 0; visibility: hidden; font-size: 1px;"><?php echo get_the_title(); ?></h1>
    <?php }
    $user = wp_get_current_user();
    $current_url = site_url();
    ?>
        <div class="topbar">
            <div class="container">
                <p class="info">🚀 Exciting News! We Now Accept Crypto Payments! 💸</p>
            </div>
        </div>

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
                            <li>
                                <a href="/blog/">Blog</a>
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
                <?php if(is_user_logged_in()) { ?>
                    <div class="tokens" title="Your tokens will be recharged every day">
                        <div class="image-area">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff950d"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.15" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="#ff950d"></path> <path d="M12 16H13C13.6667 16 15 15.6 15 14C15 12.4 13.6667 12 13 12H11C10.3333 12 9 11.6 9 10C9 8.4 10.3333 8 11 8H12M12 16H9M12 16V18M15 8H12M12 8V6M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#ff950d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </div>
                        <?php if (!in_array('premium', (array)$user->roles)) { ?>
                            <p id="userTokkens"><?php echo get_field('tokens','user_' . $user->id); ?></p>
                        <?php } else { ?>
                            <p>∞</p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

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


