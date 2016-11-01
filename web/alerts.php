<?php
$_TITLE = "WPBTS - User Management";
$_PARENT['alerts'] = time();

require_once("header.php");
require_once('php/DBConn_Dave.php');
require_once('php/alerts_functions.php');
include_once("users_functions.php");
session_start();

//Setup authentication.
if ($_SESSION['AUTH_USER_ID'] == null) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Not logged in..";
    $_SESSION['alert']['message'] = " Please authenticate to regain access";
    header('Location: login.php');
    exit();
}

$exitingAlerst = getAllALerts();
if ($exitingAlerst == false) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Unable to access alerts. ";
    $_SESSION['alert']['message'] = " Check server logs.";
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">Alert Management</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Alert Management</h1>
        </div>
    </div><!--/.row-->

    <?php
    if (isset($_SESSION['alert'])) {
        ?>
        <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong><?php echo $_SESSION['alert']["message_title"] ?></strong><?php echo $_SESSION['alert']["message"] ?>
        </div>
        <?php
        $_SESSION['alert'] = null;
    }
    ?>

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>All Alerts</h4>
            <a href="alerts_create.php" class="btn btn-default">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Alert
            </a>
        </div>
    </div>
    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <?php
            //LETS GET ALL ALERTS FROM THE DB THAT HAVE BEEN SENT.
            ?>
            <table data-toggle="table" data-search="true" data-pagination="true">
                <thead>
                <tr>
                    <th class="text-center">Alert ID</th>
                    <th class="text-center" data-sortable="true">Title</th>
                    <th class="text-center">Content</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Options</th>
                </tr>
                </thead>

                <?php

                foreach ($exitingAlerst as $value) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $value['ALERT_ID'] ?></td>
                        <td class="text-center"><?php echo $value['TITLE'] ?></td>
                        <td class="text-center"><?php echo $value['BODY'] ?></td>
                        <td class="text-center"><?php echo $value['DESCRIPTION'] ?></td>
                        <td class="text-center">
                            <a href="" data-id="<?php echo $value['ALERT_ID']; ?>" class="btn btn-xs btn-primary" onclick="sendAlert(event)">Send</a>
                            <a href="" data-id="<?php echo $value['ALERT_ID']; ?>" class="btn btn-xs btn-warning" onclick="removeAlert(event)">Remove</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>


</div>    <!--/.main-->
<div class="modal fade" id="modal-remove-alert" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure you want to permanently delete this alert?</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">Alert ID</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moAlertID"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <span id="confirmationBtns"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-send-alert" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure you want to send this alert to everyone?</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">Alert ID</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moAlertID"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <span id="confirmationBtns"></span>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<script type="text/javascript">
    
function removeAlert(ev)
{
    ev.preventDefault();
    var uid = ev.target.dataset.id;

    //get json object

    $('#modal-remove-alert .modal-body #moAlertID').html(uid);
    $('#modal-remove-alert .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/delete-alert.php?alertid=" + uid + "'>Delete Alert</a>");


    $('#modal-remove-alert').modal('show', {backdrop: 'static'});

}
     
function sendAlert(ev)
{
    ev.preventDefault();
    var uid = ev.target.dataset.id;

    //get json object

    $('#modal-send-alert .modal-body #moAlertID').html(uid);
    $('#modal-send-alert .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/send-alert.php?alertid=" + uid + "'>Send Alert</a>");


    $('#modal-send-alert').modal('show', {backdrop: 'static'});

}

</script>

</body>

</html>
