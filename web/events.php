<?php
$_TITLE = "WPBTS - Event Management";
require_once("header.php");
require_once('php/DBConn.php');
require_once('api/events/functions.php');
session_start();


//get upcoming events
$arrEvents = getUpcommingEvents($mysqli);
$sql = "SELECT * FROM VIEW_EVENTSWADDRESS WHERE STR_TO_DATE(EVENT_DATE, '%d-%m-%Y') > NOW() AND ACTIVE = 1 ORDER BY EVENT_DATE ASC;";
/*$QueryResult = $mysqli->query($sql);
if ($QueryResult == TRUE) {
    $count = 0;
    while (($Row = $QueryResult->fetch_assoc()) !== NULL) 
    {
        $arrEvents[$count]['event_id'] = $Row['EVENT_ID'];
        $arrEvents[$count]['title'] = $Row['TITLE'];
        $arrEvents[$count]['description'] = $Row['DESCRIPTION'];
        $arrEvents[$count]['event_date'] = $Row['EVENT_DATE'];
        $arrEvents[$count]['type_id'] = $Row['TYPE_ID'];
        $arrEvents[$count]['event_admin'] = $Row['EVENT_ADMIN'];
        $arrEvents[$count]['street_no'] = $Row['STREET_NO'];
        $arrEvents[$count]['street'] = $Row['STREET'];
        $arrEvents[$count]['area'] = $Row['AREA'];
        $arrEvents[$count]['city'] = $Row['CITY'];
        $arrEvents[$count]['area_code'] = $Row['AREA_CODE'];
        $arrEvents[$count]['creator_id'] = $Row['CREATOR_ID'];
        $arrEvents[$count]['address_id'] = $Row['ADDRESS_ID'];
        $count++;
    }
}*/
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
                                    <a href="edit-event.php?eventid=<?php echo $Row['event_id']; ?>">[Edit]</a>
                                    <a href="#">[Cancel]</a>
                                    <a href="#">[View]</a>
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
    
    
    
</script>
</body>

</html>
