<?php

//Through this page we can access the user details
//As well as edit and update their details
//Or delete the record from the database.

$_TITLE = "WPBTS - User Management";
require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");
include_once("address_functions.php");


//Lets get the user details from the database via the GET variable passed in from user management:
$userData = getUser($_GET['userID']);
$addressData = getAddress($userData[1][0]['ADDRESS_ID']);


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">View User</li>
        </ol>
    </div><!--/.row-->

    <?php
    if ($userData[0] == false) {
        //IF THE DATABASE HAD AN ERROR, SHOW HTML WITH MESSAGE
        //And dont load more of the page.
        ?>
        <div class="alert alert-danger" role="alert">
            <strong>DB Error:</strong> <?php echo $userData[1] ?>
        </div>
        <?php
    } else {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                User:<?php echo $userData[1][0]['FIRST_NAME'] . " " . $userData[1][0]['LAST_NAME'] . "" . $userData[1][0]['ADDRESS_ID'] ?></h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>User Functions:</h4>
            <button type="button" class="btn btn-xs btn-success">Save User</button>
            <button type="button" class="btn btn-xs btn-warning">Delete User</button>
        </div>
    </div>

    <hr>

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h4>User Details:</h4>
            <form>
                <div class="col-md-6">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Title</button>
                    <input type="text" value="<?php echo $userData[1][0]['TITLE'] ?>" name="TITLE" style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>First Name</button>
                    <input type="text" value="<?php echo $userData[1][0]['FIRST_NAME'] ?>" name="FIRST_NAME"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Last Name</button>
                    <input type="text" value="<?php echo $userData[1][0]['LAST_NAME'] ?>" name="LAST_NAME"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>National ID
                    </button>
                    <input type="text" value="<?php echo $userData[1][0]['NATIONAL_ID'] ?>" name="NATIONAL_ID"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Email</button>
                    <input type="text" value="<?php echo $userData[1][0]['EMAIL'] ?>" name="EMAIL" style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Phone</button>
                    <input type="text" value="<?php echo $userData[1][0]['PHONE'] ?>" name="PHONE" style="width: 70%">

                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Date of Birth
                    </button>
                    <input type="text" value="<?php echo $userData[1][0]['DATE_OF_BIRTH'] ?>" name="DATE_OF_BIRTH"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Blood Type</button>
                    <input type="text" value="<?php echo $userData[1][0]['BLOOD_TYPE'] ?>" name="BLOOD_TYPE"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Gender</button>
                    <input type="text" value="<?php echo $userData[1][0]['GENDER'] ?>" name="GENDER" style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Language</button>
                    <input type="text" value="<?php echo $userData[1][0]['LANGUAGE_PREF'] ?>" name="LANGUAGE"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Passport</button>
                    <input type="text" value="<?php echo $userData[1][0]['PASSPORT_NUM'] ?>" name="PASSPORT_NUM"
                           style="width: 70%">

                    <input type="text" name="USER_ID" value="<?php echo $userData[1][0]['USER_ID'] ?>">

                </div>

                <div class="col-md-12" style="margin-top: 1%">


                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Street Number
                    </button>
                    <input type="text" value="<?php echo $addressData[1][0]['STREET_NO'] ?>" name="STREET_NO"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Street
                    </button>

                    <input type="text" value="<?php echo $addressData[1][0]['STREET'] ?>" name="STREET"
                           style="width: 70%">

                    <button type="button" value="<?php echo $addressData[1][0]['OFFICE'] ?>"
                            class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Office
                    </button>
                    <input type="text" value="<?php echo $addressData[1][0]['OFFICE'] ?>" name="OFFICE"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Building Number
                    </button>
                    <input type="text" value="<?php echo $addressData[1][0]['BUILDING_NUMBER'] ?>"
                           name="BUILDING_NUMBER"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Area
                    </button>
                    <input type="text" value="<?php echo $addressData[1][0]['AREA'] ?>" name="AREA"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Area Code
                    </button>
                    <input type="text" value="<?php echo $addressData[1][0]['AREA_CODE'] ?>" name="AREA_CODE"
                           style="width: 70%">

                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>City
                    </button>
                    <input type="text" value="<?php echo $addressData[1][0]['CITY'] ?>" name="City"
                           style="width: 70%">

                    <input type="text" name="USER_ID" value="<?php echo $addressData[1][0]['ADDRESS_ID'] ?>">

                </div>

            </form>

        </div>
    </div>
</div>
    </div>
    </div>
    </div>


    </div>    <!--/.main-->
<?php
}
?>




<?php require_once('footer.php'); ?>


</body>

</html>

