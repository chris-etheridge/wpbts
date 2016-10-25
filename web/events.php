<?php
$_TITLE = "WPBTS - Event Management";
$_PARENT['events'] = time();
require_once("header.php");
require_once('php/DBConn.php');
require_once('api/events/functions.php');
session_start();


//get upcoming events
$arrEvents = getAllUpcommingEvents($mysqli);
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
                    <table class="custom-table table-bordered" width='100%'>
                        <thead>
                        <tr>
                            <th class="text-center">Event ID</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Event Date</th>
                            <th class="text-center">Status</th>
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
                            <tr class="<?php if ($count % 2 !== 0) echo "odd"; ?>">
                                <td class="text-center"><?php echo $Row['event_id']; ?></td>
                                <td class="text-center"><?php echo $Row['title']; ?></td>
                                <td class="text-center"><?php echo $Row['event_date']; ?></td>
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
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="cancelevent btn btn-xs btn-warning">Toggle Cancel</a>
                                    <a href="#;" data-id="<?php echo $Row['event_id']; ?>" class="viewevent btn btn-xs btn-info">View</a>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        if(sizeof($arrEvents) === 0) 
                        {
                            ?>
                            <tr>
                                <td colspan="4">No Upcoming Events</td>
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
                            <div class="col-md-3">
                                <label class="control-label">Title</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventTitle"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventDescription"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Date</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventDate"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Type</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventType"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Urgency</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventUrgency"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Event Admin</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventAdmin"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Street No.</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventStreetNo"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Street</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventStreet"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Area</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventArea"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-md-9">
                                <span id="moEventCity"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Area Code</label>
                            </div>
                            <div class="col-md-9">
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
                    <div class="col-md-3">
                        <label class="control-label">Event</label>
                    </div>
                    <div class="col-md-9">
                        <span id="moEventTitle"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Date</label>
                    </div>
                    <div class="col-md-9">
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
    
    var jsonEvents = <?php echo json_encode(getAllUpcommingEvents($mysqli)); ?>;
    
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
    
    //view event modal
    jQuery(function($){
         $('a.viewevent').click(function(ev){
            ev.preventDefault();
            var uid = $(this).data('id');
            
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
            $('#modal-view-event .modal-body #moEventStreet').html(objEvent.street);
            $('#modal-view-event .modal-body #moEventArea').html(objEvent.area);
            $('#modal-view-event .modal-body #moEventCity').html(objEvent.city);
            $('#modal-view-event .modal-body #moEventAreaCode').html(objEvent.area_code);
            
            $('#modal-view-event').modal('show', {backdrop: 'static'});

         });
    });
    
    //cancel event confirmation dialog
    jQuery(function($){
         $('a.cancelevent').click(function(ev){
            ev.preventDefault();
            var uid = $(this).data('id');
            
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

         });
    });

    
</script>
</body>

</html>

<?php $_SESSION['event'] = null; ?>