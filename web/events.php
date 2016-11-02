<?php
$_TITLE = "WPBTS - Event Management";
$_PARENT['events'] = time();

require_once("header.php");
require_once('php/DBConn.php');
require_once('api/events/functions.php');

//get upcoming events
$arrEvents = getAllUpcommingEvents($mysqli);
$arrPastEvents = getAllPastEvents($mysqli);
?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">Event Management</li>
        </ol>
    </div><!--/.row-->
    <br/>
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
            <h1 class="page-header">Event Management</h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>Upcoming Events</h4>
            <a href="create-event.php" class="btn btn-default btn-md">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Event
            </a>
            <div class="row">
                <div class="col-md-12">
                    <table  data-toggle="table" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th class="text-center" data-sortable="true">Event ID</th>
                            <th class="text-center" data-sortable="true">Title</th>
                            <th class="text-center" data-sortable="true">Event Date</th>
                            <th class="text-center" data-sortable="true">Status</th>
                            <th class="text-center">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //var_dump($arrEvents);
                        foreach($arrEvents as $Row)
                        {
                            //$Row['EVENT_ID']
                            ?>
                            <tr>
                                <td class="text-center"><?php echo (int)$Row['event_id']; ?></td>
                                <td class="text-center"><?php echo $Row['title']; ?></td>
                                <td class="text-center"><span class="hidden">DD-MM-YYYY</span><?php echo $Row['event_date']; ?></td>
                                <td class="text-center">
                                    <?php 
                                        if((int)$Row['active'] === 1)
                                        {
                                            ?> 
                                                <span class="label label-success">Active</span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <span class="label label-warning">Canceled</span>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="edit-event.php?eventid=<?php echo $Row['event_id']; ?>" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="cancelevent btn btn-xs btn-warning" onclick="cancelevent(event)">Toggle Cancel</a>
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="viewevent btn btn-xs btn-info" onclick="viewevent(event)">View</a>
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="viewrsvps btn btn-xs btn-default" onclick="viewrsvps(event)">RSVP's</a>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        if(sizeof($arrEvents) === 0) 
                        {
                            ?>
                            <tr>
                                <td colspan="5">No Upcoming Events</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row"> <!-- past events -->
        <div class="col-md-12">
            <h4>Past Events</h4>
            <div class="row">
                <div class="col-md-12">
                    <table  data-toggle="table" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th class="text-center" data-sortable="true">Event ID</th>
                            <th class="text-center" data-sortable="true">Title</th>
                            <th class="text-center" data-sortable="true">Event Date</th>
                            <th class="text-center">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($arrPastEvents as $Row)
                        {
                            ?>
                            <tr class="<?php if ($count % 2 !== 0) echo "odd"; ?>">
                                <td class="text-center"><?php echo (int)$Row['event_id']; ?></td>
                                <td class="text-center"><?php echo $Row['title']; ?></td>
                                <td class="text-center"><span class="hidden">DD-MM-YYYY</span><?php echo $Row['event_date']; ?></td>
                                <td class="text-center">
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="viewevent btn btn-xs btn-info" onclick="viewevent(event)">View</a>
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="viewrsvps btn btn-xs btn-default" onclick="viewrsvps(event)">RSVP's</a>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        if(sizeof($arrPastEvents) === 0) 
                        {
                            ?>
                            <tr>
                                <td colspan="3">No Past Events</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>    <!--/.main-->

<div class="modal fade" id="modal-view-event" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                         <div class="row">
                            <div class="col-sm-8 col-sm-offset-2 text-center" id="moEventImage">

                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Title</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventTitle"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventDescription"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Date</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventDate"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Type</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventType"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Urgency</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventUrgency"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Event Admin</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventAdmin"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Street No.</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventStreetNo"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Office</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventOffice"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Building Number</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventBuildingNo"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Street</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventStreet"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Area</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventArea"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventCity"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Area Code</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moEventAreaCode"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-cancel-event" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">Event</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moEventTitle"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">Date</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moEventDate"></span>
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

<div class="modal fade" id="modal-view-rsvps" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Users who have RSVP'd</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<script>
    $('#calendar').datepicker({});

    !function ($) {
        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768)
            $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767)
            $('#sidebar-collapse').collapse('hide')
    })
    
    var jsonEvents = <?php echo json_encode(getAllEvents($mysqli)); ?>;
    
    var jsonAdmins = 
    <?php 

        //get admins
        $sql = "SELECT * FROM TBL_ADMIN;";
        $admins = array();
        $QueryResult = $mysqli->query($sql);
        if ($QueryResult == TRUE)
        {
            while (($Row = $QueryResult->fetch_assoc()) !== NULL)
            {
                $admins[$Row['ADMIN_ID']] = array();
                $admins[$Row['ADMIN_ID']]['admin_id'] = $Row['ADMIN_ID'];
                $admins[$Row['ADMIN_ID']]['first_name'] = $Row['FIRST_NAME'];
                $admins[$Row['ADMIN_ID']]['last_name'] = $Row['LAST_NAME'];
            }
        }
        echo json_encode($admins);    
    ?>
            
    var jsonRsvps = 
    <?php 

        //get rsvps
        $sql = "SELECT * FROM VIEW_RSVP_USER_DETAILS;";
        $rsvps = array();
        $QueryResult = $mysqli->query($sql);
        if ($QueryResult == TRUE)
        {
            $count = 0;
            while (($Row = $QueryResult->fetch_assoc()) !== NULL)
            {
                $rsvps[$count] = array();
                $rsvps[$count]['user_id'] = $Row['USER_ID'];
                $rsvps[$count]['event_id'] = $Row['EVENT_ID'];
                $rsvps[$count]['attending'] = $Row['ATTENDING'];
                $rsvps[$count]['first_name'] = $Row['FIRST_NAME'];
                $rsvps[$count]['last_name'] = $Row['LAST_NAME'];
                $rsvps[$count]['phone'] = $Row['PHONE'];
                $rsvps[$count]['email'] = $Row['EMAIL'];
                $count++;
            }
        }
        echo json_encode($rsvps);    
    ?>
    
    //view event modal
    function viewevent(ev)
    {
        ev.preventDefault();
        var uid = ev.target.dataset.id;

        //get json object

        var objEvent;
        $.each(jsonEvents, function (i, item)
        {
            if (typeof item == 'object')
            {
                if(item.event_id === uid.toString())
                {
                    objEvent = item;
                }
            }
        });

        $('#modal-view-event .modal-header .modal-title').html("Viewing: " + objEvent.title);

        $('#modal-view-event .modal-body #moEventTitle').html(objEvent.title);
        $('#modal-view-event .modal-body #moEventDescription').html(objEvent.description);
        $('#modal-view-event .modal-body #moEventDate').html(objEvent.event_date);
        $('#modal-view-event .modal-body #moEventType').html(objEvent.type_description);
        $('#modal-view-event .modal-body #moEventUrgency').html(objEvent.urgency);
        $('#modal-view-event .modal-body #moEventAdmin').html(jsonAdmins[objEvent.event_admin].first_name + " " + jsonAdmins[objEvent.event_admin].last_name);
        $('#modal-view-event .modal-body #moEventStreetNo').html(objEvent.street_no);
        $('#modal-view-event .modal-body #moEventOffice').html(objEvent.office);
        $('#modal-view-event .modal-body #moEventBuildingNo').html(objEvent.building_number);
        $('#modal-view-event .modal-body #moEventStreet').html(objEvent.street);
        $('#modal-view-event .modal-body #moEventArea').html(objEvent.area);
        $('#modal-view-event .modal-body #moEventCity').html(objEvent.city);
        $('#modal-view-event .modal-body #moEventAreaCode').html(objEvent.area_code);
        $('#modal-view-event .modal-body #moEventImage').html('<img class="media-object img-responsive" src="img/events/' + objEvent.event_id + '.jpg" alt=""/>');

        $('#modal-view-event').modal('show', {backdrop: 'static'});

    }
    
    //cancel event confirmation dialog
    function cancelevent(ev)
    {
        ev.preventDefault();
        var uid = ev.target.dataset.id;

        //get json object
        var objEvent;
        $.each(jsonEvents, function (i, item)
        {
            if (typeof item == 'object')
            {
                if(item.event_id === uid.toString())
                {
                    objEvent = item;
                }
            }
        });
        var status = (parseInt(objEvent.active) === 0) ? 1 : 0;
        var cancelBtnTxt = "Cancel Event";
        var cancelTitleTxt = "Are You Sure You Want To Cancel This Event?";
        if(status === 1)
        {
            cancelBtnTxt = "Uncancel Event";
            cancelTitleTxt = "Are You Sure You Want To Uncancel This Event?";
        }

        $('#modal-cancel-event .modal-header .modal-title').html(cancelTitleTxt); 

        $('#modal-cancel-event .modal-body #moEventTitle').html(objEvent.title);
        $('#modal-cancel-event .modal-body #moEventDate').html(objEvent.event_date);
        $('#modal-cancel-event .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/cancel-event.php?eventid=" + objEvent.event_id + "&cancel=" + status + "'>" + cancelBtnTxt +"</a>");


        $('#modal-cancel-event').modal('show', {backdrop: 'static'});
    }
    
    //function to show users who have RSVP'd
    function viewrsvps(ev)
    {
        ev.preventDefault();
        window.console&&console.log(ev.target.dataset.id);
        var uid = ev.target.dataset.id;

        //get json object
        var html = "";
        $.each(jsonRsvps, function (i, rsvp)
        {
            if (typeof rsvp == 'object')
            {
                if(rsvp.event_id === uid.toString())
                {
                    window.console&&console.log(rsvp.first_name);
                    html += '<div class="row"><div class="col-xs-3"><label class="control-label">User ID</label></div><div class="col-xs-9"><span>' + rsvp.user_id +'</span></div></div>';
                    html += '<div class="row"><div class="col-xs-3"><label class="control-label">First Name</label></div><div class="col-xs-9"><span>' + rsvp.first_name +'</span></div></div>';
                    html += '<div class="row"><div class="col-xs-3"><label class="control-label">Last Name</label></div><div class="col-xs-9"><span>' + rsvp.last_name +'</span></div></div>';
                    html += '<div class="row"><div class="col-xs-3"><label class="control-label">Phone</label></div><div class="col-xs-9"><span>' + rsvp.phone +'</span></div></div>';
                    html += '<div class="row"><div class="col-xs-3"><label class="control-label">E-mail</label></div><div class="col-xs-9"><span>' + rsvp.email +'</span></div></div>';
                    if(parseInt(rsvp.attending) === 0) //not attending
                    {
                        html += '<div class="row"><div class="col-xs-3"><label class="control-label">Attending</label></div><div class="col-xs-9"><span class="label label-warning">Not Attending</span></div></div>';
                    }
                    else
                    {
                        html += '<div class="row"><div class="col-xs-3"><label class="control-label">Attending</label></div><div class="col-xs-9"><span class="label label-success">Attending</span></div></div>';
                    }
                    html += '<div class="row"><div class="col-md-12"><span class="divider">_____________________________________</span></div></div><br/>';
                }
            }
        });
        $('#modal-view-rsvps .modal-body').html(html);          

        $('#modal-view-rsvps').modal('show', {backdrop: 'static'});
    }

    
</script>
</body>

</html>

<?php $_SESSION['event'] = null; ?>