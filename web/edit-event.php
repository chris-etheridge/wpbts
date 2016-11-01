<?php
$_TITLE = "WPBTS - Edit Event";
$_PARENT['events'] = time();
if(!isset($_GET['eventid']))
{
    header("Location: events.php");
}

session_start();

$adminid = $_SESSION['AUTH_USER_ID'];

require_once("header.php");
require_once('php/DBConn.php');
require_once('api/events/functions.php');

//get selected event info. Add to session variable to make posting page info back easy
$eventid = filter_var($_GET['eventid'], FILTER_SANITIZE_STRING);
$event = $_SESSION['event'];//first and only slot - 0
if(!isset($_SESSION['event'])) //if session event does not exist, get event from db
{
    $event = getEvent($mysqli, $eventid)[0]; //first and only slot - 0
}

$creatorName = "";

//fetch admins from db (no api for this functionality)
$admins = array();
$sql = "SELECT * FROM TBL_ADMIN;";
$QueryResult = $mysqli->query($sql);
if ($QueryResult == TRUE)
{
    $count = 0;
    while (($Row = $QueryResult->fetch_assoc()) !== NULL)
    {
        $admins[$count] = array();
        $admins[$count]['admin_id'] = $Row['ADMIN_ID'];
        $admins[$count]['first_name'] = $Row['FIRST_NAME'];
        $admins[$count]['last_name'] = $Row['LAST_NAME'];
        if((int)$event['creator_id'] === (int)$Row['ADMIN_ID'])
        {
            $creatorName = $Row['FIRST_NAME'] . " " . $Row['LAST_NAME'];
        }
        $count++;
    }
}
    
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->
    
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="events.php">Event Management</a></li>
            <li class="active">Edit Event</li>
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
            <h1 class="page-header">Edit Event</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">            
                <form role="form" action="php/form-handler-event-edit.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <div class="col-sm-12">
                            <label>Event ID</label>
                            <input required readonly type="text" class="form-control" name="event_id" value="<?php echo $event['event_id']; ?>">
                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Creator</label>
                            <input required readonly type="text" class="form-control" name="creator_id" value="<?php echo $creatorName; ?>"
                            >
                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Title</label>
                            <input required type="text" class="form-control" name="title" value="<?php echo $event['title']; ?>">
                        </div>
                    </div>
                
                    <div class="form-group col-sm-6">
                        <div class="text-center form-image">
                            <span><img class="media-object img-responsive" src="img/events/<?php echo $event['event_id']; ?>.jpg" alt=""/></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="col-sm-12">
                            <label class="control-label">Description</label>
                            <textarea required class="form-control" rows="6" name="description"><?php echo $event['description']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="control-label">Date</label>
                                    <input required type="text" readonly="readonly" style="cursor:pointer; background-color: #FFFFFF" class="form-control daterange" id="eventdate" name="event_date" value="<?php echo $event['event_date']; ?>">    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="control-label">Type</label>
                                    <select required type="text" class="form-control" name="type_id">
                                        <?php
                                        {
                                            $sql = "SELECT * FROM TBL_EVENT_TYPE;";
                                            $QueryResult = $mysqli->query($sql);
                                            if ($QueryResult == TRUE)
                                            {
                                                ?>
                                                    <option value='' disabled>Select one--</option>
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
                                    <label class="control-label">Event Admin</label>
                                    <select required type="text" class="form-control" name="event_admin">
                                        <?php 
                                            if(sizeof($admins) > 0)
                                            {
                                                ?>
                                                    <option value='' disabled>Select one--</option>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                    <option selected disabled>Could not load list</option>
                                                <?php
                                            }
                                            foreach ($admins as $Row)
                                            {
                                                ?>
                                                    <option <?php if($event['event_admin'] === $Row['admin_id']){ echo "selected"; } ?> value='<?php echo $Row['admin_id']; ?>'><?php echo $Row['first_name'] . " " . $Row['last_name']; ?></option>
                                                <?php
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="control-label">Active</label>
                                    <select required type="text" class="form-control" name="active">
                                        <option value='' disabled>Select one--</option>
                                        <option <?php if((int)$event['active'] === 1){ echo "selected"; } ?> value='1'>Active</option>
                                        <option <?php if((int)$event['active'] === 0){ echo "selected"; } ?> value='0'>Canceled</option>
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
                            <input type="hidden" name="address_id" value="<?php echo $event['address_id']; ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Street Number</label>
                                <div class="col-sm-9"><input onkeypress="validateNumberIn(event)" required type="number" class="form-control" name="street_no" value="<?php echo $event['street_no']; ?>"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Street</label>
                                <div class="col-sm-9"><input required type="text" class="form-control" name="street" value="<?php echo $event['street']; ?>"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Suburb</label>
                                <div class="col-sm-9"><input required type="text" class="form-control" name="area" value="<?php echo $event['area']; ?>"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">City</label>
                                <div class="col-sm-9"><input required type="text" class="form-control" name="city" value="<?php echo $event['city']; ?>"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Zip Code</label>
                                <div class="col-sm-9"><input required type="text" class="form-control" name="area_code" value="<?php echo $event['area_code']; ?>"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Office / Company</label>
                                <div class="col-sm-9"><input type="text" class="form-control" name="office" value="<?php echo $event['office']; ?>"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Building Number</label>
                                <div class="col-sm-9"><input type="number" class="form-control" name="building_number" value="<?php echo $event['building_number']; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="col-md-6 col-md-offset-6 text-right">
                            <br/>
                            <button type="submit" value="submit" id="submit" class="btn btn-info">Save Event</button>
                        </div>
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