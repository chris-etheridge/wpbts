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
            <li class="active"><a href="users.php">User Management</a></li>
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
                User:<?php echo $userData[1][0]['FIRST_NAME'] . " " . $userData[1][0]['LAST_NAME'] ?></h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h3>User Details:</h3>

            <form action="php/form-handler-event-edit-save-user.php" method="get">
                <div class="col-md-6">
                    <label>User ID</label>
                    <input required readonly type="text" value="<?php echo $userData[1][0]['USER_ID'] ?>"
                           class="form-control" name="USER_ID" style="margin-bottom:2%">

                    <label>Title:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['TITLE'] ?>" class="form-control"
                           name="TITLE" style="margin-bottom:2%">

                    <label>First Name:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['FIRST_NAME'] ?>" class="form-control"
                           name="FIRST_NAME"
                           style="margin-bottom:2%">

                    <label>Last Name:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['LAST_NAME'] ?>" class="form-control"
                           name="LAST_NAME"
                           style="margin-bottom:2%">

                    <label>National ID:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['NATIONAL_ID'] ?>"
                           class="form-control" name="NATIONAL_ID"
                           style="margin-bottom:2%">

                    <label>Email:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['EMAIL'] ?>" class="form-control"
                           name="EMAIL"
                           style="margin-bottom:2%">


                </div>
                <div class="col-md-6">

                    <label>Date of Birth</label>
                    <input required="" type="date" class="form-control daterange hasDatepicker" id="DATE_OF_BIRTH"
                           name="date"
                           value="<?php echo date_format(date_create($userData[1][0]['DATE_OF_BIRTH']), 'Y-m-d') ?>"
                           style="margin-bottom: 2%">


                    <label>Blood Type::</label>
                    <select required type="text" value="<?php echo $userData[1][0]['BLOOD_TYPE'] ?>"
                            class="form-control" name="BLOOD_TYPE"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="O-"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "O-") {
                                echo "selected";
                            }
                            ?>
                        >
                            O-
                        </option>
                        <option value="O+"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "O+") {
                                echo "selected";
                            }
                            ?>
                        >O+
                        </option>
                        <option value="A"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "A") {
                                echo "selected";
                            }
                            ?>
                        >A
                        </option>
                        <option value="A+"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "A+") {
                                echo "selected";
                            }
                            ?>
                        >A+
                        </option>
                        <option value="AB"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "AB") {
                                echo "selected";
                            }
                            ?>
                        >AB
                        </option>
                        <option value="AB+"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "AB+") {
                                echo "selected";
                            }
                            ?>
                        >AB+
                        </option>
                        <option value="B-"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "B-") {
                                echo "selected";
                            }
                            ?>
                        >B-
                        </option>
                        <option value="OB"
                            <?php
                            if ($userData[1][0]['BLOOD_TYPE'] == "OB") {
                                echo "selected";
                            }
                            ?>
                        >OB
                        </option>
                    </select>


                    <label>Gender:</label>
                    <select required type="text" value="<?php echo $userData[1][0]['GENDER'] ?>" class="form-control"
                            name="GENDER"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>


                    <label>Language:</label>
                    <select required type="text" value="<?php echo $userData[1][0]['LANGUAGE_PREF'] ?>"
                            class="form-control" name="Language"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="English">English</option>
                        <option value="Afrikaans">Afrikaans</option>
                        <option value="Xhosa">Xhosa</option>
                        <option value="Zulu">Zulu</option>
                    </select>


                    <label>Passport:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['PASSPORT_NUM'] ?>"
                           class="form-control" name="PASSPORT_NO"
                           style="margin-bottom:2%">

                    <label>Phone:</label>
                    <input required type="text" value="<?php echo $userData[1][0]['PHONE'] ?>" class="form-control"
                           name="PHONE"
                           style="margin-bottom:2%">

                </div>

                <div class="col-md-6">

                    <input type="text" name="ADDRESS_ID" value="<?php echo $userData[1][0]['ADDRESS_ID'] ?>" hidden>

                    <label>Street Number:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['STREET_NO'] ?>"
                           class="form-control"
                           name="STREET_NO"
                           style="margin-bottom:2%">

                    <label>Street:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['STREET'] ?>" class="form-control"
                           name="STREET"
                           style="margin-bottom:2%">


                    <label>Office:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['OFFICE'] ?>" class="form-control"
                           name="OFFICE"
                           style="margin-bottom:2%">

                    <label>Building Number:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['BUILDING_NUMBER'] ?>"
                           class="form-control" name="BUILDING_NUMBER"
                           style="margin-bottom:2%">
                </div>
                <div class="col-md-6">
                    <label>Area:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['AREA'] ?>" class="form-control"
                           name="AREA"
                           style="margin-bottom:2%">

                    <label>Area Code:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['AREA_CODE'] ?>"
                           class="form-control"
                           name="AREA_CODE"
                           style="margin-bottom:2%">

                    <label>City:</label>
                    <input required type="text" value="<?php echo $addressData[1][0]['CITY'] ?>" class="form-control"
                           name="CITY"
                           style="margin-bottom:7%">

                    <div class="col-md-12" align="right" style="margin-bottom: 5%">
                        <button type="submit" class="btn btn-info">Save User</button>
                    </div>
                </div>
            </form>

            <!--            <form>-->
            <!--                <div class="col-md-6">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Title</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['TITLE'] ?><!--" name="TITLE" style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>First Name</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['FIRST_NAME'] ?><!--" name="FIRST_NAME"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Last Name</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['LAST_NAME'] ?><!--" name="LAST_NAME"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>National ID-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['NATIONAL_ID'] ?><!--" name="NATIONAL_ID"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Email</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['EMAIL'] ?><!--" name="EMAIL" style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Phone</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['PHONE'] ?><!--" name="PHONE" style="width: 70%">-->
            <!---->
            <!--                </div>-->
            <!--                <div class="col-md-6">-->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Date of Birth-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['DATE_OF_BIRTH'] ?><!--" name="DATE_OF_BIRTH"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Blood Type</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['BLOOD_TYPE'] ?><!--" name="BLOOD_TYPE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Gender</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['GENDER'] ?><!--" name="GENDER" style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Language</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['LANGUAGE_PREF'] ?><!--" name="LANGUAGE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Passport</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['PASSPORT_NUM'] ?><!--" name="PASSPORT_NUM"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <input type="text" name="USER_ID" value="-->
            <?php //echo $userData[1][0]['USER_ID'] ?><!--">-->
            <!---->
            <!--                </div>-->
            <!---->
            <!--                <div class="col-md-12" style="margin-top: 1%">-->
            <!---->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Street Number-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['STREET_NO'] ?><!--" name="STREET_NO"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Street-->
            <!--                    </button>-->
            <!---->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['STREET'] ?><!--" name="STREET"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" value="--><?php //echo $addressData[1][0]['OFFICE'] ?><!--"-->
            <!--                            class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Office-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['OFFICE'] ?><!--" name="OFFICE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Building Number-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['BUILDING_NUMBER'] ?><!--"-->
            <!--                           name="BUILDING_NUMBER"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Area-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['AREA'] ?><!--" name="AREA"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Area Code-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['AREA_CODE'] ?><!--" name="AREA_CODE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>City-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['CITY'] ?><!--" name="City"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <input type="text" name="USER_ID" value="-->
            <?php //echo $addressData[1][0]['ADDRESS_ID'] ?><!--">-->
            <!---->
            <!--                </div>-->
            <!---->
            <!--            </form>-->

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


<script>

    $("#eventdate").datepicker({dateFormat: "dd-mm-yy"}); //sets date picker format

    function validateNumberIn(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

</script>

<?php require_once('footer.php'); ?>


</body>

</html>

