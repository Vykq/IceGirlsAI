</main>
<?php

?>
<footer>
    <div class="main-footer">
        <div class="container">
            <div class="logo-area">
                <a href="<?php echo get_home_url(); ?>">
                    <div class="logo-image">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/icegirls.png'; ?>" alt="IceGirls.Ai">
                    </div>
                </a>
            </div>
            <div class="grid">
                <div class="col">
                    <p class="col-title">Information</p>
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="/about/">About</a>
                            </li>
                            <li>
                                <a href="/terms-of-service/">Terms of Service</a>
                            </li>
                            <li>
                                <a href="/privacy-policy/">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="/2257/">2257</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col">
                    <p class="col-title">Work with Us</p>
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="/affiliate/">Become an affiliate</a>
                            </li>
                            <li>
                                <a href="mail:<?php the_field('email','api'); ?>"><?php the_field('email','api'); ?></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col">
                    <p class="col-title">Support and Help</p>
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="/content-removal/">Content removal</a>
                            </li>
                            <li>
                                <a href="/contact-support/">Contact support</a>
                            </li>
                            <li>
                                <a href="https://discord.gg/WMn24KArkB" target="_blank">Feedback</a>
                            </li>
                            <li>
                                <a href="https://discord.gg/WMn24KArkB" target="_blank">Need help?</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col">
                    <p class="col-title">Discover</p>
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="/create/">Create</a>
                            </li>
                            <li>
                                <a href="/hub/">Hub</a>
                            </li>
                            <li>
                                <a href="/premium/">Premium</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="wrapper">
                <div class="social-icons">
                    <?php if(get_field('discord','api')) : ?>
                        <a href="<?php the_field('discord','api'); ?>" target="_blank">
                            <svg viewBox="0 -28.5 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#C0C0C0" fill-rule="nonzero"> </path> </g> </g></svg>
                        </a>
                    <?php endif; ?>
                    <?php if(get_field('reddit','api')) : ?>
                        <a href="<?php the_field('reddit','api'); ?>" target="_blank">
                        <svg viewBox="0 -1.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#C0C0C0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>reddit [#C0C0C0]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-100.000000, -7561.000000)" fill="#C0C0C0"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M57.029,7412.24746 C56.267,7412.24746 55.628,7411.6217 55.628,7410.8499 C55.628,7410.07708 56.267,7409.43103 57.029,7409.43103 C57.79,7409.43103 58.407,7410.07708 58.407,7410.8499 C58.407,7411.6217 57.791,7412.24746 57.029,7412.24746 M57.223,7414.82961 C56.55,7415.51116 55.495,7415.8428 53.999,7415.8428 C52.502,7415.8428 51.448,7415.51116 50.776,7414.82961 C50.63,7414.68154 50.63,7414.44219 50.776,7414.2931 C50.921,7414.14503 51.158,7414.14503 51.304,7414.2931 C51.829,7414.82556 52.71,7415.08519 53.999,7415.08519 C55.287,7415.08519 56.169,7414.82556 56.695,7414.2931 C56.84,7414.14503 57.077,7414.14503 57.223,7414.2931 C57.369,7414.44219 57.369,7414.68154 57.223,7414.82961 M49.592,7410.8499 C49.592,7410.07809 50.23,7409.43103 50.991,7409.43103 C51.752,7409.43103 52.369,7410.07809 52.369,7410.8499 C52.369,7411.6217 51.752,7412.24746 50.991,7412.24746 C50.23,7412.24746 49.592,7411.6217 49.592,7410.8499 M64,7409.31339 C64,7408.04665 62.984,7407.01623 61.735,7407.01623 C61.159,7407.01623 60.616,7407.23428 60.2,7407.62475 C58.705,7406.63793 56.703,7406 54.486,7405.91278 L55.709,7402.12677 L58.921,7402.89351 C58.922,7403.93611 59.758,7404.78296 60.786,7404.78296 C61.814,7404.78296 62.651,7403.93408 62.651,7402.89148 C62.651,7401.84888 61.814,7401 60.786,7401 C60.016,7401 59.355,7401.47465 59.07,7402.15112 C58.378,7401.9858 55.904,7401.39452 55.212,7401.22921 L53.702,7405.90467 C51.401,7405.94828 49.316,7406.58316 47.765,7407.59331 C47.354,7407.22312 46.822,7407.01623 46.264,7407.01623 C45.016,7407.01623 44,7408.04665 44,7409.31339 C44,7410.11765 44.414,7410.85497 45.076,7411.26876 C44.473,7414.88134 48.67,7418 53.958,7418 C59.224,7418 63.407,7414.90872 62.849,7411.3144 C63.557,7410.91176 64,7410.1572 64,7409.31339" id="reddit-[#C0C0C0]"> </path> </g> </g> </g> </g></svg>
                        </a>
                    <?php endif; ?>
                    <?php if(get_field('twitter','api')) : ?>
                        <a href="<?php the_field('twitter','api'); ?>" target="_blank">
                        <svg viewBox="0 0 1001 937" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.44 0L388.83 516.64L0 936.69H87.51L427.93 568.93L702.98 936.69H1000.78L592.65 390.99L954.57 0H867.06L553.55 338.7L300.24 0H2.44ZM131.13 64.46H267.94L872.07 872.22H735.26L131.13 64.46Z" fill="#C0C0C0"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if(get_field('patreon','api')) : ?>
                        <a href="<?php the_field('patreon','api'); ?>"  target="_blank">
                        <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 0H0V15H3V0Z" fill="#C0C0C0"></path> <path d="M9.5 0C6.46243 0 4 2.46243 4 5.5C4 8.53757 6.46243 11 9.5 11C12.5376 11 15 8.53757 15 5.5C15 2.46243 12.5376 0 9.5 0Z" fill="#C0C0C0"></path> </g></svg>
                        </a>
                    <?php endif; ?>
                    <?php if(get_field('telegram','api')) : ?>
                        <a href="<?php the_field('telegram','api'); ?>"  target="_blank">
                        <svg fill="#C0C0C0" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>telegram</title> <path d="M22.122 10.040c0.006-0 0.014-0 0.022-0 0.209 0 0.403 0.065 0.562 0.177l-0.003-0.002c0.116 0.101 0.194 0.243 0.213 0.403l0 0.003c0.020 0.122 0.031 0.262 0.031 0.405 0 0.065-0.002 0.129-0.007 0.193l0-0.009c-0.225 2.369-1.201 8.114-1.697 10.766-0.21 1.123-0.623 1.499-1.023 1.535-0.869 0.081-1.529-0.574-2.371-1.126-1.318-0.865-2.063-1.403-3.342-2.246-1.479-0.973-0.52-1.51 0.322-2.384 0.221-0.23 4.052-3.715 4.127-4.031 0.004-0.019 0.006-0.040 0.006-0.062 0-0.078-0.029-0.149-0.076-0.203l0 0c-0.052-0.034-0.117-0.053-0.185-0.053-0.045 0-0.088 0.009-0.128 0.024l0.002-0.001q-0.198 0.045-6.316 4.174c-0.445 0.351-1.007 0.573-1.619 0.599l-0.006 0c-0.867-0.105-1.654-0.298-2.401-0.573l0.074 0.024c-0.938-0.306-1.683-0.467-1.619-0.985q0.051-0.404 1.114-0.827 6.548-2.853 8.733-3.761c1.607-0.853 3.47-1.555 5.429-2.010l0.157-0.031zM15.93 1.025c-8.302 0.020-15.025 6.755-15.025 15.060 0 8.317 6.742 15.060 15.060 15.060s15.060-6.742 15.060-15.060c0-8.305-6.723-15.040-15.023-15.060h-0.002q-0.035-0-0.070 0z"></path> </g></svg>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="copyright">
                    <p>© <?php echo date('Y'); ?> <a href="<?php echo get_home_url(); ?>">IceGirls.ai</a> All Rights Reserved.</p>
                </div>
            </div>

        </div>
    </div>
</footer>
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

     <?php
     $user = wp_get_current_user();
     if(!in_array( 'premium', (array) $user->roles )) : ?>
    <div class="backdrop models-modal-wrapper modals premium-modal">
    <div class="main-modal">
        <div class="modal-wrapper">
            <div class="top">
                <p class="title" id="current-scene">Upscale</p>
                <div class="close-modal">
                    <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
            </div>
            <div class="content">
                <div class="wrapper">
                    <div class="premium-upscale">
                        <p class="offer">To use this option you need <span>Premium</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- AGE POPUP -->
<div class="backdrop age-verification">
    <div class="main-modal">
        <div class="modal-wrapper">
            <p class="title">You must be over <span class="yellow">18 years old</span> to enter this website</p>
            <p class="subtitle">By entering this site, you are certifying that you are of legal adult age. By using the site, you agree to our <a href="/terms-of-service/">Terms of Service.</a></p>
            <div class="button-area">
                <span class="main-button confirm-age">Confirm</span>
                <span class="secondary-button decline-age">Decline</span>
            </div>
        </div>

    </div>
</div>
<?php  wp_footer(); ?>
</body>
</html>