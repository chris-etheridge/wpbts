<?php
$_TITLE = "WPBTS - User Management";
require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");
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

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">User Management</h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>User Functions:</h4>
            <button type="button" class="btn btn-xs btn-primary">Create New User</button>
            <button type="button" class="btn btn-xs btn-primary">Refresh User List</button>
        </div>
    </div>

    <hr>

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>Users List:</h4>
            <input type="text" id="myInput" onkeyup="filterSName()" on placeholder="Filter by surname"
                   width='50%' class="col-md-4">
            <input type="text" id="myInput2" onkeyup="filterDOB()" placeholder="Filter by date of birth"
                   width='50%' class="col-md-4">
            <input type="text" id="myInput3" onkeyup="filterBT()" placeholder="Filter by blood type"
                   width='50%' class="col-md-4">
            <div class="col-md-12">

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
                <table id="usersTable" class="custom-table table-bordered" width='100%'>
                    <thead>
                    <th class="text-center">User ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Surname</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Blood Type</th>
                    <th class="text-center">Options</th>
                    </thead>

                    <?php
                    $count = 0;
                    if ($userData[0] == true) {
                        foreach ($userData[1] as $value) {
                            ?>
                            <tr class="<?php if ($count % 2 == 0) echo "odd" ?>">
                                <td><?php echo $value['USER_ID'] ?></td>
                                <td><?php echo $value['FIRST_NAME'] ?></td>
                                <td><?php echo $value['LAST_NAME'] ?></td>
                                <td><?php echo $value['EMAIL'] ?></td>
                                <td><?php echo $value['PHONE'] ?></td>
                                <td><?php echo $value['DATE_OF_BIRTH'] ?></td>
                                <td><?php echo $value['BLOOD_TYPE'] ?></td>
                                <td class="text-center">
                                    <a href="users_viewuser.php?userID=<?php echo $value['USER_ID'] ?>">[View/Edit]</a>
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

</body>

</html>

