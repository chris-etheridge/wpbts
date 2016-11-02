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
                if ($userData[0] == true) {
                    foreach ($userData[1] as $value) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $value['USER_ID'] ?></td>
                            <td class="text-center"><?php echo $value['FIRST_NAME'] ?></td>
                            <td class="text-center"><?php echo $value['LAST_NAME'] ?></td>
                            <td class="text-center"><?php echo $value['EMAIL'] ?></td>
                            <td class="text-center"><?php echo $value['PHONE'] ?></td>
                            <td class="text-center"><?php echo $value['DATE_OF_BIRTH'] ?></td>
                            <td class="text-center"><?php echo $value['BLOOD_TYPE'] ?></td>
                            <td class="text-center">
                                <a href="users_edituser.php?userID=<?php echo $value['USER_ID'] ?>" class="btn btn-xs btn-primary">Edit</a>
                                <a href="#;" data-id="<?php echo $value['USER_ID']; ?>" class="removeclinic btn btn-xs btn-warning"onclick="removeUser(event)">Remove</a>
                                <a href="#;" data-id="<?php echo $value['USER_ID']; ?>" class="viewclinic btn btn-xs btn-info" onclick="viewUser(event)">View</a>
                            </td>
                        </tr>
                        <?php
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

<div class="modal fade" id="modal-remove-user" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure you want to permanently delete this user?</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">User</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moUserName"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <label class="control-label">User ID</label>
                    </div>
                    <div class="col-xs-9">
                        <span id="moUserID"></span>
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

<script type="text/javascript">
    
    var jsonUsers = <?php echo json_encode($userData[1]); ?>;
    
    //cancel event confirmation dialog
    function removeUser(ev){
        ev.preventDefault();
        var uid = ev.target.dataset.id;

        //get json object

        var objUser;
        $.each(jsonUsers, function (i, item)
        {
            if (typeof item == 'object')
            {
                if(item.USER_ID === uid.toString())
                {
                    objUser = item;
                }
            }
        });

        $('#modal-remove-user .modal-body #moUserID').html(objUser.USER_ID);
        $('#modal-remove-user .modal-body #moUserName').html(objUser.FIRST_NAME + " " + objUser.LAST_NAME);
        $('#modal-remove-user .modal-footer #confirmationBtns').html("<a class='btn btn-md btn-primary' href='php/form-handler-user-remove.php?userID=" + objUser.USER_ID + "'>Permanently Delete User</a>");


        $('#modal-remove-user').modal('show', {backdrop: 'static'});

     }
</script>

</body>

</html>
