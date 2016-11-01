<?php
$_TITLE = "WPBTS - Clinic Management";
$_PARENT['clinics'] = time();

require_once("header.php");
require_once('php/DBConn.php');
require_once('api/clinics/functions.php');

session_start();


//get all clinics
$arrClinics = getAllClinics($mysqli);
?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">Clinic Management</li>
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
            <h1 class="page-header">Clinic Management</h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>All Clinics</h4>
            <a href="create-clinic.php" class="btn btn-default btn-md">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Clinic
            </a>
            <div class="row">
                <div class="col-md-12">
                    <table data-toggle="table" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th class="text-center" data-sortable="true">Clinic ID</th>
                            <th class="text-center" data-sortable="true">Description</th>
                            <th class="text-center">Primary Contact No.</th>
                            <th class="text-center">Secondary Contact No.</th>
                            <th class="text-center">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //var_dump($arrEvents);
                        foreach($arrClinics as $Row)
                        {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $Row['clinic_id']; ?></td>
                                <td class="text-center"><?php echo $Row['description']; ?></td>
                                <td class="text-center"><?php echo $Row['contact_1']; ?></td>
                                <td class="text-center"><?php echo $Row['contact_2']; ?></td>
                                <td class="text-center">
                                    <a href="edit-clinic.php?clinicid=<?php echo $Row['clinic_id']; ?>" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="#;" data-id="<?php echo $Row['clinic_id']; ?>" class="removeclinic btn btn-xs btn-warning"onclick="removeclinic(event)">Remove</a>
                                    <a href="#;" data-id="<?php echo $Row['clinic_id']; ?>" class="viewclinic btn btn-xs btn-info" onclick="viewclinic(event)">View</a>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        if(sizeof($arrClinics) === 0) 
                        {
                            ?>
                            <tr>
                                <td colspan="4">No Clinics to display</td>
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

<div class="modal fade" id="modal-view-clinic" role="dialog">
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
                            <div class="col-sm-8 col-sm-offset-2 text-center" id="moClinicImage">

                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Clinic ID</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicID"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicDescription"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Contact No. 1</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicContact1"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Contact No. 1</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicContact2"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Street No.</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicStreetNo"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Office</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicOffice"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Building Number</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicBuildingNo"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Street</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicStreet"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Area</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicArea"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicCity"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="control-label">Area Code</label>
                            </div>
                            <div class="col-xs-9">
                                <span id="moClinicAreaCode"></span>
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

<div class="modal fade" id="modal-remove-clinic" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure you want to permanently delete this clinic?</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">Clinic</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moClinicDescription"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">Clinic ID</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moClinicID"></span>
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
    
    var jsonClinics = <?php echo json_encode(getAllClinics($mysqli)); ?>;
      
    //view event modal
    function viewclinic(ev)
    {
        ev.preventDefault();
        window.console&&console.log('button clicked');
        var uid = ev.target.dataset.id;

        //get json object

        var objClinic;
        $.each(jsonClinics, function (i, item)
        {
            if (typeof item == 'object')
            {
                if(item.clinic_id === uid.toString())
                {
                    objClinic = item;
                }
            }
        });

        $('#modal-view-clinic .modal-header .modal-title').html("Viewing: " + objClinic.clinic_id);

        $('#modal-view-clinic .modal-body #moClinicID').html(objClinic.clinic_id);
        $('#modal-view-clinic .modal-body #moClinicDescription').html(objClinic.description);
        $('#modal-view-clinic .modal-body #moClinicContact1').html(objClinic.contact_1);
        $('#modal-view-clinic .modal-body #moClinicContact2').html(objClinic.contact_2);
        $('#modal-view-clinic .modal-body #moClinicDescription').html(objClinic.description);
        $('#modal-view-clinic .modal-body #moClinicStreetNo').html(objClinic.street_no);
        $('#modal-view-clinic .modal-body #moClinicOffice').html(objClinic.office);
        $('#modal-view-clinic .modal-body #moClinicBuildingNo').html(objClinic.building_number);
        $('#modal-view-clinic .modal-body #moClinicStreet').html(objClinic.street);
        $('#modal-view-clinic .modal-body #moClinicArea').html(objClinic.area);
        $('#modal-view-clinic .modal-body #moClinicCity').html(objClinic.city);
        $('#modal-view-clinic .modal-body #moClinicAreaCode').html(objClinic.area_code);
        $('#modal-view-clinic .modal-body #moClinicImage').html('<img class="media-object img-responsive" src="img/clinics/' + objClinic.clinic_id + '.jpg" alt="">');

        $('#modal-view-clinic').modal('show', {backdrop: 'static'});

     }
    
    //cancel event confirmation dialog
    function removeclinic(ev){
        ev.preventDefault();
        var uid = ev.target.dataset.id;

        //get json object

        var objClinic;
        $.each(jsonClinics, function (i, item)
        {
            if (typeof item == 'object')
            {
                if(item.clinic_id === uid.toString())
                {
                    objClinic = item;
                }
            }
        });

        $('#modal-remove-clinic .modal-body #moClinicID').html(objClinic.clinic_id);
        $('#modal-remove-clinic .modal-body #moClinicDescription').html(objClinic.description);
        $('#modal-remove-clinic .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/delete-clinic.php?clinicid=" + objClinic.clinic_id + "'>Delete Clinic</a>");


        $('#modal-remove-clinic').modal('show', {backdrop: 'static'});

     }

    
</script>
</body>

</html>

<?php $_SESSION['clinic'] = null; ?>