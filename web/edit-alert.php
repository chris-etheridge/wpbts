<?php
$_TITLE = "WPBTS - Edit Alert";
$_PARENT['alerts'] = time();
if(!isset($_GET['alertid']))
{
    header("Location: alerts.php");
}

session_start();

require_once("header.php");
require_once('php/DBConn.php');
require_once('php/alerts_functions.php');

//get selected event info
$alertid = filter_var($_GET['alertid'], FILTER_SANITIZE_STRING);
$alert = $_SESSION['alert'];//first and only slot - 0
if(!isset($_SESSION['alert']))
{
    $alert = getAlert($alertid)[0]; //first and only slot - 0
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->
    
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="events.php">Alert Management</a></li>
            <li class="active">Edit Alert</li>
        </ol>
    </div><!--/.row-->
    <br/>
    <div class="col-lg-10 col-lg-offset-1">
    <?php
        if(isset($_SESSION['alert']))
        {
            ?>
            <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><?php echo $_SESSION['alert']["message_title"] ?></strong> <?php echo $_SESSION['alert']["message"] ?>
            </div>
            <?php
            $_SESSION['alert'] = null;
        }
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Clinic</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">            
                <form role="form" action="php/form-handler-alert-edit.php" method="POST" class="form-horizontal">
                     <div class="col-md-6">
                        <label>Title:</label>
                        <input required type="text" class="form-control" name="TITLE" value="<?php echo $alert['TITLE']; ?>" style="margin-bottom:2%">
                    </div>

                    <div class="col-md-12">
                        <label>Body</label>
                        <textarea required="" class="form-control" rows="6" name="BODY"><?php echo $alert['BODY']; ?></textarea>
                    </div>

                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea required="" class="form-control" rows="6" name="DESCRIPTION" style="margin-bottom: 7%"><?php echo $alert['DESCRIPTION']; ?></textarea>
                    </div>

                    <div class="col-md-12" align="right" style="margin-bottom: 5%">
                        <input type="hidden" name="ALERT_ID" value="<?php echo $alert['ALERT_ID']; ?>">
                        <button type="submit" class="btn btn-info">Save Alert</button>
                    </div>
                </form>
        </div>
    </div>
</div>

</div>	<!--/.main-->

<?php require_once('footer.php'); ?>
	
</body>

</html>

<?php $_SESSION['clinic'] = null; ?>