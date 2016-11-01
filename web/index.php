<?php
$_TITLE = "WPBTS - Dashboard";

require_once("header.php");
require_once('php/DBConn.php');
require_once('api/events/functions.php');
require_once('api/clinics/functions.php');

session_start();
//A QUICK CHECK AND BOOT IF THE USER IS NOT LOGGED IN.
// LET ME KNOW IF YOU WANT THIS MOVED TO ANOTHER FILE
$userID = $_SESSION['AUTH_USER_ID'];
if ($userID == null) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Not logged in..";
    $_SESSION['alert']['message'] = " Please authenticate to regain access";
    header('Location: login.php');
    exit();
}


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <div class="row">
        <ol class="breadcrumb">
            <li class="active"><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <!--<li class="active">Icons</li>-->
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-4">
            <a href="events.php">
                <div class="panel panel-red panel-widget ">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked calendar">
                                <use xlink:href="#stroked-calendar"></use>
                            </svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">
                                <?php
                                echo sizeof(getUpcommingEvents($mysqli));
                                ?>
                            </div>
                            <div class="text-muted">Upcoming Events</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <a href="clinics.php">
                <div class="panel panel-red panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked clipboard-with-paper">
                                <use xlink:href="#stroked-clipboard-with-paper"></use>
                            </svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">
                                <?php
                                echo sizeof(getAllClinics($mysqli));
                                ?>
                            </div>
                            <div class="text-muted">Clinics</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <a href="users.php">
                <div class="panel panel-teal panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked male-user">
                                <use xlink:href="#stroked-male-user"></use>
                            </svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">
                                <?php
                                //get upcoming events
                                $sql = "SELECT * FROM TBL_USER;";
                                $QueryResult = $mysqli->query($sql);
                                if ($QueryResult == TRUE) {
                                    echo $QueryResult->num_rows;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </div>
                            <div class="text-muted">Users</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div><!--/.row-->


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
