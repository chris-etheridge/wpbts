<?php

//Through this page we can access the user details
//As well as edit and update their details
//Or delete the record from the database.

session_start();
$_PARENT['notifications'] = time();
$_TITLE = "WPBTS - Notification Management";
require_once("header.php");
require_once('php/DBConn_Dave.php');

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active"><a href="notifications.php">Notification Management</a></li>
            <li class="active">Create Notification</li>
        </ol>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create new notification:</h1>
        </div>
    </div><!--/.row-->

    <?php
    if (isset($_SESSION['alert'])) {
        ?>
        <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong><?php echo $_SESSION['alert']["message_title"] ?></strong> <?php echo $_SESSION['alert']["message"] ?>
        </div>
        <?php
        if ($_SESSION['alert']["message_title"] == "Email exists!") {
            $wasEmailError = true;
        } elseif ($_SESSION['alert']["message_title"] == "Address write error!") {
            $wasAddressError = true;
        } elseif ($_SESSION['alert']["message_title"] == "User data write error!") {
            $wasUserError = true;
        }
        $_SESSION['alert'] = null;
    }
    ?>
    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h3>Notification Details:</h3>
            <form action="php/form-handler-notification-create.php" method="POST">
                <div class="col-md-6">
                    <label>Title:</label>
                    <input required type="text"
                           class="form-control" name="TITLE" value="<?php echo $_SESSION['NOTIFICATION']['TITLE']; ?>"
                           style="margin-bottom:2%">
                </div>

                <div class="col-md-12">
                    <label>Body</label>
                    <textarea required class="form-control" rows="6"
                              name="BODY"><?php echo $_SESSION['NOTIFICATION']['BODY']; ?></textarea>
                </div>

                <div class="col-md-12">
                    <label>Description</label>
                    <textarea required class="form-control" rows="6" name="DESCRIPTION"
                              style="margin-bottom: 7%"><?php echo $_SESSION['NOTIFICATION']['DESCRIPTION']; ?></textarea>
                </div>

                <div class="col-md-12" align="right" style="margin-bottom: 5%">
                    <button type="submit" class="btn btn-info">Save Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>


</div>    <!--/.main-->


<?php require_once('footer.php'); ?>


</body>

</html>

