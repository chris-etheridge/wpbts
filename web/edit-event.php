<?php
$_TITLE = "WPBTS - Edit Event";
if(!isset($_GET['eventid']))
{
    header("Location: events.php");
}
require_once("header.php");
require_once('php/DBConn.php');


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"><!--.main-->

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="events.php">Event Management</a></li>
            <li class="active">Edit Event</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Event</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">            
                <form role="form" action="#" method="POST" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-6">
                        <label>Event ID</label>
                        <input disabled type="text" class="form-control" name="eventid" value="<?php echo $_GET['eventid']; ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Creator ID</label>
                        <input disabled type="text" class="form-control" name="creatorid" value="<?php //echo $_GET['adminid']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Description</label>
                        <textarea class="form-control" rows="6" name="description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Date</label>
                                <input type="text" class="form-control daterange" id="eventdate" name="date">    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Alerts</label>
                                <select type="text" class="form-control" name="alertid">
                                    <option value='-1' disabled selected>Select one--</option>
                                </select>
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Available Admins</label>
                                <select type="text" class="form-control" name="adminid">
                                    <option value='-1' disabled selected>Select one--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Address</label>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street Number</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="streetno"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Street</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="street"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Suburb</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="suburb"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="city"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Zip Code</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="zip"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-6 text-right">
                        <br/>
                        <button type="submit" class="btn btn-info">Save Event</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    

</div>	<!--/.main-->

<?php require_once('footer.php'); ?>

<script>
    
    $("#eventdate").datepicker({dateFormat: "yy-mm-dd"}); //sets date picker format
    
</script>	
</body>

</html>
