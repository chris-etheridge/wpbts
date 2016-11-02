<?php

//Through this page we can access the user details
//As well as edit and update their details
//Or delete the record from the database.

session_start();
$_PARENT['notifications'] = time();
$_TITLE = "WPBTS - Send Notification";
require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");
include_once("address_functions.php");

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
            <li class="active">Send Notification</li>
        </ol>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Send Notification:</h1>
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
            <h3>To All:</h3>
            <div class="row"> <!-- upcoming events -->
                <div class="col-md-12">
                    <a href="php/form-event-handler-notification-allusers.php" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span> All Users
                    </a>
                    <a href="php/form-handler-notification-send.php" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span> All Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>


</div>    <!--/.main-->


<script>

    $("#eventdate").datepicker({dateFormat: "dd-mm-yy"}); //sets date picker format

    function validateNumberIn(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

</script>

<?php require_once('footer.php'); ?>


</body>

</html>

