<?php
$_TITLE = "WPBTS - Event Management";
require_once("header.php");
require_once('php/DBConn.php');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Event Management</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Event Management</h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>Upcoming Events</h4>
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
                            //get upcoming events
                        $sql = "SELECT * FROM TBL_EVENT WHERE EVENT_DATE > NOW() ORDER BY EVENT_DATE ASC;";
                        $QueryResult = $mysqli->query($sql);
                        if ($QueryResult == TRUE) 
                        {
                            $count = 0;
                            while (($Row = $QueryResult->fetch_assoc()) !== NULL) 
                            {
                                //$Row['EVENT_ID']
                                ?>
                                <tr class="<?php if($count%2 !== 0) echo "odd"; ?>">
                                    <td class="text-center"><?php echo $Row['EVENT_ID']; ?></td>
                                    <td class="text-center"><?php echo $Row['TITLE']; ?></td>
                                    <td class="text-center"><?php echo $Row['EVENT_DATE']; ?></td>
                                    <td class="text-center">
                                        <a href="edit-event.php?eventid=<?php echo $Row['EVENT_ID']; ?>">[Edit]</a>
                                        <a href="#">[Cancel]</a>
                                        <a href="#">[View]</a>
                                    </td>
                                </tr>
                                <?php
                                $count++;
                            }
                        }
                        else
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
    
    <div class="row"> <!-- available alerts -->
        <div class="col-md-12">
            <h4>Available Alerts</h4>
            <div class="col-md-12">
                <table class="custom-table table-bordered" width='100%'>
                    <thead>
                        <th class="text-center">Alert ID</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Options</th>
                    </thead>
                    <tbody>
                        <?php 
                            //get available alerts
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

</div>	<!--/.main-->

<?php require_once('footer.php'); ?>

<script>
    $('#calendar').datepicker({
    });

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
