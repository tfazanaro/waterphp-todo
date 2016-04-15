<?php load('template/header'); ?>

<body>
    <div class="row">
        <div class="col s6 offset-s3">
            <div class="card blue-grey darken-1 center-align">
                <div class="card-content white-text">
                    <i class="large material-icons">live_help</i>
                    <br>
                    <span class="card-title">404 Not found</span>
                    <p>This will be shown if the page (controller or method) does not exist.</p>
                </div>
                <div class="card-action right-align">
                    <a href="<?php echo base_url(); ?>">Back To Home</a>
                </div>
            </div>
        </div>
    </div>

    <?php load('template/footer'); ?>