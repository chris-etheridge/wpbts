<?php
$_TITLE = "WPBTS - Edit Clinic";
$_PARENT['clinics'] = time();
if(!isset($_GET['clinicid']))
{
    header("Location: clinics.php");
}
require_once("header.php");
require_once('php/DBConn.php');
require_once('api/clinics/functions.php');

session_start();

//get selected event info
$clinicid = filter_var($_GET['clinicid'], FILTER_SANITIZE_STRING);
if(!isset($_SESSION['clinic']))
{
    $_SESSION['clinic'] = getClinic($mysqli, $clinicid)[0]; //first and only slot - 0
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->
    
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="events.php">Clinic Management</a></li>
            <li class="active">Edit Clinic</li>
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
                <form role="form" action="php/form-handler-clinic-edit.php" method="POST" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-6">
                        <label>Clinic ID</label>
                        <input required readonly type="text" class="form-control" name="clinic_id" value="<?php echo $_SESSION['clinic']['clinic_id']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Description</label>
                        <textarea required class="form-control" rows="6" name="description"><?php echo $_SESSION['clinic']['description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Contact No. 1</label>
                        <input required class="form-control" onkeypress="validateNumberIn(event)" type="number" name="contact_1" value="<?php echo $_SESSION['clinic']['contact_1']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Contact No. 2</label>
                        <input required class="form-control" onkeypress="validateNumberIn(event)" type="number" name="contact_2" value="<?php echo $_SESSION['clinic']['contact_2']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label">Address</label>
                        <input type="hidden" name="address_id" value="<?php echo $_SESSION['clinic']['clinic_id']; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street Number</label>
                            <div class="col-sm-9"><input onkeypress="validateNumberIn(event)" required type="number" class="form-control" name="street_no" value="<?php echo $_SESSION['clinic']['street_no']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="street" value="<?php echo $_SESSION['clinic']['street']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Suburb</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="area" value="<?php echo $_SESSION['clinic']['area']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="city" value="<?php echo $_SESSION['clinic']['city']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Zip Code</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="area_code" value="<?php echo $_SESSION['clinic']['area_code']; ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-6 text-right">
                        <br/>
                        <button type="submit" class="btn btn-info">Save Clinic</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

</div>	<!--/.main-->

<?php require_once('footer.php'); ?>

<script>
    
    $("#eventdate").datepicker({dateFormat: "dd-mm-yy"}); //sets date picker format
    
    function validateNumberIn(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[0-9]/;
        if( !regex.test(key) ) {
          theEvent.returnValue = false;
          if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    
</script>	
</body>

</html>

<?php $_SESSION['clinic'] = null; ?>