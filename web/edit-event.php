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
            <form role="form" action="#" method="POST">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Event ID</h5>
                        <input disabled type="text" class="form-control" name="eventid" value="<?php echo $_GET['eventid']; ?>">
                    </div>
                    <div class="col-sm-6">
                        <h5>Creator ID</h5>
                        <input disabled type="text" class="form-control" name="creatorid" value="<?php //echo $_GET['adminid']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Title</h5>
                        <input type="text" class="form-control" name="title">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Description</h5>
                        <textarea class="form-control" rows="6" name="description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Date</h5>
                        <input type="text" class="form-control daterange" id="eventdate" name="date">
                    </div>
                    <div class="col-sm-6">
                        <h5>Address</h5>
                        <input type="text" class="form-control" name="address">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Alerts</h5>
                        <select type="text" class="form-control" name="alertid">
                            <option value='-1' disabled selected>Select one--</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <h5>Available Admins</h5>
                        <select type="text" class="form-control" name="adminid">
                            <option value='-1' disabled selected>Select one--</option>
                        </select>
                    </div>
                </div>
                
                
                
                <div class="row">
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
