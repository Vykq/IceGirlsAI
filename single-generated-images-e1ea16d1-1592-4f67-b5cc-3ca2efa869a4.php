<?php
get_header(); ?>

    <div class="new-single-generated-image-page single-image-id">
        <div class="container">
            <div class="left">
                <a class="go-back" href="javascript:history.back()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="7.682" height="13.363" viewBox="0 0 7.682 13.363">
                        <path id="Path_406" data-name="Path 406" d="M-16980.41-20298.4l-5.268,5.266,5.268,5.27" transform="translate(16986.678 20299.816)" fill="none" stroke="#FFA702FF" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg> Go Back
                </a>

                <div class="image-info-block" id="taskid" data-id="<?php echo get_field('task_id'); ?>">
                    <p class="top">
                        Image Details
                    </p>
                    <div class="list" id="infolist">
                        <div class="loaderis">
                            <div class="spinner show">
                                <span class="loader"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right">
                <div class="image-area normal"> <!-- prideti class per JS pagal ft dydi -->
                    <div class="single-image" id="singleImage">
                        <!-- JS content -->
                        <div class="loaderis">
                            <div class="spinner show">
                                <span class="loader"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
get_footer();