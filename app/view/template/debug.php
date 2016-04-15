<?php load('template/header'); ?>

<body>
    <div class="row">
        <div class="col s6 offset-s3">
            <div class="card blue-grey darken-1 center-align">
                <div class="card-content white-text">
                    <i class="large material-icons">report_problem</i>
                    <br>
                    <span class="card-title"><?php echo $title; ?></span>
                    <p class="left-align"><i>
                        <?php 
                            echo '<b>Code</b>: '.$code.'<br>';
                            echo '<b>Message</b>: '.$message.'<br>';
                            echo '<b>File</b>: '.$file.'<br>';
                            echo '<b>Line</b>: '.$line;
                        ?>
                    </i></p>
                </div>
                <div class="card-action right-align">
                    <a href="<?php echo base_url(); ?>">Back To Home</a>
                </div>
            </div>
        </div>
    </div>

    <?php load('template/footer'); ?>