<?php
$_TITLE = "WPBTS - Create Clinic";
$_PARENT['clinics'] = time();

session_start();

$clinic = $_SESSION['clinic'];

require_once("header.php");
require_once('php/DBConn.php');


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="clinics.php">Clinic Management</a></li>
            <li class="active">Create Clinic</li>
        </ol>
    </div><!--/.row-->
    <br/>
    <div class="row">
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
            <h1 class="page-header">Create Clinic</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">            
            <form role="form" action="php/form-handler-clinic-create.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Description*</label>
                        <textarea required class="form-control" rows="6" name="description"><?php echo $clinic['description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label">Select An Image</label>
                        <input type="file" name="fileToUpload">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Contact No. 1*</label>
                        <input required class="form-control" onkeypress="validateNumberIn(event)" type="text" name="contact_1" value="<?php echo $clinic['contact_1']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Contact No. 2*</label>
                        <input required class="form-control" onkeypress="validateNumberIn(event)" type="text" name="contact_2" value="<?php echo $clinic['contact_2']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Operating Hours*</label>
                        <input required class="form-control" type="text" name="operating_hours" value="<?php echo $clinic['operating_hours']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label">Address</label>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street Number*</label>
                            <div class="col-sm-9"><input onkeypress="validateNumberIn(event)" required type="number" class="form-control" name="street_no" value="<?php echo $clinic['street_no']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="street" value="<?php echo $clinic['street']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Suburb*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="area" value="<?php echo $clinic['area']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="city" value="<?php echo $clinic['city']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Zip Code*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="area_code" value="<?php echo $clinic['area_code']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Office / Company</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="office" value="<?php echo $clinic['office']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Building Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control" name="building_number" value="<?php echo $clinic['building_number']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Latitude*</label>
                            <div class="col-sm-9"><input required type="number" min="-90" max="90" step="0.000001" class="form-control" name="latitude" value="<?php echo $clinic['latitude']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Longitude*</label>
                            <div class="col-sm-9"><input required type="number" min="-180" max="180" step="0.000001" class="form-control" name="longitude" value="<?php echo $clinic['longitude']; ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-6 text-right">
                        <br/>
                        <span>* denotes a required field </span> <button type="submit" class="btn btn-info">Save Clinic</button>
                    </div>
                </div>
            </form>
        </div>
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