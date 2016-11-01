<?php
$_TITLE = "WPBTS - User Management";
$_PARENT['users'] = time();

require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");

session_start();

if (isset($_SESSION['USER'])) {
    $_SESSION['USER'] = null;
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">User Management</li>
        </ol>
    </div><!--/.row-->
    <br/>
    <?php
    if (isset($_SESSION['alert'])) {
        ?>
        <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong><?php echo $_SESSION['alert']["message_title"] ?></strong></div>
        <?php
        $_SESSION['alert'] = null;
    }
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">User Management</h1>
        </div>
    </div><!--/.row-->
    
    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>All Users</h4>
            <a href="users_createuser.php" class="btn btn-default btn-md">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add User
            </a>
        </div>
    </div>
    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <!--            <h4>Users List:</h4>-->
            <!--            <input type="text" id="myInput" onkeyup="filterSName()" on placeholder="Filter by surname"-->
            <!--                   width='50%' class="col-md-4">-->
            <!--            <input type="text" id="myInput2" onkeyup="filterDOB()" placeholder="Filter by date of birth"-->
            <!--                   width='50%' class="col-md-4">-->
            <!--            <input type="text" id="myInput3" onkeyup="filterBT()" placeholder="Filter by blood type"-->
            <!--                   width='50%' class="col-md-4">-->
            <!--            <div class="col-md-12">-->

            <?php
            $userData = getAllUsers();

            if ($userData[0] == false) {
                //IF THE DATABASE HAD AN ERROR, SHOW HTML WITH MESSAGE
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong>DB Error:</strong> <?php echo $userData[1] ?>
                </div>
                <?php
            }
            ?>
            <table data-toggle="table" data-search="true" data-pagination="true">
                <thead>
                <tr>
                    <th class="text-center">User ID</th>
                    <th class="text-center" data-sortable="true">Name</th>
                    <th class="text-center" data-sortable="true">Surname</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center" data-sortable="true">Date of Birth</th>
                    <th class="text-center">Blood Type</th>
                    <th class="text-center">Options</th>
                </tr>
                </thead>

                <?php
                $count = 0;
                if ($userData[0] == true) {
                    foreach ($userData[1] as $value) {
                        ?>
                        <tr class="<?php if ($count % 2 == 0) echo "odd" ?>">
                            <td class="text-center"><?php echo $value['USER_ID'] ?></td>
                            <td class="text-center"><?php echo $value['FIRST_NAME'] ?></td>
                            <td class="text-center"><?php echo $value['LAST_NAME'] ?></td>
                            <td class="text-center"><?php echo $value['EMAIL'] ?></td>
                            <td class="text-center"><?php echo $value['PHONE'] ?></td>
                            <td class="text-center"><?php echo $value['DATE_OF_BIRTH'] ?></td>
                            <td class="text-center"><?php echo $value['BLOOD_TYPE'] ?></td>
                            <td class="text-center">
                                <a href="users_edituser.php?userID=<?php echo $value['USER_ID'] ?>"
                                   class="btn btn-xs btn-primary">Edit</a>
                                <a href="php/form-handler-user-remove.php?userID=<?php echo $value['USER_ID'] . "&addressID=" . $value['ADDRESS_ID'] ?>"
                                   class=" btn btn-xs btn-warning">Remove</a>
                                <a href="#;" data-id="<?php echo $value['USER_ID'] ?>"
                                   class="viewclinic btn btn-xs btn-info">View</a>
                            </td>
                        </tr>
                        <?php
                        $count++;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>


</div>    <!--/.main-->

<?php require_once('footer.php'); ?>
<!--<script>-->
<!--    $('#calendar').datepicker({});-->
<!---->
<!--    !function ($) {-->
<!--        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {-->
<!--            $(this).find('em:first').toggleClass("glyphicon-minus");-->
<!--        });-->
<!--        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");-->
<!--    }(window.jQuery);-->
<!---->
<!--    $(window).on('resize', function () {-->
<!--        if ($(window).width() > 768)-->
<!--            $('#sidebar-collapse').collapse('show')-->
<!--    })-->
<!--    $(window).on('resize', function () {-->
<!--        if ($(window).width() <= 767)-->
<!--            $('#sidebar-collapse').collapse('hide')-->
<!--    })-->
<!--</script>-->

<script>
    function filterSName() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");

        var tdField = 2;

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tdField];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script>
    function filterDOB() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput2");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        var tdField = 5;
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tdField];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script>
    function filterBT() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput3");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        var tdField = 6;
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tdField];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>


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
    jQuery(function ($) {
        $('a.viewclinic').click(function (ev) {
            ev.preventDefault();
            window.console && console.log('button clicked');
            var uid = $(this).data('id');

            //get json object

            var objClinic;
            $.each(jsonClinics, function (i, item) {
                if (typeof item == 'object') {
                    if (item.clinic_id === uid.toString()) {
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
            $('#modal-view-clinic .modal-body #moClinicStreet').html(objClinic.street);
            $('#modal-view-clinic .modal-body #moClinicArea').html(objClinic.area);
            $('#modal-view-clinic .modal-body #moClinicCity').html(objClinic.city);
            $('#modal-view-clinic .modal-body #moClinicAreaCode').html(objClinic.area_code);

            $('#modal-view-clinic').modal('show', {backdrop: 'static'});

        });
    });

    //cancel event confirmation dialog
    jQuery(function ($) {
        $('a.removeclinic').click(function (ev) {
            ev.preventDefault();
            var uid = $(this).data('id');

            //get json object

            var objClinic;
            $.each(jsonClinics, function (i, item) {
                if (typeof item == 'object') {
                    if (item.clinic_id === uid.toString()) {
                        objClinic = item;
                    }
                }
            });

            $('#modal-remove-clinic .modal-body #moClinicID').html(objClinic.clinic_id);
            $('#modal-remove-clinic .modal-body #moClinicDescription').html(objClinic.description);
            $('#modal-remove-clinic .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/delete-clinic.php?clinic=" + objClinic.clinic_id + "'>Delete Clinic</a>");


            $('#modal-remove-clinic').modal('show', {backdrop: 'static'});

        });
    });


</script>

</body>

</html>
