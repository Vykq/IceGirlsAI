<?php
$user = wp_get_current_user();
if ( !in_array( 'premium', (array) $user->roles ) ) { ?>
        <div class="backdrop main-modal-blur modals">
        <div class="main-modal">
            <div class="modal-wrapper">
                <div class="top">
                    <div class="close-modal close-modal-button">
                        <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                </div>
                <div class="content">
                    <div class="modal-grid wrapper">
                        <div class="right">
                            <div class="inner-col-wrapper modal-right">
                                <div class="right-title">
                                    <p class="col-title"><?php the_field('title','modal'); ?></p>
                                </div>
                                <?php
                                $to = get_field('date_to','modal');
                                $today = date("Y/m/d");
                                $difference = strtotime($to)-strtotime($today);
                                //echo "Difference is: ".$difference/(60*60)." hours";
                                ?>

                                <div class="date">
                                    <div class="timer">

                                        <div class="clock">
                                            <div class="days innercell">
                                                <div class="left cell days">
                                                    <span class="number">0</span>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right cell days">
                                                    <span class="number">0</span>
                                                </div>
                                            </div>
                                            <div class="hours innercell">
                                                <div class="left cell hours">
                                                    <span class="number">0</span>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right cell hours">
                                                    <span class="number">0</span>
                                                </div>
                                            </div>
                                            <div class="minutes innercell">
                                                <div class="left cell minutes">
                                                    <span class="number">0</span>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right cell minutes">
                                                    <span class="number">0</span>
                                                </div>
                                            </div>
                                            <div class="seconds innercell">
                                                <div class="left cell seconds">
                                                    <span class="number">0</span>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right cell seconds">
                                                    <span class="number">0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clock-explain">
                                            <div class="days"><p class="green"><span id="day-title"></span></p></div>
                                            <div class="hours"><p><span id="hour-title"></span></p></div>
                                            <div class="days"><p><span id="minutes-title"></span></p></div>
                                            <div class="days"><p><span id="seconds-title"></span></p></div>
                                        </div>
                                    </div>
                                    <div class="date-subtitle">
                                        <p><?php the_field('subtitle','modal'); ?></p>
                                    </div>
                                </div>

                                <div class="spots-area">
                                    <p class="subtitle"><?php the_field('subtitle_2','modal'); ?></p>
                                    <div class="people-area">
                                        <?php

                                        $currentPatrons = getCurrentPatronCount();
                                        if ($currentPatrons < 20) {
                                            $currentPatrons = $currentPatrons + 70;
                                        } else if ($currentPatrons < 30) {
                                            $currentPatrons = $currentPatrons + 60;
                                        } else if ($currentPatrons < 40) {
                                            $currentPatrons = $currentPatrons + 50;
                                        } else if ($currentPatrons < 50) {
                                            $currentPatrons = $currentPatrons + 40;
                                        } else if ($currentPatrons < 60) {
                                            $currentPatrons = $currentPatrons + 30;
                                        } else if ($currentPatrons < 70) {
                                            $currentPatrons = $currentPatrons + 20;
                                        } else if ($currentPatrons < 80) {
                                            $currentPatrons = $currentPatrons + 10;
                                        } else if ($currentPatrons > 80 && $currentPatrons < 100) {

                                        }

                                        ?>
                                        <p><span class="current-number"><?php echo $currentPatrons; ?></span><span class="divider">/</span><span class="max-number"><?php the_field('max_people','modal'); ?></span> </p>
                                    </div>
                                </div>

                                <div class="button-area">
                                    <a href="<?php echo the_field('button_url','modal'); ?>" class="main-button"><?php echo the_field('button_text','modal'); ?></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            const modal_timer="<?php the_field('timer_when_to_show','modal'); ?>"
            const deadline ="<?php the_field('date_to','modal'); ?>"
        </script>


    <?php
}

