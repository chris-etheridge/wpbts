<!-- author: Kyle Burton -->
<?php
$_TITLE = "WPBTS - Create Event";
$_PARENT['events'] = time();

session_start();

$adminid = $_SESSION['AUTH_USER_ID'];

$event = $_SESSION['event'];

require_once("header.php");
require_once('php/DBConn.php');


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="events.php">Event Management</a></li>
            <li class="active">Create Event</li>
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
            <h1 class="page-header">Create Event</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">            
            <form role="form" action="php/form-handler-event-create.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="control-label">Creator ID*</label>
                        <input readonly required type="text" class="form-control" name="creator_id" value="<?php echo $adminid; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Title*</label>
                        <input required type="text" class="form-control" name="title" value="<?php echo $event['title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Description*</label>
                        <textarea required class="form-control" rows="6" name="description"><?php echo $event['description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Date*</label>
                                <input required readonly="readonly" style="cursor:pointer; background-color: #FFFFFF" type="text" class="form-control daterange" id="eventdate" name="event_date" value="<?php echo $event['event_date']; ?>">    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Type*</label>
                                <select required type="text" class="form-control" name="type_id">
                                    <?php
                                    {
                                        $sql = "SELECT * FROM TBL_EVENT_TYPE;";
                                        $QueryResult = $mysqli->query($sql);
                                        if ($QueryResult == TRUE)
                                        {
                                            ?>
                                                <option value='' disabled selected>Select one--</option>
                                            <?php
                                            while (($Row = $QueryResult->fetch_assoc()) !== NULL)
                                            {
                                                ?>
                                                    <option <?php if($event['type_id'] === $Row['TYPE_ID']){ echo "selected"; } ?> value='<?php echo $Row['TYPE_ID']; ?>'><?php echo $Row['URGENCY'] . " - " . $Row['DESCRIPTION']; ?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <option selected disabled>Could not load list</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Available Admins*</label>
                                <select required type="text" class="form-control" name="event_admin">
                                    <?php
                                    {
                                        $sql = "SELECT * FROM TBL_ADMIN;";
                                        $QueryResult = $mysqli->query($sql);
                                        if ($QueryResult == TRUE)
                                        {
                                            ?>
                                                <option value='' disabled selected>Select one--</option>
                                            <?php
                                            while (($Row = $QueryResult->fetch_assoc()) !== NULL)
                                            {
                                                ?>
                                                    <option <?php if($event['event_admin'] === $Row['ADMIN_ID']){ echo "selected"; } ?> value='<?php echo $Row['ADMIN_ID']; ?>'><?php echo $Row['FIRST_NAME'] . " " . $Row['LAST_NAME']; ?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <option selected disabled>Could not load list</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Select An Image</label>
                                <input type="file" name="fileToUpload">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Address</label>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street Number*</label>
                            <div class="col-sm-9"><input onkeypress="validateNumberIn(event)" required type="number" class="form-control" name="street_no" value="<?php echo $event['street_no']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="street" value="<?php echo $event['street']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Suburb*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="area" value="<?php echo $event['area']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="city" value="<?php echo $event['city']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Zip Code*</label>
                            <div class="col-sm-9"><input required type="text" class="form-control" name="area_code" value="<?php echo $event['area_code']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Office / Company</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="office" value="<?php echo $event['office']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Building Number</label>
                            <div class="col-sm-9"><input type="number" min="0" step="1" class="form-control" name="building_number" value="<?php echo $event['building_number']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Latitude*</label>
                            <div class="col-sm-9"><input required type="number" min="-90" max="90" step="0.000001" class="form-control" name="latitude" value="<?php echo $event['latitude']; ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Longitude*</label>
                            <div class="col-sm-9"><input required type="number" min="-180" max="180" step="0.000001" class="form-control" name="longitude" value="<?php echo $event['longitude']; ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-6 text-right">
                        <br/>
                        <span>* denotes a required field </span> <button type="submit" class="btn btn-info">Save Event</button>
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
    $("#eventdate").datepicker("option", "minDate", 0);    //prevents past dates from being chosen
    
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
<?php $_SESSION['event'] = null; ?>